<?php
/**
 * Single template del CPT cdo_solucion.
 * URL: /soluciones/{slug}/
 *
 * @package CdoSolutions
 */

get_header();

while ( have_posts() ) :
    the_post();
    $c            = cdo_solucion_to_array( get_post() );
    $cat_url      = get_permalink();
    $contacto_url = esc_url( home_url( '/contacto/' ) );
    $catalog_url  = esc_url( home_url( '/soluciones/' ) );
?>

<?php echo cdo_solucion_jsonld_single( $c, $cat_url ); ?>

<!-- Breadcrumb -->
<nav class="px-6 md:px-8 pt-5 md:pt-8 pb-2 md:pb-4 max-w-7xl mx-auto" aria-label="<?php esc_attr_e( 'Breadcrumb', 'cdo-solutions' ); ?>">
    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs md:text-sm text-secondary">
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-on-surface transition-colors"><?php esc_html_e( 'Inicio', 'cdo-solutions' ); ?></a></li>
        <li class="opacity-50">/</li>
        <li><a href="<?php echo $catalog_url; ?>" class="hover:text-on-surface transition-colors"><?php esc_html_e( 'Soluciones', 'cdo-solutions' ); ?></a></li>
        <li class="opacity-50">/</li>
        <li class="text-on-surface font-medium"><?php echo esc_html( $c['name'] ); ?></li>
    </ol>
</nav>

<!-- Hero -->
<section class="cdo-hero relative pt-2 md:pt-6 pb-12 md:pb-24 px-6 md:px-8 overflow-hidden bg-surface-container-lowest">
    <div class="cdo-blob absolute top-[-15%] right-[-10%] w-[400px] md:w-[520px] h-[400px] md:h-[520px] bg-tertiary opacity-10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute top-[20%] left-[-10%] w-[320px] md:w-[400px] h-[320px] md:h-[400px] bg-primary opacity-12 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        <div data-cdo-reveal class="flex items-center gap-4 mb-6 md:mb-8">
            <div class="cdo-float w-14 h-14 md:w-20 md:h-20 rounded-2xl bg-gradient-to-tr <?php echo esc_attr( $c['grad'] ); ?> flex items-center justify-center text-white shadow-xl shrink-0">
                <span class="material-symbols-outlined text-2xl md:text-4xl" aria-hidden="true"><?php echo esc_html( $c['icon'] ); ?></span>
            </div>
            <div>
                <span class="text-[10px] md:text-xs font-bold uppercase tracking-[0.3em] text-primary block">
                    <?php echo esc_html( $c['number'] ); ?> · <?php echo esc_html( $c['eyebrow'] ); ?>
                </span>
            </div>
        </div>

        <h1 data-cdo-reveal data-cdo-delay="100"
            class="cdo-hero-headline text-4xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tighter text-on-surface mb-4 md:mb-6">
            <?php echo esc_html( $c['name'] ); ?>
        </h1>
        <p data-cdo-reveal data-cdo-delay="200" class="text-lg md:text-2xl text-on-surface font-medium mb-4 md:mb-6 leading-snug">
            <?php echo esc_html( $c['tagline'] ); ?>
        </p>
        <p data-cdo-reveal data-cdo-delay="300" class="text-base md:text-lg text-secondary leading-relaxed max-w-3xl">
            <?php echo esc_html( $c['desc'] ); ?>
        </p>

        <div data-cdo-reveal data-cdo-delay="400" class="mt-8 md:mt-10 flex flex-wrap gap-3">
            <a href="<?php echo $contacto_url; ?>?topic=<?php echo esc_attr( $c['id'] ); ?>"
               class="bg-on-surface text-surface-container-lowest px-7 sm:px-9 py-3.5 font-headline font-bold rounded-lg border-b-4 border-primary-container transition-all hover:translate-y-[-2px] inline-flex items-center justify-center gap-2 w-full sm:w-auto">
                <?php esc_html_e( 'Solicitar propuesta', 'cdo-solutions' ); ?>
                <span class="material-symbols-outlined text-primary-container" aria-hidden="true">arrow_right_alt</span>
            </a>
            <a href="#sub-servicios"
               class="border-2 border-on-surface text-on-surface px-7 sm:px-9 py-3.5 font-headline font-bold rounded-lg hover:bg-surface-container-low transition-colors inline-flex items-center justify-center gap-2 w-full sm:w-auto">
                <?php esc_html_e( 'Ver qué incluye', 'cdo-solutions' ); ?>
            </a>
        </div>
    </div>
</section>

