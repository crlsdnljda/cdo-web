<?php
/**
 * Header — sticky black top nav con submenús (dropdown desktop / accordion móvil).
 *
 * @package CdoSolutions
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="light">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-surface-container-lowest text-on-surface font-body antialiased' ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#cdo-main"><?php esc_html_e( 'Saltar al contenido', 'cdo-solutions' ); ?></a>

<?php
/**
 * Construir el árbol del menú: top-level items + sus hijos (1 nivel).
 */
$location_id = get_nav_menu_locations()['primary'] ?? 0;
$raw_items   = $location_id ? wp_get_nav_menu_items( $location_id ) : array();

$tree = array(); // parent_id => [ items ]
if ( $raw_items ) {
    foreach ( $raw_items as $it ) {
        $tree[ (int) $it->menu_item_parent ][] = $it;
    }
}
$top_items = $tree[0] ?? array();

// Fallback si el menú está vacío
if ( ! $top_items ) {
    $top_items = array(
        (object) array( 'ID' => 0, 'title' => __( 'Inicio',         'cdo-solutions' ), 'url' => home_url( '/' ) ),
        (object) array( 'ID' => 0, 'title' => __( 'Soluciones',     'cdo-solutions' ), 'url' => home_url( '/soluciones/' ) ),
        (object) array( 'ID' => 0, 'title' => __( 'Software',       'cdo-solutions' ), 'url' => home_url( '/software/' ) ),
        (object) array( 'ID' => 0, 'title' => __( 'Sobre nosotros', 'cdo-solutions' ), 'url' => home_url( '/sobre-nosotros/' ) ),
        (object) array( 'ID' => 0, 'title' => __( 'Contacto',       'cdo-solutions' ), 'url' => home_url( '/contacto/' ) ),
    );
}

