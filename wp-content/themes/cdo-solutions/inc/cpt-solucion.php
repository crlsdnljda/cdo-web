<?php
/**
 * CPT: Soluciones (las 5 áreas de servicio del catálogo).
 *
 * URL: /soluciones/{slug}/
 * - catálogo: /soluciones/ (template-servicios.php — Page Template "Soluciones")
 * - individual: single-cdo_solucion.php
 *
 * @package CdoSolutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- Opciones predefinidas ---------- */

function cdo_solucion_gradients() {
    return array(
        'from-primary to-primary-container'   => __( 'Lima oliva',     'cdo-solutions' ),
        'from-tertiary to-tertiary-fixed-dim' => __( 'Rosa magenta',   'cdo-solutions' ),
        'from-[#6366F1] to-[#A5B4FC]'         => __( 'Azul violeta',   'cdo-solutions' ),
        'from-[#F59E0B] to-[#FCD34D]'         => __( 'Naranja ámbar',  'cdo-solutions' ),
        'from-[#10B981] to-[#6EE7B7]'         => __( 'Verde',          'cdo-solutions' ),
        'from-[#EC4899] to-[#F9A8D4]'         => __( 'Rosa fucsia',    'cdo-solutions' ),
    );
}

/* ---------- Registro del CPT ---------- */

function cdo_register_cpt_solucion() {
    $labels = array(
        'name'                  => _x( 'Soluciones', 'post type general name', 'cdo-solutions' ),
        'singular_name'         => _x( 'Solución',   'post type singular name','cdo-solutions' ),
        'menu_name'             => __( 'Soluciones',                            'cdo-solutions' ),
        'name_admin_bar'        => __( 'Solución',                              'cdo-solutions' ),
        'add_new'               => __( 'Añadir nueva',                          'cdo-solutions' ),
        'add_new_item'          => __( 'Añadir nueva solución',                 'cdo-solutions' ),
        'new_item'              => __( 'Nueva solución',                        'cdo-solutions' ),
        'edit_item'             => __( 'Editar solución',                       'cdo-solutions' ),
        'view_item'             => __( 'Ver solución',                          'cdo-solutions' ),
        'all_items'             => __( 'Todas las soluciones',                  'cdo-solutions' ),
        'search_items'          => __( 'Buscar soluciones',                     'cdo-solutions' ),
        'not_found'             => __( 'No hay soluciones.',                    'cdo-solutions' ),
        'not_found_in_trash'    => __( 'No hay soluciones en la papelera.',     'cdo-solutions' ),
    );

    register_post_type( 'cdo_solucion', array(
        'labels'              => $labels,
        'description'         => __( 'Categorías de servicios de cdo.solutions.', 'cdo-solutions' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-portfolio',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'rewrite'             => array(
            'slug'       => 'soluciones',
            'with_front' => false,
            'feeds'      => false,
        ),
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    ) );
}
add_action( 'init', 'cdo_register_cpt_solucion' );

/**
 * Flush controlado de rewrite rules tras cambios en el CPT.
 */
function cdo_solucion_maybe_flush_rewrites() {
    if ( get_option( 'cdo_solucion_rewrites_v' ) !== '3' ) {
        flush_rewrite_rules( false );
        update_option( 'cdo_solucion_rewrites_v', '3' );
    }
}
add_action( 'init', 'cdo_solucion_maybe_flush_rewrites', 99 );

/* ---------- Meta box ---------- */

