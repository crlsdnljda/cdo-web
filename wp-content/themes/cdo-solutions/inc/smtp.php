<?php
/**
 * SMTP — enviar todo el correo de WordPress vía un servidor externo
 * (Mailcow self-hosted).
 *
 * Sin plugins. Las credenciales viven en env vars expuestas como
 * constantes PHP desde docker-compose.prod.yml:
 *
 *   CDO_SMTP_HOST       — ej. "servicios.corporativo.online"
 *   CDO_SMTP_PORT       — ej. 587
 *   CDO_SMTP_USER       — ej. "info@cdo.solutions"
 *   CDO_SMTP_PASS       — la contraseña del buzón
 *   CDO_SMTP_ENCRYPTION — "tls" (STARTTLS, puerto 587) o "ssl" (puerto 465)
 *   CDO_SMTP_FROM       — opcional; si no, se usa CDO_SMTP_USER
 *   CDO_SMTP_FROM_NAME  — opcional; default "CDO Solutions"
 *
 * Si CDO_SMTP_HOST está vacío → no hacemos nada y wp_mail() usa el
 * mail() nativo de PHP (que probablemente no funciona en producción
 * — por eso configuramos esto).
 *
 * @package CdoSolutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Configura PHPMailer para que use SMTP autenticado.
 */
function cdo_smtp_configure( $phpmailer ) {
    $host = defined( 'CDO_SMTP_HOST' ) ? (string) CDO_SMTP_HOST : '';
    if ( '' === $host ) { return; }

    $phpmailer->isSMTP();
    $phpmailer->Host        = $host;
    $phpmailer->Port        = defined( 'CDO_SMTP_PORT' ) ? (int) CDO_SMTP_PORT : 587;
    $phpmailer->SMTPAuth    = true;
    $phpmailer->Username    = defined( 'CDO_SMTP_USER' ) ? (string) CDO_SMTP_USER : '';
    $phpmailer->Password    = defined( 'CDO_SMTP_PASS' ) ? (string) CDO_SMTP_PASS : '';

    // STARTTLS (587) por defecto; SSL/TLS implícito (465) si así se configura.
    $enc = defined( 'CDO_SMTP_ENCRYPTION' ) ? strtolower( (string) CDO_SMTP_ENCRYPTION ) : 'tls';
    $phpmailer->SMTPSecure  = ( 'ssl' === $enc ) ? 'ssl' : 'tls';
    $phpmailer->SMTPAutoTLS = true;

    // Remitente "From" — debe coincidir con un buzón/alias autorizado
    // a enviar como esa dirección, o el server lo rechazará por SPF/DKIM.
    $from      = defined( 'CDO_SMTP_FROM' )      && CDO_SMTP_FROM      ? (string) CDO_SMTP_FROM      : $phpmailer->Username;
    $from_name = defined( 'CDO_SMTP_FROM_NAME' ) && CDO_SMTP_FROM_NAME ? (string) CDO_SMTP_FROM_NAME : 'CDO Solutions';
    if ( $from ) {
        $phpmailer->setFrom( $from, $from_name, false );
    }
}
add_action( 'phpmailer_init', 'cdo_smtp_configure' );

/**
 * Forzar el From a nivel de filtros (algunas plantillas/plugins de WP
 * lo sobrescriben con `wordpress@dominio` antes de phpmailer_init).
 */
function cdo_smtp_from_email( $email ) {
    if ( defined( 'CDO_SMTP_FROM' ) && CDO_SMTP_FROM ) { return (string) CDO_SMTP_FROM; }
    if ( defined( 'CDO_SMTP_USER' ) && CDO_SMTP_USER ) { return (string) CDO_SMTP_USER; }
    return $email;
}
add_filter( 'wp_mail_from', 'cdo_smtp_from_email' );

function cdo_smtp_from_name( $name ) {
    if ( defined( 'CDO_SMTP_FROM_NAME' ) && CDO_SMTP_FROM_NAME ) { return (string) CDO_SMTP_FROM_NAME; }
    return $name;
}
add_filter( 'wp_mail_from_name', 'cdo_smtp_from_name' );

/**
 * Loggear los fallos de wp_mail al error_log para que aparezcan en
 * `docker logs`. Útil para diagnosticar credenciales / firewall / TLS.
 */
function cdo_smtp_log_failure( $wp_error ) {
    if ( is_wp_error( $wp_error ) ) {
        error_log( '[cdo-smtp] wp_mail failed: ' . $wp_error->get_error_message() );
    }
}
add_action( 'wp_mail_failed', 'cdo_smtp_log_failure' );
