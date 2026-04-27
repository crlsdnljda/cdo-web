<?php
/**
 * CPT: Software (productos propios cdo.solutions)
 *
 * Registra el tipo de contenido `cdo_software` con todos los campos que
 * usa la página /software/ (template-software.php). El template lee
 * directamente los posts del CPT en vez de tener un array hardcoded.
 *
 * @package CdoSolutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- Opciones predefinidas ---------- */

/**
 * Gradientes disponibles para los productos. Clave => label visible en admin.
 * El valor de clave se guarda y se usa como string de clases Tailwind en el front.
 */
function cdo_software_gradients() {
    return array(
        'from-tertiary to-tertiary-fixed-dim'   => __( 'Rosa magenta',   'cdo-solutions' ),
        'from-[#10B981] to-[#6EE7B7]'           => __( 'Verde',           'cdo-solutions' ),
        'from-primary to-primary-container'     => __( 'Lima oliva',      'cdo-solutions' ),
        'from-[#6366F1] to-[#A5B4FC]'           => __( 'Azul violeta',    'cdo-solutions' ),
        'from-[#F59E0B] to-[#FCD34D]'           => __( 'Naranja ámbar',   'cdo-solutions' ),
        'from-[#EC4899] to-[#F9A8D4]'           => __( 'Rosa fucsia',     'cdo-solutions' ),
    );
}

/* ---------- Registrar el CPT ---------- */

