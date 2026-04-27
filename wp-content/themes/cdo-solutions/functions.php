<?php
/**
 * CDO Solutions theme — bootstrap.
 *
 * @package CdoSolutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CDO_THEME_VERSION', '1.0.0' );

/**
 * Cargar includes del tema (CPTs, helpers, etc.).
 */
require_once get_template_directory() . '/inc/cpt-software.php';
require_once get_template_directory() . '/inc/cpt-solucion.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/seo.php';

/**
 * Theme support + menus.
 */
function cdo_setup() {
    load_theme_textdomain( 'cdo-solutions', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'align-wide' );

    register_nav_menus( array(
        'primary' => __( 'Menú principal', 'cdo-solutions' ),
        'footer_servicios' => __( 'Footer · Servicios', 'cdo-solutions' ),
        'footer_agencia'   => __( 'Footer · Agencia', 'cdo-solutions' ),
        'footer_legal'     => __( 'Footer · Legal', 'cdo-solutions' ),
    ) );
}
add_action( 'after_setup_theme', 'cdo_setup' );

/**
 * Enqueue styles and scripts.
 *
 * Tailwind is loaded via CDN in the <head>, then the inline config runs AFTER
 * the CDN script so window.tailwind exists when we set tailwind.config.
 * Animations + mobile menu live in cdo-ui.js (deferred, footer).
 */
function cdo_assets() {
    wp_enqueue_style(
        'cdo-google-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'cdo-material-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'cdo-style',
        get_stylesheet_uri(),
        array( 'cdo-google-fonts', 'cdo-material-symbols' ),
        CDO_THEME_VERSION
    );

    wp_enqueue_script(
        'cdo-tailwind',
        'https://cdn.tailwindcss.com?plugins=forms,container-queries',
        array(),
        null,
        false // head
    );

    wp_add_inline_script( 'cdo-tailwind', cdo_tailwind_config_js(), 'after' );

    wp_enqueue_script(
        'cdo-ui',
        get_template_directory_uri() . '/assets/js/cdo-ui.js',
        array(),
        CDO_THEME_VERSION,
        true // footer
    );
}
add_action( 'wp_enqueue_scripts', 'cdo_assets' );

/**
 * Tailwind config payload. Runs AFTER the CDN script so `tailwind` is defined.
 * Mirrors the tokens of the Stitch "Architectural Vitality" export.
 */
function cdo_tailwind_config_js() {
    return <<<JS
window.tailwind && (tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "on-tertiary-fixed": "#3e0022",
        "on-surface-variant": "#454935",
        "surface-container": "#eceef2",
        "secondary-fixed-dim": "#c6c6c6",
        "surface-container-highest": "#e0e2e6",
        "secondary": "#5e5e5e",
        "primary-fixed-dim": "#b1d427",
        "tertiary-container": "#ffe8ee",
        "on-primary-fixed-variant": "#3e4c00",
        "on-background": "#191c1f",
        "on-secondary-container": "#646464",
        "on-tertiary-fixed-variant": "#8c0053",
        "on-secondary": "#ffffff",
        "surface-bright": "#f7f9fd",
        "surface": "#f7f9fd",
        "background": "#f7f9fd",
        "on-error": "#ffffff",
        "on-secondary-fixed": "#1b1b1b",
        "primary-fixed": "#cdf145",
        "surface-container-low": "#f2f4f8",
        "secondary-fixed": "#e2e2e2",
        "primary-container": "#d8fd50",
        "outline-variant": "#c5c9af",
        "on-primary-container": "#5e7400",
        "surface-tint": "#536600",
        "on-tertiary-container": "#c5267b",
        "on-error-container": "#93000a",
        "surface-variant": "#e0e2e6",
        "surface-container-lowest": "#ffffff",
        "surface-container-high": "#e6e8ec",
        "on-tertiary": "#ffffff",
        "primary": "#536600",
        "on-surface": "#191c1f",
        "inverse-on-surface": "#eff1f5",
        "tertiary-fixed": "#ffd9e4",
        "on-secondary-fixed-variant": "#474747",
        "outline": "#757963",
        "error": "#ba1a1a",
        "inverse-surface": "#2d3134",
        "on-primary": "#ffffff",
        "surface-dim": "#d8dade",
        "inverse-primary": "#b1d427",
        "tertiary": "#b4136d",
        "error-container": "#ffdad6",
        "secondary-container": "#e2e2e2",
        "on-primary-fixed": "#171e00",
        "tertiary-fixed-dim": "#ffb0cd"
      },
      borderRadius: {
        DEFAULT: "0.125rem",
        lg: "0.25rem",
        xl: "0.5rem",
        full: "0.75rem"
      },
      fontFamily: {
        headline: ["Plus Jakarta Sans", "system-ui", "sans-serif"],
        display:  ["Plus Jakarta Sans", "system-ui", "sans-serif"],
        body:     ["Inter", "system-ui", "sans-serif"],
        label:    ["Inter", "system-ui", "sans-serif"]
      }
    }
  }
});
JS;
}

/**
 * Register a few sidebars (footer-ready, optional).
 */
function cdo_widgets() {
    register_sidebar( array(
        'name' => __( 'Footer', 'cdo-solutions' ),
        'id'   => 'footer-1',
        'before_widget' => '<div class="cdo-footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="font-headline font-bold text-xs uppercase tracking-widest mb-6 text-on-surface">',
        'after_title'   => '</h5>',
    ) );
}
add_action( 'widgets_init', 'cdo_widgets' );

/**
 * Hide the WP admin bar on the front-end. Visitors never see it, and logged-in
 * users get a cleaner preview. Admin remains reachable at /wp-admin/.
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Helper: render an inline Material Symbols Outlined icon.
 */
function cdo_icon( $name, $classes = '' ) {
    printf(
        '<span class="material-symbols-outlined %s" aria-hidden="true">%s</span>',
        esc_attr( $classes ),
        esc_html( $name )
    );
}

/**
 * Helper: site logo "cdo.solutions" with split colors.
 *
 * @param string $variant 'header' (white/gray on dark) or 'footer' (dark on light).
 */
function cdo_logo( $variant = 'header' ) {
    $home = esc_url( home_url( '/' ) );
    if ( 'footer' === $variant ) {
        echo '<a href="' . $home . '" class="text-lg font-extrabold tracking-tighter">';
        echo '<span class="text-on-surface">cdo.</span><span class="text-secondary">solutions</span>';
        echo '</a>';
    } else {
        echo '<a href="' . $home . '" class="text-xl font-extrabold tracking-tighter">';
        echo '<span class="text-white">cdo.</span><span class="text-gray-400">solutions</span>';
        echo '</a>';
    }
}
