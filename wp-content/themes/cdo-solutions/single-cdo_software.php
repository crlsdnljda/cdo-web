<?php
/**
 * Single template para el CPT cdo_software.
 *
 * Cada producto (cdo.mail, cdo.chat, cdo.screen…) tiene su propia URL
 * /software/{slug}/ con su hero, features, calculadora de precio,
 * banner de personalización, comparativa y CTA. JSON-LD propio.
 *
 * @package CdoSolutions
 */

get_header();

while ( have_posts() ) :
    the_post();
    $p            = cdo_software_to_array( get_post() );
    $product_url  = get_permalink();
    $contacto_url = esc_url( home_url( '/contacto/' ) );
    $catalog_url  = esc_url( home_url( '/software/' ) );
?>

<?php
// Schema.org de este producto + breadcrumb.
echo cdo_software_jsonld_single( $p, $product_url );
?>

<!-- Breadcrumb visible -->
<nav class="px-6 md:px-8 pt-5 md:pt-8 pb-2 md:pb-4 max-w-7xl mx-auto" aria-label="<?php esc_attr_e( 'Breadcrumb', 'cdo-solutions' ); ?>">
    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs md:text-sm text-secondary">
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-on-surface transition-colors"><?php esc_html_e( 'Inicio', 'cdo-solutions' ); ?></a></li>
        <li class="opacity-50">/</li>
        <li><a href="<?php echo $catalog_url; ?>" class="hover:text-on-surface transition-colors"><?php esc_html_e( 'Software', 'cdo-solutions' ); ?></a></li>
        <li class="opacity-50">/</li>
        <li class="text-on-surface font-medium"><?php echo esc_html( $p['name'] ); ?></li>
    </ol>
</nav>

