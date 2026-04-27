<?php
/**
 * Template Name: Sobre nosotros
 *
 * @package CdoSolutions
 */

get_header();
$contacto_url = esc_url( home_url( '/contacto/' ) );
?>

<!-- Hero -->
<section class="cdo-hero relative pt-20 md:pt-28 pb-14 md:pb-20 px-6 md:px-8 overflow-hidden bg-surface-container-lowest">
    <div class="cdo-blob absolute top-[-15%] right-[-10%] w-[500px] h-[500px] bg-tertiary opacity-10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute top-[20%] left-[-10%] w-[400px] h-[400px] bg-primary opacity-15 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        <span data-cdo-reveal class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-6 block"><?php esc_html_e( 'Sobre nosotros', 'cdo-solutions' ); ?></span>
        <h1 data-cdo-reveal data-cdo-delay="100"
            class="cdo-hero-headline font-display text-[2.25rem] sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-on-surface leading-[1.05] tracking-tighter">
            <?php esc_html_e( 'Hacemos que vender online y en tienda física sea', 'cdo-solutions' ); ?>
            <span class="text-primary-container bg-black px-2 inline-block"><?php esc_html_e( 'fácil', 'cdo-solutions' ); ?></span><?php esc_html_e( '.', 'cdo-solutions' ); ?>
        </h1>
        <p data-cdo-reveal data-cdo-delay="200" class="mt-6 md:mt-8 text-lg md:text-xl text-secondary max-w-3xl leading-relaxed">
            <?php esc_html_e( 'Somos cdo.solutions — Centro de Desarrollo Online. Llevamos más de 10 años ayudando a empresas omnicanal a vender online sin que la operativa, la tecnología y la logística se conviertan en un cuello de botella.', 'cdo-solutions' ); ?>
        </p>
    </div>
</section>

<!-- Stats banner — destacado arriba para impacto inmediato -->
<section class="bg-surface-container-low py-10 md:py-14 px-6 md:px-8 border-y border-surface-container-highest">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-12 text-center">
        <div data-cdo-reveal class="space-y-1">
            <div class="flex justify-center mb-2"><?php cdo_icon( 'shopping_cart', 'text-primary text-3xl' ); ?></div>
            <div class="text-3xl md:text-4xl font-display font-black text-on-surface"><span data-cdo-count="50" data-cdo-prefix="+">+50</span></div>
            <div class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Ecommerces gestionados', 'cdo-solutions' ); ?></div>
        </div>
        <div data-cdo-reveal data-cdo-delay="100" class="space-y-1">
            <div class="flex justify-center mb-2"><?php cdo_icon( 'schedule', 'text-tertiary text-3xl' ); ?></div>
            <div class="text-3xl md:text-4xl font-display font-black text-on-surface"><span data-cdo-count="10" data-cdo-prefix="+">+10</span></div>
            <div class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Años de experiencia', 'cdo-solutions' ); ?></div>
        </div>
        <div data-cdo-reveal data-cdo-delay="200" class="space-y-1">
            <div class="flex justify-center mb-2"><?php cdo_icon( 'payments', 'text-on-surface text-3xl' ); ?></div>
            <div class="text-3xl md:text-4xl font-display font-black text-on-surface"><span data-cdo-count="5" data-cdo-prefix="+" data-cdo-suffix="M&euro;">+5M&euro;</span></div>
            <div class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Ventas gestionadas', 'cdo-solutions' ); ?></div>
        </div>
        <div data-cdo-reveal data-cdo-delay="300" class="space-y-1">
            <div class="flex justify-center mb-2"><?php cdo_icon( 'public', 'text-on-surface-variant text-3xl' ); ?></div>
            <div class="text-3xl md:text-4xl font-display font-black text-on-surface"><?php esc_html_e( 'EU', 'cdo-solutions' ); ?></div>
            <div class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-secondary"><?php esc_html_e( 'Mercado europeo', 'cdo-solutions' ); ?></div>
        </div>
    </div>
</section>

