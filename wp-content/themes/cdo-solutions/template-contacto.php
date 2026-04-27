<?php
/**
 * Template Name: Contacto
 *
 * @package CdoSolutions
 */

get_header();
?>

<!-- Hero + form en dos columnas -->
<section class="cdo-hero relative pt-20 md:pt-28 pb-16 md:pb-24 px-6 md:px-8 overflow-hidden bg-surface-container-lowest">
    <div class="cdo-blob absolute top-[-15%] right-[-10%] w-[400px] md:w-[500px] h-[400px] md:h-[500px] bg-primary opacity-15 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="cdo-blob cdo-blob--rev absolute bottom-[-10%] left-[-10%] w-[320px] md:w-[400px] h-[320px] md:h-[400px] bg-tertiary opacity-10 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16">

        <!-- Texto + datos -->
        <div class="lg:col-span-2">
            <span data-cdo-reveal class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-6 block"><?php esc_html_e( 'Contacto', 'cdo-solutions' ); ?></span>
            <h1 data-cdo-reveal data-cdo-delay="100"
                class="cdo-hero-headline font-display text-[2.25rem] sm:text-5xl md:text-6xl font-extrabold text-on-surface leading-[1.05] tracking-tighter mb-6 md:mb-8">
                <?php esc_html_e( 'Cuéntanos qué', 'cdo-solutions' ); ?>
                <span class="text-primary-container bg-black px-2 inline-block"><?php esc_html_e( 'necesitas', 'cdo-solutions' ); ?></span><?php esc_html_e( '.', 'cdo-solutions' ); ?>
            </h1>
            <p data-cdo-reveal data-cdo-delay="200" class="text-base md:text-lg text-secondary leading-relaxed mb-10 md:mb-12">
                <?php esc_html_e( 'Respondemos en menos de 24 horas con una propuesta clara, sin compromiso y con plazo.', 'cdo-solutions' ); ?>
            </p>

            <ul class="space-y-5 md:space-y-6">
                <?php
                $contact_items = array(
                    array( 'icon' => 'schedule',      'grad' => 'from-[#6366F1] to-[#A5B4FC]', 'label' => __( 'Horario',          'cdo-solutions' ), 'text' => __( 'Lun–Vie · 9:00 a 19:00', 'cdo-solutions' ), 'href' => null ),
                    array( 'icon' => 'mark_email_read', 'grad' => 'from-primary to-primary-container', 'label' => __( 'Tiempo de respuesta','cdo-solutions' ), 'text' => __( 'Menos de 24 horas',      'cdo-solutions' ), 'href' => null ),
                    array( 'icon' => 'support_agent', 'grad' => 'from-[#10B981] to-[#6EE7B7]', 'label' => __( 'Soporte clientes', 'cdo-solutions' ), 'text' => __( '24/7 vía portal',       'cdo-solutions' ), 'href' => null ),
                    array( 'icon' => 'place',         'grad' => 'from-[#F59E0B] to-[#FCD34D]', 'label' => __( 'Zona',             'cdo-solutions' ), 'text' => __( 'País Vasco — España',  'cdo-solutions' ), 'href' => null ),
                );
                foreach ( $contact_items as $i => $ci ) :
                ?>
                    <li data-cdo-reveal data-cdo-delay="<?php echo (int) ( 200 + $i * 100 ); ?>" class="flex items-start gap-4">
                        <div class="cdo-float w-12 h-12 rounded-xl bg-gradient-to-tr <?php echo esc_attr( $ci['grad'] ); ?> flex items-center justify-center text-white shadow-lg shrink-0">
                            <span class="material-symbols-outlined" aria-hidden="true"><?php echo esc_html( $ci['icon'] ); ?></span>
                        </div>
                        <div>
                            <div class="text-xs font-bold uppercase tracking-widest text-secondary mb-1"><?php echo esc_html( $ci['label'] ); ?></div>
                            <?php if ( $ci['href'] ) : ?>
                                <a href="<?php echo esc_attr( $ci['href'] ); ?>" class="text-base md:text-lg font-headline font-bold text-on-surface hover:text-primary transition-colors break-all"><?php echo esc_html( $ci['text'] ); ?></a>
                            <?php else : ?>
                                <div class="text-base md:text-lg font-headline font-bold text-on-surface"><?php echo esc_html( $ci['text'] ); ?></div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Formulario -->
        <div class="lg:col-span-3" data-cdo-reveal="right" data-cdo-delay="200">
            <div class="bg-surface-container-lowest border border-surface-container-highest rounded-2xl p-6 md:p-10 shadow-sm">
                <h2 class="text-xl md:text-2xl font-headline font-bold mb-2 text-on-surface"><?php esc_html_e( 'Háblanos de tu proyecto', 'cdo-solutions' ); ?></h2>
                <p class="text-sm text-secondary mb-6 md:mb-8"><?php esc_html_e( 'Cuanta más información mejor — así preparamos una propuesta a medida.', 'cdo-solutions' ); ?></p>

                <?php echo function_exists( 'cdo_contact_form_notice' ) ? cdo_contact_form_notice() : ''; ?>

                <?php
                $cdo_recaptcha_site = defined( 'CDO_RECAPTCHA_SITE_KEY' ) ? (string) CDO_RECAPTCHA_SITE_KEY : '';
                ?>
                <form id="cdo-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="space-y-5 md:space-y-6">
                    <input type="hidden" name="action" value="cdo_contact_form" />
                    <?php wp_nonce_field( 'cdo_contact', 'cdo_contact_nonce' ); ?>
                    <input type="text" name="cdo_website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;opacity:0;" aria-hidden="true" />
                    <?php if ( '' !== $cdo_recaptcha_site ) : ?>
                        <input type="hidden" name="cdo_recaptcha_token" id="cdo-recaptcha-token" value="" />
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                        <label class="block">
                            <span class="text-xs font-bold uppercase tracking-widest text-secondary mb-2 block"><?php esc_html_e( 'Nombre *', 'cdo-solutions' ); ?></span>
                            <input type="text" name="cdo_name" required
                                   class="w-full px-4 py-3 rounded-lg bg-surface-container-low border border-transparent focus:bg-surface-container-lowest focus:border-primary focus:outline-none transition-all text-on-surface" />
                        </label>
                        <label class="block">
                            <span class="text-xs font-bold uppercase tracking-widest text-secondary mb-2 block"><?php esc_html_e( 'Empresa', 'cdo-solutions' ); ?></span>
                            <input type="text" name="cdo_company"
                                   class="w-full px-4 py-3 rounded-lg bg-surface-container-low border border-transparent focus:bg-surface-container-lowest focus:border-primary focus:outline-none transition-all text-on-surface" />
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                        <label class="block">
                            <span class="text-xs font-bold uppercase tracking-widest text-secondary mb-2 block"><?php esc_html_e( 'Email *', 'cdo-solutions' ); ?></span>
                            <input type="email" name="cdo_email" required
                                   class="w-full px-4 py-3 rounded-lg bg-surface-container-low border border-transparent focus:bg-surface-container-lowest focus:border-primary focus:outline-none transition-all text-on-surface" />
                        </label>
                        <label class="block">
                            <span class="text-xs font-bold uppercase tracking-widest text-secondary mb-2 block"><?php esc_html_e( 'Teléfono', 'cdo-solutions' ); ?></span>
                            <input type="tel" name="cdo_phone"
                                   class="w-full px-4 py-3 rounded-lg bg-surface-container-low border border-transparent focus:bg-surface-container-lowest focus:border-primary focus:outline-none transition-all text-on-surface" />
                        </label>
                    </div>

                    <label class="block">
                        <span class="text-xs font-bold uppercase tracking-widest text-secondary mb-2 block"><?php esc_html_e( '¿Qué necesitas?', 'cdo-solutions' ); ?></span>
                        <select name="cdo_topic"
                                class="w-full px-4 py-3 rounded-lg bg-surface-container-low border border-transparent focus:bg-surface-container-lowest focus:border-primary focus:outline-none transition-all text-on-surface">
                            <option value=""><?php esc_html_e( '— Selecciona un área —', 'cdo-solutions' ); ?></option>
                            <option value="desarrollo-web"><?php esc_html_e( 'Desarrollo Web y Automatización', 'cdo-solutions' ); ?></option>
                            <option value="marketing"><?php esc_html_e( 'Marketing Digital y Comunicación', 'cdo-solutions' ); ?></option>
                            <option value="ecommerce"><?php esc_html_e( 'E-commerce y Gestión de Envíos', 'cdo-solutions' ); ?></option>
                            <option value="diseno"><?php esc_html_e( 'Diseño Gráfico y Creatividad', 'cdo-solutions' ); ?></option>
                            <option value="soporte"><?php esc_html_e( 'Soporte y Consultoría Técnica', 'cdo-solutions' ); ?></option>
                            <option value="software"><?php esc_html_e( 'Software', 'cdo-solutions' ); ?></option>
                            <option value="otro"><?php esc_html_e( 'Otro / no estoy seguro', 'cdo-solutions' ); ?></option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-xs font-bold uppercase tracking-widest text-secondary mb-2 block"><?php esc_html_e( 'Cuéntanos tu proyecto *', 'cdo-solutions' ); ?></span>
                        <textarea name="cdo_message" rows="6" required
                                  class="w-full px-4 py-3 rounded-lg bg-surface-container-low border border-transparent focus:bg-surface-container-lowest focus:border-primary focus:outline-none transition-all text-on-surface resize-y"></textarea>
                    </label>

                    <label class="flex items-start gap-3 text-sm text-secondary">
                        <input type="checkbox" name="cdo_privacy" required class="mt-1 rounded text-primary focus:ring-primary" />
                        <span>
                            <?php
                            printf(
                                /* translators: %s = link to privacy policy */
                                esc_html__( 'Acepto la %s y el tratamiento de mis datos para responder a esta solicitud.', 'cdo-solutions' ),
                                '<a href="' . esc_url( home_url( '/privacidad/' ) ) . '" class="underline hover:text-primary">' . esc_html__( 'política de privacidad', 'cdo-solutions' ) . '</a>'
                            );
                            ?>
                        </span>
                    </label>

                    <button type="submit"
                            class="bg-on-surface text-surface-container-lowest px-8 md:px-10 py-3.5 md:py-4 font-headline font-bold rounded-lg border-b-4 border-primary-container transition-all hover:translate-y-[-2px] inline-flex items-center gap-3">
                        <?php esc_html_e( 'Enviar mensaje', 'cdo-solutions' ); ?>
                        <span class="material-symbols-outlined" aria-hidden="true">arrow_right_alt</span>
                    </button>

                    <?php if ( '' !== $cdo_recaptcha_site ) : ?>
                        <p class="text-[11px] text-secondary leading-relaxed">
                            <?php
                            printf(
                                /* translators: 1: link to Google Privacy, 2: link to Google ToS */
                                esc_html__( 'Este sitio está protegido por reCAPTCHA y se aplican la %1$s y los %2$s de Google.', 'cdo-solutions' ),
                                '<a href="https://policies.google.com/privacy" target="_blank" rel="noopener" class="underline hover:text-primary">' . esc_html__( 'Política de Privacidad', 'cdo-solutions' ) . '</a>',
                                '<a href="https://policies.google.com/terms"   target="_blank" rel="noopener" class="underline hover:text-primary">' . esc_html__( 'Términos del Servicio', 'cdo-solutions' ) . '</a>'
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                </form>

                <?php if ( '' !== $cdo_recaptcha_site ) : ?>
                    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr( $cdo_recaptcha_site ); ?>"></script>
                    <script>
                    (function(){
                        var form = document.getElementById('cdo-contact-form');
                        var tokenInput = document.getElementById('cdo-recaptcha-token');
                        if ( !form || !tokenInput || typeof grecaptcha === 'undefined' ) { return; }

                        var submitting = false;
                        form.addEventListener('submit', function(e){
                            if ( submitting ) { return; }
                            e.preventDefault();
                            submitting = true;
                            grecaptcha.ready(function(){
                                grecaptcha.execute(<?php echo wp_json_encode( $cdo_recaptcha_site ); ?>, { action: 'cdo_contact' })
                                    .then(function(token){
                                        tokenInput.value = token;
                                        form.submit();
                                    })
                                    .catch(function(){
                                        // Si reCAPTCHA falla, dejamos enviar el form de todas formas;
                                        // el backend hace fail-open y aplica el resto de validaciones.
                                        form.submit();
                                    });
                            });
                        });
                    })();
                    </script>
                    <style>
                        /* El badge flotante de reCAPTCHA estorba con el banner de cookies y el botón flotante */
                        .grecaptcha-badge { visibility: hidden; }
                    </style>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<!-- FAQ -->
<section class="py-20 md:py-24 px-6 md:px-8 bg-surface-container-low">
    <div class="max-w-4xl mx-auto">
        <div data-cdo-reveal class="text-center mb-10 md:mb-12">
            <span class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-4 block"><?php esc_html_e( 'Antes de escribirnos', 'cdo-solutions' ); ?></span>
            <h2 class="cdo-section-headline text-3xl md:text-4xl lg:text-5xl font-display font-extrabold tracking-tighter text-on-surface">
                <?php esc_html_e( 'Preguntas habituales.', 'cdo-solutions' ); ?>
            </h2>
        </div>

        <?php
        $faqs = array(
            array(
                'q' => __( '¿Cuánto tarda un proyecto típico en arrancar?', 'cdo-solutions' ),
                'a' => __( 'Iniciamos los trabajos tan pronto recibimos la orden. Un proyecto estándar entra en producción en cuestión de días.', 'cdo-solutions' ),
            ),
            array(
                'q' => __( '¿Trabajáis con tiendas pequeñas o solo grandes?', 'cdo-solutions' ),
                'a' => __( 'Colaboramos sobre todo con empresas de cierto tamaño con tiendas online en marcha, pero estudiamos cada caso antes de proponer.', 'cdo-solutions' ),
            ),
            array(
                'q' => __( '¿Hacéis soporte presencial?', 'cdo-solutions' ),
                'a' => __( 'Sí. Vamos a oficinas para reparar PCs, montar y mantener infraestructura de red, además del soporte técnico online de las herramientas que automatizamos.', 'cdo-solutions' ),
            ),
            array(
                'q' => __( '¿Qué información necesitáis para una propuesta?', 'cdo-solutions' ),
                'a' => __( 'Un email contándonos qué quieres conseguir, qué herramientas usas hoy y cuáles son tus métricas actuales. Con eso preparamos un primer plan.', 'cdo-solutions' ),
            ),
        );
        foreach ( $faqs as $i => $faq ) :
        ?>
            <details data-cdo-reveal data-cdo-delay="<?php echo (int) ( $i * 80 ); ?>"
                     class="group border-b border-outline-variant py-5 md:py-6 cursor-pointer">
                <summary class="flex justify-between items-center gap-6 list-none">
                    <span class="text-base md:text-lg font-headline font-bold text-on-surface"><?php echo esc_html( $faq['q'] ); ?></span>
                    <span class="material-symbols-outlined text-primary text-2xl group-open:rotate-45 transition-transform shrink-0" aria-hidden="true">add</span>
                </summary>
                <p class="mt-4 text-secondary leading-relaxed text-sm md:text-base"><?php echo esc_html( $faq['a'] ); ?></p>
            </details>
        <?php endforeach; ?>
    </div>
</section>

<?php get_footer(); ?>