$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<nav class="cdo-topnav sticky top-0 w-full z-50 bg-black flex md:grid md:grid-cols-3 justify-between items-center px-6 md:px-8 py-4 md:py-5">
    <div class="md:justify-self-start">
        <?php cdo_logo( 'header' ); ?>
    </div>

    <!-- Desktop nav (centrado real con grid) -->
    <div class="hidden md:flex md:justify-self-center gap-2 items-center">
        <?php foreach ( $top_items as $item ) :
            $children = isset( $tree[ (int) $item->ID ] ) ? $tree[ (int) $item->ID ] : array();
            $is_current = isset( $item->url ) && trailingslashit( $item->url ) === trailingslashit( $current_url );
            $base_link = "font-['Plus_Jakarta_Sans'] font-bold tracking-tight uppercase text-xs hover:text-[#D8FD50] transition-colors duration-300 inline-flex items-center gap-1 py-2 px-3 rounded-md";
            $link_cls  = $is_current
                ? $base_link . ' text-white border-b-2 border-[#D8FD50] rounded-b-none'
                : $base_link . ' text-gray-400';
            ?>
            <?php if ( $children ) : ?>
                <div class="cdo-nav-item relative">
                    <a class="<?php echo esc_attr( $link_cls ); ?>" href="<?php echo esc_url( $item->url ); ?>">
                        <?php echo esc_html( $item->title ); ?>
                        <span class="material-symbols-outlined text-base cdo-nav-chevron" aria-hidden="true">expand_more</span>
                    </a>
                    <div class="cdo-nav-submenu absolute top-full right-0 lg:left-0 lg:right-auto pt-2 min-w-[240px]">
                        <ul class="bg-on-surface rounded-xl shadow-2xl py-2 border border-white/5">
                            <?php foreach ( $children as $child ) :
                                $child_current = isset( $child->url ) && trailingslashit( $child->url ) === trailingslashit( $current_url );
                                $child_cls = "block px-4 py-2.5 text-sm font-['Plus_Jakarta_Sans'] font-bold tracking-tight transition-colors";
                                $child_cls .= $child_current ? ' text-primary-container bg-white/5' : ' text-white hover:text-primary-container hover:bg-white/5';
                                ?>
                                <li>
                                    <a class="<?php echo esc_attr( $child_cls ); ?>" href="<?php echo esc_url( $child->url ); ?>">
                                        <?php echo esc_html( $child->title ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php else : ?>
                <a class="<?php echo esc_attr( $link_cls ); ?>" href="<?php echo esc_url( $item->url ); ?>">
                    <?php echo esc_html( $item->title ); ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="flex items-center gap-2 md:gap-3 md:justify-self-end">
        <a href="https://crm.cdo.solutions/"
           target="_blank" rel="noopener noreferrer"
           class="hidden md:inline-flex items-center gap-1.5 border border-white/30 text-white px-4 lg:px-5 py-2 font-headline font-bold text-xs uppercase tracking-widest rounded-lg hover:border-primary-container hover:text-primary-container transition-colors">
            <span class="material-symbols-outlined text-base" aria-hidden="true">login</span>
            <?php esc_html_e( 'Iniciar sesión', 'cdo-solutions' ); ?>
        </a>

        <a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"
           class="hidden sm:inline-block bg-primary-container text-on-primary-fixed px-5 md:px-6 py-2 font-headline font-bold text-xs uppercase tracking-widest rounded-lg hover:scale-105 active:scale-95 transition-transform">
            <?php esc_html_e( 'Hablemos', 'cdo-solutions' ); ?>
        </a>

        <button type="button"
                class="md:hidden w-11 h-11 flex items-center justify-center rounded-lg text-white hover:bg-white/10 active:scale-95 transition-all"
                data-cdo-menu-toggle
                aria-controls="cdo-mobile-menu"
                aria-expanded="false"
                aria-label="<?php esc_attr_e( 'Abrir menú', 'cdo-solutions' ); ?>">
            <span class="material-symbols-outlined text-3xl" aria-hidden="true">menu</span>
        </button>
    </div>
</nav>

<!-- Mobile menu overlay -->
<div id="cdo-mobile-menu"
     class="cdo-mobile-menu md:hidden"
     data-cdo-mobile-menu
     role="dialog"
     aria-modal="true"
     aria-label="<?php esc_attr_e( 'Menú principal', 'cdo-solutions' ); ?>">

    <?php foreach ( $top_items as $item ) :
        $children = isset( $tree[ (int) $item->ID ] ) ? $tree[ (int) $item->ID ] : array();
    ?>
        <?php if ( $children ) : ?>
            <details class="cdo-mobile-group" data-cdo-mobile-group>
                <summary class="cdo-mobile-group-summary">
                    <span><?php echo esc_html( $item->title ); ?></span>
                    <span class="material-symbols-outlined cdo-mobile-group-chevron" aria-hidden="true">expand_more</span>
                </summary>
                <div class="cdo-mobile-group-children">
                    <a href="<?php echo esc_url( $item->url ); ?>" class="cdo-mobile-group-parent">
                        <?php
                        /* translators: %s = nombre de la sección */
                        printf( esc_html__( 'Ver %s', 'cdo-solutions' ), esc_html( $item->title ) );
                        ?>
                    </a>
                    <?php foreach ( $children as $child ) : ?>
                        <a href="<?php echo esc_url( $child->url ); ?>" class="cdo-mobile-child">
                            <?php echo esc_html( $child->title ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </details>
        <?php else : ?>
            <a href="<?php echo esc_url( $item->url ); ?>"><?php echo esc_html( $item->title ); ?></a>
        <?php endif; ?>
    <?php endforeach; ?>

    <a href="https://crm.cdo.solutions/" target="_blank" rel="noopener noreferrer" class="cdo-mobile-login">
        <span class="material-symbols-outlined" aria-hidden="true">login</span>
        <?php esc_html_e( 'Iniciar sesión', 'cdo-solutions' ); ?>
    </a>
    <a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>" class="cdo-mobile-cta">
        <?php esc_html_e( 'Hablemos', 'cdo-solutions' ); ?>
    </a>
</div>

<main id="cdo-main">
