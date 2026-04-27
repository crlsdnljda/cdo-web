<?php
/**
 * Front page — Home (Architectural Vitality / Vivid Architect V3).
 *
 * @package CdoSolutions
 */

get_header();

$contacto_url  = esc_url( home_url( '/contacto/' ) );
$servicios_url = esc_url( home_url( '/soluciones/' ) );
?>

<!-- 1. Hero -->
<section class="cdo-hero relative min-h-[90vh] lg:min-h-[920px] flex items-center pt-24 pb-16 lg:pt-20 px-6 md:px-8 overflow-hidden bg-surface-container-lowest">
    <div class="cdo-blob absolute top-[-12%] right-[-10%] w-[460px] md:w-[600px] h-[460px] md:h-[600px] bg-tertiary opacity-10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute bottom-[-12%] left-[-8%] w-[340px] md:w-[400px] h-[340px] md:h-[400px] bg-primary opacity-20 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center relative z-10">
        <div>
            <h1 data-cdo-reveal
                class="cdo-hero-headline font-display text-[2.5rem] sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-on-surface leading-[1.05] tracking-tighter">
                <?php esc_html_e( 'Soluciones integrales para', 'cdo-solutions' ); ?>
                <span class="text-primary-container bg-black px-2 inline-block"><?php esc_html_e( 'vender', 'cdo-solutions' ); ?></span>
                <?php esc_html_e( 'online.', 'cdo-solutions' ); ?>
            </h1>
            <p data-cdo-reveal data-cdo-delay="100"
               class="mt-6 md:mt-8 text-lg md:text-xl text-secondary max-w-lg leading-relaxed">
                <?php esc_html_e( 'Para empresas con tienda online y tiendas físicas. Software propio + servicios integrados — del ecommerce al mostrador, bajo un mismo equipo.', 'cdo-solutions' ); ?>
            </p>
            <div data-cdo-reveal data-cdo-delay="200" class="mt-8 md:mt-10 flex flex-wrap gap-3 sm:gap-4">
                <a href="<?php echo $contacto_url; ?>"
                   class="bg-on-surface text-surface-container-lowest px-7 sm:px-10 py-3.5 sm:py-4 font-headline font-bold rounded-lg border-b-4 border-primary-container transition-all hover:translate-y-[-2px] inline-flex items-center gap-2">
                    <?php esc_html_e( 'Empezar proyecto', 'cdo-solutions' ); ?>
                    <span class="material-symbols-outlined text-primary-container" aria-hidden="true">arrow_right_alt</span>
                </a>
                <a href="<?php echo $servicios_url; ?>"
                   class="border-2 border-on-surface text-on-surface px-7 sm:px-10 py-3.5 sm:py-4 font-headline font-bold rounded-lg hover:bg-surface-container-low transition-colors inline-block">
                    <?php esc_html_e( 'Ver soluciones', 'cdo-solutions' ); ?>
                </a>
            </div>
            <div data-cdo-reveal data-cdo-delay="300" class="mt-10 flex items-center gap-4">
                <div class="flex -space-x-2">
                    <div class="w-9 h-9 rounded-full border-2 border-white bg-gradient-to-tr from-primary to-primary-container shadow"></div>
                    <div class="w-9 h-9 rounded-full border-2 border-white bg-gradient-to-tr from-tertiary to-tertiary-fixed-dim shadow"></div>
                    <div class="w-9 h-9 rounded-full border-2 border-white bg-gradient-to-tr from-[#6366F1] to-[#A5B4FC] shadow"></div>
                    <div class="w-9 h-9 rounded-full border-2 border-white bg-gradient-to-tr from-[#F59E0B] to-[#FCD34D] shadow"></div>
                </div>
                <div class="text-sm text-secondary">
                    <span class="font-bold text-on-surface">+50 empresas</span> <?php esc_html_e( 'confían en nosotros', 'cdo-solutions' ); ?>
                </div>
            </div>
        </div>

        <div data-cdo-reveal="right" data-cdo-delay="200" class="relative group">

            <!-- Interactive dashboard (light theme, pure HTML/CSS) -->
            <div class="cdo-float relative z-20 rounded-2xl shadow-2xl bg-gradient-to-br from-white to-surface-container-low aspect-[4/3] p-5 md:p-7 overflow-hidden border border-surface-container-highest">

                <!-- Title bar -->
                <div class="flex items-center justify-between mb-4 md:mb-5">
                    <div class="flex gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#FF5F57]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#FEBC2E]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#28C840]"></span>
                    </div>
                    <div class="text-xs text-secondary font-mono tracking-tight">cdo.dashboard</div>
                    <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-container/40 border border-primary">
                        <span class="cdo-pulse-dot w-1.5 h-1.5 rounded-full bg-primary"></span>
                        <span class="text-[9px] font-bold uppercase tracking-widest text-primary">Live</span>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="flex gap-1 mb-5 border-b border-surface-container-highest -mx-5 md:-mx-7 px-5 md:px-7">
                    <button type="button" data-cdo-tab="tienda"    class="cdo-tab cdo-tab--active px-3 py-2 text-[10px] md:text-xs font-bold uppercase tracking-widest text-on-surface border-b-2 border-primary-container -mb-px transition-colors"><?php esc_html_e( 'Tienda', 'cdo-solutions' ); ?></button>
                    <button type="button" data-cdo-tab="marketing" class="cdo-tab px-3 py-2 text-[10px] md:text-xs font-bold uppercase tracking-widest text-secondary border-b-2 border-transparent hover:text-on-surface -mb-px transition-colors"><?php esc_html_e( 'Marketing', 'cdo-solutions' ); ?></button>
                    <button type="button" data-cdo-tab="soporte"   class="cdo-tab px-3 py-2 text-[10px] md:text-xs font-bold uppercase tracking-widest text-secondary border-b-2 border-transparent hover:text-on-surface -mb-px transition-colors"><?php esc_html_e( 'Soporte', 'cdo-solutions' ); ?></button>
                </div>

                <!-- Pane: Tienda -->
                <div data-cdo-tab-content="tienda" class="cdo-tab-pane">
                    <div class="grid grid-cols-3 gap-2 md:gap-2.5 mb-3 md:mb-4">
                        <div class="rounded-lg bg-gradient-to-tr from-[#6366F1]/15 to-[#A5B4FC]/5 border border-[#6366F1]/30 p-2 md:p-3 hover:scale-105 transition-transform cursor-default">
                            <div class="text-[8px] md:text-[9px] font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Ventas', 'cdo-solutions' ); ?></div>
                            <div class="text-base md:text-lg font-display font-black text-on-surface mt-1">€<span data-cdo-count="12450" data-cdo-format="thousands">12.450</span></div>
                        </div>
                        <div class="rounded-lg bg-gradient-to-tr from-tertiary/15 to-tertiary-fixed-dim/5 border border-tertiary/30 p-2 md:p-3 hover:scale-105 transition-transform cursor-default">
                            <div class="text-[8px] md:text-[9px] font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Pedidos', 'cdo-solutions' ); ?></div>
                            <div class="text-base md:text-lg font-display font-black text-on-surface mt-1"><span data-cdo-count="142">142</span></div>
                        </div>
                        <div class="rounded-lg bg-gradient-to-tr from-primary/20 to-primary-container/15 border border-primary/30 p-2 md:p-3 hover:scale-105 transition-transform cursor-default">
                            <div class="text-[8px] md:text-[9px] font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Conv.', 'cdo-solutions' ); ?></div>
                            <div class="text-base md:text-lg font-display font-black text-on-surface mt-1"><span data-cdo-count="3.8" data-cdo-decimals="1">3.8</span>%</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg p-3 md:p-4 border border-surface-container-highest">
                        <div class="flex justify-between items-center mb-3">
                            <div class="text-[10px] font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Últimos 7 días', 'cdo-solutions' ); ?></div>
                            <div class="text-[10px] text-primary font-bold">+38%</div>
                        </div>
                        <div class="flex items-end gap-1.5 h-16 md:h-20">
                            <div data-cdo-bar="40" data-cdo-delay="0"   class="flex-1 bg-gradient-to-t from-[#6366F1] to-[#A5B4FC] rounded-sm hover:opacity-80 transition-opacity"></div>
                            <div data-cdo-bar="55" data-cdo-delay="80"  class="flex-1 bg-gradient-to-t from-[#6366F1] to-[#A5B4FC] rounded-sm hover:opacity-80 transition-opacity"></div>
                            <div data-cdo-bar="35" data-cdo-delay="160" class="flex-1 bg-gradient-to-t from-[#6366F1] to-[#A5B4FC] rounded-sm hover:opacity-80 transition-opacity"></div>
                            <div data-cdo-bar="70" data-cdo-delay="240" class="flex-1 bg-gradient-to-t from-[#6366F1] to-[#A5B4FC] rounded-sm hover:opacity-80 transition-opacity"></div>
                            <div data-cdo-bar="60" data-cdo-delay="320" class="flex-1 bg-gradient-to-t from-[#6366F1] to-[#A5B4FC] rounded-sm hover:opacity-80 transition-opacity"></div>
                            <div data-cdo-bar="85" data-cdo-delay="400" class="flex-1 bg-gradient-to-t from-primary-container to-primary rounded-sm hover:opacity-80 transition-opacity"></div>
                            <div data-cdo-bar="95" data-cdo-delay="480" class="flex-1 bg-gradient-to-t from-tertiary to-tertiary-fixed-dim rounded-sm hover:opacity-80 transition-opacity"></div>
                        </div>
                    </div>
                </div>

                <!-- Pane: Marketing -->
                <div data-cdo-tab-content="marketing" class="cdo-tab-pane hidden">
                    <div class="space-y-2.5 md:space-y-3">
                        <div class="rounded-lg bg-white border border-surface-container-highest hover:border-on-surface/30 transition-colors p-3">
                            <div class="flex justify-between items-center mb-2">
                                <div class="text-xs text-on-surface font-medium"><?php esc_html_e( 'Newsletter abril', 'cdo-solutions' ); ?></div>
                                <div class="text-[9px] font-bold uppercase tracking-widest text-primary"><?php esc_html_e( 'Activo', 'cdo-solutions' ); ?></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-secondary mb-1.5">
                                <span><?php esc_html_e( 'Aperturas', 'cdo-solutions' ); ?></span><span class="text-on-surface font-bold">68%</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-surface-container-highest overflow-hidden">
                                <div data-cdo-bar="68" data-cdo-bar-axis="x" data-cdo-delay="100" class="h-full bg-gradient-to-r from-tertiary to-tertiary-fixed-dim rounded-full"></div>
                            </div>
                        </div>

                        <div class="rounded-lg bg-white border border-surface-container-highest hover:border-on-surface/30 transition-colors p-3">
                            <div class="flex justify-between items-center mb-2">
                                <div class="text-xs text-on-surface font-medium"><?php esc_html_e( 'Funnel conversión', 'cdo-solutions' ); ?></div>
                                <div class="text-[9px] font-bold uppercase tracking-widest text-primary">+12%</div>
                            </div>
                            <div class="flex justify-between text-[10px] text-secondary mb-1.5">
                                <span><?php esc_html_e( 'Visitas → Compra', 'cdo-solutions' ); ?></span><span class="text-on-surface font-bold">3.8%</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-surface-container-highest overflow-hidden">
                                <div data-cdo-bar="38" data-cdo-bar-axis="x" data-cdo-delay="200" class="h-full bg-gradient-to-r from-[#6366F1] to-[#A5B4FC] rounded-full"></div>
                            </div>
                        </div>

                        <div class="rounded-lg bg-white border border-surface-container-highest hover:border-on-surface/30 transition-colors p-3">
                            <div class="flex justify-between items-center mb-2">
                                <div class="text-xs text-on-surface font-medium"><?php esc_html_e( 'Automatización n8n', 'cdo-solutions' ); ?></div>
                                <div class="text-[9px] font-bold uppercase tracking-widest text-primary">24/7</div>
                            </div>
                            <div class="flex justify-between text-[10px] text-secondary mb-1.5">
                                <span><?php esc_html_e( 'Tareas ejecutadas', 'cdo-solutions' ); ?></span><span class="text-on-surface font-bold"><span data-cdo-count="1842">1842</span></span>
                            </div>
                            <div class="h-1.5 rounded-full bg-surface-container-highest overflow-hidden">
                                <div data-cdo-bar="92" data-cdo-bar-axis="x" data-cdo-delay="300" class="h-full bg-gradient-to-r from-primary-container to-primary rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pane: Soporte -->
                <div data-cdo-tab-content="soporte" class="cdo-tab-pane hidden">
                    <div class="grid grid-cols-2 gap-2 md:gap-2.5 mb-3">
                        <div class="rounded-lg bg-gradient-to-tr from-[#10B981]/15 to-[#6EE7B7]/5 border border-[#10B981]/30 p-3 hover:scale-105 transition-transform">
                            <div class="text-[9px] font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Tickets activos', 'cdo-solutions' ); ?></div>
                            <div class="text-2xl font-display font-black text-on-surface mt-1"><span data-cdo-count="3">3</span></div>
                        </div>
                        <div class="rounded-lg bg-gradient-to-tr from-primary/20 to-primary-container/15 border border-primary/30 p-3 hover:scale-105 transition-transform">
                            <div class="text-[9px] font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Resp. media', 'cdo-solutions' ); ?></div>
                            <div class="text-2xl font-display font-black text-on-surface mt-1"><span data-cdo-count="14">14</span> <span class="text-sm text-secondary">min</span></div>
                        </div>
                    </div>
                    <div class="rounded-lg bg-white border border-surface-container-highest p-3">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-xs text-on-surface font-medium"><?php esc_html_e( 'Satisfacción cliente', 'cdo-solutions' ); ?></div>
                            <div class="text-[9px] font-bold uppercase tracking-widest text-primary">98%</div>
                        </div>
                        <div class="h-1.5 rounded-full bg-surface-container-highest overflow-hidden mb-3">
                            <div data-cdo-bar="98" data-cdo-bar-axis="x" data-cdo-delay="100" class="h-full bg-gradient-to-r from-primary-container to-primary rounded-full"></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-xs text-secondary"><?php esc_html_e( 'Uptime sistemas', 'cdo-solutions' ); ?></div>
                            <div class="flex items-center gap-1.5">
                                <span class="cdo-pulse-dot w-1.5 h-1.5 rounded-full bg-primary"></span>
                                <span class="text-xs text-on-surface font-bold">99.97%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating glass cards alrededor del dashboard -->
            <div class="cdo-hero-floats">
                <div class="cdo-float cdo-float--rev absolute -top-8 -left-8 glass-panel p-5 rounded-xl shadow-xl z-30 hidden md:block">
                    <?php cdo_icon( 'insights', 'text-tertiary text-3xl' ); ?>
                    <div class="mt-2 font-headline font-extrabold text-2xl"><span data-cdo-count="320" data-cdo-prefix="+" data-cdo-suffix="%">+320%</span></div>
                    <div class="text-[10px] uppercase tracking-widest text-secondary font-bold"><?php esc_html_e( 'Crecimiento Anual', 'cdo-solutions' ); ?></div>
                </div>
                <div class="cdo-float absolute -bottom-6 -right-6 glass-panel py-3 px-5 rounded-xl shadow-xl z-30 hidden md:block">
                    <div class="flex items-center gap-2">
                        <div class="cdo-pulse-dot w-3 h-3 rounded-full bg-primary-container"></div>
                        <span class="text-xs font-bold uppercase tracking-widest"><?php esc_html_e( 'Live Metrics', 'cdo-solutions' ); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Marquee -->
