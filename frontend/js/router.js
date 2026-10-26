

(function() {
    'use strict';

    const Router = {
        routes: {
            '/': 'views/home.html',
            '/plans': 'views/home.html',
            '/login': 'views/login.html',
            '/register': 'views/register.html',
            '/dashboard': 'views/dashboard.html',
            '/classes': 'views/classes.html',
            '/trainers': 'views/trainers.html',
            '/profile': 'views/profile.html',
            '/bookings': 'views/bookings.html'
        },

        init: function() {
            
            window.addEventListener('hashchange', () => this.handleRoute());
            
            window.addEventListener('load', () => this.handleRoute());

            this.attachNavListeners();
            this.attachDemoLogin();
            this.attachMobileMenuListeners();
        },

        handleRoute: function() {
            const hash = window.location.hash.slice(1) || '/';
            const route = this.routes[hash];

            if (route) {
                this.loadView(route, hash);
            } else {
                this.loadView('views/home.html', '/');
            }

            
            this.updateActiveNav(hash);
        },

        loadView: function(viewPath, route) {
            const contentDiv = document.getElementById('app-content');
            
            contentDiv.innerHTML = '<div class="loader" style="margin: 100px auto;"></div>';

            fetch(viewPath)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('View not found');
                    }
                    return response.text();
                })
                .then(html => {
                    contentDiv.innerHTML = html;
                    
                    
                    window.scrollTo(0, 0);
                    
                    
                    this.reinitPlugins();
                    if (route === '/plans') {
                        requestAnimationFrame(() => {
                            const plans = document.getElementById('our-plans');
                            if (plans) plans.scrollIntoView({ behavior: 'auto', block: 'start' });
                        });
                    }
                    
                    
                    this.closeMobileMenu();
                })
                .catch(error => {
                    console.error('Error loading view:', error);
                    contentDiv.innerHTML = `
                        <div style="text-align: center; padding: 100px 20px; background: #151515;">
                            <h2 style="color: #f36100;">Page Not Found</h2>
                            <p style="color: #c4c4c4;">The page you're looking for doesn't exist.</p>
                            <a href="#/" class="primary-btn" style="margin-top: 20px;">Go Home</a>
                        </div>
                    `;
                });
        },

        attachDemoLogin: function() {
            // The views are injected dynamically, so bind to the persistent document.
            document.addEventListener('submit', (event) => {
                if (event.target && event.target.id === 'loginForm') {
                    event.preventDefault();
                    // Never put passwords in the URL or browser console.
                    alert('Demo login — authentication will be available in a later milestone.');
                }
                if (event.target && event.target.id === 'registerForm') {
                    event.preventDefault();
                    const form = event.target;
                    const password = form.querySelector('#password').value;
                    const confirmation = form.querySelector('#confirmPassword').value;
                    if (password !== confirmation) {
                        alert('Passwords do not match!');
                        return;
                    }
                    alert('Demo registration — account creation will be available in a later milestone.');
                }
            });
        },

        attachMobileMenuListeners: function() {
            // Delegated listeners work even when the menu is rendered or updated later.
            document.addEventListener('click', (event) => {
                const opener = event.target.closest('.canvas-open');
                const closer = event.target.closest('.canvas-close');
                const overlay = event.target.closest('.offcanvas-menu-overlay');
                const mobileLink = event.target.closest('.offcanvas-menu-wrapper a');
                const menu = document.querySelector('.offcanvas-menu-wrapper');
                const backdrop = document.querySelector('.offcanvas-menu-overlay');
                if (opener) {
                    event.preventDefault();
                    if (menu && backdrop) {
                        menu.classList.add('show-offcanvas-menu-wrapper');
                        backdrop.classList.add('active');
                        opener.setAttribute('aria-expanded', 'true');
                    }
                } else if (closer || overlay || mobileLink) {
                    this.closeMobileMenu();
                }
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') this.closeMobileMenu();
            });
        },

        attachNavListeners: function() {
            
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('nav-link')) {
                    e.preventDefault();
                    const href = e.target.getAttribute('href');
                    if (href && href.startsWith('#/')) {
                        window.location.hash = href.slice(1);
                    }
                }
            });
        },

        updateActiveNav: function(currentRoute) {
            
            const navLinks = document.querySelectorAll('.nav-menu ul li');
            navLinks.forEach(li => li.classList.remove('active'));

            
            const activeLink = document.querySelector(`.nav-menu a[href="#${currentRoute}"]`);
            if (activeLink) {
                activeLink.parentElement.classList.add('active');
            }
        },

        closeMobileMenu: function() {
            const menuWrapper = document.querySelector('.offcanvas-menu-wrapper');
            const overlay = document.querySelector('.offcanvas-menu-overlay');
            
            if (menuWrapper) {
                menuWrapper.classList.remove('show-offcanvas-menu-wrapper');
            }
            if (overlay) {
                overlay.classList.remove('active');
            }
            const opener = document.querySelector('.canvas-open');
            if (opener) opener.setAttribute('aria-expanded', 'false');
        },

        reinitPlugins: function() {
            
            if (typeof $ !== 'undefined') {
                $('.set-bg').each(function() {
                    var bg = $(this).data('setbg');
                    $(this).css('background-image', 'url(' + bg + ')');
                });

                
                if ($.fn.owlCarousel) {
                    $('.owl-carousel').each(function() {
                        $(this).owlCarousel('destroy');
                    });

                    
                    var hero_s = $(".hs-slider");
                    if (hero_s.length) {
                        hero_s.owlCarousel({
                            loop: true,
                            margin: 0,
                            nav: true,
                            items: 1,
                            dots: false,
                            animateOut: 'fadeOut',
                            animateIn: 'fadeIn',
                            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                            smartSpeed: 1200,
                            autoHeight: false,
                            autoplay: true
                        });
                    }

                    
                    var ts_slider = $(".ts-slider");
                    if (ts_slider.length) {
                        ts_slider.owlCarousel({
                            loop: true,
                            margin: 0,
                            items: 3,
                            dots: true,
                            dotsEach: 2,
                            smartSpeed: 1200,
                            autoHeight: false,
                            autoplay: true,
                            responsive: {
                                320: { items: 1 },
                                768: { items: 2 },
                                992: { items: 3 }
                            }
                        });
                    }
                }
            }
        }
    };

    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => Router.init());
    } else {
        Router.init();
    }

})();