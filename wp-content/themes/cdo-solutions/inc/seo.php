<?php
/**
 * SEO + GEO optimization para cdo.solutions.
 *
 * Cubre lo que WordPress no incluye por defecto:
 * - Meta description por página
 * - Open Graph + Twitter Cards (compartir en redes/Slack/WhatsApp)
 * - Organization schema (sitewide)
 * - LocalBusiness schema (páginas con servicio geo-restringido)
 * - FAQ schema (página de contacto)
 * - WebSite schema con SearchAction
 *
 * @package CdoSolutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- Meta description por página ---------- */

/**
 * Devuelve la meta description adecuada según la página actual.
 */
function cdo_meta_description() {
    if ( is_front_page() ) {
        return __( 'cdo.solutions — Software propio + servicios para empresas omnicanal con tienda online y tiendas físicas. E-commerce, transporte y mantenimiento técnico para todo el mercado europeo.', 'cdo-solutions' );
    }

    if ( is_singular() ) {
        $post = get_post();

        // Software (cdo.mail, cdo.chat, cdo.screen)
        if ( 'cdo_software' === $post->post_type ) {
            $tagline = (string) get_post_meta( $post->ID, '_cdo_tagline', true );
            $base    = $tagline ?: $post->post_title;
            return wp_strip_all_tags( $base . ' — Software propio cdo.solutions, self-hosted, sin coste por contacto.' );
        }

        // Soluciones (Soporte, Transporte, Mantenimiento)
        if ( 'cdo_solucion' === $post->post_type ) {
            $tagline = (string) get_post_meta( $post->ID, '_cdo_sol_tagline', true );
            return wp_strip_all_tags( $tagline ?: wp_trim_words( $post->post_content, 28 ) );
        }

        // Páginas estáticas
        if ( has_excerpt() ) {
            return wp_strip_all_tags( get_the_excerpt() );
        }
        $content = wp_strip_all_tags( $post->post_content );
        if ( $content ) {
            return wp_trim_words( $content, 28 );
        }
    }

    // Fallback: tagline del sitio o mensaje por defecto
    $blogdesc = get_bloginfo( 'description' );
    return $blogdesc ?: __( 'cdo.solutions — Software propio y servicios para empresas omnicanal.', 'cdo-solutions' );
}

/* ---------- Output de meta tags ---------- */

function cdo_seo_meta_tags() {
    if ( is_404() ) { return; }

    $description = cdo_meta_description();
    $title       = wp_get_document_title();
    $url         = is_singular() ? get_permalink() : home_url( $_SERVER['REQUEST_URI'] ?? '/' );
    $site_name   = get_bloginfo( 'name' );
    $image       = '';

    // Featured image si existe
    if ( is_singular() && has_post_thumbnail() ) {
        $image = get_the_post_thumbnail_url( get_post(), 'large' );
    }

    // SEO básico
    echo "\n<!-- SEO meta -->\n";
    echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $description ) ) . '">' . "\n";

    // Open Graph
    $og_type = is_singular( array( 'cdo_software', 'cdo_solucion' ) ) ? 'product' : ( is_singular() ? 'article' : 'website' );
    echo '<meta property="og:type"        content="' . esc_attr( $og_type ) . '">' . "\n";
    echo '<meta property="og:title"       content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta property="og:url"         content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:locale"      content="es_ES">' . "\n";
    echo '<meta property="og:site_name"   content="' . esc_attr( $site_name ) . '">' . "\n";
    if ( $image ) {
        echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
        echo '<meta property="og:image:alt" content="' . esc_attr( $title ) . '">' . "\n";
    }

    // Twitter Card
    echo '<meta name="twitter:card"        content="' . ( $image ? 'summary_large_image' : 'summary' ) . '">' . "\n";
    echo '<meta name="twitter:title"       content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
    if ( $image ) {
        echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
    }

    // Robots: dejamos a WP gestionar el noindex/follow estándar
}
add_action( 'wp_head', 'cdo_seo_meta_tags', 5 );

/* ---------- Organization + WebSite schema (sitewide) ---------- */

