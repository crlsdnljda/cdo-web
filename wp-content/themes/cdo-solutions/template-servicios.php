<?php
/**
 * Template Name: Soluciones
 *
 * Catálogo de las 3 áreas de servicio: Soporte (e-commerce),
 * Transporte (logística) y Mantenimiento (soporte técnico/infraestructura).
 *
 * Cada área es una entrada del CPT cdo_solucion con su URL /soluciones/{slug}/.
 *
 * @package CdoSolutions
 */

get_header();

$categories   = cdo_get_solucion_categories();
$contacto_url = esc_url( home_url( '/contacto/' ) );
$page_url     = trailingslashit( get_permalink() );
?>

<?php echo cdo_solucion_jsonld_collection( $categories, $page_url ); ?>

<!-- Hero -->
<section class="cdo-hero relative pt-20 md:pt-28 pb-14 md:pb-20 px-6 md:px-8 overflow-hidden bg-surface-container-lowest">
    <div class="cdo-blob absolute top-[-15%] right-[-10%] w-[400px] md:w-[500px] h-[400px] md:h-[500px] bg-tertiary opacity-10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute top-[20%] left-[-10%] w-[320px] md:w-[400px] h-[320px] md:h-[400px] bg-primary opacity-15 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10 text-center">
        <span data-cdo-reveal class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-6 block"><?php esc_html_e( 'Soluciones', 'cdo-solutions' ); ?></span>
        <h1 data-cdo-reveal data-cdo-delay="100"
            class="cdo-hero-headline font-display text-[2.25rem] sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-on-surface leading-[1.05] tracking-tighter">
            <?php esc_html_e( 'Tres áreas, un único', 'cdo-solutions' ); ?>
            <span class="text-primary-container bg-black px-2 inline-block"><?php esc_html_e( 'equipo', 'cdo-solutions' ); ?></span><?php esc_html_e( '.', 'cdo-solutions' ); ?>
        </h1>
        <p data-cdo-reveal data-cdo-delay="200" class="mt-6 md:mt-8 text-lg md:text-xl text-secondary max-w-3xl mx-auto leading-relaxed">
            <?php esc_html_e( 'Soporte e-commerce, transporte y logística, y mantenimiento técnico — bajo un mismo techo. Cubrimos todo lo que tu negocio necesita para operar online y offline.', 'cdo-solutions' ); ?>
        </p>
    </div>
</section>

<!-- Grid de soluciones -->
<section id="categorias" class="py-16 md:py-24 px-6 md:px-8 bg-surface-container-lowest border-t border-surface-container-highest">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 md:gap-8 mb-10 md:mb-14">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3 block"><?php esc_html_e( 'Nuestras áreas', 'cdo-solutions' ); ?></span>
                <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface">
                    <?php esc_html_e( 'Elige el área que necesitas.', 'cdo-solutions' ); ?>
                </h2>
            </div>
            <p class="text-base text-secondary max-w-md"><?php esc_html_e( 'Pulsa cualquier área para ver el detalle de servicios, herramientas y productos asociados.', 'cdo-solutions' ); ?></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
            <?php foreach ( $categories as $i => $c ) : ?>
                <a href="<?php echo esc_url( $c['permalink'] ); ?>"
                   data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>"
                   class="cdo-service-card group block p-6 md:p-7 bg-surface-container-lowest rounded-2xl border border-surface-container-highest hover:border-on-surface relative overflow-hidden">

                    <div class="cdo-float w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr <?php echo esc_attr( $c['grad'] ); ?> mb-5 flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl md:text-3xl" aria-hidden="true"><?php echo esc_html( $c['icon'] ); ?></span>
                    </div>

                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-secondary block mb-2"><?php echo esc_html( $c['number'] ); ?> · <?php echo esc_html( $c['eyebrow'] ); ?></span>
                    <h3 class="text-2xl md:text-3xl font-display font-extrabold tracking-tighter text-on-surface mb-3 leading-tight">
                        <?php echo esc_html( $c['name'] ); ?>
                    </h3>
                    <p class="text-sm text-secondary leading-relaxed mb-6 sm:min-h-[3.25rem]">
                        <?php echo esc_html( $c['tagline'] ); ?>
                    </p>

                    <div class="flex items-center justify-between gap-3 pt-5 border-t border-surface-container-highest">
                        <span class="text-xs text-secondary"><?php
                            $count = count( $c['items'] );
                            printf( esc_html( _n( '%d sub-servicio', '%d sub-servicios', $count, 'cdo-solutions' ) ), (int) $count );
                        ?></span>
                        <span class="shrink-0 text-on-surface group-hover:text-primary transition-colors flex items-center gap-1 text-sm font-bold">
                            <?php esc_html_e( 'Ver detalle', 'cdo-solutions' ); ?>
                            <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
                        </span>
                    </div>

                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA final -->
<section class="cdo-cta-banner mx-4 md:mx-8 mt-10 md:mt-16 mb-10 md:mb-16 px-5 md:px-8 py-10 md:py-24 bg-black rounded-2xl md:rounded-3xl relative overflow-hidden text-center">
    <div class="cdo-blob absolute top-0 right-0 w-72 md:w-96 h-72 md:h-96 bg-primary opacity-25 blur-[150px] pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute bottom-0 left-0 w-72 md:w-96 h-72 md:h-96 bg-tertiary opacity-15 blur-[150px] pointer-events-none"></div>

    <div class="max-w-3xl mx-auto relative z-10">
        <h2 data-cdo-reveal class="cdo-cta-headline text-2xl md:text-4xl lg:text-5xl font-display font-extrabold text-white tracking-tighter mb-5 md:mb-10 leading-tight">
            <?php esc_html_e( '¿No sabes por dónde empezar?', 'cdo-solutions' ); ?>
        </h2>
        <a data-cdo-reveal data-cdo-delay="200" href="<?php echo $contacto_url; ?>"
           class="bg-primary-container text-on-primary-fixed px-7 md:px-12 py-3.5 md:py-5 font-headline font-extrabold text-base md:text-lg rounded-xl hover:scale-105 transition-transform inline-flex items-center gap-3">
            <?php esc_html_e( 'Hablamos 30 minutos', 'cdo-solutions' ); ?>
            <span class="material-symbols-outlined" aria-hidden="true">arrow_right_alt</span>
        </a>
    </div>
</section>

<?php get_footer(); ?>