<!-- Hero del producto -->
<section class="cdo-hero relative pt-2 md:pt-6 pb-12 md:pb-24 px-6 md:px-8 overflow-hidden bg-surface-container-lowest">
    <div class="cdo-blob absolute top-[-15%] right-[-10%] w-[400px] md:w-[520px] h-[400px] md:h-[520px] bg-tertiary opacity-10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute top-[20%] left-[-10%] w-[320px] md:w-[400px] h-[320px] md:h-[400px] bg-primary opacity-12 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 items-start">

        <!-- Cabecera -->
        <div data-cdo-reveal class="lg:col-span-5">
            <div class="cdo-float w-14 h-14 md:w-20 md:h-20 rounded-2xl bg-gradient-to-tr <?php echo esc_attr( $p['grad'] ); ?> mb-5 md:mb-8 flex items-center justify-center text-white shadow-xl">
                <span class="material-symbols-outlined text-2xl md:text-4xl" aria-hidden="true"><?php echo esc_html( $p['icon'] ); ?></span>
            </div>
            <span class="text-[10px] md:text-xs font-bold uppercase tracking-[0.3em] text-primary mb-2 md:mb-3 block">
                <?php echo esc_html( $p['eyebrow'] ); ?>
            </span>
            <h1 class="cdo-hero-headline text-4xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tighter text-on-surface mb-3 md:mb-4">
                <?php echo esc_html( $p['name'] ); ?>
            </h1>
            <p class="text-base md:text-xl text-on-surface font-medium mb-3 md:mb-6">
                <?php echo esc_html( $p['tagline'] ); ?>
            </p>
            <p class="text-sm md:text-base text-secondary leading-relaxed mb-5 md:mb-8">
                <?php echo esc_html( $p['desc'] ); ?>
            </p>

            <div class="mb-6">
                <div class="text-[10px] font-bold uppercase tracking-[0.3em] text-secondary mb-3"><?php esc_html_e( 'Reemplaza a', 'cdo-solutions' ); ?></div>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ( $p['replaces'] as $r ) : ?>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-surface-container-lowest border border-surface-container-highest text-xs font-bold text-on-surface">
                            <span class="material-symbols-outlined text-tertiary text-base mr-1" aria-hidden="true">block</span>
                            <?php echo esc_html( $r ); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php
            $has_tiers   = ! empty( $p['tiers'] );
            $base_price  = $has_tiers ? (int) $p['tiers'][0]['price'] : (int) $p['price'];
            $first_qty   = $has_tiers ? (int) $p['tiers'][0]['max']   : 0;
            $max_qty     = $has_tiers ? (int) end( $p['tiers'] )['max'] : 0;
            $unit_plural = $p['unit_plural'] ?: __( 'unidades', 'cdo-solutions' );
            ?>

            <?php if ( $has_tiers ) : ?>
                <div class="mb-8 p-5 md:p-6 rounded-xl bg-surface-container-low border border-outline-variant"
                     data-cdo-price-calc
                     data-cdo-tiers="<?php echo esc_attr( wp_json_encode( $p['tiers'] ) ); ?>"
                     data-cdo-period="<?php echo esc_attr( $p['price_period'] ); ?>">
                    <div class="flex items-baseline justify-between gap-3 mb-3">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-secondary"><?php esc_html_e( 'Desde', 'cdo-solutions' ); ?></span>
                        <?php if ( $p['price_iva'] ) : ?>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-secondary px-2 py-0.5 rounded-full bg-surface-container-lowest border border-surface-container-highest"><?php esc_html_e( '+ IVA', 'cdo-solutions' ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-baseline gap-2 mb-5">
                        <span class="text-3xl md:text-4xl font-display font-extrabold text-on-surface leading-none" data-cdo-price-out><?php echo esc_html( $base_price ); ?>&nbsp;€</span>
                        <span class="text-base font-medium text-secondary"><?php echo esc_html( $p['price_period'] ); ?></span>
                    </div>
                    <input type="range" class="cdo-slider w-full"
                           min="<?php echo (int) $first_qty; ?>"
                           max="<?php echo (int) $max_qty; ?>"
                           step="<?php echo max( 1, (int) round( $first_qty / 10 ) ); ?>"
                           value="<?php echo (int) $first_qty; ?>"
                           data-cdo-price-slider
                           aria-label="<?php esc_attr_e( 'Cantidad', 'cdo-solutions' ); ?>" />
                    <div class="flex justify-between mt-3 text-sm">
                        <span class="text-secondary">
                            <strong class="text-on-surface" data-cdo-quantity-out><?php echo number_format_i18n( $first_qty ); ?></strong>
                            <?php echo esc_html( $unit_plural ); ?>
                        </span>
                        <span class="text-xs text-secondary"><?php
                            printf(
                                /* translators: %s = max quantity formatted */
                                esc_html__( 'hasta %s', 'cdo-solutions' ),
                                number_format_i18n( $max_qty )
                            );
                        ?></span>
                    </div>
                </div>
            <?php elseif ( ! empty( $p['price'] ) ) : ?>
                <div class="mb-8 p-5 md:p-6 rounded-xl bg-surface-container-low border border-outline-variant">
                    <div class="flex items-baseline justify-between gap-3 mb-3">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-secondary"><?php esc_html_e( 'Desde', 'cdo-solutions' ); ?></span>
                        <?php if ( $p['price_iva'] ) : ?>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-secondary px-2 py-0.5 rounded-full bg-surface-container-lowest border border-surface-container-highest"><?php esc_html_e( '+ IVA', 'cdo-solutions' ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl md:text-4xl font-display font-extrabold text-on-surface leading-none"><?php echo esc_html( $p['price'] ); ?>&nbsp;€</span>
                        <span class="text-base font-medium text-secondary"><?php echo esc_html( $p['price_period'] ); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            if ( ! empty( $p['demo_url'] ) ) {
                $cta_href   = esc_url( $p['demo_url'] );
                $cta_target = ' target="_blank" rel="noopener"';
                $cta_icon   = 'open_in_new';
            } else {
                $cta_href   = $contacto_url . '?topic=' . rawurlencode( $p['id'] );
                $cta_target = '';
                $cta_icon   = 'arrow_right_alt';
            }
            ?>
            <div>
                <a href="<?php echo $cta_href; ?>"<?php echo $cta_target; ?>
                   class="bg-on-surface text-surface-container-lowest px-6 md:px-8 py-3.5 font-headline font-bold rounded-lg border-b-4 border-primary-container transition-all hover:translate-y-[-2px] inline-flex items-center justify-center gap-2 w-full sm:w-auto">
                    <?php
                    /* translators: %s = product name */
                    printf( esc_html__( 'Ver demo de %s', 'cdo-solutions' ), esc_html( $p['name'] ) );
                    ?>
                    <span class="material-symbols-outlined text-primary-container" aria-hidden="true"><?php echo esc_html( $cta_icon ); ?></span>
                </a>
            </div>
        </div>

        <!-- Features grid -->
        <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
            <?php foreach ( $p['features'] as $j => $f ) : ?>
                <div data-cdo-reveal data-cdo-delay="<?php echo (int) ( $j * 60 ); ?>"
                     class="cdo-service-card group p-5 bg-surface-container-lowest rounded-xl border border-surface-container-highest hover:border-on-surface">
                    <div class="w-10 h-10 rounded-lg bg-surface-container-low flex items-center justify-center mb-3 group-hover:bg-primary-container transition-colors">
                        <span class="material-symbols-outlined text-on-surface" aria-hidden="true"><?php echo esc_html( $f['icon'] ); ?></span>
                    </div>
                    <h3 class="text-base font-headline font-bold mb-1.5 text-on-surface"><?php echo esc_html( $f['title'] ); ?></h3>
                    <p class="text-sm text-secondary leading-relaxed"><?php echo esc_html( $f['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- Banner "Adaptable a tu medida" + Modelo de facturación -->
<section class="px-6 md:px-8 pb-16 md:pb-24 bg-surface-container-lowest">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="p-5 md:p-8 rounded-2xl bg-gradient-to-r from-primary-container/30 via-primary-container/15 to-tertiary-fixed/20 border border-primary-container/50 flex flex-col md:flex-row md:items-center gap-5 md:gap-6 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-container opacity-20 blur-3xl rounded-full pointer-events-none"></div>
            <div class="cdo-float w-12 h-12 md:w-16 md:h-16 rounded-2xl bg-primary-container flex items-center justify-center text-on-primary-fixed shadow-lg shrink-0 relative">
                <span class="material-symbols-outlined text-xl md:text-3xl" aria-hidden="true">tune</span>
            </div>
            <div class="flex-1 relative">
                <h2 class="text-lg md:text-xl font-headline font-bold text-on-surface mb-1">
                    <?php
                    /* translators: %s = product name */
                    printf( esc_html__( 'Adaptamos %s a tu medida', 'cdo-solutions' ), esc_html( $p['name'] ) );
                    ?>
                </h2>
                <p class="text-sm md:text-base text-secondary leading-relaxed max-w-2xl mb-4">
                    <?php esc_html_e( '¿Necesitas una funcionalidad concreta, una integración con tu sistema o un flujo a medida? Lo desarrollamos. Como es nuestro propio software, podemos modificar cualquier cosa para que haga exactamente lo que tu equipo necesita.', 'cdo-solutions' ); ?>
                </p>
                <div class="max-w-2xl bg-surface-container-lowest/70 border-l-2 border-primary-container pl-3 pr-4 py-3 rounded-r-lg">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-primary text-lg leading-none" aria-hidden="true">payments</span>
                        <strong class="text-xs md:text-sm font-semibold text-on-surface uppercase tracking-wider"><?php esc_html_e( 'Modelo de facturación', 'cdo-solutions' ); ?></strong>
                    </div>
                    <ul class="space-y-1.5 text-xs md:text-sm text-on-surface leading-relaxed">
                        <li class="flex gap-2">
                            <span class="material-symbols-outlined text-secondary text-base leading-none mt-0.5" aria-hidden="true">build_circle</span>
                            <span><strong class="font-semibold"><?php esc_html_e( 'Instalación:', 'cdo-solutions' ); ?></strong> <?php esc_html_e( 'se factura según el tiempo de instalación, con tarifa por hora especificada en tu contrato.', 'cdo-solutions' ); ?></span>
                        </li>
                        <li class="flex gap-2">
                            <span class="material-symbols-outlined text-secondary text-base leading-none mt-0.5" aria-hidden="true">tune</span>
                            <span><strong class="font-semibold"><?php esc_html_e( 'Desarrollo a medida:', 'cdo-solutions' ); ?></strong> <?php esc_html_e( 'las funcionalidades personalizadas se facturan por tiempo de desarrollo, también con la tarifa por hora del contrato.', 'cdo-solutions' ); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="<?php echo $contacto_url; ?>?topic=<?php echo esc_attr( $p['id'] ); ?>-custom"
               class="relative md:shrink-0 w-full md:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-on-surface text-surface-container-lowest font-headline font-bold text-sm hover:translate-y-[-2px] transition-transform">
                <?php esc_html_e( 'Pídenos lo que necesites', 'cdo-solutions' ); ?>
                <span class="material-symbols-outlined text-primary-container" aria-hidden="true">arrow_right_alt</span>
            </a>
        </div>
    </div>
</section>

<!-- Otros productos -->
<?php
$others = array_filter( cdo_get_software_products(), function ( $other ) use ( $p ) {
    return $other['id'] !== $p['id'];
} );
if ( ! empty( $others ) ) :
?>
<section class="py-16 md:py-20 px-6 md:px-8 bg-surface-container-low border-t border-surface-container-highest">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8 md:mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-2 block"><?php esc_html_e( 'Otros productos', 'cdo-solutions' ); ?></span>
                <h2 class="cdo-section-headline text-2xl md:text-3xl lg:text-4xl font-display font-extrabold tracking-tighter text-on-surface">
                    <?php esc_html_e( 'Conoce el resto del catálogo', 'cdo-solutions' ); ?>
                </h2>
            </div>
            <a href="<?php echo $catalog_url; ?>" class="text-sm font-bold text-on-surface hover:text-primary inline-flex items-center gap-1">
                <?php esc_html_e( 'Ver todos', 'cdo-solutions' ); ?>
                <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
            <?php foreach ( $others as $i => $o ) :
                $o_price = ! empty( $o['tiers'] ) ? (int) $o['tiers'][0]['price'] : (int) $o['price'];
            ?>
                <a href="<?php echo esc_url( $o['permalink'] ); ?>"
                   data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>"
                   class="cdo-service-card group block p-6 bg-surface-container-lowest rounded-2xl border border-surface-container-highest hover:border-on-surface">
                    <div class="cdo-float w-12 h-12 rounded-xl bg-gradient-to-tr <?php echo esc_attr( $o['grad'] ); ?> mb-4 flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl" aria-hidden="true"><?php echo esc_html( $o['icon'] ); ?></span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-secondary block mb-1.5"><?php echo esc_html( $o['eyebrow'] ); ?></span>
                    <h3 class="text-xl font-display font-extrabold tracking-tighter text-on-surface mb-2"><?php echo esc_html( $o['name'] ); ?></h3>
                    <p class="text-sm text-secondary leading-relaxed mb-4"><?php echo esc_html( $o['tagline'] ); ?></p>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface font-bold"><?php echo esc_html( $o_price ); ?>&nbsp;€<span class="text-secondary font-normal"> <?php echo esc_html( $o['price_period'] ); ?></span></span>
                        <span class="text-on-surface group-hover:text-primary transition-colors inline-flex items-center gap-1 font-bold">
                            <?php esc_html_e( 'Ver', 'cdo-solutions' ); ?>
                            <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
                        </span>
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
            /* translators: %s = product name */
            printf( esc_html__( '¿Quieres probar %s?', 'cdo-solutions' ), esc_html( $p['name'] ) );
            ?>
        </h2>
        <a data-cdo-reveal data-cdo-delay="200" href="<?php echo $contacto_url; ?>?topic=<?php echo esc_attr( $p['id'] ); ?>"
           class="bg-primary-container text-on-primary-fixed px-7 md:px-12 py-3.5 md:py-5 font-headline font-extrabold text-base md:text-lg rounded-xl hover:scale-105 transition-transform inline-flex items-center gap-3">
            <?php esc_html_e( 'Pedir demo', 'cdo-solutions' ); ?>
            <span class="material-symbols-outlined" aria-hidden="true">arrow_right_alt</span>
        </a>
        <p data-cdo-reveal data-cdo-delay="300" class="mt-4 md:mt-8 text-secondary-fixed text-xs md:text-sm">
            <?php esc_html_e( 'Te enseñamos el producto en una llamada de 30 minutos.', 'cdo-solutions' ); ?>
        </p>
    </div>
</section>

<?php
endwhile;
get_footer();