<!-- Quiénes somos -->
<section class="py-20 md:py-24 px-6 md:px-8 bg-surface-container-lowest overflow-hidden">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
        <div data-cdo-reveal="left">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3 block"><?php esc_html_e( 'Quiénes somos', 'cdo-solutions' ); ?></span>
            <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter mb-6 md:mb-8 text-on-surface">
                <?php esc_html_e( 'Trabajamos con quienes ya facturan en serio.', 'cdo-solutions' ); ?>
            </h2>
            <p class="text-base md:text-lg text-secondary leading-relaxed mb-5">
                <?php esc_html_e( 'Colaboramos con empresas de tamaño medio y grande, muchas con facturaciones anuales significativas y un extenso recorrido en el mercado, a quienes brindamos soporte y optimización constante.', 'cdo-solutions' ); ?>
            </p>
            <p class="text-base md:text-lg text-secondary leading-relaxed mb-8">
                <?php esc_html_e( 'Nuestro objetivo es optimizar y automatizar todos los procesos posibles dentro de tu empresa para mejorar la eficiencia. En el área de marketing, nos centramos en crear oportunidades reales de venta y mejorar la competitividad de tu marca.', 'cdo-solutions' ); ?>
            </p>
            <div class="inline-flex items-start sm:items-center gap-3 px-5 py-3 rounded-xl bg-surface-container-low border border-outline-variant max-w-xl">
                <span class="material-symbols-outlined text-tertiary shrink-0 mt-0.5 sm:mt-0" aria-hidden="true">lock</span>
                <span class="text-sm text-on-surface font-medium">
                    <?php esc_html_e( 'Trabajamos bajo acuerdos de confidencialidad. No compartimos nombres de clientes.', 'cdo-solutions' ); ?>
                </span>
            </div>
        </div>

        <div data-cdo-reveal="right" data-cdo-delay="200" class="relative">
            <div class="absolute -inset-8 bg-gradient-to-tr from-tertiary-fixed-dim to-primary-container opacity-30 blur-3xl rounded-full cdo-gradient-shift"></div>
            <div class="relative grid grid-cols-2 gap-3 md:gap-4">
                <div class="cdo-float aspect-square rounded-2xl bg-gradient-to-tr from-primary to-primary-container shadow-xl flex items-center justify-center text-on-primary-fixed">
                    <span class="material-symbols-outlined text-5xl md:text-6xl" aria-hidden="true">storefront</span>
                </div>
                <div class="cdo-float cdo-float--rev aspect-square rounded-2xl bg-gradient-to-tr from-tertiary to-tertiary-fixed-dim shadow-xl mt-8 md:mt-12 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-5xl md:text-6xl" aria-hidden="true">campaign</span>
                </div>
                <div class="cdo-float cdo-float--rev aspect-square rounded-2xl bg-gradient-to-tr from-[#6366F1] to-[#A5B4FC] shadow-xl flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-5xl md:text-6xl" aria-hidden="true">local_shipping</span>
                </div>
                <div class="cdo-float aspect-square rounded-2xl bg-gradient-to-tr from-[#10B981] to-[#6EE7B7] shadow-xl mt-8 md:mt-12 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-5xl md:text-6xl" aria-hidden="true">build</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cliente ideal: omnicanal -->
