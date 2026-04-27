<?php
/**
 * Footer — fondo claro, 4 columnas + barra inferior con copyright + legal.
 *
 * @package CdoSolutions
 */
?>
</main><!-- #cdo-main -->

<footer class="w-full bg-[#F9FAFB] border-t border-surface-container-highest mt-10 md:mt-16">

    <!-- Banda superior con marca + claim corto -->
    <div class="px-6 md:px-8 pt-12 md:pt-16 pb-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-10 items-start">

            <!-- Marca + descripción -->
            <div class="md:col-span-5">
                <div class="mb-4"><?php cdo_logo( 'footer' ); ?></div>
                <p class="font-['Inter'] text-sm md:text-base text-slate-600 leading-relaxed mb-5 max-w-md">
                    <?php esc_html_e( 'Centro de Desarrollo Online. Software propio + servicios para empresas omnicanal con tienda online y tiendas físicas. España y mercado europeo.', 'cdo-solutions' ); ?>
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-surface-container-highest text-[11px] font-bold text-on-surface">
                        <span class="material-symbols-outlined text-primary text-sm" aria-hidden="true">public</span>
                        <?php esc_html_e( 'Mercado europeo', 'cdo-solutions' ); ?>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-surface-container-highest text-[11px] font-bold text-on-surface">
                        <span class="material-symbols-outlined text-tertiary text-sm" aria-hidden="true">place</span>
                        <?php esc_html_e( 'Sede: Gipuzkoa', 'cdo-solutions' ); ?>
                    </span>
                </div>
            </div>

            <!-- Soluciones -->
            <div class="md:col-span-3">
                <h5 class="font-headline font-bold text-xs uppercase tracking-widest mb-5 text-on-surface"><?php esc_html_e( 'Soluciones', 'cdo-solutions' ); ?></h5>
                <ul class="space-y-3 font-['Inter'] text-sm text-slate-600">
                    <li><a class="hover:text-on-surface transition-colors inline-flex items-center gap-1.5" href="<?php echo esc_url( home_url( '/soluciones/soporte/' ) ); ?>">
                        <span class="material-symbols-outlined text-base text-[#6366F1]" aria-hidden="true">shopping_bag</span>
                        <?php esc_html_e( 'Soporte e‑commerce', 'cdo-solutions' ); ?>
                    </a></li>
                    <li><a class="hover:text-on-surface transition-colors inline-flex items-center gap-1.5" href="<?php echo esc_url( home_url( '/soluciones/transporte/' ) ); ?>">
                        <span class="material-symbols-outlined text-base text-[#F59E0B]" aria-hidden="true">local_shipping</span>
                        <?php esc_html_e( 'Transporte · País Vasco', 'cdo-solutions' ); ?>
                    </a></li>
                    <li><a class="hover:text-on-surface transition-colors inline-flex items-center gap-1.5" href="<?php echo esc_url( home_url( '/soluciones/mantenimiento/' ) ); ?>">
                        <span class="material-symbols-outlined text-base text-[#10B981]" aria-hidden="true">build</span>
                        <?php esc_html_e( 'Mantenimiento · Gipuzkoa', 'cdo-solutions' ); ?>
                    </a></li>
                </ul>
            </div>

            <!-- Software -->
            <div class="md:col-span-2">
                <h5 class="font-headline font-bold text-xs uppercase tracking-widest mb-5 text-on-surface"><?php esc_html_e( 'Software', 'cdo-solutions' ); ?></h5>
                <ul class="space-y-3 font-['Inter'] text-sm text-slate-600">
                    <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/software/cdo-mail/' ) ); ?>">cdo.mail</a></li>
                    <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/software/cdo-chat/' ) ); ?>">cdo.chat</a></li>
                    <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/software/cdo-screen/' ) ); ?>">cdo.screen</a></li>
                    <li><a class="hover:text-primary transition-colors text-primary font-semibold" href="<?php echo esc_url( home_url( '/software/' ) ); ?>"><?php esc_html_e( 'Ver catálogo →', 'cdo-solutions' ); ?></a></li>
                </ul>
            </div>

            <!-- Empresa -->
            <div class="md:col-span-2">
                <h5 class="font-headline font-bold text-xs uppercase tracking-widest mb-5 text-on-surface"><?php esc_html_e( 'Empresa', 'cdo-solutions' ); ?></h5>
                <ul class="space-y-3 font-['Inter'] text-sm text-slate-600">
                    <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/sobre-nosotros/' ) ); ?>"><?php esc_html_e( 'Sobre nosotros', 'cdo-solutions' ); ?></a></li>
                    <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contacto', 'cdo-solutions' ); ?></a></li>
                    <li><a class="hover:text-on-surface transition-colors inline-flex items-center gap-1" href="https://crm.cdo.solutions/" target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e( 'Iniciar sesión', 'cdo-solutions' ); ?>
                        <span class="material-symbols-outlined text-base" aria-hidden="true">open_in_new</span>
                    </a></li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Banda CTA central -->
    <div class="px-6 md:px-8 py-8 md:py-10 max-w-7xl mx-auto border-t border-surface-container-highest">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-[0.3em] text-primary mb-1.5"><?php esc_html_e( '¿Hablamos?', 'cdo-solutions' ); ?></div>
                <p class="text-base md:text-lg font-headline font-bold text-on-surface leading-tight">
                    <?php esc_html_e( '30 minutos sin compromiso para entender tu caso.', 'cdo-solutions' ); ?>
                </p>
            </div>
            <a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"
               class="shrink-0 inline-flex items-center justify-center gap-2 bg-on-surface text-surface-container-lowest px-6 py-3 font-headline font-bold text-sm rounded-lg border-b-4 border-primary-container hover:translate-y-[-2px] transition-transform">
                <?php esc_html_e( 'Solicitar llamada', 'cdo-solutions' ); ?>
                <span class="material-symbols-outlined text-primary-container" aria-hidden="true">arrow_right_alt</span>
            </a>
        </div>
    </div>

    <!-- Banda inferior: copyright + legal -->
    <div class="bg-white border-t border-surface-container-highest">
        <div class="px-6 md:px-8 py-5 max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-3 md:gap-6 text-xs text-slate-600">
            <div class="font-['Inter']">
                © <?php echo esc_html( gmdate( 'Y' ) ); ?> cdo.solutions · <?php esc_html_e( 'Todos los derechos reservados.', 'cdo-solutions' ); ?>
            </div>
            <ul class="flex flex-wrap gap-x-5 gap-y-2 font-['Inter']">
                <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/aviso-legal/' ) ); ?>"><?php esc_html_e( 'Aviso legal', 'cdo-solutions' ); ?></a></li>
                <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/politica-privacidad/' ) ); ?>"><?php esc_html_e( 'Privacidad', 'cdo-solutions' ); ?></a></li>
                <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/politica-de-cookies/' ) ); ?>"><?php esc_html_e( 'Cookies', 'cdo-solutions' ); ?></a></li>
                <li><a class="hover:text-on-surface transition-colors" href="<?php echo esc_url( home_url( '/personalizar-cookies/' ) ); ?>"><?php esc_html_e( 'Personalizar cookies', 'cdo-solutions' ); ?></a></li>
            </ul>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
