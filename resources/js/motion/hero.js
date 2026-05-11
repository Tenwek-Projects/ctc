import gsap from 'gsap';
import SplitType from 'split-type';
import { CTC_EASE } from './config.js';

const HERO_PRELOADER_MAX_MS = 14000;

function preloadHeroImage(url) {
    const trimmed = (url || '').trim();
    if (!trimmed) return Promise.resolve();

    return new Promise((resolve) => {
        const img = new Image();
        const done = () => resolve();
        img.onload = done;
        img.onerror = done;
        img.src = trimmed;
    });
}

function waitForHeroMedia(hero) {
    const media = hero.querySelector('[data-ctc-hero-media]');
    if (!media) return Promise.resolve();

    const video = media.querySelector('video');
    if (video) {
        return new Promise((resolve) => {
            const finish = () => resolve();
            if (video.readyState >= 3) {
                finish();
                return;
            }
            video.addEventListener('canplay', finish, { once: true });
            video.addEventListener('error', finish, { once: true });
        });
    }

    const iframe = media.querySelector('iframe');
    if (iframe) {
        return Promise.race([
            new Promise((resolve) => {
                iframe.addEventListener('load', () => resolve(), { once: true });
            }),
            new Promise((resolve) => {
                window.setTimeout(resolve, 7000);
            }),
        ]);
    }

    const preloadEl = media.querySelector('[data-hero-preload]');
    const url = preloadEl?.dataset?.heroPreload;
    return preloadHeroImage(url);
}

function hideHeroPreloader(hero) {
    if (hero.dataset.ctcHeroPreloaderDone === '1') return;
    hero.dataset.ctcHeroPreloaderDone = '1';
    hero.removeAttribute('aria-busy');
    hero.dispatchEvent(new CustomEvent('ctc:heroPreloadDone', { bubbles: false }));

    const el = hero.querySelector('[data-ctc-hero-preloader]');
    if (!el) return;

    el.classList.add('opacity-0', 'pointer-events-none');
    window.setTimeout(() => {
        el.remove();
    }, 520);
}

function whenHeroPreloadDone(hero, fn) {
    const run = () => requestAnimationFrame(() => fn());
    if (hero.dataset.ctcHeroPreloaderDone === '1') {
        run();
        return;
    }
    const onDone = () => {
        hero.removeEventListener('ctc:heroPreloadDone', onDone);
        run();
    };
    hero.addEventListener('ctc:heroPreloadDone', onDone, { once: true });
    queueMicrotask(() => {
        if (hero.dataset.ctcHeroPreloaderDone === '1') {
            hero.removeEventListener('ctc:heroPreloadDone', onDone);
            run();
        }
    });
}

export function initHeroMediaPreload(hero) {
    const safety = window.setTimeout(() => hideHeroPreloader(hero), HERO_PRELOADER_MAX_MS);

    waitForHeroMedia(hero)
        .catch(() => {})
        .finally(() => {
            window.clearTimeout(safety);
            hideHeroPreloader(hero);
        });
}

function readCarouselPayload() {
    const el = document.getElementById('ctc-hero-carousel-data');
    if (!el?.textContent) return null;
    try {
        return JSON.parse(el.textContent);
    } catch {
        return null;
    }
}

