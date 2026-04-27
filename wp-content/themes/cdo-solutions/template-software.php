<?php
/**
 * Template Name: Software
 *
 * Página dedicada al software propio de cdo.solutions:
 * - cdo.mail   (Email marketing y automatización)
 * - cdo.chat   (Atención al cliente omnicanal)
 * - cdo.screen (Cartelería digital — gestión de pantallas en tiendas)
 *
 * NOTA INTERNA (no exponer públicamente): los productos están construidos sobre
 * proyectos open source con mejoras propias y soporte directo:
 *   - cdo.mail   → Mautic
 *   - cdo.chat   → Chatwoot
 *   - cdo.screen → Xibo
 * Comercialmente se presentan como software propio, sin mencionar la base.
 *
 * @package CdoSolutions
 */

get_header();

$contacto_url = esc_url( home_url( '/contacto/' ) );

/**
 * Productos cargados desde el CPT cdo_software (admin → Software).
 * El registro y el helper viven en inc/cpt-software.php.
 */
$products = cdo_get_software_products();
?>

<?php
// Schema.org del catálogo (CollectionPage + ItemList).
// Los SoftwareApplication individuales viven en sus páginas /software/{slug}/.
echo cdo_software_jsonld_collection( $products, trailingslashit( get_permalink() ) );
?>

<!-- Hero -->
<section class="cdo-hero relative pt-20 md:pt-28 pb-14 md:pb-20 px-6 md:px-8 overflow-hidden bg-surface-container-lowest">
    <div class="cdo-blob absolute top-[-15%] right-[-10%] w-[400px] md:w-[520px] h-[400px] md:h-[520px] bg-tertiary opacity-12 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute top-[20%] left-[-10%] w-[320px] md:w-[400px] h-[320px] md:h-[400px] bg-primary opacity-15 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10 text-center">
        <span data-cdo-reveal class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-6 block">
            <?php esc_html_e( 'Software propio', 'cdo-solutions' ); ?>
        </span>
        <h1 data-cdo-reveal data-cdo-delay="100"
            class="cdo-hero-headline font-display text-[2.25rem] sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-on-surface leading-[1.05] tracking-tighter">
            <?php esc_html_e( 'Tus herramientas,', 'cdo-solutions' ); ?>
            <span class="text-primary-container bg-black px-2 inline-block"><?php esc_html_e( 'sin alquilar SaaS', 'cdo-solutions' ); ?></span><?php esc_html_e( '.', 'cdo-solutions' ); ?>
        </h1>
        <p data-cdo-reveal data-cdo-delay="200" class="mt-6 md:mt-8 text-lg md:text-xl text-secondary max-w-3xl mx-auto leading-relaxed">
            <?php esc_html_e( 'Software propio desarrollado por nuestro equipo. Self-hosted en tu infraestructura, sin coste por contacto y con soporte directo del fabricante. Las mismas funcionalidades que las plataformas líderes — pero a tu medida.', 'cdo-solutions' ); ?>
        </p>
        <div data-cdo-reveal data-cdo-delay="300" class="mt-8 md:mt-10 flex flex-wrap gap-3 sm:gap-4 justify-center">
            <a href="<?php echo $contacto_url; ?>"
               class="bg-on-surface text-surface-container-lowest px-7 sm:px-10 py-3.5 sm:py-4 font-headline font-bold rounded-lg border-b-4 border-primary-container transition-all hover:translate-y-[-2px] inline-flex items-center gap-2">
                <?php esc_html_e( 'Ver demo', 'cdo-solutions' ); ?>
                <span class="material-symbols-outlined text-primary-container" aria-hidden="true">arrow_right_alt</span>
            </a>
            <a href="#productos"
               class="border-2 border-on-surface text-on-surface px-7 sm:px-10 py-3.5 sm:py-4 font-headline font-bold rounded-lg hover:bg-surface-container-low transition-colors inline-block">
                <?php esc_html_e( 'Ver productos', 'cdo-solutions' ); ?>
            </a>
        </div>
    </div>