function cdo_organization_schema() {
    static $printed = false;
    if ( $printed ) { return; }
    $printed = true;

    // Logo desde el site_icon de WordPress (lo definió el usuario).
    // Schema.org recomienda tamaño mínimo 112×112; site_icon es 512×512.
    $logo_url = function_exists( 'get_site_icon_url' ) ? get_site_icon_url( 512 ) : '';

    $org = array(
        '@context'      => 'https://schema.org',
        '@type'         => 'Organization',
        '@id'           => home_url( '/#organization' ),
        'name'          => 'cdo.solutions',
        'alternateName' => 'CDO Solutions',
        'legalName'     => 'cdo.solutions',
        'description'   => __( 'Centro de Desarrollo Online — Software propio y servicios integrales para empresas omnicanal con tienda online y tiendas físicas. Cobertura España y mercado europeo; soporte presencial en Gipuzkoa y transporte local en País Vasco.', 'cdo-solutions' ),
        'url'           => home_url( '/' ),
        'logo'          => $logo_url ?: home_url( '/' ),
        'image'         => $logo_url ?: home_url( '/' ),
        'inLanguage'    => 'es',
        'founder'       => array(
            '@type' => 'Person',
            'name'  => 'Carlos Daniel Ojeda',
        ),
        'address'       => array(
            '@type'           => 'PostalAddress',
            'addressRegion'   => 'Gipuzkoa',
            'addressCountry'  => 'ES',
        ),
        'areaServed'    => array(
            array( '@type' => 'Country', 'name' => 'España' ),
            array( '@type' => 'Place',   'name' => 'Unión Europea' ),
        ),
        'contactPoint'  => array(
            '@type'             => 'ContactPoint',
            'contactType'       => 'customer support',
            'url'               => home_url( '/contacto/' ),
            'availableLanguage' => array( 'es' ),
            'areaServed'        => 'EU',
        ),
        'knowsAbout'    => array(
            'E-commerce', 'Email marketing', 'Atención al cliente omnicanal',
            'Cartelería digital', 'Logística de última milla',
            'Mantenimiento informático', 'Infraestructura de red',
            'Mautic', 'Chatwoot', 'Xibo', 'Shopify', 'PrestaShop', 'WooCommerce',
        ),
    );

    $website = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'WebSite',
        '@id'         => home_url( '/#website' ),
        'name'        => get_bloginfo( 'name' ),
        'url'         => home_url( '/' ),
        'inLanguage'  => 'es',
        'publisher'   => array( '@id' => home_url( '/#organization' ) ),
    );

    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
    echo '<script type="application/ld+json">' . "\n" . wp_json_encode( $org, $flags ) . "\n" . '</script>' . "\n";
    echo '<script type="application/ld+json">' . "\n" . wp_json_encode( $website, $flags ) . "\n" . '</script>' . "\n";
}
add_action( 'wp_head', 'cdo_organization_schema', 6 );

/* ---------- LocalBusiness schema (Mantenimiento + Transporte) ---------- */

function cdo_localbusiness_schema() {
    if ( ! is_singular( 'cdo_solucion' ) ) { return; }

    $slug = (string) get_post_field( 'post_name' );
    if ( ! in_array( $slug, array( 'mantenimiento', 'transporte' ), true ) ) { return; }

    $name        = get_the_title();
    $description = (string) get_post_meta( get_the_ID(), '_cdo_sol_tagline', true );

    if ( 'mantenimiento' === $slug ) {
        $area = array(
            array(
                '@type' => 'AdministrativeArea',
                'name'  => 'Gipuzkoa',
            ),
        );
        $region    = 'Gipuzkoa';
        $business  = 'ProfessionalService';
    } else {
        $area = array(
            array( '@type' => 'AdministrativeArea', 'name' => 'Bizkaia' ),
            array( '@type' => 'AdministrativeArea', 'name' => 'Gipuzkoa' ),
            array( '@type' => 'AdministrativeArea', 'name' => 'Álava' ),
        );
        $region    = 'País Vasco';
        // Schema.org no tiene "DeliveryService" como tipo; LocalBusiness
        // es el tipo válido más cercano para un negocio local de transporte.
        $business  = 'LocalBusiness';
    }

    $data = array(
        '@context'    => 'https://schema.org',
        '@type'       => $business,
        '@id'         => get_permalink() . '#localbusiness',
        'name'        => 'cdo.solutions — ' . $name,
        'description' => $description,
        'url'         => get_permalink(),
        'inLanguage'  => 'es',
        'image'       => has_post_thumbnail() ? get_the_post_thumbnail_url( get_post(), 'large' ) : '',
        'priceRange'  => '€€',
        'address'     => array(
            '@type'          => 'PostalAddress',
            'addressRegion'  => $region,
            'addressCountry' => 'ES',
        ),
        'areaServed'  => $area,
        'parentOrganization' => array( '@id' => home_url( '/#organization' ) ),
        'openingHoursSpecification' => array(
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
            'opens'     => '09:00',
            'closes'    => '19:00',
        ),
    );
    if ( empty( $data['image'] ) ) { unset( $data['image'] ); }

    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
    echo '<script type="application/ld+json">' . "\n" . wp_json_encode( $data, $flags ) . "\n" . '</script>' . "\n";
}
add_action( 'wp_head', 'cdo_localbusiness_schema', 7 );

/* ---------- FAQ schema (página de Contacto) ---------- */

