<?php
/**
 * Restringe el acceso a /wp-admin/ y /wp-login.php a las IPs permitidas.
 *
 * IPs permitidas: definidas en la constante CDO_ADMIN_ALLOWED_IPS
 * (configurada en wp-config.php desde la env var del mismo nombre).
 *
 * Formato: lista separada por comas, soporta IPs exactas o CIDR.
 *   Ej: "85.85.243.98, 192.168.1.0/24, 2.150.0.0/16"
 *
 * Si la constante está vacía o sin definir → no se aplica restricción
 * (fail-open para evitar bloquear al admin si olvidan configurarla).
 *
 * @package CdoSolutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Devuelve la IP del cliente real, teniendo en cuenta el proxy Traefik.
 */
function cdo_get_client_ip() {
    if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $list = array_map( 'trim', explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
        return $list[0]; // primera IP de la cadena = cliente original
    }
    if ( ! empty( $_SERVER['HTTP_X_REAL_IP'] ) )      { return $_SERVER['HTTP_X_REAL_IP']; }
    if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) { return $_SERVER['HTTP_CF_CONNECTING_IP']; }
    return $_SERVER['REMOTE_ADDR'] ?? '';
}

/**
 * Comprueba si una IP coincide con una entrada (IP exacta o CIDR IPv4).
 */
function cdo_ip_matches( $ip, $rule ) {
    $rule = trim( $rule );
    if ( '' === $rule ) { return false; }

    // CIDR IPv4
    if ( strpos( $rule, '/' ) !== false ) {
        list( $subnet, $bits ) = explode( '/', $rule, 2 );
        $bits = (int) $bits;
        if ( $bits < 0 || $bits > 32 ) { return false; }
        $ip_long     = ip2long( $ip );
        $subnet_long = ip2long( $subnet );
        if ( false === $ip_long || false === $subnet_long ) { return false; }
        $mask = $bits === 0 ? 0 : ( -1 << ( 32 - $bits ) );
        return ( $ip_long & $mask ) === ( $subnet_long & $mask );
    }

    return $ip === $rule;
}

/**
 * Comprueba si la URL actual debe estar restringida.
 */
function cdo_request_needs_admin_protection() {
    // Las llamadas internas (cron, ajax, REST de admin) no se bloquean
    if ( wp_doing_cron() )                                    { return false; }
    if ( wp_doing_ajax() )                                    { return false; }
    if ( defined( 'WP_CLI' ) && WP_CLI )                      { return false; }

    $req = $_SERVER['REQUEST_URI'] ?? '';

    // Permitir admin-ajax y admin-post incluso desde fuera (las usa el front-end)
    if ( strpos( $req, '/wp-admin/admin-ajax.php' ) !== false ) { return false; }
    if ( strpos( $req, '/wp-admin/admin-post.php' ) !== false ) { return false; }

    // Restringir wp-login y todo el resto de /wp-admin/
    if ( strpos( $req, '/wp-login.php' ) !== false )            { return true; }
    if ( strpos( $req, '/wp-admin' )    === 0 ||
         strpos( $req, '/wp-admin/' )   !== false )             { return true; }

    return false;
}

/**
 * Hook principal — corre temprano para no cargar plantillas innecesariamente.
 */
function cdo_admin_ip_restrict() {
    if ( ! cdo_request_needs_admin_protection() ) { return; }

    // ----- 1. Bypass por token secreto (cookie de 1 año) -----
    // Útil cuando el proxy no pasa la IP real, o cuando viajas / cambia tu red.
    // URL de activación: https://cdo.solutions/wp-admin/?cdo_key=TU_TOKEN
    $token = defined( 'CDO_ADMIN_TOKEN' ) ? (string) CDO_ADMIN_TOKEN : '';
    if ( '' !== $token ) {
        // Cookie ya presente y válida → pasa
        if ( ! empty( $_COOKIE['cdo_admin_key'] ) && hash_equals( $token, (string) $_COOKIE['cdo_admin_key'] ) ) {
            return;
        }
        // Token vía URL → setea cookie y permite
        if ( ! empty( $_GET['cdo_key'] ) && hash_equals( $token, (string) $_GET['cdo_key'] ) ) {
            setcookie( 'cdo_admin_key', $token, time() + YEAR_IN_SECONDS, '/', '', is_ssl(), true );
            return;
        }
    }

    // ----- 2. Lista de IPs permitidas (CDO_ADMIN_ALLOWED_IPS) -----
    $raw = defined( 'CDO_ADMIN_ALLOWED_IPS' ) ? (string) CDO_ADMIN_ALLOWED_IPS : '';
    if ( '' !== trim( $raw ) ) {
        $allowed = array_filter( array_map( 'trim', explode( ',', $raw ) ) );
        if ( ! empty( $allowed ) ) {
            $client_ip = cdo_get_client_ip();
            foreach ( $allowed as $rule ) {
                if ( cdo_ip_matches( $client_ip, $rule ) ) {
                    return; // IP permitida
                }
            }
        }
    }

    // ----- 3. Si no hay ni token ni IPs configuradas → fail-open -----
    if ( '' === $token && '' === trim( $raw ) ) { return; }

    // Bloqueado — redirect 302 a la home, sin filtración de info
    wp_safe_redirect( home_url( '/' ), 302 );
    exit;
}
// IMPORTANTE: usamos 'after_setup_theme' priority 1 (el primer hook que se
// dispara DESPUÉS de cargar functions.php del tema). 'plugins_loaded' no
// vale porque ya pasó cuando este archivo se incluye desde functions.php.
add_action( 'after_setup_theme', 'cdo_admin_ip_restrict', 1 );

// Por seguridad extra, también registramos en 'init' por si algo se cuela
add_action( 'init', 'cdo_admin_ip_restrict', 1 );