function cdo_register_cpt_software() {
    $labels = array(
        'name'                  => _x( 'Software',  'post type general name',  'cdo-solutions' ),
        'singular_name'         => _x( 'Producto',  'post type singular name', 'cdo-solutions' ),
        'menu_name'             => __( 'Software',                              'cdo-solutions' ),
        'name_admin_bar'        => __( 'Producto Software',                     'cdo-solutions' ),
        'add_new'               => __( 'Añadir nuevo',                          'cdo-solutions' ),
        'add_new_item'          => __( 'Añadir nuevo producto',                 'cdo-solutions' ),
        'new_item'              => __( 'Nuevo producto',                        'cdo-solutions' ),
        'edit_item'             => __( 'Editar producto',                       'cdo-solutions' ),
        'view_item'             => __( 'Ver producto',                          'cdo-solutions' ),
        'all_items'             => __( 'Todos los productos',                   'cdo-solutions' ),
        'search_items'          => __( 'Buscar productos',                      'cdo-solutions' ),
        'not_found'             => __( 'No hay productos.',                     'cdo-solutions' ),
        'not_found_in_trash'    => __( 'No hay productos en la papelera.',      'cdo-solutions' ),
        'featured_image'        => __( 'Captura del producto',                  'cdo-solutions' ),
        'set_featured_image'    => __( 'Establecer captura',                    'cdo-solutions' ),
        'remove_featured_image' => __( 'Quitar captura',                        'cdo-solutions' ),
    );

    register_post_type( 'cdo_software', array(
        'labels'              => $labels,
        'description'         => __( 'Productos propios de software de cdo.solutions.', 'cdo-solutions' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_position'       => 22,
        'menu_icon'           => 'dashicons-screenoptions',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'rewrite'             => array(
            'slug'       => 'software',
            'with_front' => false,
            'feeds'      => false,
        ),
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    ) );
}
add_action( 'init', 'cdo_register_cpt_software' );

/**
 * Después de cambiar la configuración del CPT hay que regenerar las rewrite rules.
 * Esto se ejecuta una sola vez (versión bumped en option) y luego no vuelve a correr.
 */
function cdo_software_maybe_flush_rewrites() {
    if ( get_option( 'cdo_software_rewrites_v' ) !== '2' ) {
        flush_rewrite_rules( false );
        update_option( 'cdo_software_rewrites_v', '2' );
    }
}
add_action( 'init', 'cdo_software_maybe_flush_rewrites', 99 );

/* ---------- Meta box ---------- */

function cdo_software_meta_box() {
    add_meta_box(
        'cdo_software_details',
        __( 'Detalles del producto', 'cdo-solutions' ),
        'cdo_software_meta_box_render',
        'cdo_software',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'cdo_software_meta_box' );

function cdo_software_meta_box_render( $post ) {
    wp_nonce_field( 'cdo_software_save', 'cdo_software_nonce' );

    $eyebrow      = get_post_meta( $post->ID, '_cdo_eyebrow',      true );
    $tagline      = get_post_meta( $post->ID, '_cdo_tagline',      true );
    $icon         = get_post_meta( $post->ID, '_cdo_icon',         true );
    $gradient     = get_post_meta( $post->ID, '_cdo_gradient',     true );
    $price        = get_post_meta( $post->ID, '_cdo_price',        true );
    $price_period = get_post_meta( $post->ID, '_cdo_price_period', true );
    $price_iva    = get_post_meta( $post->ID, '_cdo_price_iva',    true );
    $unit_sing    = get_post_meta( $post->ID, '_cdo_unit_singular', true );
    $unit_plural  = get_post_meta( $post->ID, '_cdo_unit_plural',   true );
    $tiers        = get_post_meta( $post->ID, '_cdo_tiers',         true );
    $demo_url     = get_post_meta( $post->ID, '_cdo_demo_url',      true );
    $replaces     = get_post_meta( $post->ID, '_cdo_replaces',     true );
    $features     = get_post_meta( $post->ID, '_cdo_features',     true );

    if ( '' === $price_period ) { $price_period = '/mes'; }
    if ( '' === $price_iva )    { $price_iva    = '1'; }

    $gradients = cdo_software_gradients();
    ?>
    <style>
        .cdo-meta-grid { display:grid; grid-template-columns: 200px 1fr; gap: 14px 18px; align-items:start; }
        .cdo-meta-grid > label { font-weight:600; padding-top:8px; }
        .cdo-meta-grid input[type=text],
        .cdo-meta-grid input[type=number],
        .cdo-meta-grid select,
        .cdo-meta-grid textarea { width:100%; box-sizing:border-box; }
        .cdo-meta-grid textarea { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 12px; }
        .cdo-meta-help { color:#646970; font-size:12px; margin:4px 0 0; }
        .cdo-price-row { display:flex; gap:12px; align-items:center; }
        .cdo-price-row input[type=number] { width:120px; }
        .cdo-price-row input[type=text]   { width:100px; }
    </style>

    <div class="cdo-meta-grid">

        <label for="cdo_eyebrow"><?php esc_html_e( 'Eyebrow', 'cdo-solutions' ); ?></label>
        <div>
            <input type="text" id="cdo_eyebrow" name="cdo_eyebrow" value="<?php echo esc_attr( $eyebrow ); ?>" placeholder="Email marketing y automatización" />
            <p class="cdo-meta-help"><?php esc_html_e( 'Texto pequeño en mayúsculas que aparece encima del nombre del producto.', 'cdo-solutions' ); ?></p>
        </div>

        <label for="cdo_tagline"><?php esc_html_e( 'Tagline', 'cdo-solutions' ); ?></label>
        <div>
            <input type="text" id="cdo_tagline" name="cdo_tagline" value="<?php echo esc_attr( $tagline ); ?>" placeholder="Email marketing sin coste por contacto." />
            <p class="cdo-meta-help"><?php esc_html_e( 'Frase de una línea con la propuesta de valor principal.', 'cdo-solutions' ); ?></p>
        </div>

        <label for="cdo_icon"><?php esc_html_e( 'Icono (Material Symbol)', 'cdo-solutions' ); ?></label>
        <div>
            <input type="text" id="cdo_icon" name="cdo_icon" value="<?php echo esc_attr( $icon ); ?>" placeholder="mark_email_unread" />
            <p class="cdo-meta-help">
                <?php
                printf(
                    /* translators: %s = link to Material Symbols catalog */
                    esc_html__( 'Nombre del icono de %s. Ej: mark_email_unread, support_agent, shopping_cart.', 'cdo-solutions' ),
                    '<a href="https://fonts.google.com/icons" target="_blank" rel="noopener">Material Symbols</a>'
                );
                ?>
            </p>
        </div>

        <label for="cdo_gradient"><?php esc_html_e( 'Color del icono', 'cdo-solutions' ); ?></label>
        <div>
            <select id="cdo_gradient" name="cdo_gradient">
                <option value=""><?php esc_html_e( '— Selecciona un gradiente —', 'cdo-solutions' ); ?></option>
                <?php foreach ( $gradients as $value => $label ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $gradient, $value ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <label><?php esc_html_e( 'Precio base', 'cdo-solutions' ); ?></label>
        <div>
            <div class="cdo-price-row">
                <span><?php esc_html_e( 'Desde', 'cdo-solutions' ); ?></span>
                <input type="number" name="cdo_price" value="<?php echo esc_attr( $price ); ?>" placeholder="100" min="0" step="1" /> €
                <input type="text" name="cdo_price_period" value="<?php echo esc_attr( $price_period ); ?>" placeholder="/mes" />
                <label style="font-weight:normal;">
                    <input type="checkbox" name="cdo_price_iva" value="1" <?php checked( $price_iva, '1' ); ?> />
                    <?php esc_html_e( '+ IVA', 'cdo-solutions' ); ?>
                </label>
            </div>
            <p class="cdo-meta-help"><?php esc_html_e( 'Deja el precio vacío si quieres que aparezca solo "Pedir demo" sin importe. Si rellenas tramos abajo, este precio se ignora y se usa el del primer tramo.', 'cdo-solutions' ); ?></p>
        </div>

        <label><?php esc_html_e( 'Unidad escalable', 'cdo-solutions' ); ?></label>
        <div>
            <div class="cdo-price-row">
                <input type="text" name="cdo_unit_singular" value="<?php echo esc_attr( $unit_sing ); ?>" placeholder="contacto" />
                <input type="text" name="cdo_unit_plural"   value="<?php echo esc_attr( $unit_plural ); ?>" placeholder="contactos" />
            </div>
            <p class="cdo-meta-help"><?php esc_html_e( 'Singular y plural de la unidad por la que escala el precio (contacto / contactos, agente / agentes, usuario / usuarios). Solo se usa si rellenas tramos abajo.', 'cdo-solutions' ); ?></p>
        </div>

        <label for="cdo_tiers"><?php esc_html_e( 'Tramos de precio', 'cdo-solutions' ); ?></label>
        <div>
            <textarea id="cdo_tiers" name="cdo_tiers" rows="6" placeholder="5000 | 100
10000 | 150
25000 | 200
50000 | 300
100000 | 450"><?php echo esc_textarea( $tiers ); ?></textarea>
            <p class="cdo-meta-help">
                <strong><?php esc_html_e( 'Un tramo por línea, formato:', 'cdo-solutions' ); ?></strong> <code>cantidad_máxima | precio_en_euros</code><br>
                <?php esc_html_e( 'Si rellenas tramos, en la web aparece un slider para que el visitante calcule su precio en vivo. Déjalo vacío para mostrar solo el precio fijo de arriba.', 'cdo-solutions' ); ?>
            </p>
        </div>

        <label for="cdo_demo_url"><?php esc_html_e( 'URL del demo', 'cdo-solutions' ); ?></label>
        <div>
            <input type="url" id="cdo_demo_url" name="cdo_demo_url" value="<?php echo esc_attr( $demo_url ); ?>" placeholder="https://demo.cdo.solutions/cdo-mail" />
            <p class="cdo-meta-help"><?php esc_html_e( 'Enlace a una demo online, vídeo de YouTube/Loom, o entorno de pruebas. Si lo dejas vacío, el botón "Ver demo" enviará al formulario de contacto.', 'cdo-solutions' ); ?></p>
        </div>

        <label for="cdo_replaces"><?php esc_html_e( 'Reemplaza a', 'cdo-solutions' ); ?></label>
        <div>
            <textarea id="cdo_replaces" name="cdo_replaces" rows="2" placeholder="Mailchimp, Klaviyo, Active Campaign, Brevo"><?php echo esc_textarea( $replaces ); ?></textarea>
            <p class="cdo-meta-help"><?php esc_html_e( 'Lista de competidores separados por comas. Aparecen como pildoras debajo de la descripción.', 'cdo-solutions' ); ?></p>
        </div>

        <label for="cdo_features"><?php esc_html_e( 'Features', 'cdo-solutions' ); ?></label>
        <div>
            <textarea id="cdo_features" name="cdo_features" rows="10" placeholder="all_inclusive | Contactos ilimitados | Sin penalización por crecer tu lista
account_tree | Workflows visuales | Editor drag-and-drop para campañas multi-paso"><?php echo esc_textarea( $features ); ?></textarea>
            <p class="cdo-meta-help">
                <strong><?php esc_html_e( 'Una feature por línea, con este formato:', 'cdo-solutions' ); ?></strong><br>
                <code>icono | título | descripción</code><br>
                <?php esc_html_e( 'Ejemplo: ', 'cdo-solutions' ); ?><code>api | API y webhooks | Integración total con tu CRM, ecommerce y herramientas internas.</code>
            </p>
        </div>

    </div>
    <?php
}

/* ---------- Guardar ---------- */

function cdo_software_save( $post_id, $post ) {
    if ( ! isset( $_POST['cdo_software_nonce'] ) || ! wp_verify_nonce( $_POST['cdo_software_nonce'], 'cdo_software_save' ) ) { return; }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                                                                  { return; }
    if ( 'cdo_software' !== $post->post_type )                                                                            { return; }
    if ( ! current_user_can( 'edit_post', $post_id ) )                                                                    { return; }

    $fields = array(
        'cdo_eyebrow'       => 'sanitize_text_field',
        'cdo_tagline'       => 'sanitize_text_field',
        'cdo_icon'          => 'sanitize_text_field',
        'cdo_gradient'      => 'sanitize_text_field',
        'cdo_price'         => 'absint',
        'cdo_price_period'  => 'sanitize_text_field',
        'cdo_unit_singular' => 'sanitize_text_field',
        'cdo_unit_plural'   => 'sanitize_text_field',
        'cdo_tiers'         => 'sanitize_textarea_field',
        'cdo_demo_url'      => 'esc_url_raw',
        'cdo_replaces'      => 'sanitize_textarea_field',
        'cdo_features'      => 'sanitize_textarea_field',
    );
    foreach ( $fields as $key => $sanitizer ) {
        $value = isset( $_POST[ $key ] ) ? call_user_func( $sanitizer, wp_unslash( $_POST[ $key ] ) ) : '';
        update_post_meta( $post_id, '_' . $key, $value );
    }
    update_post_meta( $post_id, '_cdo_price_iva', isset( $_POST['cdo_price_iva'] ) ? '1' : '0' );
}
add_action( 'save_post_cdo_software', 'cdo_software_save', 10, 2 );

/* ---------- Helper para el template ---------- */

/**
 * Convierte un post de CPT software al array que usa template-software.php.
 *
 * @param int|WP_Post $post
 * @return array
 */
function cdo_software_to_array( $post ) {
    $post = get_post( $post );
    if ( ! $post ) { return array(); }

    // Replaces: CSV → array de strings limpio
    $replaces_raw = (string) get_post_meta( $post->ID, '_cdo_replaces', true );
    $replaces     = array_filter( array_map( 'trim', preg_split( '/[,\n]+/', $replaces_raw ) ) );

    // Features: una por línea, formato icon | title | desc
    $features_raw = (string) get_post_meta( $post->ID, '_cdo_features', true );
    $features     = array();
    foreach ( preg_split( '/\r?\n/', $features_raw ) as $line ) {
        $line = trim( $line );
        if ( '' === $line ) { continue; }
        $parts = array_map( 'trim', explode( '|', $line ) );
        if ( count( $parts ) < 3 ) { continue; }
        $features[] = array(
            'icon'  => $parts[0],
            'title' => $parts[1],
            'desc'  => $parts[2],
        );
    }

    // Tiers: una línea por tramo, formato "max | price"
    $tiers_raw = (string) get_post_meta( $post->ID, '_cdo_tiers', true );
    $tiers     = array();
    foreach ( preg_split( '/\r?\n/', $tiers_raw ) as $line ) {
        $line = trim( $line );
        if ( '' === $line ) { continue; }
        $parts = array_map( 'trim', explode( '|', $line ) );
        if ( count( $parts ) < 2 ) { continue; }
        $max   = (int) preg_replace( '/[^0-9]/', '', $parts[0] );
        $price = (int) preg_replace( '/[^0-9]/', '', $parts[1] );
        if ( $max > 0 && $price > 0 ) {
            $tiers[] = array( 'max' => $max, 'price' => $price );
        }
    }
    // Ordenar ascendente por max
    usort( $tiers, function ( $a, $b ) { return $a['max'] - $b['max']; } );

    return array(
        'id'           => $post->post_name,
        'permalink'    => get_permalink( $post ),
        'name'         => $post->post_title,
        'eyebrow'      => (string) get_post_meta( $post->ID, '_cdo_eyebrow', true ),
        'tagline'      => (string) get_post_meta( $post->ID, '_cdo_tagline', true ),
        'desc'         => wp_strip_all_tags( $post->post_content ),
        'icon'         => (string) get_post_meta( $post->ID, '_cdo_icon', true ),
        'grad'         => (string) get_post_meta( $post->ID, '_cdo_gradient', true ),
        'price'        => (int)    get_post_meta( $post->ID, '_cdo_price', true ),
        'price_period' => (string) ( get_post_meta( $post->ID, '_cdo_price_period', true ) ?: '/mes' ),
        'price_iva'    => '1' === get_post_meta( $post->ID, '_cdo_price_iva', true ),
        'unit_sing'    => (string) get_post_meta( $post->ID, '_cdo_unit_singular', true ),
        'unit_plural'  => (string) get_post_meta( $post->ID, '_cdo_unit_plural',   true ),
        'tiers'        => $tiers,
        'demo_url'     => (string) get_post_meta( $post->ID, '_cdo_demo_url',      true ),
        'replaces'     => array_values( $replaces ),
        'features'     => $features,
    );
}

/**
 * Devuelve todos los productos publicados ordenados por menu_order y luego fecha.
 *
 * @return array[]
 */
function cdo_get_software_products() {
    $q = new WP_Query( array(
        'post_type'      => 'cdo_software',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
    ) );
    $out = array();
    foreach ( $q->posts as $p ) {
        $out[] = cdo_software_to_array( $p );
    }
    return $out;
}

/* ---------- Schema.org JSON-LD ---------- */

/**
 * Construye el array de datos schema.org/SoftwareApplication para un producto.
 *
 * @param array  $product Producto normalizado (ver cdo_software_to_array).
 * @param string $page_url URL absoluta de la página /software/.
 * @return array
 */
function cdo_software_jsonld_data( $product, $page_url ) {
    $product_url = $page_url . '#' . $product['id'];
    $features    = array();
    foreach ( (array) $product['features'] as $f ) {
        if ( ! empty( $f['title'] ) ) { $features[] = $f['title']; }
    }

    $offers = array();
    if ( ! empty( $product['tiers'] ) ) {
        foreach ( $product['tiers'] as $tier ) {
            $offers[] = array(
                '@type'         => 'Offer',
                'price'         => (string) $tier['price'],
                'priceCurrency' => 'EUR',
                'name'          => sprintf(
                    /* translators: 1: cantidad, 2: unidad plural */
                    __( 'Hasta %1$s %2$s', 'cdo-solutions' ),
                    number_format_i18n( $tier['max'] ),
                    $product['unit_plural'] ?: ''
                ),
                'availability'  => 'https://schema.org/InStock',
                'url'           => $product_url,
                'priceSpecification' => array(
                    '@type'         => 'UnitPriceSpecification',
                    'price'         => (string) $tier['price'],
                    'priceCurrency' => 'EUR',
                    'unitText'      => 'MONTH',
                    'valueAddedTaxIncluded' => false,
                ),
            );
        }
    } elseif ( ! empty( $product['price'] ) ) {
        $offers[] = array(
            '@type'         => 'Offer',
            'price'         => (string) $product['price'],
            'priceCurrency' => 'EUR',
            'availability'  => 'https://schema.org/InStock',
            'url'           => $product_url,
            'priceSpecification' => array(
                '@type'         => 'UnitPriceSpecification',
                'price'         => (string) $product['price'],
                'priceCurrency' => 'EUR',
                'unitText'      => 'MONTH',
                'valueAddedTaxIncluded' => false,
            ),
        );
    }

    $data = array(
        '@context'            => 'https://schema.org',
        '@type'               => 'SoftwareApplication',
        'name'                => $product['name'],
        'description'         => $product['desc'],
        'applicationCategory' => 'BusinessApplication',
        'operatingSystem'     => 'Web, Linux, Windows, Android',
        'url'                 => $product_url,
        'inLanguage'          => 'es',
        'brand'               => array(
            '@type' => 'Brand',
            'name'  => 'cdo.solutions',
        ),
        'provider'            => array(
            '@type' => 'Organization',
            'name'  => 'cdo.solutions',
            'url'   => home_url( '/' ),
        ),
    );

    if ( ! empty( $features ) ) {
        $data['featureList'] = $features;
    }
    if ( ! empty( $offers ) ) {
        $data['offers'] = 1 === count( $offers ) ? $offers[0] : $offers;
    }

    return $data;
}

/**
 * JSON-LD del catálogo /software/ (CollectionPage + ItemList apuntando a las páginas individuales).
 */
function cdo_software_jsonld_collection( $products, $page_url ) {
    if ( empty( $products ) ) { return ''; }

    $items = array();
    $i     = 1;
    foreach ( $products as $p ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $i++,
            'url'      => ! empty( $p['permalink'] ) ? $p['permalink'] : $page_url . '#' . $p['id'],
            'name'     => $p['name'],
        );
    }

    $collection = array(
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
            'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
            'numberOfItems'   => count( $items ),
            'itemListElement' => $items,
        ),
    );

    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
    return '<script type="application/ld+json">' . "\n" . wp_json_encode( $collection, $flags ) . "\n" . '</script>' . "\n";
}

/**
 * JSON-LD de una página individual de producto (SoftwareApplication + BreadcrumbList).
 */
function cdo_software_jsonld_single( $product, $product_url ) {
    if ( empty( $product ) ) { return ''; }

    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
    $out   = '';

    $sa = cdo_software_jsonld_data( $product, $product_url );
    // Sobreescribir url para que sea exactamente la URL canónica del producto.
    $sa['url'] = $product_url;
    $out .= '<script type="application/ld+json">' . "\n" . wp_json_encode( $sa, $flags ) . "\n" . '</script>' . "\n";

    $catalog_url = trailingslashit( home_url( '/software/' ) );
    $bc = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => array(
            array( '@type' => 'ListItem', 'position' => 1, 'name' => __( 'Inicio',   'cdo-solutions' ), 'item' => home_url( '/' ) ),
            array( '@type' => 'ListItem', 'position' => 2, 'name' => __( 'Software', 'cdo-solutions' ), 'item' => $catalog_url ),
            array( '@type' => 'ListItem', 'position' => 3, 'name' => $product['name'],                  'item' => $product_url ),
        ),
    );
    $out .= '<script type="application/ld+json">' . "\n" . wp_json_encode( $bc, $flags ) . "\n" . '</script>' . "\n";

    return $out;
}

/* ---------- Columnas del listado en admin ---------- */

function cdo_software_admin_columns( $cols ) {
    $new = array();
    foreach ( $cols as $k => $v ) {
        $new[ $k ] = $v;
        if ( 'title' === $k ) {
            $new['cdo_eyebrow'] = __( 'Eyebrow', 'cdo-solutions' );
            $new['cdo_price']   = __( 'Precio',  'cdo-solutions' );
        }
    }
    return $new;
}
add_filter( 'manage_cdo_software_posts_columns', 'cdo_software_admin_columns' );

function cdo_software_admin_column_value( $col, $post_id ) {
    if ( 'cdo_eyebrow' === $col ) {
        echo esc_html( get_post_meta( $post_id, '_cdo_eyebrow', true ) );
    } elseif ( 'cdo_price' === $col ) {
        $price  = (int)    get_post_meta( $post_id, '_cdo_price',        true );
        $period = (string) get_post_meta( $post_id, '_cdo_price_period', true );
        if ( $price ) {
            echo esc_html( $price . ' € ' . $period );
        } else {
            echo '—';
        }
    }
}
add_action( 'manage_cdo_software_posts_custom_column', 'cdo_software_admin_column_value', 10, 2 );