function initHeroCarousel(slides, bgNodes, ui, reduced) {
    if (!slides?.length || !bgNodes.length) {
        return false;
    }

    const { title, subtitle, description, ctas } = ui;
    const initialTitleHtml = title?.innerHTML ?? '';
    const initialSubtitle = subtitle?.textContent?.trim() ?? '';
    const initialDescription = description?.textContent?.trim() ?? '';

    const dots = document.querySelectorAll('[data-ctc-hero-dot]');

    let index = 0;
    let timer = null;
    const intervalMs = 6200;

    const killKen = () => {
        bgNodes.forEach((node) => gsap.killTweensOf(node));
    };

    const runKen = (node) => {
        if (!node || reduced) return;
        gsap.fromTo(
            node,
            { scale: 1.02 },
            { scale: 1.09, duration: 16, ease: 'none' },
        );
    };

    const syncDots = () => {
        dots.forEach((d, i) => {
            d.classList.toggle('ctc-hero-dot--active', i === index);
            d.setAttribute('aria-current', i === index ? 'true' : 'false');
        });
    };

    const goTo = (nextIndex) => {
        index = nextIndex;
        const s = slides[index] || {};

        bgNodes.forEach((node, idx) => {
            const active = idx === index;
            gsap.to(node, {
                opacity: active ? 1 : 0,
                duration: 1.15,
                ease: 'power2.inOut',
            });
        });

        killKen();
        runKen(bgNodes[index]);

        if (title) {
            if (s.title) title.textContent = s.title;
            else title.innerHTML = initialTitleHtml;
        }
        if (subtitle) subtitle.textContent = s.subtitle || initialSubtitle;
        if (description) description.textContent = initialDescription;

        if (ctas.length && s.cta_url && s.cta_label) {
            ctas[0].href = s.cta_url;
            ctas[0].textContent = s.cta_label;
        }

        syncDots();
    };

    const tick = () => {
        goTo((index + 1) % slides.length);
    };

    const start = () => {
        if (reduced) return;
        if (timer) return;
        timer = window.setInterval(tick, intervalMs);
    };

    const stop = () => {
        if (!timer) return;
        window.clearInterval(timer);
        timer = null;
    };

    goTo(0);
    start();

    document.addEventListener(
        'visibilitychange',
        () => {
            if (document.hidden) stop();
            else start();
        },
        { passive: true },
    );

    const hero = document.querySelector('[data-ctc-hero]');
    if (hero && !reduced) {
        let sx = 0;
        hero.addEventListener(
            'touchstart',
            (e) => {
                sx = e.changedTouches[0].clientX;
            },
            { passive: true },
        );
        hero.addEventListener(
            'touchend',
            (e) => {
                const dx = e.changedTouches[0].clientX - sx;
                if (Math.abs(dx) < 50) return;
                stop();
                goTo(dx < 0 ? (index + 1) % slides.length : (index - 1 + slides.length) % slides.length);
                start();
            },
            { passive: true },
        );
    }

    dots.forEach((d, i) => {
        d.addEventListener('click', () => {
            stop();
            goTo(i);
            start();
        });
    });

    return true;
}

const WOW_BACK = 'back.out(1.28)';
const WOW_SNAP = 'back.out(1.08)';

/**
 * @param {object} ctx
 */
