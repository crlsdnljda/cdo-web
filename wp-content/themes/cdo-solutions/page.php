<?php
/**
 * Generic page template — used when a Page has no template assigned.
 *
 * @package CdoSolutions
 */

get_header();
?>

<section class="py-32 px-8 bg-surface-container-lowest">
    <div class="max-w-4xl mx-auto">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h1 class="text-5xl md:text-6xl font-display font-extrabold tracking-tighter mb-12 text-on-surface"><?php the_title(); ?></h1>
                <div class="prose prose-lg max-w-none text-secondary leading-relaxed">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>