<!-- Sub-servicios -->
<?php if ( ! empty( $c['items'] ) ) : ?>
<section id="sub-servicios" class="py-16 md:py-24 px-6 md:px-8 bg-surface-container-low scroll-mt-24">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="mb-10 md:mb-14">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3 block"><?php esc_html_e( 'Qué incluye', 'cdo-solutions' ); ?></span>
            <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface">
                <?php esc_html_e( 'Sub-servicios de esta área', 'cdo-solutions' ); ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            <?php foreach ( $c['items'] as $j => $it ) : ?>
                <div data-cdo-reveal data-cdo-delay="<?php echo (int) ( ( $j % 3 ) * 80 ); ?>"
                     class="cdo-service-card group p-6 bg-surface-container-lowest rounded-xl border border-surface-container-highest hover:border-on-surface">
                    <div class="w-11 h-11 rounded-lg bg-surface-container-low flex items-center justify-center mb-4 group-hover:bg-primary-container transition-colors">
                        <span class="material-symbols-outlined text-on-surface" aria-hidden="true"><?php echo esc_html( $it['icon'] ); ?></span>
                    </div>
                    <h3 class="text-lg font-headline font-bold mb-2 text-on-surface"><?php echo esc_html( $it['title'] ); ?></h3>
                    <p class="text-sm text-secondary leading-relaxed"><?php echo esc_html( $it['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Stack -->
<?php if ( ! empty( $c['stack'] ) ) : ?>
<section class="py-16 md:py-20 px-6 md:px-8 bg-surface-container-lowest">
    <div data-cdo-reveal class="max-w-5xl mx-auto text-center">
        <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3 block"><?php esc_html_e( 'Stack', 'cdo-solutions' ); ?></span>
        <h2 class="cdo-section-headline text-2xl md:text-3xl lg:text-4xl font-display font-extrabold tracking-tighter text-on-surface mb-8 md:mb-10">
            <?php esc_html_e( 'Trabajamos con las mejores herramientas.', 'cdo-solutions' ); ?>
        </h2>
        <div class="flex flex-wrap justify-center gap-2 md:gap-3">
            <?php foreach ( $c['stack'] as $tool ) : ?>
                <span class="inline-flex items-center px-4 py-2 rounded-full bg-surface-container-low border border-surface-container-highest text-sm font-bold text-on-surface">
                    <?php echo esc_html( $tool ); ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Otras áreas -->
<?php
$others = array_filter( cdo_get_solucion_categories(), function ( $other ) use ( $c ) {
    return $other['id'] !== $c['id'];
} );
if ( ! empty( $others ) ) :
?>
<section class="py-16 md:py-20 px-6 md:px-8 bg-surface-container-lowest border-t border-surface-container-highest">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8 md:mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-2 block"><?php esc_html_e( 'Otras áreas', 'cdo-solutions' ); ?></span>
                <h2 class="cdo-section-headline text-2xl md:text-3xl font-display font-extrabold tracking-tighter text-on-surface">
                    <?php esc_html_e( 'Conoce el resto de soluciones', 'cdo-solutions' ); ?>
                </h2>
            </div>
            <a href="<?php echo $catalog_url; ?>" class="text-sm font-bold text-on-surface hover:text-primary inline-flex items-center gap-1">
                <?php esc_html_e( 'Ver todas', 'cdo-solutions' ); ?>
                <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
            <?php foreach ( array_values( $others ) as $i => $o ) : ?>
                <a href="<?php echo esc_url( $o['permalink'] ); ?>"
                   data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>"
                   class="cdo-service-card group block p-6 bg-surface-container-lowest rounded-2xl border border-surface-container-highest hover:border-on-surface">
                    <div class="flex items-start gap-4">
                        <div class="cdo-float w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gradient-to-tr <?php echo esc_attr( $o['grad'] ); ?> flex items-center justify-center text-white shadow-lg shrink-0">
                            <span class="material-symbols-outlined text-2xl" aria-hidden="true"><?php echo esc_html( $o['icon'] ); ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-secondary block mb-1"><?php echo esc_html( $o['number'] ); ?> · <?php echo esc_html( $o['eyebrow'] ); ?></span>
                            <h3 class="text-lg md:text-xl font-headline font-bold text-on-surface group-hover:text-primary transition-colors leading-tight mb-1.5">
                                <?php echo esc_html( $o['name'] ); ?>
                            </h3>
                            <p class="text-sm text-secondary leading-relaxed"><?php echo esc_html( $o['tagline'] ); ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA final -->
<section class="cdo-cta-banner mx-4 md:mx-8 mt-10 md:mt-16 mb-10 md:mb-16 px-5 md:px-8 py-10 md:py-24 bg-black rounded-2xl md:rounded-3xl relative overflow-hidden text-center">
    <div class="cdo-blob absolute top-0 right-0 w-72 md:w-96 h-72 md:h-96 bg-primary opacity-25 blur-[150px] pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute bottom-0 left-0 w-72 md:w-96 h-72 md:h-96 bg-tertiary opacity-15 blur-[150px] pointer-events-none"></div>

    <div class="max-w-3xl mx-auto relative z-10">
        <h2 data-cdo-reveal class="cdo-cta-headline text-2xl md:text-4xl lg:text-5xl font-display font-extrabold text-white tracking-tighter mb-5 md:mb-10 leading-tight">
            <?php
            /* translators: %s = nombre del área */
            printf( esc_html__( '¿Necesitas ayuda con %s?', 'cdo-solutions' ), esc_html( $c['name'] ) );
            ?>
        </h2>
        <a data-cdo-reveal data-cdo-delay="200" href="<?php echo $contacto_url; ?>?topic=<?php echo esc_attr( $c['id'] ); ?>"
           class="bg-primary-container text-on-primary-fixed px-7 md:px-12 py-3.5 md:py-5 font-headline font-extrabold text-base md:text-lg rounded-xl hover:scale-105 transition-transform inline-flex items-center gap-3">
            <?php esc_html_e( 'Hablemos', 'cdo-solutions' ); ?>
            <span class="material-symbols-outlined" aria-hidden="true">arrow_right_alt</span>
        </a>
        <p data-cdo-reveal data-cdo-delay="300" class="mt-4 md:mt-8 text-secondary-fixed text-xs md:text-sm">
            <?php esc_html_e( 'Llamada de 30 minutos sin compromiso para entender tu caso.', 'cdo-solutions' ); ?>
        </p>
    </div>
</section>

<?php
endwhile;
get_footer();
