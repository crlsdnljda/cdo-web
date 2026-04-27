<?php
/**
 * Generic fallback template — used for the blog index, archives, search, etc.
 *
 * @package CdoSolutions
 */

get_header();
?>

<section class="py-32 px-8 bg-surface-container-lowest">
    <div class="max-w-5xl mx-auto">

        <header class="mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block">
                <?php
                if ( is_search() ) {
                    /* translators: %s = search term */
                    printf( esc_html__( 'Resultados para "%s"', 'cdo-solutions' ), esc_html( get_search_query() ) );
                } elseif ( is_archive() ) {
                    the_archive_title();
                } else {
                    esc_html_e( 'Blog', 'cdo-solutions' );
                }
                ?>
            </span>
            <h1 class="text-5xl md:text-6xl font-display font-extrabold tracking-tighter text-on-surface">
                <?php bloginfo( 'name' ); ?>
            </h1>
        </header>

        <?php if ( have_posts() ) : ?>

            <div class="space-y-12">
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class( 'border-b border-surface-container-highest pb-12 last:border-b-0' ); ?>>
                    <h2 class="text-3xl font-display font-bold tracking-tight mb-3">
                        <a class="hover:text-primary transition-colors" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="text-secondary text-sm font-bold uppercase tracking-widest mb-4">
                        <?php echo esc_html( get_the_date() ); ?>
                    </div>
                    <div class="text-secondary leading-relaxed">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="mt-6 inline-flex items-center gap-2 text-on-surface font-bold border-b-2 border-primary-container pb-1 hover:gap-3 transition-all">
                        <?php esc_html_e( 'Leer más', 'cdo-solutions' ); ?>
                        <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
                    </a>
                </article>
            <?php endwhile; ?>
            </div>

            <div class="mt-16">
                <?php the_posts_pagination( array(
                    'prev_text' => '&larr; ' . __( 'Anterior', 'cdo-solutions' ),
                    'next_text' => __( 'Siguiente', 'cdo-solutions' ) . ' &rarr;',
                ) ); ?>
            </div>

        <?php else : ?>

            <p class="text-xl text-secondary"><?php esc_html_e( 'No hay contenido todavía.', 'cdo-solutions' ); ?></p>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