<section class="py-10 md:py-12 bg-surface-container-lowest overflow-hidden border-y border-surface-container-highest" aria-label="<?php esc_attr_e( 'Plataformas con las que trabajamos', 'cdo-solutions' ); ?>">
    <div class="text-center text-xs font-bold uppercase tracking-[0.3em] text-secondary mb-6">
        <?php esc_html_e( 'Trabajamos con todo el ecosistema ecommerce', 'cdo-solutions' ); ?>
    </div>
    <div class="flex marquee-animation whitespace-nowrap">
        <?php
        // Cubre plataformas, pago, email/CRM, logística, marketplaces, ads, analytics, automatización, atención
        $platforms = array(
            // Plataformas ecommerce
            'Shopify', 'PrestaShop', 'WooCommerce', 'Magento', 'BigCommerce', 'VTEX',
            // Pago
            'Stripe', 'PayPal', 'Redsys', 'Bizum', 'Klarna', 'Adyen',
            // Email marketing / CRM
            'Mailchimp', 'Klaviyo', 'Active Campaign', 'Brevo', 'HubSpot', 'Conectif',
            // Logística
            'ShippyPro', 'Outvio', 'Sendcloud', 'ITS Rever', 'SEUR', 'MRW', 'Correos Express', 'GLS', 'DHL',
            // Marketplaces
            'Amazon', 'eBay', 'Etsy', 'AliExpress',
            // Ads / Social
            'Meta Ads', 'Google Ads', 'TikTok Ads', 'Pinterest', 'Later', 'Metricool',
            // Analytics
            'GA4', 'Tag Manager', 'Hotjar', 'Looker Studio',
            // Automatización
            'n8n', 'Zapier', 'Make',
            // Atención cliente
            'Zendesk', 'Intercom', 'Crisp',
        );
        for ( $i = 0; $i < 2; $i++ ) : ?>
            <div class="flex items-center gap-12 md:gap-20 px-8 md:px-10 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
                <?php foreach ( $platforms as $name ) : ?>
                    <span class="text-lg md:text-xl font-black font-headline text-secondary whitespace-nowrap"><?php echo esc_html( $name ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </div>
</section>

<!-- 3. Soluciones (dinámico desde CPT cdo_solucion) -->
<?php
$home_solutions = function_exists( 'cdo_get_solucion_categories' ) ? cdo_get_solucion_categories() : array();
$home_software  = function_exists( 'cdo_get_software_products' )    ? cdo_get_software_products()    : array();
?>
<?php if ( ! empty( $home_solutions ) ) : ?>
<section class="py-20 md:py-28 px-6 md:px-8 bg-surface-container-lowest">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 md:mb-14 gap-5 md:gap-8">
            <div data-cdo-reveal class="max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3 block"><?php esc_html_e( 'Soluciones', 'cdo-solutions' ); ?></span>
                <h2 class="cdo-section-headline text-4xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tighter text-on-surface">
                    <?php esc_html_e( 'Tres áreas, un único equipo.', 'cdo-solutions' ); ?>
                </h2>
            </div>
            <a href="<?php echo $servicios_url; ?>" data-cdo-reveal data-cdo-delay="100"
               class="text-sm font-bold text-on-surface hover:text-primary inline-flex items-center gap-1 shrink-0">
                <?php esc_html_e( 'Ver todas las soluciones', 'cdo-solutions' ); ?>
                <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
            <?php foreach ( $home_solutions as $i => $sol ) : ?>
                <a href="<?php echo esc_url( $sol['permalink'] ); ?>"
                   data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>"
                   class="cdo-service-card group block p-6 md:p-7 bg-surface-container-lowest rounded-2xl border border-surface-container-highest hover:border-on-surface">
                    <div class="cdo-float w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr <?php echo esc_attr( $sol['grad'] ); ?> mb-5 flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl md:text-3xl" aria-hidden="true"><?php echo esc_html( $sol['icon'] ); ?></span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-secondary block mb-2"><?php echo esc_html( $sol['number'] ); ?> · <?php echo esc_html( $sol['eyebrow'] ); ?></span>
                    <h3 class="text-2xl md:text-3xl font-display font-extrabold tracking-tighter text-on-surface mb-3 leading-tight"><?php echo esc_html( $sol['name'] ); ?></h3>
                    <p class="text-sm text-secondary leading-relaxed mb-5 sm:min-h-[3.25rem]"><?php echo esc_html( $sol['tagline'] ); ?></p>
                    <div class="flex items-center justify-between gap-3 pt-4 border-t border-surface-container-highest">
                        <span class="text-xs text-secondary"><?php
                            $count = count( $sol['items'] );
                            printf( esc_html( _n( '%d sub-servicio', '%d sub-servicios', $count, 'cdo-solutions' ) ), (int) $count );
                        ?></span>
                        <span class="shrink-0 text-on-surface group-hover:text-primary transition-colors flex items-center gap-1 text-sm font-bold">
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

<!-- 4. Software propio (dinámico desde CPT cdo_software) -->
<?php if ( ! empty( $home_software ) ) : ?>
<section class="py-20 md:py-28 px-6 md:px-8 bg-surface-container-low border-t border-surface-container-highest">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 md:mb-14 gap-5 md:gap-8">
            <div data-cdo-reveal class="max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3 block"><?php esc_html_e( 'Software propio', 'cdo-solutions' ); ?></span>
                <h2 class="cdo-section-headline text-4xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tighter text-on-surface">
                    <?php esc_html_e( 'Tu casa,', 'cdo-solutions' ); ?>
                    <span class="text-primary-container bg-black px-2 inline-block"><?php esc_html_e( 'no alquilada', 'cdo-solutions' ); ?></span><?php esc_html_e( '.', 'cdo-solutions' ); ?>
                </h2>
            </div>
            <a href="<?php echo esc_url( home_url( '/software/' ) ); ?>" data-cdo-reveal data-cdo-delay="100"
               class="text-sm font-bold text-on-surface hover:text-primary inline-flex items-center gap-1 shrink-0">
                <?php esc_html_e( 'Ver catálogo software', 'cdo-solutions' ); ?>
                <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
            <?php foreach ( $home_software as $i => $pp ) :
                $pp_price       = ! empty( $pp['tiers'] ) ? (int) $pp['tiers'][0]['price'] : (int) $pp['price'];
                $pp_has_slider  = ! empty( $pp['tiers'] );
            ?>
                <a href="<?php echo esc_url( $pp['permalink'] ); ?>"
                   data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>"
                   class="cdo-service-card group block p-6 md:p-7 bg-surface-container-lowest rounded-2xl border border-surface-container-highest hover:border-on-surface">
                    <div class="cdo-float w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-tr <?php echo esc_attr( $pp['grad'] ); ?> mb-5 flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl md:text-3xl" aria-hidden="true"><?php echo esc_html( $pp['icon'] ); ?></span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-secondary block mb-2"><?php echo esc_html( $pp['eyebrow'] ); ?></span>
                    <h3 class="text-2xl md:text-3xl font-display font-extrabold tracking-tighter text-on-surface mb-3 leading-tight"><?php echo esc_html( $pp['name'] ); ?></h3>
                    <p class="text-sm text-secondary leading-relaxed mb-5 sm:min-h-[3.25rem]"><?php echo esc_html( $pp['tagline'] ); ?></p>
                    <div class="flex items-end justify-between gap-3 pt-4 border-t border-surface-container-highest">
                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-secondary mb-0.5"><?php esc_html_e( 'Desde', 'cdo-solutions' ); ?></div>
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-display font-extrabold text-on-surface"><?php echo esc_html( $pp_price ); ?>&nbsp;€</span>
                                <span class="text-xs text-secondary"><?php echo esc_html( $pp['price_period'] ); ?></span>
                            </div>
                            <?php if ( $pp_has_slider && ! empty( $pp['unit_plural'] ) ) : ?>
                                <div class="text-[10px] text-secondary mt-1 inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-primary text-sm" aria-hidden="true">tune</span>
                                    <?php printf( esc_html__( 'Escalable por %s', 'cdo-solutions' ), esc_html( $pp['unit_plural'] ) ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <span class="shrink-0 text-on-surface group-hover:text-primary transition-colors flex items-center gap-1 text-sm font-bold">
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

<!-- 5. ICP — Tienda online + tienda física -->
<section class="py-20 md:py-28 px-6 md:px-8 bg-surface-container-lowest">
    <div class="max-w-5xl mx-auto text-center">
        <span data-cdo-reveal class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block"><?php esc_html_e( 'Para quién trabajamos', 'cdo-solutions' ); ?></span>
        <h2 data-cdo-reveal data-cdo-delay="100"
            class="cdo-section-headline text-3xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tighter text-on-surface mb-6 md:mb-8">
            <?php esc_html_e( 'Tienda online', 'cdo-solutions' ); ?>
            <span class="text-primary-container bg-black px-2 inline-block"><?php esc_html_e( '+', 'cdo-solutions' ); ?></span>
            <?php esc_html_e( 'tienda física.', 'cdo-solutions' ); ?>
        </h2>
        <p data-cdo-reveal data-cdo-delay="200" class="text-base md:text-lg text-secondary leading-relaxed max-w-3xl mx-auto mb-8 md:mb-10">
            <?php esc_html_e( 'Trabajamos con empresas omnicanal: la tienda online vendiendo, las tiendas físicas funcionando, y todo conectado en un único stack — del ecommerce al mostrador. Llevamos nuestras soluciones a todo el mercado europeo.', 'cdo-solutions' ); ?>
        </p>

        <div data-cdo-reveal data-cdo-delay="300" class="flex flex-wrap justify-center gap-2 md:gap-3 mb-8">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-low border border-surface-container-highest text-sm font-bold text-on-surface">
                <span class="material-symbols-outlined text-[#6366F1] text-base" aria-hidden="true">storefront</span>
                <?php esc_html_e( 'Online', 'cdo-solutions' ); ?>
            </span>
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-low border border-surface-container-highest text-sm font-bold text-on-surface">
                <span class="material-symbols-outlined text-[#F59E0B] text-base" aria-hidden="true">store</span>
                <?php esc_html_e( 'Físicas', 'cdo-solutions' ); ?>
            </span>
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-low border border-surface-container-highest text-sm font-bold text-on-surface">
                <span class="material-symbols-outlined text-primary text-base" aria-hidden="true">sync_alt</span>
                <?php esc_html_e( 'Todo conectado', 'cdo-solutions' ); ?>
            </span>
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-container/20 border border-primary-container/50 text-sm font-bold text-on-surface">
                <span class="material-symbols-outlined text-primary text-base" aria-hidden="true">public</span>
                <?php esc_html_e( 'Mercado europeo', 'cdo-solutions' ); ?>
            </span>
        </div>

        <a data-cdo-reveal data-cdo-delay="400" href="<?php echo esc_url( home_url( '/sobre-nosotros/' ) ); ?>"
           class="inline-flex items-center gap-2 text-sm font-bold text-on-surface hover:text-primary transition-colors">
            <?php esc_html_e( 'Conoce más sobre nosotros', 'cdo-solutions' ); ?>
            <span class="material-symbols-outlined text-base" aria-hidden="true">arrow_forward</span>
        </a>
    </div>
</section>

<!-- 5. Nuestro método -->
<section class="py-20 md:py-32 px-6 md:px-8 bg-surface-container-lowest">
    <div class="max-w-7xl mx-auto">
        <h2 data-cdo-reveal class="cdo-section-headline text-4xl md:text-5xl font-display font-extrabold tracking-tighter mb-12 md:mb-20 text-center">
            <?php esc_html_e( 'Nuestro método.', 'cdo-solutions' ); ?>
        </h2>

        <?php
        $steps = array(
            array( 'num' => '01', 'icon' => 'search',         'icon_color' => 'text-tertiary',         'title' => __( 'Análisis',          'cdo-solutions' ), 'desc' => __( 'Auditoría profunda de tu situación actual y detección de cuellos de botella.', 'cdo-solutions' ) ),
            array( 'num' => '02', 'icon' => 'architecture',   'icon_color' => 'text-primary',          'title' => __( 'Estrategia',        'cdo-solutions' ), 'desc' => __( 'Hoja de ruta técnica y comercial a medida con objetivos claros.',           'cdo-solutions' ) ),
            array( 'num' => '03', 'icon' => 'rocket_launch',  'icon_color' => 'text-secondary',        'title' => __( 'Implementación',    'cdo-solutions' ), 'desc' => __( 'Ejecución ágil con los más altos estándares de calidad y rendimiento.',     'cdo-solutions' ) ),
            array( 'num' => '04', 'icon' => 'support_agent',  'icon_color' => 'text-on-surface',       'title' => __( 'Soporte continuo',  'cdo-solutions' ), 'desc' => __( 'Optimización constante basada en datos para nunca dejar de crecer.',         'cdo-solutions' ) ),
        );
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 md:gap-12 relative">
            <?php foreach ( $steps as $i => $step ) : ?>
                <div data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>" class="relative group">
                    <div class="text-7xl font-display font-black text-on-surface/5 absolute -top-12 left-0 group-hover:text-primary-container/30 transition-colors"><?php echo esc_html( $step['num'] ); ?></div>
                    <div class="relative pt-8">
                        <div class="w-12 h-12 bg-surface-container-low rounded-xl mb-6 flex items-center justify-center group-hover:bg-primary-container transition-colors">
                            <span class="material-symbols-outlined <?php echo esc_attr( $step['icon_color'] ); ?> group-hover:text-on-primary-fixed transition-colors" aria-hidden="true"><?php echo esc_html( $step['icon'] ); ?></span>
                        </div>
                        <h4 class="text-xl font-bold mb-3"><?php echo esc_html( $step['title'] ); ?></h4>
                        <div class="w-12 h-1 bg-primary-container mb-4 group-hover:w-20 transition-all duration-300"></div>
                        <p class="text-sm text-secondary leading-relaxed"><?php echo esc_html( $step['desc'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 6. Stats — contadores animados -->
<section class="bg-surface-container-low py-16 md:py-20 px-6 md:px-8">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-12 text-center">

        <div data-cdo-reveal class="space-y-2">
            <div class="flex justify-center mb-3 md:mb-4"><?php cdo_icon( 'shopping_cart', 'text-primary text-3xl md:text-4xl' ); ?></div>
            <div class="text-4xl md:text-5xl font-display font-black text-on-surface">
                <span data-cdo-count="50" data-cdo-prefix="+">+50</span>
            </div>
            <div class="text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Ecommerces gestionados', 'cdo-solutions' ); ?></div>
        </div>

        <div data-cdo-reveal data-cdo-delay="100" class="space-y-2">
            <div class="flex justify-center mb-3 md:mb-4"><?php cdo_icon( 'schedule', 'text-tertiary text-3xl md:text-4xl' ); ?></div>
            <div class="text-4xl md:text-5xl font-display font-black text-on-surface">
                <span data-cdo-count="10" data-cdo-prefix="+">+10</span>
            </div>
            <div class="text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Años de experiencia', 'cdo-solutions' ); ?></div>
        </div>

        <div data-cdo-reveal data-cdo-delay="200" class="space-y-2">
            <div class="flex justify-center mb-3 md:mb-4"><?php cdo_icon( 'payments', 'text-on-surface text-3xl md:text-4xl' ); ?></div>
            <div class="text-4xl md:text-5xl font-display font-black text-on-surface">
                <span data-cdo-count="5" data-cdo-prefix="+" data-cdo-suffix="M&euro;">+5M&euro;</span>
            </div>
            <div class="text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Ventas gestionadas', 'cdo-solutions' ); ?></div>
        </div>

        <div data-cdo-reveal data-cdo-delay="300" class="space-y-2">
            <div class="flex justify-center mb-3 md:mb-4"><?php cdo_icon( 'verified', 'text-on-surface-variant text-3xl md:text-4xl' ); ?></div>
            <div class="text-4xl md:text-5xl font-display font-black text-on-surface">24/7</div>
            <div class="text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Soporte técnico', 'cdo-solutions' ); ?></div>
        </div>

    </div>
</section>

<!-- 7. Testimonio (NDA) -->
<section class="py-24 md:py-40 px-6 md:px-8 bg-surface-container-lowest overflow-hidden relative">
    <div class="max-w-4xl mx-auto relative text-center">
        <span class="material-symbols-outlined text-[120px] md:text-[160px] absolute -top-16 md:-top-24 left-1/2 -translate-x-1/2 opacity-10 text-primary-container" aria-hidden="true">format_quote</span>
        <blockquote data-cdo-reveal class="text-2xl sm:text-3xl md:text-5xl font-display italic font-bold text-on-surface relative z-10 leading-tight">
            &ldquo;<?php esc_html_e( 'Trabajar con cdo.solutions no ha sido un gasto, sino la mejor inversión de nuestra historia. Han triplicado nuestra tasa de conversión en menos de un año.', 'cdo-solutions' ); ?>&rdquo;
        </blockquote>
        <div data-cdo-reveal data-cdo-delay="200" class="mt-12 md:mt-16 flex flex-col items-center">
            <div class="w-20 h-20 rounded-full border-4 border-primary-container p-1 mb-4 overflow-hidden shadow-xl bg-gradient-to-tr from-tertiary to-primary-container flex items-center justify-center">
                <span class="font-display font-extrabold text-2xl text-white">&infin;</span>
            </div>
            <div class="font-headline font-bold text-lg text-on-surface"><?php esc_html_e( 'Director de operaciones', 'cdo-solutions' ); ?></div>
            <div class="text-xs font-bold uppercase tracking-widest text-primary mt-1"><?php esc_html_e( 'Cliente bajo NDA', 'cdo-solutions' ); ?></div>
        </div>
    </div>
</section>

<!-- 8. CTA final -->
<section class="cdo-cta-banner mx-4 md:mx-8 mb-12 md:mb-16 px-6 md:px-8 py-16 md:py-24 bg-black rounded-2xl md:rounded-3xl relative overflow-hidden text-center">
    <div class="cdo-blob absolute top-0 right-0 w-72 md:w-96 h-72 md:h-96 bg-primary opacity-25 blur-[150px] pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute bottom-0 left-0 w-72 md:w-96 h-72 md:h-96 bg-tertiary opacity-15 blur-[150px] pointer-events-none"></div>

    <div class="max-w-3xl mx-auto relative z-10">
        <h2 data-cdo-reveal class="cdo-cta-headline text-3xl md:text-5xl lg:text-6xl font-display font-extrabold text-white tracking-tighter mb-8 md:mb-10 leading-tight">
            <?php esc_html_e( '¿Listo para hacer crecer tu negocio online?', 'cdo-solutions' ); ?>
        </h2>
        <a data-cdo-reveal data-cdo-delay="200" href="<?php echo $contacto_url; ?>"
           class="bg-primary-container text-on-primary-fixed px-8 md:px-12 py-4 md:py-5 font-headline font-extrabold text-base md:text-lg rounded-xl hover:scale-105 transition-transform inline-flex items-center gap-3">
            <?php esc_html_e( 'Hablemos', 'cdo-solutions' ); ?>
            <span class="material-symbols-outlined" aria-hidden="true">arrow_right_alt</span>
        </a>
        <p data-cdo-reveal data-cdo-delay="300" class="mt-6 md:mt-8 text-secondary-fixed text-sm"><?php esc_html_e( 'Respuesta garantizada en menos de 24 horas.', 'cdo-solutions' ); ?></p>
    </div>
</section>

<?php get_footer(); ?>