function cdo_solucion_meta_box() {
    add_meta_box(
        'cdo_solucion_details',
        __( 'Detalles de la solución', 'cdo-solutions' ),
        'cdo_solucion_meta_box_render',
        'cdo_solucion',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'cdo_solucion_meta_box' );

function cdo_solucion_meta_box_render( $post ) {
    wp_nonce_field( 'cdo_solucion_save', 'cdo_solucion_nonce' );

    $eyebrow      = get_post_meta( $post->ID, '_cdo_sol_eyebrow',          true );
    $tagline      = get_post_meta( $post->ID, '_cdo_sol_tagline',          true );
    $number       = get_post_meta( $post->ID, '_cdo_sol_number',           true );
    $icon         = get_post_meta( $post->ID, '_cdo_sol_icon',             true );
    $gradient     = get_post_meta( $post->ID, '_cdo_sol_gradient',         true );
    $subservices  = get_post_meta( $post->ID, '_cdo_sol_subservices',      true );
    $stack        = get_post_meta( $post->ID, '_cdo_sol_stack',            true );
    $related_sw   = get_post_meta( $post->ID, '_cdo_sol_related_software', true );

    $gradients = cdo_solucion_gradients();
    ?>
    <style>
        .cdo-meta-grid { display:grid; grid-template-columns: 200px 1fr; gap: 14px 18px; align-items:start; }
        .cdo-meta-grid > label { font-weight:600; padding-top:8px; }
        .cdo-meta-grid input[type=text],
        .cdo-meta-grid select,
        .cdo-meta-grid textarea { width:100%; box-sizing:border-box; }
        .cdo-meta-grid textarea { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 12px; }
        .cdo-meta-help { color:#646970; font-size:12px; margin:4px 0 0; }
        .cdo-row { display:flex; gap:12px; }
        .cdo-row input[type=text] { width:80px; }
    </style>
    <div class="cdo-meta-grid">

        <label for="cdo_sol_number"><?php esc_html_e( 'Número', 'cdo-solutions' ); ?></label>
        <div>
            <div class="cdo-row">
                <input type="text" id="cdo_sol_number" name="cdo_sol_number" value="<?php echo esc_attr( $number ); ?>" placeholder="01" />
            </div>
            <p class="cdo-meta-help"><?php esc_html_e( 'Número de orden visible (01, 02, 03…). Solo para mostrar — el orden real se controla en "Atributos de página → Orden".', 'cdo-solutions' ); ?></p>
        </div>

        <label for="cdo_sol_eyebrow"><?php esc_html_e( 'Eyebrow', 'cdo-solutions' ); ?></label>
        <div>
            <input type="text" id="cdo_sol_eyebrow" name="cdo_sol_eyebrow" value="<?php echo esc_attr( $eyebrow ); ?>" placeholder="Soluciones personalizadas para optimizar tus procesos online" />
        </div>

        <label for="cdo_sol_tagline"><?php esc_html_e( 'Tagline', 'cdo-solutions' ); ?></label>
        <div>
            <input type="text" id="cdo_sol_tagline" name="cdo_sol_tagline" value="<?php echo esc_attr( $tagline ); ?>" placeholder="Tu tienda online, sin preocupaciones." />
            <p class="cdo-meta-help"><?php esc_html_e( 'Frase de una línea con la propuesta de valor.', 'cdo-solutions' ); ?></p>
        </div>

        <label for="cdo_sol_icon"><?php esc_html_e( 'Icono (Material Symbol)', 'cdo-solutions' ); ?></label>
        <div>
            <input type="text" id="cdo_sol_icon" name="cdo_sol_icon" value="<?php echo esc_attr( $icon ); ?>" placeholder="shopping_bag" />
            <p class="cdo-meta-help"><a href="https://fonts.google.com/icons" target="_blank" rel="noopener">fonts.google.com/icons</a></p>
        </div>

        <label for="cdo_sol_gradient"><?php esc_html_e( 'Color del icono', 'cdo-solutions' ); ?></label>
        <div>
            <select id="cdo_sol_gradient" name="cdo_sol_gradient">
                <option value=""><?php esc_html_e( '— Selecciona un gradiente —', 'cdo-solutions' ); ?></option>
                <?php foreach ( $gradients as $value => $label ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $gradient, $value ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <label for="cdo_sol_subservices"><?php esc_html_e( 'Sub-servicios', 'cdo-solutions' ); ?></label>
        <div>
            <textarea id="cdo_sol_subservices" name="cdo_sol_subservices" rows="10" placeholder="storefront | Desarrollo y optimización de tiendas | PrestaShop, Shopify y WooCommerce
local_shipping | Gestión de envíos | Integración con ShippyPro y Outvio
undo | Gestión de devoluciones | ITS Rever, Outvio y ShippyPro"><?php echo esc_textarea( $subservices ); ?></textarea>
            <p class="cdo-meta-help">
                <strong><?php esc_html_e( 'Uno por línea, formato:', 'cdo-solutions' ); ?></strong> <code>icono | título | descripción</code>
            </p>
        </div>

        <label for="cdo_sol_stack"><?php esc_html_e( 'Stack / herramientas', 'cdo-solutions' ); ?></label>
        <div>
            <textarea id="cdo_sol_stack" name="cdo_sol_stack" rows="2" placeholder="Shopify, PrestaShop, WooCommerce, ShippyPro, Outvio"><?php echo esc_textarea( $stack ); ?></textarea>
            <p class="cdo-meta-help"><?php esc_html_e( 'Lista CSV de herramientas/plataformas con las que trabajamos en esta área. Aparecen como pildoras en la página individual.', 'cdo-solutions' ); ?></p>
        </div>

        <label for="cdo_sol_related_software"><?php esc_html_e( 'Productos relacionados', 'cdo-solutions' ); ?></label>
        <div>
            <input type="text" id="cdo_sol_related_software" name="cdo_sol_related_software" value="<?php echo esc_attr( $related_sw ); ?>" placeholder="cdo-mail, cdo-chat" />
            <p class="cdo-meta-help"><?php esc_html_e( 'Slugs de productos del CPT Software que se mostrarán como "productos relacionados" en la página individual. Separados por comas.', 'cdo-solutions' ); ?></p>
        </div>

    </div>
    <?php
}

/* ---------- Guardado ---------- */

function cdo_solucion_save( $post_id, $post ) {
    if ( ! isset( $_POST['cdo_solucion_nonce'] ) || ! wp_verify_nonce( $_POST['cdo_solucion_nonce'], 'cdo_solucion_save' ) ) { return; }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                                                                    { return; }
    if ( 'cdo_solucion' !== $post->post_type )                                                                              { return; }
    if ( ! current_user_can( 'edit_post', $post_id ) )                                                                      { return; }

    $fields = array(
        'cdo_sol_eyebrow'          => 'sanitize_text_field',
        'cdo_sol_tagline'          => 'sanitize_text_field',
        'cdo_sol_number'           => 'sanitize_text_field',
        'cdo_sol_icon'             => 'sanitize_text_field',
        'cdo_sol_gradient'         => 'sanitize_text_field',
        'cdo_sol_subservices'      => 'sanitize_textarea_field',
        'cdo_sol_stack'            => 'sanitize_textarea_field',
        'cdo_sol_related_software' => 'sanitize_text_field',
    );
    foreach ( $fields as $key => $sanitizer ) {
        $value = isset( $_POST[ $key ] ) ? call_user_func( $sanitizer, wp_unslash( $_POST[ $key ] ) ) : '';
        update_post_meta( $post_id, '_' . $key, $value );
    }
}
add_action( 'save_post_cdo_solucion', 'cdo_solucion_save', 10, 2 );

/* ---------- Helpers ---------- */

function cdo_solucion_to_array( $post ) {
    $post = get_post( $post );
    if ( ! $post ) { return array(); }

    // Sub-servicios (icon | title | desc)
    $sub_raw = (string) get_post_meta( $post->ID, '_cdo_sol_subservices', true );
    $items   = array();
    foreach ( preg_split( '/\r?\n/', $sub_raw ) as $line ) {
        $line = trim( $line );
        if ( '' === $line ) { continue; }
        $parts = array_map( 'trim', explode( '|', $line ) );
        if ( count( $parts ) < 3 ) { continue; }
        $items[] = array(
            'icon'  => $parts[0],
            'title' => $parts[1],
            'desc'  => $parts[2],
        );
    }

    // Stack CSV
    $stack_raw = (string) get_post_meta( $post->ID, '_cdo_sol_stack', true );
    $stack     = array_values( array_filter( array_map( 'trim', preg_split( '/[,\n]+/', $stack_raw ) ) ) );

    // Productos relacionados (slugs)
    $related_raw = (string) get_post_meta( $post->ID, '_cdo_sol_related_software', true );
    $related     = array_values( array_filter( array_map( 'trim', preg_split( '/[,\s]+/', $related_raw ) ) ) );

    return array(
        'id'          => $post->post_name,
        'permalink'   => get_permalink( $post ),
        'name'        => $post->post_title,
        'desc'        => wp_strip_all_tags( $post->post_content ),
        'eyebrow'     => (string) get_post_meta( $post->ID, '_cdo_sol_eyebrow', true ),
        'tagline'     => (string) get_post_meta( $post->ID, '_cdo_sol_tagline', true ),
        'number'      => (string) get_post_meta( $post->ID, '_cdo_sol_number',  true ),
        'icon'        => (string) get_post_meta( $post->ID, '_cdo_sol_icon',    true ),
        'grad'        => (string) get_post_meta( $post->ID, '_cdo_sol_gradient', true ),
        'items'       => $items,
        'stack'       => $stack,
        'related_sw'  => $related,
    );
}

function cdo_get_solucion_categories() {
    $q = new WP_Query( array(
        'post_type'      => 'cdo_solucion',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
    ) );
    $out = array();
    foreach ( $q->posts as $p ) {
        $out[] = cdo_solucion_to_array( $p );
    }
    return $out;
}

/* ---------- Schema.org JSON-LD ---------- */

function cdo_solucion_jsonld_collection( $cats, $page_url ) {
    if ( empty( $cats ) ) { return ''; }
    $items = array();
    $i     = 1;
    foreach ( $cats as $c ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $i++,
            'url'      => $c['permalink'],
            'name'     => $c['name'],
        );
    }
    $data = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'CollectionPage',
        'name'       => get_the_title(),
        'url'        => $page_url,
        'inLanguage' => 'es',
        'isPartOf'   => array(
            '@type' => 'WebSite',
            'name'  => get_bloginfo( 'name' ),
            'url'   => home_url( '/' ),
        ),
        'mainEntity' => array(
            '@type'           => 'ItemList',
            'numberOfItems'   => count( $items ),
            'itemListElement' => $items,
        ),
    );
    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
    return '<script type="application/ld+json">' . "\n" . wp_json_encode( $data, $flags ) . "\n" . '</script>' . "\n";
}

function cdo_solucion_jsonld_single( $cat, $cat_url ) {
    if ( empty( $cat ) ) { return ''; }
    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
    $out   = '';

    $service = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => $cat['name'],
        'description' => $cat['desc'] ?: $cat['tagline'],
        'url'         => $cat_url,
        'inLanguage'  => 'es',
        'provider'    => array(
            '@type' => 'Organization',
            'name'  => 'cdo.solutions',
            'url'   => home_url( '/' ),
        ),
        'areaServed'  => 'ES',
    );
    if ( ! empty( $cat['items'] ) ) {
        $offers = array();
        foreach ( $cat['items'] as $it ) {
            $offers[] = array(
                '@type'       => 'Offer',
                'name'        => $it['title'],
                'description' => $it['desc'],
            );
        }
        $service['hasOfferCatalog'] = array(
            '@type'           => 'OfferCatalog',
            'name'            => $cat['name'],
            'itemListElement' => $offers,
        );
    }
    $out .= '<script type="application/ld+json">' . "\n" . wp_json_encode( $service, $flags ) . "\n" . '</script>' . "\n";

    $catalog_url = trailingslashit( home_url( '/soluciones/' ) );
    $bc = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'inLanguage'      => 'es',
        'itemListElement' => array(
            array( '@type' => 'ListItem', 'position' => 1, 'name' => __( 'Inicio',     'cdo-solutions' ), 'item' => home_url( '/' ) ),
            array( '@type' => 'ListItem', 'position' => 2, 'name' => __( 'Soluciones', 'cdo-solutions' ), 'item' => $catalog_url ),
            array( '@type' => 'ListItem', 'position' => 3, 'name' => $cat['name'],                       'item' => $cat_url ),
        ),
    );
    $out .= '<script type="application/ld+json">' . "\n" . wp_json_encode( $bc, $flags ) . "\n" . '</script>' . "\n";

    return $out;
}

/* ---------- Columnas en admin ---------- */

function cdo_solucion_admin_columns( $cols ) {
    $new = array();
    foreach ( $cols as $k => $v ) {
        $new[ $k ] = $v;
        if ( 'title' === $k ) {
            $new['cdo_sol_number']  = __( 'Nº',      'cdo-solutions' );
            $new['cdo_sol_eyebrow'] = __( 'Eyebrow', 'cdo-solutions' );
        }
    }
    return $new;
}
add_filter( 'manage_cdo_solucion_posts_columns', 'cdo_solucion_admin_columns' );

function cdo_solucion_admin_column_value( $col, $post_id ) {
    if ( 'cdo_sol_number' === $col )  { echo esc_html( get_post_meta( $post_id, '_cdo_sol_number',  true ) ); }
    if ( 'cdo_sol_eyebrow' === $col ) { echo esc_html( get_post_meta( $post_id, '_cdo_sol_eyebrow', true ) ); }
}
add_action( 'manage_cdo_solucion_posts_custom_column', 'cdo_solucion_admin_column_value', 10, 2 );
