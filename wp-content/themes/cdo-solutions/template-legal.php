<?php
/**
 * Template Name: Legal (privacidad / cookies / aviso)
 *
 * Para páginas que vienen del plugin Adapta RGPD u otros generadores.
 * El contenido HTML semántico (h2/p/ul/...) se estiliza vía .cdo-legal-content
 * en style.css, aplicando la tipografía de marca y el acento lima.
 *
 * @package CdoSolutions
 */

get_header();
?>

<!-- Hero legal -->
<section class="cdo-hero relative pt-20 md:pt-28 pb-10 md:pb-14 px-6 md:px-8 overflow-hidden bg-surface-container-lowest">
    <div class="cdo-blob absolute top-[-15%] right-[-10%] w-[380px] md:w-[460px] h-[380px] md:h-[460px] bg-primary opacity-10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute top-[20%] left-[-10%] w-[280px] md:w-[340px] h-[280px] md:h-[340px] bg-tertiary opacity-08 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        <span data-cdo-reveal class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block">
            <?php esc_html_e( 'Información legal', 'cdo-solutions' ); ?>
        </span>
        <h1 data-cdo-reveal data-cdo-delay="100"
            class="cdo-hero-headline font-display text-4xl md:text-5xl lg:text-6xl font-extrabold text-on-surface leading-[1.05] tracking-tighter">
            <?php the_title(); ?>
        </h1>
        <p data-cdo-reveal data-cdo-delay="200" class="mt-6 text-sm md:text-base text-secondary">
            <?php
            /* translators: %s = formatted last updated date */
            printf(
                esc_html__( 'Última actualización: %s', 'cdo-solutions' ),
                '<strong class="text-on-surface font-semibold">' . esc_html( wp_date( 'j \\d\\e F \\d\\e Y', get_post_modified_time( 'U' ) ) ) . '</strong>'
            );
            ?>
        </p>
    </div>
</section>

<!-- Contenido -->
<section class="py-12 md:py-20 px-6 md:px-8 bg-surface-container-lowest border-t border-surface-container-highest">
    <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-10 lg:gap-16">

        <!-- Sidebar de páginas legales -->
        <aside class="hidden lg:block">
            <div class="sticky top-28">
                <div class="text-[10px] font-bold uppercase tracking-[0.3em] text-secondary mb-4">
                    <?php esc_html_e( 'Documentos', 'cdo-solutions' ); ?>
                </div>
                <nav class="flex flex-col gap-1">
                    <?php
                    $legal_links = array(
                        'aviso-legal'          => __( 'Aviso legal',            'cdo-solutions' ),
                        'politica-privacidad'  => __( 'Política de privacidad', 'cdo-solutions' ),
                        'politica-de-cookies'  => __( 'Política de cookies',    'cdo-solutions' ),
                        'personalizar-cookies' => __( 'Personalizar cookies',   'cdo-solutions' ),
                    );
                    $current_slug = get_post_field( 'post_name' );
                    foreach ( $legal_links as $slug => $label ) :
                        $page = get_page_by_path( $slug );
                        if ( ! $page || 'publish' !== $page->post_status ) {
                            continue;
                        }
                        $active = ( $slug === $current_slug );
                        $cls = 'block px-3 py-2 text-sm font-medium rounded-lg transition-colors ';
                        $cls .= $active
                            ? 'bg-primary-container text-on-primary-fixed'
                            : 'text-secondary hover:bg-surface-container-low hover:text-on-surface';
                        ?>
                        <a class="<?php echo esc_attr( $cls ); ?>" href="<?php echo esc_url( get_permalink( $page ) ); ?>">
                            <?php echo esc_html( $label ); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </aside>

        <!-- Contenido del plugin -->
        <article data-cdo-reveal class="cdo-legal-content min-w-0">
            <?php
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </article>

    </div>
</section>

<?php get_footer(); ?>