</section>

<!-- Por qué nuestro software -->
<section class="py-16 md:py-20 px-6 md:px-8 bg-surface-container-low">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="text-center mb-12 md:mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block"><?php esc_html_e( '¿Por qué propio y no SaaS?', 'cdo-solutions' ); ?></span>
            <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface">
                <?php esc_html_e( 'Misma potencia. Sin alquileres.', 'cdo-solutions' ); ?>
            </h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <?php
            $reasons = array(
                array( 'icon' => 'shield_lock',      'grad' => 'from-primary to-primary-container',     'title' => __( 'Datos en tu casa',           'cdo-solutions' ), 'desc' => __( 'Self-hosted en tu infraestructura. Cumplimiento RGPD bajo tu control, sin terceros.', 'cdo-solutions' ) ),
                array( 'icon' => 'savings',          'grad' => 'from-tertiary to-tertiary-fixed-dim',   'title' => __( 'Sin coste por uso',          'cdo-solutions' ), 'desc' => __( 'Olvídate de pagar por contacto, agente o conversación. Coste plano y predecible.',    'cdo-solutions' ) ),
                array( 'icon' => 'tune',             'grad' => 'from-[#6366F1] to-[#A5B4FC]',           'title' => __( 'Personalización total',      'cdo-solutions' ), 'desc' => __( 'Adaptamos los flujos, integraciones y UI a cómo trabaja realmente tu equipo.',         'cdo-solutions' ) ),
                array( 'icon' => 'support_agent',    'grad' => 'from-[#F59E0B] to-[#FCD34D]',           'title' => __( 'Soporte directo',            'cdo-solutions' ), 'desc' => __( 'Hablas con quien construye y mantiene la plataforma. En español y sin tickets eternos.', 'cdo-solutions' ) ),
            );
            foreach ( $reasons as $i => $r ) :
            ?>
                <div data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>" class="text-center">
                    <div class="cdo-float w-14 h-14 md:w-16 md:h-16 mx-auto mb-4 md:mb-5 rounded-2xl bg-gradient-to-tr <?php echo esc_attr( $r['grad'] ); ?> flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl md:text-3xl" aria-hidden="true"><?php echo esc_html( $r['icon'] ); ?></span>
                    </div>
                    <h3 class="text-base md:text-lg font-headline font-bold mb-2 text-on-surface"><?php echo esc_html( $r['title'] ); ?></h3>
                    <p class="text-sm text-secondary leading-relaxed"><?php echo esc_html( $r['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Índice visual de productos -->
<section id="productos" class="py-16 md:py-20 px-6 md:px-8 bg-surface-container-lowest border-t border-surface-container-highest">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 md:gap-8 mb-10 md:mb-12">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3 block"><?php esc_html_e( 'Nuestros productos', 'cdo-solutions' ); ?></span>
                <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface">
                    <?php esc_html_e( 'Conoce el catálogo.', 'cdo-solutions' ); ?>
                </h2>
            </div>
            <p class="text-base text-secondary max-w-md"><?php esc_html_e( 'Pulsa en cualquier producto para saltar a su ficha completa con features, precio y demo.', 'cdo-solutions' ); ?></p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
            <?php foreach ( $products as $i => $p ) :
                $card_price       = ! empty( $p['tiers'] ) ? (int) $p['tiers'][0]['price'] : (int) $p['price'];
                $card_period      = $p['price_period'] ?: '/mes';
                $card_has_slider  = ! empty( $p['tiers'] );
            ?>
                <a href="<?php echo esc_url( $p['permalink'] ); ?>"
                   data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>"
                   class="cdo-service-card group block p-6 md:p-7 bg-surface-container-lowest rounded-2xl border border-surface-container-highest hover:border-on-surface relative overflow-hidden">

                    <!-- Icono -->
                    <div class="cdo-float w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr <?php echo esc_attr( $p['grad'] ); ?> mb-5 flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl md:text-3xl" aria-hidden="true"><?php echo esc_html( $p['icon'] ); ?></span>
                    </div>

                    <!-- Eyebrow + nombre -->
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-secondary block mb-2"><?php echo esc_html( $p['eyebrow'] ); ?></span>
                    <h3 class="text-2xl md:text-3xl font-display font-extrabold tracking-tighter text-on-surface mb-3">
                        <?php echo esc_html( $p['name'] ); ?>
                    </h3>

                    <!-- Tagline -->
                    <p class="text-sm text-secondary leading-relaxed mb-5 sm:min-h-[3.25rem]">
                        <?php echo esc_html( $p['tagline'] ); ?>
                    </p>

                    <!-- Precio + indicador escalable -->
                    <div class="flex items-end justify-between gap-3 pt-5 border-t border-surface-container-highest">
                        <div class="min-w-0">
                            <div class="text-[10px] font-bold uppercase tracking-widest text-secondary mb-0.5"><?php esc_html_e( 'Desde', 'cdo-solutions' ); ?></div>
                            <div class="flex items-baseline flex-wrap gap-x-1 gap-y-0.5">
                                <span class="text-2xl font-display font-extrabold text-on-surface"><?php echo esc_html( $card_price ); ?>&nbsp;€</span>
                                <span class="text-xs text-secondary"><?php echo esc_html( $card_period ); ?></span>
                                <?php if ( $p['price_iva'] ) : ?>
                                    <span class="text-[9px] font-bold uppercase tracking-widest text-secondary px-1.5 py-0.5 rounded-full bg-surface-container-low border border-surface-container-highest"><?php esc_html_e( '+ IVA', 'cdo-solutions' ); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ( $card_has_slider && ! empty( $p['unit_plural'] ) ) : ?>
                                <div class="text-[10px] text-secondary mt-1.5 inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-primary text-sm" aria-hidden="true">tune</span>
                                    <?php
                                    /* translators: %s = unit plural (contactos, agentes, pantallas) */
                                    printf( esc_html__( 'Escalable por %s', 'cdo-solutions' ), esc_html( $p['unit_plural'] ) );
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="shrink-0 text-on-surface group-hover:text-primary transition-colors flex items-center gap-1 text-sm font-bold">
                            <span class="hidden sm:inline"><?php esc_html_e( 'Ver ficha', 'cdo-solutions' ); ?></span>
                            <span class="sm:hidden"><?php esc_html_e( 'Ver', 'cdo-solutions' ); ?></span>
                            <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
                        </div>
                    </div>

                </a>
            <?php endforeach; ?>
        </div>

        <!-- Custom build CTA — desarrollo a medida -->
        <div data-cdo-reveal class="mt-8 md:mt-10 relative overflow-hidden rounded-2xl bg-on-surface text-white p-6 md:p-10">
            <div class="cdo-blob absolute top-0 right-0 w-72 md:w-96 h-72 md:h-96 bg-primary opacity-20 blur-[120px] pointer-events-none"></div>
            <div class="cdo-blob cdo-blob--rev absolute -bottom-20 -left-20 w-72 h-72 bg-tertiary opacity-15 blur-[120px] pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center gap-6 lg:gap-10">
                <div class="cdo-float w-14 h-14 md:w-16 lg:w-20 md:h-16 lg:h-20 rounded-2xl bg-primary-container flex items-center justify-center text-on-primary-fixed shadow-xl shrink-0">
                    <span class="material-symbols-outlined text-2xl md:text-3xl lg:text-4xl" aria-hidden="true">code_blocks</span>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-primary-container mb-2 block"><?php esc_html_e( 'Aplicaciones internas a medida', 'cdo-solutions' ); ?></span>
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-display font-extrabold tracking-tighter mb-3 leading-tight">
                        <?php esc_html_e( '¿Necesitas algo distinto?', 'cdo-solutions' ); ?>
                        <span class="text-primary-container"><?php esc_html_e( 'Te lo construimos.', 'cdo-solutions' ); ?></span>
                    </h3>
                    <p class="text-sm md:text-base lg:text-lg text-white/80 leading-relaxed max-w-3xl mb-5">
                        <?php esc_html_e( 'Si nuestro catálogo no cubre tu caso, desarrollamos cualquier tipo de aplicación a medida — desplegada en tu propio servidor para uso exclusivo de tu equipo. Construida por nosotros, mantenida por nosotros, y siempre bajo tu control.', 'cdo-solutions' ); ?>
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-md lg:max-w-none">
                        <div class="px-4 py-3 rounded-xl bg-white/5 border border-white/10">
                            <div class="text-[10px] font-bold uppercase tracking-[0.25em] text-white/60 mb-0.5"><?php esc_html_e( 'Desarrollo', 'cdo-solutions' ); ?></div>
                            <div class="flex items-baseline flex-wrap gap-x-1.5 gap-y-1">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-white/60"><?php esc_html_e( 'Desde', 'cdo-solutions' ); ?></span>
                                <span class="text-2xl font-display font-extrabold text-white">200&nbsp;€</span>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-white/50 px-1.5 py-0.5 rounded-full bg-white/10"><?php esc_html_e( '+ IVA', 'cdo-solutions' ); ?></span>
                            </div>
                        </div>
                        <div class="px-4 py-3 rounded-xl bg-primary-container/15 border border-primary-container/40">
                            <div class="text-[10px] font-bold uppercase tracking-[0.25em] text-primary-container mb-0.5"><?php esc_html_e( 'Mantenimiento', 'cdo-solutions' ); ?></div>
                            <div class="flex items-baseline flex-wrap gap-x-1.5 gap-y-1">
                                <span class="text-2xl font-display font-extrabold text-white">100&nbsp;€</span>
                                <span class="text-sm text-white/70"><?php esc_html_e( '/mes', 'cdo-solutions' ); ?></span>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-white/50 px-1.5 py-0.5 rounded-full bg-white/10"><?php esc_html_e( '+ IVA', 'cdo-solutions' ); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $contacto_url; ?>?topic=software-a-medida"
                   class="lg:shrink-0 w-full lg:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 rounded-xl bg-primary-container text-on-primary-fixed font-headline font-extrabold text-sm md:text-base hover:scale-105 transition-transform shadow-lg">
                    <?php esc_html_e( 'Pedir presupuesto', 'cdo-solutions' ); ?>
                    <span class="material-symbols-outlined" aria-hidden="true">arrow_right_alt</span>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Comparativa SaaS vs cdo -->
<section class="py-20 md:py-28 px-6 md:px-8 bg-surface-container-lowest border-t border-surface-container-highest">
    <div class="max-w-5xl mx-auto">
        <div data-cdo-reveal class="text-center mb-12 md:mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block"><?php esc_html_e( 'Comparativa', 'cdo-solutions' ); ?></span>
            <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface">
                <?php esc_html_e( 'SaaS típico vs. software propio.', 'cdo-solutions' ); ?>
            </h2>
        </div>

        <div data-cdo-reveal data-cdo-delay="100" class="overflow-x-auto rounded-2xl border border-surface-container-highest -mx-2 md:mx-0">
            <table class="w-full text-left min-w-[560px]">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="px-4 md:px-6 py-4 text-xs font-bold uppercase tracking-widest text-secondary"></th>
                        <th class="px-4 md:px-6 py-4 text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'SaaS típico', 'cdo-solutions' ); ?></th>
                        <th class="px-4 md:px-6 py-4 text-xs font-bold uppercase tracking-widest text-on-primary-fixed bg-primary-container">cdo.*</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = array(
                        array( __( 'Datos',          'cdo-solutions' ), __( 'En la nube del proveedor',                  'cdo-solutions' ), __( 'En tu infraestructura',         'cdo-solutions' ) ),
                        array( __( 'Coste',          'cdo-solutions' ), __( 'Crece por contacto / agente / conversación', 'cdo-solutions' ), __( 'Plano y predecible',            'cdo-solutions' ) ),
                        array( __( 'Personalización','cdo-solutions' ), __( 'Limitada a lo que ofrece su panel',          'cdo-solutions' ), __( 'Total — adaptamos lo que pidas', 'cdo-solutions' ) ),
                        array( __( 'Soporte',        'cdo-solutions' ), __( 'Tickets y SLAs lentos, en inglés',           'cdo-solutions' ), __( 'Directo, en español, ágil',     'cdo-solutions' ) ),
                        array( __( 'RGPD',           'cdo-solutions' ), __( 'Depende del proveedor (USA, etc.)',          'cdo-solutions' ), __( '100% bajo tu control',          'cdo-solutions' ) ),
                        array( __( 'Vendor lock-in', 'cdo-solutions' ), __( 'Migrar fuera = caro y arriesgado',           'cdo-solutions' ), __( 'Cero lock-in: tus datos son tuyos', 'cdo-solutions' ) ),
                    );
                    foreach ( $rows as $row ) :
                    ?>
                        <tr class="border-t border-surface-container-highest">
                            <td class="px-4 md:px-6 py-4 font-headline font-bold text-on-surface text-sm md:text-base"><?php echo esc_html( $row[0] ); ?></td>
                            <td class="px-4 md:px-6 py-4 text-secondary text-sm md:text-base">
                                <span class="inline-flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-base" aria-hidden="true">close</span>
                                    <?php echo esc_html( $row[1] ); ?>
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-on-surface text-sm md:text-base font-medium bg-primary-container/10">
                                <span class="inline-flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-base" aria-hidden="true">check_circle</span>
                                    <?php echo esc_html( $row[2] ); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- CTA final -->
<section class="cdo-cta-banner mx-4 md:mx-8 mb-10 md:mb-16 px-5 md:px-8 py-10 md:py-24 bg-black rounded-2xl md:rounded-3xl relative overflow-hidden text-center">
    <div class="cdo-blob absolute top-0 right-0 w-72 md:w-96 h-72 md:h-96 bg-primary opacity-25 blur-[150px] pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute bottom-0 left-0 w-72 md:w-96 h-72 md:h-96 bg-tertiary opacity-15 blur-[150px] pointer-events-none"></div>

    <div class="max-w-3xl mx-auto relative z-10">
        <h2 data-cdo-reveal class="cdo-cta-headline text-2xl md:text-4xl lg:text-5xl font-display font-extrabold text-white tracking-tighter mb-5 md:mb-10 leading-tight">
            <?php esc_html_e( '¿Quieres dejar de pagar SaaS al peso?', 'cdo-solutions' ); ?>
        </h2>
        <a data-cdo-reveal data-cdo-delay="200" href="<?php echo $contacto_url; ?>"
           class="bg-primary-container text-on-primary-fixed px-7 md:px-12 py-3.5 md:py-5 font-headline font-extrabold text-base md:text-lg rounded-xl hover:scale-105 transition-transform inline-flex items-center gap-3">
            <?php esc_html_e( 'Ver demos', 'cdo-solutions' ); ?>
            <span class="material-symbols-outlined" aria-hidden="true">arrow_right_alt</span>
        </a>
        <p data-cdo-reveal data-cdo-delay="300" class="mt-4 md:mt-8 text-secondary-fixed text-xs md:text-sm"><?php esc_html_e( 'Te enseñamos los productos en una llamada de 30 minutos.', 'cdo-solutions' ); ?></p>
    </div>
</section>

<?php get_footer(); ?>
