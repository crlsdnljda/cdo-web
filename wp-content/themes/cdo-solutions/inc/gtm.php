<?php
/**
 * Google Tag Manager integration.
 *
 * - Snippet <script> en <head> (prioridad 1, lo más arriba posible)
 * - Snippet <noscript><iframe> tras <body> (vía wp_body_open)
 * - ID configurable vía env var CDO_GTM_ID (definido como constante en wp-config)
 * - Si la constante está vacía → no se inyecta nada
 * - Exento del admin de WordPress y de cron/ajax
 *
 * Para gating estricto por consentimiento (RGPD), configurar Consent Mode v2
 * en el propio GTM. Por defecto este snippet carga siempre — los tags dentro
 * de GTM son los que deciden cuándo disparar.
 *
 * @package CdoSolutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * ID de contenedor GTM (formato GTM-XXXXXXX). Vacío = desactivado.
 */
function cdo_gtm_id() {
    return defined( 'CDO_GTM_ID' ) ? trim( (string) CDO_GTM_ID ) : '';
}

/**
 * ¿Debemos inyectar GTM en esta petición?
 */
function cdo_gtm_should_load() {
    if ( is_admin() )                           { return false; }
    if ( wp_doing_ajax() )                      { return false; }
    if ( wp_doing_cron() )                      { return false; }
    if ( defined( 'WP_CLI' ) && WP_CLI )        { return false; }
    return cdo_gtm_id() !== '';
}

/**
 * <script> de GTM justo al principio del <head>.
 */
function cdo_gtm_head() {
    if ( ! cdo_gtm_should_load() ) { return; }
    $id = esc_js( cdo_gtm_id() );
    ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $id; ?>');</script>
<!-- End Google Tag Manager -->
    <?php
}
add_action( 'wp_head', 'cdo_gtm_head', 1 );

/**
 * <noscript><iframe> de GTM justo después de <body>.
 */
function cdo_gtm_body() {
    if ( ! cdo_gtm_should_load() ) { return; }
    $id = esc_attr( cdo_gtm_id() );
    ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $id; ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action( 'wp_body_open', 'cdo_gtm_body' );
