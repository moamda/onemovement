/* global $ */
'use strict';

(function () {

    /* --------------------------------------------------
       Sticky Navbar Shrink
       -------------------------------------------------- */
    var navbar = document.querySelector('.lp-navbar');
    function handleNavbarScroll() {
        if (!navbar) return;
        if (window.scrollY > 60) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    window.addEventListener('scroll', handleNavbarScroll, { passive: true });
    handleNavbarScroll();

    /* --------------------------------------------------
       Smooth Scroll (anchor links)
       -------------------------------------------------- */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('a[href^="#"]');
        if (!link) return;
        var hash = link.getAttribute('href');
        if (hash === '#') return;
        var target = document.querySelector(hash);
        if (!target) return;
        e.preventDefault();
        var offset = (navbar ? navbar.offsetHeight : 70) + 16;
        var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({ top: top, behavior: 'smooth' });
        /* Close Bootstrap 4 mobile nav via jQuery if available */
        if (typeof $ !== 'undefined') {
            $('#navbarMain').collapse('hide');
        }
    });

    /* --------------------------------------------------
       Animated Counters (IntersectionObserver)
       -------------------------------------------------- */
    function easeOutQuart(t) {
        return 1 - Math.pow(1 - t, 4);
    }

    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        if (isNaN(target)) return;
        var duration = 1800;
        var start = null;
        function step(ts) {
            if (!start) start = ts;
            var elapsed = ts - start;
            var progress = Math.min(elapsed / duration, 1);
            var value = Math.round(easeOutQuart(progress) * target);
            el.textContent = value;
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target;
        }
        requestAnimationFrame(step);
    }

    var counters = document.querySelectorAll('[data-count]');
    if (counters.length && 'IntersectionObserver' in window) {
        var counterObs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        counters.forEach(function (c) { counterObs.observe(c); });
    } else {
        counters.forEach(function (c) {
            c.textContent = c.getAttribute('data-count');
        });
    }

    /* --------------------------------------------------
       AOS-Lite Scroll Reveal
       -------------------------------------------------- */
    var aosEls = document.querySelectorAll('[data-aos]');
    if (aosEls.length && 'IntersectionObserver' in window) {
        var aosObs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var delay = parseInt(entry.target.getAttribute('data-aos-delay') || '0', 10);
                    setTimeout(function () {
                        entry.target.classList.add('aos-animate');
                    }, delay);
                    aosObs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        aosEls.forEach(function (el) { aosObs.observe(el); });
    } else {
        aosEls.forEach(function (el) { el.classList.add('aos-animate'); });
    }

    /* --------------------------------------------------
       Active Nav Link Highlight on Scroll
       -------------------------------------------------- */
    var sections = document.querySelectorAll('section[id]');
    var navLinks = document.querySelectorAll('.lp-navbar .nav-link[href^="#"]');

    function updateActiveNav() {
        var scrollY = window.scrollY;
        var navH = navbar ? navbar.offsetHeight : 70;
        var activeId = '';
        sections.forEach(function (sec) {
            if (sec.offsetTop - navH - 60 <= scrollY) {
                activeId = sec.id;
            }
        });
        navLinks.forEach(function (link) {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + activeId) {
                link.classList.add('active');
            }
        });
    }
    window.addEventListener('scroll', updateActiveNav, { passive: true });
    updateActiveNav();

    /* --------------------------------------------------
       Form Submit Loading State
       -------------------------------------------------- */
    var form = document.getElementById('lead-form');
    if (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('.lp-btn-submit');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span>Sending...</span>';
            }
        });
    }

})();
