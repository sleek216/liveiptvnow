/**
 * LIVE IPTV NOW — Optimized App JS
 * Orange Theme · Performance First
 */

document.addEventListener('DOMContentLoaded', () => {

    // ── Check user prefers reduced motion ──
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ── FAQ Accordion ──
    document.querySelectorAll('.fq-q, .fqi-q, .fq2-q').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.fq, .fqi, .fq2');
            if (!item) return;

            const wasOpen = item.classList.contains('on');
            const container = item.classList.contains('fq2')
                ? (item.closest('.faq-grid-2') || item.parentElement)
                : item.parentElement;

            if (container) {
                container.querySelectorAll('.fq, .fqi, .fq2').forEach(x => {
                    x.classList.remove('on');
                    const q = x.querySelector('.fq-q, .fqi-q, .fq2-q');
                    if (q) q.setAttribute('aria-expanded', 'false');
                });
            }

            if (!wasOpen) {
                item.classList.add('on');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // ── Scroll To Top Button ──
    const scrollBtn = document.createElement('button');
    scrollBtn.className = 'scroll-top';
    scrollBtn.innerHTML = '<i class="ri-arrow-up-line"></i>';
    scrollBtn.setAttribute('aria-label', 'Scroll to top');
    document.body.appendChild(scrollBtn);

    // Combine all scroll listeners into ONE for performance
    let scrollTicking = false;
    const hdr = document.getElementById('hdr');

    window.addEventListener('scroll', () => {
        if (!scrollTicking) {
            requestAnimationFrame(() => {
                const sy = window.scrollY;
                // Header shadow
                if (hdr) hdr.classList.toggle('scrolled', sy > 40);
                // Scroll-to-top button visibility
                scrollBtn.classList.toggle('visible', sy > 500);
                scrollTicking = false;
            });
            scrollTicking = true;
        }
    }, { passive: true });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' });
    });

    // ── Counter Animation (skip if reduced motion) ──
    if (!reducedMotion) {
        const counters = document.querySelectorAll('[data-count]');
        if (counters.length) {
            const cObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = parseInt(el.dataset.count, 10);
                        const suffix = el.dataset.suffix || '';
                        let current = 0;
                        const step = Math.max(1, Math.floor(target / 60));
                        const interval = setInterval(() => {
                            current = Math.min(current + step, target);
                            el.textContent = current.toLocaleString() + suffix;
                            if (current >= target) clearInterval(interval);
                        }, 16);
                        cObserver.unobserve(el);
                    }
                });
            }, { threshold: 0.3, rootMargin: '0px 0px -50px 0px' });
            counters.forEach(c => cObserver.observe(c));
        }
    }

    // ── Smooth Scroll for anchor links ──
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
            const id = a.getAttribute('href');
            if (id === '#') return;
            const target = document.querySelector(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'start' });
            }
        });
    });

    // ── Pricing Tabs ──
    const tabs = document.querySelectorAll('.pk-tab');
    const pkCards = document.querySelectorAll('.pk[data-duration]');
    if (tabs.length && pkCards.length) {
        tabs.forEach(t => t.addEventListener('click', () => {
            const d = t.dataset.tab;
            tabs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            pkCards.forEach(c => {
                if (c.dataset.duration === d) {
                    c.style.display = 'flex';
                    if (!reducedMotion) {
                        requestAnimationFrame(() => {
                            c.style.opacity = '0';
                            c.style.transform = 'translateY(16px)';
                            requestAnimationFrame(() => {
                                c.style.transition = 'all 0.4s cubic-bezier(0.22,1,0.36,1)';
                                c.style.opacity = '1';
                                c.style.transform = 'translateY(0)';
                            });
                        });
                    }
                } else {
                    c.style.display = 'none';
                }
            });
        }));
    }

    // ── Channel Filter Tabs ──
    const chTabs = document.querySelectorAll('.ch-tab');
    const chCards = document.querySelectorAll('.cc[data-category]');
    if (chTabs.length && chCards.length) {
        chTabs.forEach(t => t.addEventListener('click', () => {
            const cat = t.dataset.category;
            chTabs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            chCards.forEach(c => {
                c.style.display = (cat === 'all' || c.dataset.category === cat) ? '' : 'none';
            });
        }));
    }

    // ── Channel Search — debounced ──
    const chSearch = document.getElementById('channelSearch');
    if (chSearch && chCards.length) {
        let searchTimer;
        chSearch.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                const q = chSearch.value.toLowerCase().trim();
                chCards.forEach(c => {
                    c.style.display = (!q || c.textContent.toLowerCase().includes(q)) ? '' : 'none';
                });
            }, 150); // 150ms debounce
        });
    }

    // ── Magnetic hover — only on non-touch, non-reduced-motion ──
    if (!reducedMotion && window.matchMedia('(hover: hover)').matches) {
        const magnetSelectors = '.fc, .spot, .dv, .rv, .pk, .cc, .ctc, .pt';
        document.querySelectorAll(magnetSelectors).forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const dx = ((e.clientX - rect.left) / rect.width - 0.5) * 4;
                const dy = ((e.clientY - rect.top) / rect.height - 0.5) * -4;
                card.style.transform = `translateY(-6px) perspective(600px) rotateX(${dy}deg) rotateY(${dx}deg)`;
            }, { passive: true });
            card.addEventListener('mouseleave', () => { card.style.transform = ''; });
        });
    }

    // ── AOS Init — deferred waits for AOS to be loaded ──
    function initAOS() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: reducedMotion ? 0 : 500,
                once: true,
                offset: 60,
                easing: 'ease-out-cubic',
                disable: reducedMotion
            });
        } else {
            // AOS not ready yet, try again shortly
            setTimeout(initAOS, 100);
        }
    }
    initAOS();

    // ── Language switcher dropdown ──
    document.querySelectorAll('[data-lang-switcher]').forEach((switcher) => {
        const toggle = switcher.querySelector('[data-lang-toggle]');
        const menu = switcher.querySelector('[data-lang-menu]');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', (event) => {
            event.stopPropagation();
            const isOpen = switcher.classList.contains('is-open');

            document.querySelectorAll('[data-lang-switcher].is-open').forEach((openSwitcher) => {
                if (openSwitcher !== switcher) {
                    openSwitcher.classList.remove('is-open');
                    const openToggle = openSwitcher.querySelector('[data-lang-toggle]');
                    if (openToggle) openToggle.setAttribute('aria-expanded', 'false');
                }
            });

            switcher.classList.toggle('is-open', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('[data-lang-switcher].is-open').forEach((switcher) => {
            switcher.classList.remove('is-open');
            const toggle = switcher.querySelector('[data-lang-toggle]');
            if (toggle) toggle.setAttribute('aria-expanded', 'false');
        });
    });

});
