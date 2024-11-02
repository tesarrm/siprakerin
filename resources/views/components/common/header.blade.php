@php
    $gambar = auth()->user()->gambar;
    $imageUrl = $gambar ? '/storage/posts/'.$gambar : '/assets/images/blank_profile.png'; 

    // dd(Auth::user()->penempatan);
    // dd(Auth::user()->biodata);
@endphp

<header class="z-40" :class="{ 'dark': $store.app.semidark && $store.app.menu === 'horizontal' }">
    <div class="shadow-sm">
        <div class="relative bg-white flex w-full items-center px-5 py-2.5 dark:bg-[#0e1726]">
            <div class="horizontal-logo flex lg:hidden justify-between items-center ltr:mr-2 rtl:ml-2">
                <a href="/" class="main-logo flex items-center shrink-0">
                    <img class="w-8 ltr:-ml-1 rtl:-mr-1 inline" src="/assets/images/logo.png"
                        alt="image" />
                    <span
                        class="text-2xl ltr:ml-1.5 rtl:mr-1.5  font-semibold  align-middle hidden md:inline dark:text-white-light transition-all duration-300">SIPRAKERIN</span>
                </a>

                <a href="javascript:;"
                    class="collapse-icon flex-none dark:text-[#d0d2d6] hover:text-primary dark:hover:text-primary flex lg:hidden ltr:ml-2 rtl:mr-2 p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:bg-white-light/90 dark:hover:bg-dark/60"
                    @click="$store.app.toggleSidebar()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" />
                        <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </a>
            </div>
            <div class="ltr:mr-2 rtl:ml-2 hidden sm:block">
                <ul class="flex items-center space-x-2 rtl:space-x-reverse dark:text-[#d0d2d6]">
                </ul>
            </div>
            <div x-data="header"
                class="sm:flex-1 ltr:sm:ml-0 ltr:ml-auto sm:rtl:mr-0 rtl:mr-auto flex items-center space-x-1.5 lg:space-x-2 rtl:space-x-reverse dark:text-[#d0d2d6]">
                <div class="sm:ltr:mr-auto sm:rtl:ml-auto" x-data="{ search: false }" @click.outside="search = false">
                </div>
                <div>
                    <a href="javascript:;" x-cloak x-show="$store.app.theme === 'light'" href="javascript:;"
                        class="flex items-center p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:text-primary hover:bg-white-light/90 dark:hover:bg-dark/60"
                        @click="$store.app.toggleTheme('dark')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="5" stroke="currentColor"
                                stroke-width="1.5" />
                            <path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" />
                            <path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" />
                            <path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" />
                            <path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </a>
                    <a href="javascript:;" x-cloak x-show="$store.app.theme === 'dark'" href="javascript:;"
                        class="flex items-center p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:text-primary hover:bg-white-light/90 dark:hover:bg-dark/60"
                        @click="$store.app.toggleTheme('system')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z"
                                fill="currentColor" />
                        </svg>
                    </a>
                    <a href="javascript:;" x-cloak x-show="$store.app.theme === 'system'" href="javascript:;"
                        class="flex items-center p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:text-primary hover:bg-white-light/90 dark:hover:bg-dark/60"
                        @click="$store.app.toggleTheme('light')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z"
                                stroke="currentColor" stroke-width="1.5" />
                            <path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                            <path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </a>
                </div>

                {{-- <div class="dropdown" x-data="dropdown" @click.outside="open = false">
                    <a href="javascript:;"
                        class="relative block p-2 rounded-full bg-white-light/40 dark:bg-dark/40 hover:text-primary hover:bg-white-light/90 dark:hover:bg-dark/60"
                        @click="toggle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0001 9.7041V9C19.0001 5.13401 15.8661 2 12.0001 2C8.13407 2 5.00006 5.13401 5.00006 9V9.7041C5.00006 10.5491 4.74995 11.3752 4.28123 12.0783L3.13263 13.8012C2.08349 15.3749 2.88442 17.5139 4.70913 18.0116C9.48258 19.3134 14.5175 19.3134 19.291 18.0116C21.1157 17.5139 21.9166 15.3749 20.8675 13.8012L19.7189 12.0783C19.2502 11.3752 19.0001 10.5491 19.0001 9.7041Z"
                                stroke="currentColor" stroke-width="1.5" />
                            <path d="M7.5 19C8.15503 20.7478 9.92246 22 12 22C14.0775 22 15.845 20.7478 16.5 19"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M12 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>

                        <span class="flex absolute w-3 h-3 ltr:right-0 rtl:left-0 top-0">
                            <span
                                class="animate-ping absolute ltr:-left-[3px] rtl:-right-[3px] -top-[3px] inline-flex h-full w-full rounded-full bg-success/50 opacity-75"></span>
                            <span class="relative inline-flex rounded-full w-[6px] h-[6px] bg-success"></span>
                        </span>
                    </a>
                    <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                        class="ltr:-right-2 rtl:-left-2 top-11 !py-0 text-dark dark:text-white-dark w-[300px] sm:w-[350px] divide-y dark:divide-white/10">
                        <li>
                            <div
                                class="flex items-center px-4 py-2 justify-between font-semibold hover:!bg-transparent">
                                <h4 class="text-lg">Notification</h4>
                                <template x-if="notifications.length">
                                    <span class="badge bg-primary/80" x-text="notifications.length + 'New'"></span>
                                </template>
                            </div>
                        </li>
                        <template x-for="notification in notifications">
                            <li class=" dark:text-white-light/90 ">
                                <div class="flex items-center px-4 py-2 group" @click.self="toggle">
                                    <div class="grid place-content-center rounded">
                                        <div class="w-12 h-12 relative">
                                            <img class="w-12 h-12 rounded-full object-cover"
                                                :src="`/assets/images/${notification.profile}`"
                                                alt="image" />
                                            <span
                                                class="bg-success w-2 h-2 rounded-full block absolute right-[6px] bottom-0"></span>
                                        </div>
                                    </div>
                                    <div class="ltr:pl-3 rtl:pr-3 flex flex-auto">
                                        <div class="ltr:pr-3 rtl:pl-3">
                                            <h6 x-html="notification.message"></h6>
                                            <span class="text-xs block font-normal dark:text-gray-500"
                                                x-text="notification.time"></span>
                                        </div>
                                        <button type="button"
                                            class="ltr:ml-auto rtl:mr-auto text-neutral-300 hover:text-danger opacity-0 group-hover:opacity-100"
                                            @click="removeNotification(notification.id)">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <circle opacity="0.5" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="1.5" />
                                                <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </template>
                        <template x-if="notifications.length">
                            <li>
                                <div class="p-4">
                                    <button class="btn btn-primary block w-full btn-small" @click="toggle">Read All
                                        Notifications</button>
                                </div>
                            </li>
                        </template>
                        <template x-if="!notifications.length">
                            <li>
                                <div class="!grid place-content-center hover:!bg-transparent text-lg min-h-[200px]">
                                    <div class="mx-auto ring-4 ring-primary/30 rounded-full mb-4 text-primary">
                                        <svg width="40" height="40" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5"
                                                d="M20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20C15.5228 20 20 15.5228 20 10Z"
                                                fill="currentColor" />
                                            <path
                                                d="M10 4.25C10.4142 4.25 10.75 4.58579 10.75 5V11C10.75 11.4142 10.4142 11.75 10 11.75C9.58579 11.75 9.25 11.4142 9.25 11V5C9.25 4.58579 9.58579 4.25 10 4.25Z"
                                                fill="currentColor" />
                                            <path
                                                d="M10 15C10.5523 15 11 14.5523 11 14C11 13.4477 10.5523 13 10 13C9.44772 13 9 13.4477 9 14C9 14.5523 9.44772 15 10 15Z"
                                                fill="currentColor" />
                                        </svg>
                                    </div>
                                    No data available.
                                </div>
                            </li>
                        </template>
                    </ul>
                </div> --}}
                <div class="dropdown flex-shrink-0" x-data="dropdown" @click.outside="open = false">
                    <a href="javascript:;" class="relative group" @click="toggle()">
                        <span>
                            <img class="w-9 h-9 rounded-full object-cover saturate-50 group-hover:saturate-100"
                                src="{{$imageUrl}}" alt="image" />
                        </span>
                    </a>
                    <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                        class="ltr:right-0 rtl:left-0 text-dark dark:text-white-dark top-11 !py-0 w-[230px] font-semibold dark:text-white-light/90">
                        <li>
                            <div class="flex items-center px-4 py-4">
                                <div class="flex-none">
                                    <img class="rounded-md w-10 h-10 object-cover"
                                        src="{{$imageUrl}}"
                                        alt="image" />
                                </div>
                                <div class="ltr:pl-4 rtl:pr-4 truncate">
                                    <h4 class="text-base">{{auth()->user()->name}}
                                    </h4>
                                    <a class="text-black/60  hover:text-primary dark:text-dark-light/60 dark:hover:text-white"
                                        href="javascript:;">{{auth()->user()->email}}</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="/pengaturan-akun" class="dark:hover:text-white" @click="toggle">
                                <svg class="w-4.5 h-4.5 ltr:mr-2 rtl:ml-2 shrink-0" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="6" r="4" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path opacity="0.5"
                                        d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z"
                                        stroke="currentColor" stroke-width="1.5" />
                                </svg>
                                Akun 
                                @if(auth()->user()->hasRole('admin'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Admin</span>
                                @elseif(auth()->user()->hasRole('koordinator'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Koordinator</span>
                                @elseif(auth()->user()->hasRole('pembimbing'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Pembimbing</span>
                                @elseif(auth()->user()->hasRole('wali_kelas'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Wali Kelas</span>
                                @elseif(auth()->user()->hasRole('siswa'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Siswa</span>
                                @elseif(auth()->user()->hasRole('guru'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Guru</span>
                                @elseif(auth()->user()->hasRole('karyawan'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Karyawan</span>
                                @elseif(auth()->user()->hasRole('ortu'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Ortu</span>
                                @elseif(auth()->user()->hasRole('industri'))
                                    <span class="ml-2 text-xs bg-success-light rounded text-success px-1 ltr:ml-2 rtl:ml-2">Industri</span>
                                @endif
                            </a>
                        </li>
                        <li class="border-t border-white-light dark:border-white-light/10">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                                @csrf
                                <a href="#" class="text-danger !py-3 flex pl-4" @click.prevent="toggle; document.getElementById('logout-form').submit();">
                                    <svg class="w-4.5 h-4.5 ltr:mr-2 rtl:ml-2 shrink-0 rotate-90" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5"
                                            d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M12 15L12 2M12 2L15 5.5M12 2L9 5.5" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Sign Out
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- horizontal menu -->
        <ul
            class="horizontal-menu hidden py-1.5 font-semibold px-6 lg:space-x-1.5 xl:space-x-8 rtl:space-x-reverse bg-white border-t border-[#ebedf2] dark:border-[#191e3a] dark:bg-[#0e1726] text-black dark:text-white-dark">
            <li class="menu nav-item relative">
                <a href="/" class="nav-link">
                    <div class="flex items-center">
                        <svg class="group-hover:!text-primary shrink-0" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5"
                                d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                fill="currentColor" />
                            <path
                                d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                fill="currentColor" />
                        </svg>
                        <span class="px-1">Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu nav-item relative">
                <a href="/biodata" class="nav-link">
                    <div class="flex items-center">
                        <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="6" r="4" 
                                fill="currentColor"/>
                            <ellipse opacity="0.5" cx="12" cy="17" rx="7" ry="4" 
                                fill="currentColor"/>
                        </svg>
                        <span class="px-1">Biodata</span>
                    </div>
                </a>
            </li>
            @if(Auth::user()->biodata)
            <li class="menu nav-item relative">
                <a href="/pilihankota-buat" class="nav-link">
                    <div class="flex items-center">
                        <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M20.9129 5.88881C21.25 6.39325 21.25 7.09549 21.25 8.49995V21.2499H21.75C22.1642 21.2499 22.5 21.5857 22.5 21.9999C22.5 22.4142 22.1642 22.7499 21.75 22.7499H1.75C1.33579 22.7499 1 22.4142 1 21.9999C1 21.5857 1.33579 21.2499 1.75 21.2499H2.25V8.49995C2.25 7.09549 2.25 6.39325 2.58706 5.88881C2.73298 5.67043 2.92048 5.48293 3.13886 5.33701C3.58008 5.04219 5.67561 5.00524 6.75702 5.00061C6.75291 5.292 6.75294 5.59649 6.75298 5.91045L6.75299 5.99995V7.24995H4.25C3.83579 7.24995 3.5 7.58573 3.5 7.99995C3.5 8.41416 3.83579 8.74995 4.25 8.74995H6.75299V10.2499H4.25C3.83579 10.2499 3.5 10.5857 3.5 10.9999C3.5 11.4142 3.83579 11.7499 4.25 11.7499H6.75299V13.2499H4.25C3.83579 13.2499 3.5 13.5857 3.5 13.9999C3.5 14.4142 3.83579 14.7499 4.25 14.7499H6.75299V21.2499H16.7529V14.7499H19.25C19.6642 14.7499 20 14.4142 20 13.9999C20 13.5857 19.6642 13.2499 19.25 13.2499H16.7529V11.7499H19.25C19.6642 11.7499 20 11.4142 20 10.9999C20 10.5857 19.6642 10.2499 19.25 10.2499H16.7529V8.74995H19.25C19.6642 8.74995 20 8.41416 20 7.99995C20 7.58573 19.6642 7.24995 19.25 7.24995H16.7529V5.99995L16.7529 5.91046V5.91043C16.753 5.59648 16.753 5.292 16.7489 5.00061C17.8303 5.00524 19.9199 5.04219 20.3611 5.33701C20.5795 5.48293 20.767 5.67043 20.9129 5.88881Z" 
                                fill="currentColor"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 2H12.75C14.6356 2 15.5784 2 16.1642 2.58579C16.75 3.17157 16.75 4.11438 16.75 6V21.25H18.25H21.25H21.75C22.1642 21.25 22.5 21.5858 22.5 22C22.5 22.4142 22.1642 22.75 21.75 22.75H1.75C1.33579 22.75 1 22.4142 1 22C1 21.5858 1.33579 21.25 1.75 21.25H2.25H5.25H6.75V6C6.75 4.11438 6.75 3.17157 7.33579 2.58579C7.92157 2 8.86438 2 10.75 2ZM11.75 18.25C12.1642 18.25 12.5 18.5858 12.5 19V21.25H11V19C11 18.5858 11.3358 18.25 11.75 18.25ZM9.75 14C9.33579 14 9 14.3358 9 14.75C9 15.1642 9.33579 15.5 9.75 15.5H13.75C14.1642 15.5 14.5 15.1642 14.5 14.75C14.5 14.3358 14.1642 14 13.75 14H9.75ZM9 11.75C9 11.3358 9.33579 11 9.75 11H13.75C14.1642 11 14.5 11.3358 14.5 11.75C14.5 12.1642 14.1642 12.5 13.75 12.5H9.75C9.33579 12.5 9 12.1642 9 11.75ZM9.75 8.5C9.33579 8.5 9 8.83579 9 9.25C9 9.66421 9.33579 10 9.75 10H13.75C14.1642 10 14.5 9.66421 14.5 9.25C14.5 8.83579 14.1642 8.5 13.75 8.5H9.75ZM9 6.25C9 5.83579 9.33579 5.5 9.75 5.5H13.75C14.1642 5.5 14.5 5.83579 14.5 6.25C14.5 6.66421 14.1642 7 13.75 7H9.75C9.33579 7 9 6.66421 9 6.25Z" 
                                fill="currentColor"/>
                        </svg>
                        <span class="px-1">Pilihan Kota</span>
                    </div>
                </a>
            </li>
            @endif
            @if(Auth::user()->penempatan)
            <li class="menu nav-item relative">
                <a href="/jurnal" class="nav-link">
                    <div class="flex items-center">
                        <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                fill="currentColor"/>
                            <path d="M10.5431 7.51724C10.8288 7.2173 10.8172 6.74256 10.5172 6.4569C10.2173 6.17123 9.74256 6.18281 9.4569 6.48276L7.14286 8.9125L6.5431 8.28276C6.25744 7.98281 5.78271 7.97123 5.48276 8.2569C5.18281 8.54256 5.17123 9.01729 5.4569 9.31724L6.59976 10.5172C6.74131 10.6659 6.9376 10.75 7.14286 10.75C7.34812 10.75 7.5444 10.6659 7.68596 10.5172L10.5431 7.51724Z" 
                                fill="currentColor"/>
                            <path d="M13 8.25C12.5858 8.25 12.25 8.58579 12.25 9C12.25 9.41422 12.5858 9.75 13 9.75H18C18.4142 9.75 18.75 9.41422 18.75 9C18.75 8.58579 18.4142 8.25 18 8.25H13Z" 
                                fill="currentColor"/>
                            <path d="M10.5431 14.5172C10.8288 14.2173 10.8172 13.7426 10.5172 13.4569C10.2173 13.1712 9.74256 13.1828 9.4569 13.4828L7.14286 15.9125L6.5431 15.2828C6.25744 14.9828 5.78271 14.9712 5.48276 15.2569C5.18281 15.5426 5.17123 16.0173 5.4569 16.3172L6.59976 17.5172C6.74131 17.6659 6.9376 17.75 7.14286 17.75C7.34812 17.75 7.5444 17.6659 7.68596 17.5172L10.5431 14.5172Z" 
                                fill="currentColor"/>
                            <path d="M13 15.25C12.5858 15.25 12.25 15.5858 12.25 16C12.25 16.4142 12.5858 16.75 13 16.75H18C18.4142 16.75 18.75 16.4142 18.75 16C18.75 15.5858 18.4142 15.25 18 15.25H13Z" 
                                fill="currentColor"/>
                        </svg>
                        <span class="px-1">Jurnal dan Kehadiran</span>
                    </div>
                </a>
            </li>
            <li class="menu nav-item relative">
                <a href="/pelanggaran" class="nav-link">
                    <div class="flex items-center">
                        <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12Z" 
                                fill="currentColor"/>
                            <path d="M8.96967 8.96967C9.26256 8.67678 9.73744 8.67678 10.0303 8.96967L12 10.9394L13.9697 8.96969C14.2626 8.6768 14.7374 8.6768 15.0303 8.96969C15.3232 9.26258 15.3232 9.73746 15.0303 10.0304L13.0607 12L15.0303 13.9696C15.3232 14.2625 15.3232 14.7374 15.0303 15.0303C14.7374 15.3232 14.2625 15.3232 13.9696 15.0303L12 13.0607L10.0304 15.0303C9.73746 15.3232 9.26258 15.3232 8.96969 15.0303C8.6768 14.7374 8.6768 14.2626 8.96969 13.9697L10.9394 12L8.96967 10.0303C8.67678 9.73744 8.67678 9.26256 8.96967 8.96967Z" 
                                fill="currentColor"/>
                        </svg>
                        <span class="px-1">Pelanggaran</span>
                    </div>
                </a>
            </li>
            <li class="menu nav-item relative">
                <a href="/nilai" class="nav-link">
                    <div class="flex items-center">
                        <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M21 15.9983V9.99826C21 7.16983 21 5.75562 20.1213 4.87694C19.3529 4.10856 18.175 4.01211 16 4H8C5.82497 4.01211 4.64706 4.10856 3.87868 4.87694C3 5.75562 3 7.16983 3 9.99826V15.9983C3 18.8267 3 20.2409 3.87868 21.1196C4.75736 21.9983 6.17157 21.9983 9 21.9983H15C17.8284 21.9983 19.2426 21.9983 20.1213 21.1196C21 20.2409 21 18.8267 21 15.9983Z" 
                                fill="currentColor"/>
                            <path d="M8 3.5C8 2.67157 8.67157 2 9.5 2H14.5C15.3284 2 16 2.67157 16 3.5V4.5C16 5.32843 15.3284 6 14.5 6H9.5C8.67157 6 8 5.32843 8 4.5V3.5Z" 
                                fill="currentColor"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5483 10.4883C15.8309 10.7911 15.8146 11.2657 15.5117 11.5483L11.226 15.5483C10.9379 15.8172 10.4907 15.8172 10.2025 15.5483L8.48826 13.9483C8.18545 13.6657 8.16909 13.1911 8.45171 12.8883C8.73434 12.5855 9.20893 12.5691 9.51174 12.8517L10.7143 13.9741L14.4883 10.4517C14.7911 10.1691 15.2657 10.1855 15.5483 10.4883Z" 
                                fill="currentColor"/>
                        </svg>
                        <span class="px-1">Nilai</span>
                    </div>
                </a>
            </li>
            <li class="menu nav-item relative">
                <a href="/hasilmonitoring" class="nav-link">
                    <div class="flex items-center">
                        <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M20.3133 11.1566C20.3133 16.2137 16.2137 20.3133 11.1566 20.3133C6.09956 20.3133 2 16.2137 2 11.1566C2 6.09956 6.09956 2 11.1566 2C16.2137 2 20.3133 6.09956 20.3133 11.1566Z" 
                                fill="currentColor"/>
                            <path d="M17.1001 18.1219L20.7664 21.7882C21.0487 22.0705 21.5064 22.0705 21.7887 21.7882C22.071 21.5059 22.071 21.0482 21.7887 20.7659L18.1224 17.0996C17.809 17.4666 17.4671 17.8085 17.1001 18.1219Z" 
                                fill="currentColor"/>
                        </svg>
                        <span class="px-1">Monitoring</span>
                    </div>
                </a>
            </li>
            @endif
            <li class="menu nav-item relative">
                <a href="/pusatunduhan-view" class="nav-link">
                    <div class="flex items-center">
                        <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5" d="M22 16.0003V15.0003C22 12.1718 21.9998 10.7581 21.1211 9.8794C20.2424 9.00072 18.8282 9.00072 15.9998 9.00072H7.99977C5.17135 9.00072 3.75713 9.00072 2.87845 9.8794C2 10.7579 2 12.1711 2 14.9981V15.0003V16.0003C2 18.8287 2 20.2429 2.87868 21.1216C3.75736 22.0003 5.17157 22.0003 8 22.0003H16H16C18.8284 22.0003 20.2426 22.0003 21.1213 21.1216C22 20.2429 22 18.8287 22 16.0003Z" 
                                fill="currentColor"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.25C11.5858 1.25 11.25 1.58579 11.25 2L11.25 12.9726L9.56943 11.0119C9.29986 10.6974 8.82639 10.661 8.51189 10.9306C8.1974 11.2001 8.16098 11.6736 8.43054 11.9881L11.4305 15.4881C11.573 15.6543 11.781 15.75 12 15.75C12.2189 15.75 12.4269 15.6543 12.5694 15.4881L15.5694 11.9881C15.839 11.6736 15.8026 11.2001 15.4881 10.9306C15.1736 10.661 14.7001 10.6974 14.4305 11.0119L12.75 12.9726L12.75 2C12.75 1.58579 12.4142 1.25 12 1.25Z" 
                                fill="currentColor"/>
                        </svg>
                        <span class="px-1">Unduhan</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</header>
<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("header", () => ({
            init() {
                const selector = document.querySelector('ul.horizontal-menu a[href="' + window
                    .location.pathname + '"]');
                if (selector) {
                    selector.classList.add('active');
                    const ul = selector.closest('ul.sub-menu');
                    if (ul) {
                        let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                        if (ele) {
                            ele = ele[0];
                            setTimeout(() => {
                                ele.classList.add('active');
                            });
                        }
                    }
                }
            },

            notifications: [{
                    id: 1,
                    profile: 'user-profile.jpeg',
                    message: '<strong class="text-sm mr-1">John Doe</strong>invite you to <strong>Prototyping</strong>',
                    time: '45 min ago',
                },
                {
                    id: 2,
                    profile: 'profile-34.jpeg',
                    message: '<strong class="text-sm mr-1">Adam Nolan</strong>mentioned you to <strong>UX Basics</strong>',
                    time: '9h Ago',
                },
                {
                    id: 3,
                    profile: 'profile-16.jpeg',
                    message: '<strong class="text-sm mr-1">Anna Morgan</strong>Upload a file',
                    time: '9h Ago',
                }
            ],

            messages: [{
                    id: 1,
                    image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-success-light dark:bg-success text-success dark:text-success-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></span>',
                    title: 'Congratulations!',
                    message: 'Your OS has been updated.',
                    time: '1hr',
                },
                {
                    id: 2,
                    image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-info-light dark:bg-info text-info dark:text-info-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>',
                    title: 'Did you know?',
                    message: 'You can switch between artboards.',
                    time: '2hr',
                },
                {
                    id: 3,
                    image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-danger-light dark:bg-danger text-danger dark:text-danger-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>',
                    title: 'Something went wrong!',
                    message: 'Send Reposrt',
                    time: '2days',
                },
                {
                    id: 4,
                    image: '<span class="grid place-content-center w-9 h-9 rounded-full bg-warning-light dark:bg-warning text-warning dark:text-warning-light"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">    <circle cx="12" cy="12" r="10"></circle>    <line x1="12" y1="8" x2="12" y2="12"></line>    <line x1="12" y1="16" x2="12.01" y2="16"></line></svg></span>',
                    title: 'Warning',
                    message: 'Your password strength is low.',
                    time: '5days',
                },
            ],

            removeNotification(value) {
                this.notifications = this.notifications.filter((d) => d.id !== value);
            },

            removeMessage(value) {
                this.messages = this.messages.filter((d) => d.id !== value);
            },
        }));
    });
</script>
