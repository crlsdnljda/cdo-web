/**
 * CDO Solutions — UI behaviour.
 * - Reveal on scroll (IntersectionObserver)
 * - Animated counters
 * - Animated chart bars
 * - Mobile menu toggle
 * - Smooth anchor scroll
 *
 * Vanilla JS, no dependencies. Respects prefers-reduced-motion.
 */
(function () {
    'use strict';

    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ----------------------------------------------------------------
       1. Reveal on scroll — adds .is-revealed when element enters view
    ---------------------------------------------------------------- */
    function initReveal() {
        var els = document.querySelectorAll('[data-cdo-reveal]');
        if (!els.length) return;

        if (prefersReduced || !('IntersectionObserver' in window)) {
            els.forEach(function (el) { el.classList.add('is-revealed'); });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

        els.forEach(function (el) { observer.observe(el); });
    }

    /* ----------------------------------------------------------------
       2. Animated counters
       Attributes:
         data-cdo-count="50"        target value (required)
         data-cdo-prefix="+"        prepended string
         data-cdo-suffix="%"        appended string
         data-cdo-decimals="1"      number of decimals
         data-cdo-format="thousands" insert "." every 3 digits (es-ES)
    ---------------------------------------------------------------- */
    function formatNumber(str, format) {
        if (format === 'thousands') {
            // Insert "." every 3 digits in the integer part (Spanish style).
            var parts = String(str).split('.');
            parts[0]  = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return parts.join(',');
        }
        return str;
    }

    function animateCount(el) {
        var target = parseFloat(el.getAttribute('data-cdo-count'));
        if (isNaN(target)) return;
        var prefix   = el.getAttribute('data-cdo-prefix') || '';
        var suffix   = el.getAttribute('data-cdo-suffix') || '';
        var decimals = parseInt(el.getAttribute('data-cdo-decimals') || '0', 10);
        var format   = el.getAttribute('data-cdo-format') || '';
        var duration = 1600;

        function render(value) {
            el.textContent = prefix + formatNumber(value.toFixed(decimals), format) + suffix;
        }

        if (prefersReduced) { render(target); return; }

        var start = performance.now();
        function frame(now) {
            var p = Math.min(1, (now - start) / duration);
            var eased = 1 - Math.pow(1 - p, 3); // easeOutCubic
            render(target * eased);
            if (p < 1) requestAnimationFrame(frame);
        }
        requestAnimationFrame(frame);
    }

    function initCounters() {
        var counters = document.querySelectorAll('[data-cdo-count]');
        if (!counters.length) return;

        if (!('IntersectionObserver' in window)) {
            counters.forEach(animateCount);
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(function (el) { observer.observe(el); });
    }

    /* ----------------------------------------------------------------
       3. Animated chart bars
       Attributes:
         data-cdo-bar="85"            target percentage (0-100)
         data-cdo-bar-axis="x"|"y"    grow horizontally (width) or vertically (height). Default: y
         data-cdo-delay="200"         ms before starting the animation
    ---------------------------------------------------------------- */
    function barAxis(bar)  { return bar.getAttribute('data-cdo-bar-axis') === 'x' ? 'width' : 'height'; }
    function setBar(bar, val) { bar.style[ barAxis(bar) ] = val; }

    function initChartBars() {
        var bars = document.querySelectorAll('[data-cdo-bar]');
        if (!bars.length) return;

        bars.forEach(function (bar) { setBar(bar, '0%'); });

        if (prefersReduced || !('IntersectionObserver' in window)) {
            bars.forEach(function (bar) { setBar(bar, bar.getAttribute('data-cdo-bar') + '%'); });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var bar   = entry.target;
                    var delay = parseInt(bar.getAttribute('data-cdo-delay') || '0', 10);
                    setTimeout(function () { setBar(bar, bar.getAttribute('data-cdo-bar') + '%'); }, delay);
                    observer.unobserve(bar);
                }
            });
        }, { threshold: 0.3 });

        bars.forEach(function (bar) { observer.observe(bar); });
    }

    /* ----------------------------------------------------------------
       3.5 Tab switcher — for the hero dashboard mockup.
       Buttons:  [data-cdo-tab="<id>"]
       Panes:    [data-cdo-tab-content="<id>"]
       On switch, re-animate any bars/counters inside the activated pane.
    ---------------------------------------------------------------- */
    function reanimatePane(pane) {
        // Reset bars to 0 then trigger their target value with the original delay.
        pane.querySelectorAll('[data-cdo-bar]').forEach(function (bar) {
            setBar(bar, '0%');
            var delay  = parseInt(bar.getAttribute('data-cdo-delay') || '0', 10);
            var target = bar.getAttribute('data-cdo-bar') + '%';
            setTimeout(function () { setBar(bar, target); }, delay + 30);
        });
        // Re-run counters from 0.
        pane.querySelectorAll('[data-cdo-count]').forEach(function (el) {
            el.textContent = '0';
            animateCount(el);
        });
    }

    function initTabs() {
        var buttons = document.querySelectorAll('[data-cdo-tab]');
        if (!buttons.length) return;

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var id    = btn.getAttribute('data-cdo-tab');
                var group = btn.closest('.cdo-float, .relative') || document; // scope siblings

                // Toggle button styles
                group.querySelectorAll('[data-cdo-tab]').forEach(function (b) {
                    var active = b === btn;
                    b.classList.toggle('cdo-tab--active', active);
                    b.classList.toggle('text-white', active);
                    b.classList.toggle('border-primary-container', active);
                    b.classList.toggle('text-white/40', !active);
                    b.classList.toggle('border-transparent', !active);
                });

                // Show/hide panes
                group.querySelectorAll('[data-cdo-tab-content]').forEach(function (pane) {
                    var match = pane.getAttribute('data-cdo-tab-content') === id;
                    pane.classList.toggle('hidden', !match);
                    if (match) reanimatePane(pane);
                });
            });
        });
    }

    /* ----------------------------------------------------------------
       3.6 Calculadora de precio por tramos.
       Estructura HTML esperada:
         [data-cdo-price-calc][data-cdo-tiers='[{"max":N,"price":M},...]'][data-cdo-period="/mes"]
            [data-cdo-price-out]    ← lugar donde imprimir "150 €"
            [data-cdo-quantity-out] ← lugar donde imprimir "10.000"
            input[data-cdo-price-slider]
       Al mover el slider, calculamos el tramo aplicable y actualizamos.
    ---------------------------------------------------------------- */
    function priceForQuantity(qty, tiers) {
        for (var i = 0; i < tiers.length; i++) {
            if (qty <= tiers[i].max) return tiers[i].price;
        }
        return tiers[tiers.length - 1].price;
    }

    function formatThousands(n) {
        return String(n).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function initPricingCalculators() {
        var calcs = document.querySelectorAll('[data-cdo-price-calc]');
        calcs.forEach(function (calc) {
            var slider = calc.querySelector('[data-cdo-price-slider]');
            var priceOut = calc.querySelector('[data-cdo-price-out]');
            var qtyOut   = calc.querySelector('[data-cdo-quantity-out]');
            if (!slider || !priceOut) return;

            var tiers;
            try { tiers = JSON.parse(calc.getAttribute('data-cdo-tiers') || '[]'); } catch (e) { tiers = []; }
            if (!tiers.length) return;

            function update() {
                var qty   = parseInt(slider.value, 10);
                var price = priceForQuantity(qty, tiers);
                priceOut.innerHTML = formatThousands(price) + ' €';
                if (qtyOut) qtyOut.textContent = formatThousands(qty);
            }

            slider.addEventListener('input', update);
            update();
        });
    }

    /* ----------------------------------------------------------------
       4. Mobile menu toggle
    ---------------------------------------------------------------- */
    function initMobileMenu() {
        var btn  = document.querySelector('[data-cdo-menu-toggle]');
        var menu = document.querySelector('[data-cdo-mobile-menu]');
        if (!btn || !menu) return;

        function setOpen(open) {
            btn.setAttribute('aria-expanded', String(open));
            menu.classList.toggle('is-open', open);
            document.body.classList.toggle('overflow-hidden', open);
            var icon = btn.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = open ? 'close' : 'menu';
        }

        btn.addEventListener('click', function () {
            setOpen(btn.getAttribute('aria-expanded') !== 'true');
        });

        // Close on link click + on Escape
        menu.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () { setOpen(false); });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setOpen(false);
        });
    }

    /* ----------------------------------------------------------------
       5. Smooth anchor scroll (skip when JS scrolling not desired)
    ---------------------------------------------------------------- */
    function initSmoothAnchors() {
        if (prefersReduced) return;
        document.documentElement.style.scrollBehavior = 'smooth';
    }

    /* ----------------------------------------------------------------
       5.5 Cookie consent: recargar la página al aceptar/rechazar.
       El plugin Adapta RGPD guarda la cookie de consentimiento en el click
       de #cookies-eu-accept / #cookies-eu-reject. Recargamos tras 250 ms
       para que los píxeles condicionados al consentimiento (Google Analytics,
       Meta Pixel, Hotjar, etc.) puedan inicializarse con el estado nuevo.
    ---------------------------------------------------------------- */
    function initCookieConsentReload() {
        document.addEventListener('click', function (e) {
            var btn = e.target.closest(
                '#cookies-eu-accept, .cookies-eu-accept, ' +
                '#cookies-eu-reject, .cookies-eu-reject'
            );
            if (!btn) return;
            // Pequeño delay para que el plugin escriba la cookie antes del reload
            setTimeout(function () { window.location.reload(); }, 250);
        }, true); // capture phase: nos aseguramos de correr aunque el plugin haga preventDefault
    }

    /* ----------------------------------------------------------------
       6. Header shadow on scroll
    ---------------------------------------------------------------- */
    function initHeaderShadow() {
        var nav = document.querySelector('.cdo-topnav');
        if (!nav) return;
        function update() {
            if (window.scrollY > 8) nav.classList.add('is-scrolled');
            else nav.classList.remove('is-scrolled');
        }
        update();
        window.addEventListener('scroll', update, { passive: true });
    }

    /* ----------------------------------------------------------------
       Boot
    ---------------------------------------------------------------- */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    function boot() {
        initReveal();
        initCounters();
        initChartBars();
        initTabs();
        initPricingCalculators();
        initMobileMenu();
        initSmoothAnchors();
        initHeaderShadow();
        initCookieConsentReload();
    }
})();
