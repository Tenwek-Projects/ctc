import './bootstrap';
import Alpine from 'alpinejs';
import 'trix/dist/trix.esm.min.js';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', async () => {
    const isAdmin = document.body?.dataset?.ctcSite === 'admin';
    const hero = document.querySelector('[data-ctc-hero]');

    let motion = { lenis: null, getScrollY: () => window.scrollY };

    if (!isAdmin) {
        if (hero) {
            const [{ initHeroHls }, { initHeroMediaPreload }] = await Promise.all([
                import('./hero-hls.js'),
                import('./motion/hero.js'),
            ]);
            await initHeroHls();
            initHeroMediaPreload(hero);
        }

        const { initCtcMotion } = await import('./motion/index.js');
        motion = initCtcMotion() ?? motion;
    }

    const getScrollY = motion?.getScrollY ?? (() => window.scrollY);

    const setTopbarVisibility = () => {
        document.body.classList.toggle('ctc-topbar-hidden', getScrollY() > 24);
    };

    setTopbarVisibility();

    if (motion?.lenis) {
        motion.lenis.on('scroll', setTopbarVisibility);
    } else {
        window.addEventListener('scroll', setTopbarVisibility, { passive: true });
    }

    const navbar = document.querySelector('.ctc-navbar');
    const sentinel = document.getElementById('ctc-navbar-sentinel');
    const spacer = document.getElementById('ctc-navbar-spacer');
    if (navbar && sentinel && spacer && 'IntersectionObserver' in window) {
        const setSpacerHeight = (h) => {
            spacer.style.height = h ? `${h}px` : '0px';
        };

        const io = new IntersectionObserver((entries) => {
            const entry = entries[0];
            const shouldFix = !!entry && !entry.isIntersecting;
            document.body.classList.toggle('ctc-nav-fixed', shouldFix);
            setSpacerHeight(shouldFix ? navbar.getBoundingClientRect().height : 0);
        }, { threshold: 0 });

        io.observe(sentinel);

        window.addEventListener(
            'resize',
            () => {
                if (document.body.classList.contains('ctc-nav-fixed')) {
                    setSpacerHeight(navbar.getBoundingClientRect().height);
                }
            },
            { passive: true },
        );
    }

    const formatWithCommas = (n) => n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    const animateCount = (el, target, { durationMs = 1200, suffix = '', prefix = '', useCommas = true } = {}) => {
        const start = 0;
        const startTime = performance.now();

        const tick = (now) => {
            const t = Math.min(1, (now - startTime) / durationMs);
            const eased = 1 - Math.pow(1 - t, 3);
            const value = Math.round(start + (target - start) * eased);

            const text = (useCommas ? formatWithCommas(value) : String(value));
            el.textContent = `${prefix}${text}${suffix}`;

            if (t < 1) requestAnimationFrame(tick);
        };

        requestAnimationFrame(tick);
    };

    const initStatsCountUp = () => {
        const section = document.getElementById('home-stats');
        if (!section) return;

        const values = Array.from(section.querySelectorAll('.ctc-stat-value'));
        if (!values.length) return;

        values.forEach((el) => {
            const raw = (el.textContent || '').trim();
            const suffixMatch = raw.match(/[+%]$/);
            const suffix = suffixMatch ? suffixMatch[0] : '';
            const prefixMatch = raw.match(/^\D+/);
            const prefix = prefixMatch ? prefixMatch[0].trim() : '';

            const digits = raw.replace(/[^\d]/g, '');
            const target = digits ? parseInt(digits, 10) : 0;

            el.dataset.ctcTarget = String(target);
            el.dataset.ctcSuffix = suffix;
            el.dataset.ctcPrefix = prefix && prefix !== '+' ? prefix : '';
            el.textContent = `${el.dataset.ctcPrefix || ''}0${suffix}`;
        });

        let ran = false;
        const run = () => {
            if (ran) return;
            ran = true;

            values.forEach((el) => {
                const target = parseInt(el.dataset.ctcTarget || '0', 10);
                const suffix = el.dataset.ctcSuffix || '';
                const prefix = el.dataset.ctcPrefix || '';
                animateCount(el, target, { durationMs: 1200, suffix, prefix, useCommas: true });
            });
        };

        if (!('IntersectionObserver' in window)) {
            run();
            return;
        }

        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    run();
                    io.disconnect();
                }
            });
        }, { threshold: 0.35 });

        io.observe(section);
    };

    initStatsCountUp();

    const initBackToTop = () => {
        const btn = document.getElementById('ctc-back-top');
        if (!btn || document.body.dataset.ctcSite !== 'public' || document.body.classList.contains('ctc-news-playful')) return;

        const reducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false;

        window.ctcScrollToTop = () => {
            if (motion?.lenis) {
                motion.lenis.scrollTo(0, { immediate: reducedMotion });
            } else {
                window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' });
            }
            btn.blur();
        };

        const thresholdPx = 380;
        const updateVisibility = () => {
            btn.classList.toggle('ctc-back-top--visible', getScrollY() > thresholdPx);
        };

        updateVisibility();
        if (motion?.lenis) {
            motion.lenis.on('scroll', updateVisibility);
        } else {
            window.addEventListener('scroll', updateVisibility, { passive: true });
        }

        btn.addEventListener('click', () => window.ctcScrollToTop?.());
    };

    initBackToTop();

    const heroScrollBtn = document.querySelector('[data-ctc-hero-scroll-indicator]');
    if (heroScrollBtn && document.body.dataset.ctcSite === 'public' && !document.body.classList.contains('ctc-news-playful')) {
        const reducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false;
        heroScrollBtn.addEventListener('click', () => {
            const sel = heroScrollBtn.dataset.ctcHeroScrollTo || '#home-stats';
            const el = document.querySelector(sel);
            if (!el) return;

            if (motion?.lenis) {
                motion.lenis.scrollTo(el, {
                    offset: -80,
                    immediate: reducedMotion,
                });
            } else {
                el.scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'start' });
            }
        });
    }
});
