<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset='utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <title>{{ $title ?? 'VRISTO - Multipurpose Tailwind Dashboard Template' }}</title>

    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <link rel="icon" type="image/svg" href="/assets/images/favicon.svg" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <script src="/assets/js/perfect-scrollbar.min.js"></script>
    <script defer src="/assets/js/popper.min.js"></script>
    <script defer src="/assets/js/tippy-bundle.umd.min.js"></script>
    <script defer src="/assets/js/sweetalert.min.js"></script>
    @vite(['resources/css/app.css'])


</head>

<body x-data="main" class="antialiased relative font-nunito text-sm font-normal overflow-x-hidden"
    :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ?  'dark' : '', $store.app.menu, $store.app.layout, $store.app
        .rtlClass
    ]">

    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 bg-[black]/60 z-50 lg:hidden" :class="{ 'hidden': !$store.app.sidebar }"
        @click="$store.app.toggleSidebar()"></div>

    <!-- screen loader -->
    <div
        class="screen_loader fixed inset-0 bg-[#fafafa] dark:bg-[#060818] z-[60] grid place-content-center animate__animated">
        <svg width="64" height="64" viewBox="0 0 135 135" xmlns="http://www.w3.org/2000/svg" fill="#4361ee">
            <path
                d="M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z">
                <animateTransform attributeName="transform" type="rotate" from="0 67 67" to="-360 67 67" dur="2.5s"
                    repeatCount="indefinite" />
            </path>
            <path
                d="M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z">
                <animateTransform attributeName="transform" type="rotate" from="0 67 67" to="360 67 67" dur="8s"
                    repeatCount="indefinite" />
            </path>
        </svg>
    </div>

    <div class="fixed bottom-6 ltr:right-6 rtl:left-6 z-50" x-data="scrollToTop">
        <template x-if="showTopButton">
            <button type="button"
                class="btn btn-outline-primary rounded-full p-2 animate-pulse bg-[#fafafa] dark:bg-[#060818] dark:hover:bg-primary"
                @click="goToTop">
                <svg width="24" height="24" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z"
                        fill="currentColor" />
                    <path
                        d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z"
                        fill="currentColor" />
                </svg>
            </button>
        </template>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("scrollToTop", () => ({
                showTopButton: false,
                init() {
                    window.onscroll = () => {
                        this.scrollFunction();
                    };
                },

                scrollFunction() {
                    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                        this.showTopButton = true;
                    } else {
                        this.showTopButton = false;
                    }
                },

                goToTop() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                },
            }));
        });
    </script>

    <x-common.theme-customiser />

    <div class="main-container text-black dark:text-white-dark min-h-screen" :class="[$store.app.navbar]">

        <x-common.sidebar />

        <div class="main-content flex flex-col min-h-screen">
            <x-common.header />

            <div class="p-6 animate__animated" :class="[$store.app.animation]">
                {{ $slot }}

            </div>
            <x-common.footer />
        </div>
    </div>
    <script src="/assets/js/alpine-collaspe.min.js"></script>
    <script src="/assets/js/alpine-persist.min.js"></script>
    <script defer src="/assets/js/alpine-ui.min.js"></script>
    <script defer src="/assets/js/alpine-focus.min.js"></script>
    <script defer src="/assets/js/alpine.min.js"></script>

    <script>
        localStorage.clear();
    </script>

    @if(!auth()->user()->hasRole('siswa')) 
        <script src="/assets/js/custom.js"></script>
    @else 
        <script>

            (function () {
                const $themeConfig = {
                    locale: 'en', // en, da, de, el, es, fr, hu, it, ja, pl, pt, ru, sv, tr, zh
                    theme: 'light', // light, dark, system
                    menu: 'horizontal', // vertical, collapsible-vertical, horizontal
                    layout: 'boxed-layout', // full, boxed-layout
                    rtlClass: 'ltr', // rtl, ltr
                    animation: '', // animate__fadeIn, animate__fadeInDown, animate__fadeInUp, animate__fadeInLeft, animate__fadeInRight, animate__slideInDown, animate__slideInLeft, animate__slideInRight, animate__zoomIn
                    navbar: 'navbar-floating', // navbar-sticky, navbar-floating, navbar-static
                    semidark: false,
                };
                window.addEventListener('load', function () {
                    // screen loader
                    const screen_loader = document.getElementsByClassName('screen_loader');
                    if (screen_loader?.length) {
                        screen_loader[0].classList.add('animate__fadeOut');
                        setTimeout(() => {
                            document.body.removeChild(screen_loader[0]);
                        }, 200);
                    }

                    // set rtl layout
                    Alpine.store('app').setRTLLayout();
                });

                // set current year in footer
                const yearEle = document.querySelector('#footer-year');
                if (yearEle) {
                    yearEle.innerHTML = new Date().getFullYear();
                }

                // perfect scrollbar
                const initPerfectScrollbar = () => {
                    const container = document.querySelectorAll('.perfect-scrollbar');
                    for (let i = 0; i < container.length; i++) {
                        new PerfectScrollbar(container[i], {
                            wheelPropagation: true,
                            // suppressScrollX: true,
                        });
                    }
                };
                initPerfectScrollbar();

                document.addEventListener('alpine:init', () => {
                    Alpine.data('collapse', () => ({
                        collapse: false,

                        collapseSidebar() {
                            this.collapse = !this.collapse;
                        },
                    }));

                    Alpine.data('dropdown', (initialOpenState = false) => ({
                        open: initialOpenState,

                        toggle() {
                            this.open = !this.open;
                        },
                    }));
                    Alpine.data('modal', (initialOpenState = false) => ({
                        open: initialOpenState,

                        toggle() {
                            this.open = !this.open;
                        },
                    }));

                    // Magic: $tooltip
                    Alpine.magic('tooltip', (el) => (message, placement) => {
                        let instance = tippy(el, {
                            content: message,
                            trigger: 'manual',
                            placement: placement || undefined,
                            allowHTML: true,
                        });

                        instance.show();
                    });

                    Alpine.directive('dynamictooltip', (el, { expression }, { evaluate }) => {
                        let string = evaluate(expression);
                        tippy(el, {
                            content: string.charAt(0).toUpperCase() + string.slice(1),
                        });
                    });

                    // Directive: x-tooltip
                    Alpine.directive('tooltip', (el, { expression }) => {
                        tippy(el, {
                            content: expression,
                            placement: el.getAttribute('data-placement') || undefined,
                            allowHTML: true,
                            delay: el.getAttribute('data-delay') || 0,
                            animation: el.getAttribute('data-animation') || 'fade',
                            theme: el.getAttribute('data-theme') || '',
                        });
                    });

                    // Magic: $popovers
                    Alpine.magic('popovers', (el) => (message, placement) => {
                        let instance = tippy(el, {
                            content: message,
                            placement: placement || undefined,
                            interactive: true,
                            allowHTML: true,
                            // hideOnClick: el.getAttribute("data-dismissable") ? true : "toggle",
                            delay: el.getAttribute('data-delay') || 0,
                            animation: el.getAttribute('data-animation') || 'fade',
                            theme: el.getAttribute('data-theme') || '',
                            trigger: el.getAttribute('data-trigger') || 'click',
                        });

                        instance.show();
                    });

                    // main - custom functions
                    Alpine.data('main', (value) => ({}));

                    Alpine.store('app', {
                        // theme
                        theme: Alpine.$persist($themeConfig.theme),
                        isDarkMode: Alpine.$persist(false),
                        toggleTheme(val) {
                            if (!val) {
                                val = this.theme || $themeConfig.theme; // light|dark|system
                            }

                            this.theme = val;

                            if (this.theme == 'light') {
                                this.isDarkMode = false;
                            } else if (this.theme == 'dark') {
                                this.isDarkMode = true;
                            } else if (this.theme == 'system') {
                                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                    this.isDarkMode = true;
                                } else {
                                    this.isDarkMode = false;
                                }
                            }
                        },

                        // navigation menu
                        menu: Alpine.$persist($themeConfig.menu),
                        toggleMenu(val) {
                            if (!val) {
                                val = this.menu || $themeConfig.menu; // vertical, collapsible-vertical, horizontal
                            }
                            this.sidebar = false; // reset sidebar state
                            this.menu = val;
                        },

                        // layout
                        layout: Alpine.$persist($themeConfig.layout),
                        toggleLayout(val) {
                            if (!val) {
                                val = this.layout || $themeConfig.layout; // full, boxed-layout
                            }

                            this.layout = val;
                        },

                        // rtl support
                        rtlClass: Alpine.$persist($themeConfig.rtlClass),
                        toggleRTL(val) {
                            if (!val) {
                                val = this.rtlClass || $themeConfig.rtlClass; // rtl, ltr
                            }

                            this.rtlClass = val;
                            this.setRTLLayout();
                        },

                        setRTLLayout() {
                            document.querySelector('html').setAttribute('dir', this.rtlClass || $themeConfig.rtlClass);
                        },

                        // animation
                        animation: Alpine.$persist($themeConfig.animation),
                        toggleAnimation(val) {
                            if (!val) {
                                val = this.animation || $themeConfig.animation; // animate__fadeIn, animate__fadeInDown, animate__fadeInLeft, animate__fadeInRight
                            }

                            val = val?.trim();

                            this.animation = val;
                        },

                        // navbar type
                        navbar: Alpine.$persist($themeConfig.navbar),
                        toggleNavbar(val) {
                            if (!val) {
                                val = this.navbar || $themeConfig.navbar; // navbar-sticky, navbar-floating, navbar-static
                            }

                            this.navbar = val;
                        },

                        // semidark
                        semidark: Alpine.$persist($themeConfig.semidark),
                        toggleSemidark(val) {
                            if (!val) {
                                val = this.semidark || $themeConfig.semidark;
                            }

                            this.semidark = val;
                        },

                        // multi language
                        locale: Alpine.$persist($themeConfig.locale),
                        toggleLocale(val) {
                            if (!val) {
                                val = this.locale || $themeConfig.locale;
                            }

                            this.locale = val;
                            if (this.locale?.toLowerCase() === 'ae') {
                                this.toggleRTL('rtl');
                            } else {
                                this.toggleRTL('ltr');
                            }
                        },

                        // sidebar
                        sidebar: false,
                        toggleSidebar() {
                            this.sidebar = !this.sidebar;
                        },
                    });
                });
            })();

        </script>
    @endif


</body>

</html>