<section class="py-20 md:py-24 px-6 md:px-8 bg-surface-container-low border-y border-surface-container-highest">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="text-center max-w-3xl mx-auto mb-12 md:mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block"><?php esc_html_e( 'Para quién trabajamos', 'cdo-solutions' ); ?></span>
            <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface mb-5 md:mb-6">
                <?php esc_html_e( 'Tienda online', 'cdo-solutions' ); ?>
                <span class="text-primary-container bg-black px-2 inline-block"><?php esc_html_e( 'y tienda física', 'cdo-solutions' ); ?></span><?php esc_html_e( '.', 'cdo-solutions' ); ?>
            </h2>
            <p class="text-base md:text-lg text-secondary leading-relaxed">
                <?php esc_html_e( 'Nuestro cliente ideal es la empresa omnicanal: vende online y a la vez tiene una o varias tiendas físicas. Cada canal con su lógica propia, perfectamente conectados — del ecommerce al mostrador.', 'cdo-solutions' ); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6">
            <?php
            $icp = array(
                array(
                    'icon'  => 'storefront',
                    'grad'  => 'from-[#6366F1] to-[#A5B4FC]',
                    'title' => __( 'Tu tienda online', 'cdo-solutions' ),
                    'desc'  => __( 'La ponemos a vender, la mantenemos a salvo de incidencias y la hacemos escalar — Shopify, PrestaShop, WooCommerce, marketing automatizado y logística integrada.', 'cdo-solutions' ),
                ),
                array(
                    'icon'  => 'store',
                    'grad'  => 'from-[#F59E0B] to-[#FCD34D]',
                    'title' => __( 'Tus tiendas físicas', 'cdo-solutions' ),
                    'desc'  => __( 'Pantallas digitales, redes, equipos, copias de seguridad locales y soporte técnico presencial — vamos a tu tienda cuando hace falta.', 'cdo-solutions' ),
                ),
                array(
                    'icon'  => 'sync_alt',
                    'grad'  => 'from-primary to-primary-container',
                    'title' => __( 'Todo conectado', 'cdo-solutions' ),
                    'desc'  => __( 'Stock, transporte entre tiendas, comunicación con cliente, atención post-venta — todo el negocio funcionando como una única operación.', 'cdo-solutions' ),
                ),
            );
            foreach ( $icp as $i => $card ) :
            ?>
                <div data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>"
                     class="cdo-service-card p-6 md:p-7 bg-surface-container-lowest rounded-2xl border border-surface-container-highest hover:border-on-surface">
                    <div class="cdo-float w-14 h-14 rounded-2xl bg-gradient-to-tr <?php echo esc_attr( $card['grad'] ); ?> mb-5 flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl" aria-hidden="true"><?php echo esc_html( $card['icon'] ); ?></span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-headline font-bold mb-3 text-on-surface"><?php echo esc_html( $card['title'] ); ?></h3>
                    <p class="text-sm md:text-base text-secondary leading-relaxed"><?php echo esc_html( $card['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Por qué elegirnos -->
<section class="py-20 md:py-24 px-6 md:px-8 bg-surface-container-lowest">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="text-center mb-12 md:mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block"><?php esc_html_e( 'Por qué cdo.solutions', 'cdo-solutions' ); ?></span>
            <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface">
                <?php esc_html_e( 'Lo que nos hace diferentes.', 'cdo-solutions' ); ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
            <?php
            $values = array(
                array( 'icon' => 'bolt',          'grad' => 'from-primary to-primary-container',     'title' => __( 'Eficiencia',           'cdo-solutions' ), 'desc' => __( 'Optimizamos cada proceso para que tu equipo dedique tiempo a lo que de verdad aporta valor.', 'cdo-solutions' ) ),
                array( 'icon' => 'autorenew',     'grad' => 'from-tertiary to-tertiary-fixed-dim',   'title' => __( 'Automatización',       'cdo-solutions' ), 'desc' => __( 'Convertimos tareas repetitivas en flujos que trabajan por ti 24 horas al día.',              'cdo-solutions' ) ),
                array( 'icon' => 'trending_up',   'grad' => 'from-[#6366F1] to-[#A5B4FC]',           'title' => __( 'Resultados medibles',  'cdo-solutions' ), 'desc' => __( 'Cada decisión se respalda con datos. Sin humo, sin promesas que no se puedan auditar.',       'cdo-solutions' ) ),
                array( 'icon' => 'savings',       'grad' => 'from-[#F59E0B] to-[#FCD34D]',           'title' => __( 'Sin alquileres SaaS',  'cdo-solutions' ), 'desc' => __( 'Software propio self-hosted. Sin pagar por contacto creciente ni quedar atrapado en una nube ajena.', 'cdo-solutions' ) ),
                array( 'icon' => 'support_agent', 'grad' => 'from-[#10B981] to-[#6EE7B7]',           'title' => __( 'Equipo accesible',     'cdo-solutions' ), 'desc' => __( 'Hablas con quien construye y mantiene. Sin tickets infinitos ni tiers de soporte.',           'cdo-solutions' ) ),
                array( 'icon' => 'verified',      'grad' => 'from-[#EC4899] to-[#F9A8D4]',           'title' => __( 'Un solo proveedor',    'cdo-solutions' ), 'desc' => __( 'Web, marketing, logística, software y soporte presencial bajo un mismo equipo.',             'cdo-solutions' ) ),
            );
            foreach ( $values as $i => $v ) :
            ?>
                <div data-cdo-reveal data-cdo-delay="<?php echo (int) ( ( $i % 3 ) * 100 ); ?>"
                     class="cdo-service-card p-6 md:p-7 bg-surface-container-lowest rounded-2xl border border-transparent hover:border-on-surface">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-tr <?php echo esc_attr( $v['grad'] ); ?> mb-5 md:mb-6 flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-2xl" aria-hidden="true"><?php echo esc_html( $v['icon'] ); ?></span>
                    </div>
                    <h3 class="text-lg md:text-xl font-headline font-bold mb-3 text-on-surface"><?php echo esc_html( $v['title'] ); ?></h3>
                    <p class="text-sm text-secondary leading-relaxed"><?php echo esc_html( $v['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Metodología -->
<section class="py-20 md:py-28 px-6 md:px-8 bg-surface-container-low">
    <div class="max-w-7xl mx-auto">
        <div data-cdo-reveal class="text-center mb-12 md:mb-20">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block"><?php esc_html_e( '¿Cómo trabajamos?', 'cdo-solutions' ); ?></span>
            <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface mb-4 md:mb-6">
                <?php esc_html_e( 'Cuatro pasos. Ningún humo.', 'cdo-solutions' ); ?>
            </h2>
            <p class="text-base md:text-lg text-secondary max-w-2xl mx-auto"><?php esc_html_e( 'Iniciamos los trabajos en cuanto recibimos la orden, garantizando agilidad desde el primer día.', 'cdo-solutions' ); ?></p>
        </div>

        <?php
        $steps = array(
            array( 'icon' => 'search',          'title' => __( 'Análisis',         'cdo-solutions' ), 'desc' => __( 'Entendemos tu negocio, tus métricas actuales y dónde están los cuellos de botella.', 'cdo-solutions' ) ),
            array( 'icon' => 'architecture',    'title' => __( 'Estrategia',       'cdo-solutions' ), 'desc' => __( 'Diseñamos un plan a medida con objetivos claros y herramientas específicas.',           'cdo-solutions' ) ),
            array( 'icon' => 'rocket_launch',   'title' => __( 'Implementación',   'cdo-solutions' ), 'desc' => __( 'Ejecutamos con tecnología de vanguardia y los más altos estándares de calidad.',         'cdo-solutions' ) ),
            array( 'icon' => 'insights',        'title' => __( 'Optimización',     'cdo-solutions' ), 'desc' => __( 'Medimos, ajustamos y mejoramos continuamente sobre datos reales.',                       'cdo-solutions' ) ),
        );
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-6">
            <?php foreach ( $steps as $i => $step ) : ?>
                <div data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 100 ); ?>"
                     class="relative bg-surface-container-lowest p-6 rounded-2xl border border-surface-container-highest">
                    <div class="absolute -top-4 left-6 text-5xl md:text-6xl font-display font-black text-primary-container leading-none tracking-tighter">0<?php echo (int) $i + 1; ?></div>
                    <div class="pt-8">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-primary" aria-hidden="true"><?php echo esc_html( $step['icon'] ); ?></span>
                            <h3 class="text-lg md:text-xl font-headline font-bold text-on-surface"><?php echo esc_html( $step['title'] ); ?></h3>
                        </div>
                        <p class="text-sm text-secondary leading-relaxed"><?php echo esc_html( $step['desc'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Stack -->
<section class="py-16 md:py-20 px-6 md:px-8 bg-surface-container-lowest">
    <div data-cdo-reveal class="max-w-7xl mx-auto text-center">
        <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3 block"><?php esc_html_e( 'Stack', 'cdo-solutions' ); ?></span>
        <h2 class="cdo-section-headline text-2xl md:text-3xl lg:text-4xl font-display font-extrabold tracking-tighter text-on-surface mb-8 md:mb-10">
            <?php esc_html_e( 'Trabajamos con las mejores herramientas del mercado.', 'cdo-solutions' ); ?>
        </h2>
        <div class="flex flex-wrap justify-center gap-2 md:gap-3 max-w-5xl mx-auto">
            <?php
            $tools = array(
                'Shopify', 'PrestaShop', 'WooCommerce', 'Magento',
                'Stripe', 'Redsys', 'Bizum', 'Klarna',
                'Klaviyo', 'Mailchimp', 'Conectif',
                'n8n', 'Zapier', 'Make',
                'ShippyPro', 'Outvio', 'ITS Rever',
                'GA4', 'Tag Manager', 'Hotjar',
                'Meta Ads', 'Google Ads', 'TikTok Ads',
                'Synology', 'Ubiquiti', 'pfSense',
            );
            foreach ( $tools as $t ) : ?>
                <span class="inline-flex items-center px-3 md:px-4 py-1.5 md:py-2 rounded-full bg-surface-container-low border border-surface-container-highest text-xs md:text-sm font-bold text-on-surface">
                    <?php echo esc_html( $t ); ?>
                </span>
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
            <?php esc_html_e( 'Hablemos de tu proyecto.', 'cdo-solutions' ); ?>
        </h2>
        <a data-cdo-reveal data-cdo-delay="200" href="<?php echo $contacto_url; ?>"
           class="bg-primary-container text-on-primary-fixed px-7 md:px-12 py-3.5 md:py-5 font-headline font-extrabold text-base md:text-lg rounded-xl hover:scale-105 transition-transform inline-flex items-center gap-3">
            <?php esc_html_e( 'Solicita una llamada', 'cdo-solutions' ); ?>
            <span class="material-symbols-outlined" aria-hidden="true">arrow_right_alt</span>
        </a>
        <p data-cdo-reveal data-cdo-delay="300" class="mt-4 md:mt-8 text-secondary-fixed text-xs md:text-sm">
            <?php esc_html_e( '30 minutos sin compromiso para entender tu caso.', 'cdo-solutions' ); ?>
        </p>
    </div>
</section>

<?php get_footer(); ?>