function cdo_faq_schema() {
    if ( ! is_page() ) { return; }
    if ( get_post_field( 'post_name' ) !== 'contacto' ) { return; }

    $faqs = array(
        array(
            __( '¿Cuánto tarda un proyecto típico en arrancar?', 'cdo-solutions' ),
            __( 'Iniciamos los trabajos tan pronto recibimos la orden. Un proyecto estándar entra en producción en cuestión de días.', 'cdo-solutions' ),
        ),
        array(
            __( '¿Trabajáis con tiendas pequeñas o solo grandes?', 'cdo-solutions' ),
            __( 'Colaboramos sobre todo con empresas de cierto tamaño con tiendas online en marcha, pero estudiamos cada caso antes de proponer.', 'cdo-solutions' ),
        ),
        array(
            __( '¿Hacéis soporte presencial?', 'cdo-solutions' ),
            __( 'Sí. Vamos a oficinas para reparar PCs, montar y mantener infraestructura de red, además del soporte técnico online de las herramientas que automatizamos.', 'cdo-solutions' ),
        ),
        array(
            __( '¿Qué información necesitáis para una propuesta?', 'cdo-solutions' ),
            __( 'Un email contándonos qué quieres conseguir, qué herramientas usas hoy y cuáles son tus métricas actuales. Con eso preparamos un primer plan.', 'cdo-solutions' ),
        ),
    );

    $items = array();
    foreach ( $faqs as $f ) {
        $items[] = array(
            '@type'          => 'Question',
            'name'           => $f[0],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $f[1],
            ),
        );
    }

    $data = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'inLanguage' => 'es',
        'mainEntity' => $items,
    );

    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
    echo '<script type="application/ld+json">' . "\n" . wp_json_encode( $data, $flags ) . "\n" . '</script>' . "\n";
}
add_action( 'wp_head', 'cdo_faq_schema', 8 );

/* ---------- Mejoras de excerpts (más largo para evitar el "..." cortado) ---------- */

function cdo_excerpt_length( $length ) {
    return 28;
}
add_filter( 'excerpt_length', 'cdo_excerpt_length' );

/* ---------- Sitemap: limpiar contenido sensible o irrelevante ---------- */

/**
 * Excluir el provider de "users" del sitemap (no queremos exponer la URL de los
 * autores — revela el username del admin y es ruido para SEO).
 */
function cdo_sitemap_remove_users( $provider, $name ) {
    if ( 'users' === $name ) { return false; }
    return $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'cdo_sitemap_remove_users', 10, 2 );

/**
 * Excluir CPTs internos del sitemap (consultas del formulario son privadas).
 */
function cdo_sitemap_filter_post_types( $post_types ) {
    unset( $post_types['cdo_contact_msg'] );
    return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'cdo_sitemap_filter_post_types' );

/**
 * Reescribe la lista de páginas excluidas del sitemap.
 *
 * Adapta RGPD (prio 10) excluye Aviso Legal porque tiene `avisolegalID = 16`
 * registrado y `robots-index = 0`. Eso es indeseado: el Aviso Legal tiene
 * contenido propio y queremos que Google lo descubra. Corremos a prio 20
 * (después del plugin) y forzamos la lista a SOLO las páginas que de verdad
 * no aportan nada al SEO.
 */
function cdo_sitemap_exclude_pages( $args, $post_type ) {
    if ( 'page' !== $post_type ) { return $args; }
    $exclude_slugs = array( 'pagina-ejemplo', 'personalizar-cookies' );
    $exclude_ids   = array();
    foreach ( $exclude_slugs as $slug ) {
        $page = get_page_by_path( $slug );
        if ( $page ) { $exclude_ids[] = (int) $page->ID; }
    }
    $args['post__not_in'] = $exclude_ids;
    return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'cdo_sitemap_exclude_pages', 20, 2 );

/* ---------- Robots.txt enriquecido ---------- */

function cdo_robots_txt( $output, $public ) {
    if ( ! $public ) { return $output; } // si blog_public=0, mantener el "Disallow: /"

    $sitemap = esc_url_raw( home_url( '/wp-sitemap.xml' ) );
    $output  = "User-agent: *\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Disallow: /wp-login.php\n";
    $output .= "Disallow: /xmlrpc.php\n";
    $output .= "Disallow: /?s=\n";
    $output .= "Disallow: /search/\n";
    $output .= "Disallow: /wp-content/plugins/\n";
    $output .= "Disallow: /wp-content/cache/\n";
    $output .= "Disallow: /readme.html\n";
    $output .= "Disallow: /license.txt\n";
    $output .= "Allow: /wp-admin/admin-ajax.php\n";
    $output .= "Allow: /wp-content/uploads/\n";
    $output .= "\n";
    $output .= "Sitemap: {$sitemap}\n";

    return $output;
}
add_filter( 'robots_txt', 'cdo_robots_txt', 10, 2 );