function runHeroWowIntro(ctx) {
    const {
        hero,
        reduced,
        hasCarousel,
        media,
        overlay,
        title,
        subtitleWrap,
        descCard,
        ctasWrap,
        dotsWrap,
        indicator,
    } = ctx;

    const ctaEls = ctasWrap ? Array.from(ctasWrap.querySelectorAll('a[data-cta]')) : [];
    const dotBtns = dotsWrap ? Array.from(dotsWrap.querySelectorAll('[data-ctc-hero-dot]')) : [];

    const nodesToShow = [
        media,
        overlay,
        title,
        subtitleWrap,
        descCard,
        ctasWrap,
        dotsWrap,
        indicator,
    ].filter(Boolean);

    if (reduced) {
        gsap.set(nodesToShow, { opacity: 1, scale: 1, y: 0, filter: 'none', clearProps: 'transform' });
        gsap.set(ctaEls, { opacity: 1, y: 0, scale: 1 });
        gsap.set(dotBtns, { opacity: 1, scale: 1 });
        if (indicator) {
            const chev = indicator.querySelector('.ctc-hero-scroll-indicator__chev');
            if (chev) {
                gsap.set(chev, { y: 0 });
            }
        }
        return;
    }

    if (media && !hasCarousel) {
        gsap.set(media, { scale: 1.1, filter: 'blur(10px)', transformOrigin: '50% 50%' });
    }

    if (title && hasCarousel) {
        gsap.set(title, { opacity: 0, y: 56, scale: 0.94, transformOrigin: '50% 50%' });
    }

    if (subtitleWrap) {
        gsap.set(subtitleWrap, { opacity: 0, y: 28, scale: 0.88, transformOrigin: '50% 50%' });
    }

    if (descCard) {
        gsap.set(descCard, {
            opacity: 0,
            y: 36,
            clipPath: 'inset(0 100% 0 0)',
            filter: 'blur(8px)',
        });
    }

    if (ctaEls.length) {
        gsap.set(ctaEls, { opacity: 0, y: 40, scale: 0.92, transformOrigin: '50% 100%' });
    }

    if (dotBtns.length) {
        gsap.set(dotBtns, { opacity: 0, scale: 0.35 });
    }

    if (indicator) {
        gsap.set(indicator, { opacity: 0, y: 14 });
    }

    let titleLines = null;
    let useTitleFallback = false;
    if (!hasCarousel && title?.textContent?.trim()) {
        const split = new SplitType(title, { types: 'lines' });
        titleLines = split.lines;
        if (titleLines?.length) {
            gsap.set(titleLines, {
                opacity: 0,
                yPercent: 118,
                rotateX: -42,
                transformOrigin: '50% 100%',
            });
        } else {
            useTitleFallback = true;
            gsap.set(title, { opacity: 0, y: 52, scale: 0.94, transformOrigin: '50% 50%' });
        }
    }

    const tl = gsap.timeline({
        defaults: { ease: CTC_EASE.out },
    });

    if (media && !hasCarousel) {
        tl.to(
            media,
            {
                scale: 1,
                filter: 'blur(0px)',
                duration: 1.35,
                ease: 'power3.out',
            },
            0,
        );
    }

    if (titleLines?.length) {
        tl.to(
            titleLines,
            {
                opacity: 1,
                yPercent: 0,
                rotateX: 0,
                duration: 1.05,
                stagger: 0.11,
                ease: WOW_BACK,
            },
            0.12,
        );
    } else if (useTitleFallback && title) {
        tl.to(
            title,
            {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 1.08,
                ease: WOW_BACK,
            },
            0.12,
        );
    } else if (hasCarousel && title) {
        tl.to(
            title,
            {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 1.12,
                ease: WOW_BACK,
            },
            0.14,
        );
    }

    if (subtitleWrap) {
        tl.to(
            subtitleWrap,
            {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.92,
                ease: WOW_SNAP,
            },
            0.32,
        );
    }

    if (descCard) {
        tl.to(
            descCard,
            {
                opacity: 1,
                y: 0,
                clipPath: 'inset(0 0% 0 0)',
                filter: 'blur(0px)',
                duration: 1,
                ease: 'power3.out',
            },
            0.42,
        );
    }

    if (ctaEls.length) {
        tl.to(
            ctaEls,
            {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.82,
                stagger: 0.12,
                ease: WOW_SNAP,
            },
            0.52,
        );
    }

    if (dotBtns.length) {
        tl.to(
            dotBtns,
            {
                opacity: 1,
                scale: 1,
                duration: 0.55,
                stagger: 0.06,
                ease: 'back.out(2)',
            },
            0.58,
        );
    }

    if (indicator) {
        tl.to(indicator, { opacity: 1, y: 0, duration: 0.65, ease: 'power3.out' }, 0.72);
        tl.add(() => {
            const chev = indicator.querySelector('.ctc-hero-scroll-indicator__chev');
            if (chev) {
                gsap.to(chev, {
                    y: 5,
                    repeat: -1,
                    yoyo: true,
                    duration: 1.45,
                    ease: 'power1.inOut',
                });
            }
        });
    }

    hero.classList.add('ctc-hero-intro-done');
}

export function initHeroMotion(reduced, scrollTriggerOk) {
    const hero = document.querySelector('[data-ctc-hero]');
    if (!hero) return;

    const media = hero.querySelector('[data-ctc-hero-media]');
    const overlay = hero.querySelector('[data-ctc-hero-overlay]');
    const title = document.getElementById('ctc-hero-title');
    const subtitle = document.getElementById('ctc-hero-subtitle');
    const subtitleWrap = hero.querySelector('[data-ctc-hero-subtitle-wrap]');
    const description = document.getElementById('ctc-hero-description');
    const descCard = hero.querySelector('[data-ctc-hero-desc-card]');
    const ctasWrap = document.getElementById('ctc-hero-ctas');
    const ctasForCarousel = ctasWrap ? Array.from(ctasWrap.querySelectorAll('[data-cta="1"]')) : [];
    const dotsWrap = hero.querySelector('[data-ctc-hero-dots]');
    const indicator = document.querySelector('[data-ctc-hero-scroll-indicator]');

    const carouselSlides = readCarouselPayload();
    const bgSlides = Array.from(hero.querySelectorAll('.ctc-hero-slide'));
    const hasCarousel = initHeroCarousel(
        carouselSlides,
        bgSlides,
        { title, subtitle, description, ctas: ctasForCarousel },
        reduced,
    );

    if (!hasCarousel && media && !reduced && scrollTriggerOk) {
        gsap.fromTo(
            media,
            { scale: 1 },
            {
                scale: 1.07,
                ease: 'none',
                scrollTrigger: {
                    trigger: hero,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 0.75,
                },
            },
        );
    }

    whenHeroPreloadDone(hero, () => {
        runHeroWowIntro({
            hero,
            reduced,
            hasCarousel,
            media,
            overlay,
            title,
            subtitleWrap,
            descCard,
            ctasWrap,
            dotsWrap,
            indicator,
        });
    });
}
