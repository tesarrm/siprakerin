<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

 <!-- line -->
    <div class="mb-5" x-data="{ tab: 'home'}">
        <!-- buttons -->
        <div>
            <ul class="flex flex-wrap mt-3 mb-5 border-b border-white-light dark:border-[#191e3a]">
                <li>
                    <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center hover:border-b border-transparent hover:!border-secondary hover:text-secondary" :class="{'border-b !border-secondary text-secondary' : tab === 'home'}" @click="tab = 'home'">
                        <svg> ... </svg>Home</a>
                </li>
                <li>
                    <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center hover:border-b border-transparent hover:!border-secondary hover:text-secondary" :class="{'border-b !border-secondary text-secondary' : tab === 'profile'}" @click="tab = 'profile'">
                        <svg> ... </svg>Profile</a>
                </li>
                <li>
                    <a href="javascript:" class="p-5 py-3 -mb-[1px] flex items-center hover:border-b border-transparent hover:!border-secondary hover:text-secondary" :class="{'border-b !border-secondary text-secondary' : tab === 'contact'}" @click="tab='contact'">
                        <svg> ... </svg>Contact</a>
                </li>
            </ul>
        </div>

        <!-- description -->
        <div class="flex-1 text-sm ">
            <template x-if="tab === 'home'">
                <div>
                    <h4 class="font-semibold text-2xl mb-4">We move your world!</h4>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                </div>
            </template>
            <template x-if="tab === 'profile'">
                <div>
                    <div class="flex items-start">
                        <div class="w-20 h-20 ltr:mr-4 rtl:ml-4 flex-none">
                            <img src=" /assets/images/profile-34.jpeg " alt="image" class="w-20 h-20 m-0 rounded-full ring-2 ring-[#ebedf2] dark:ring-white-dark object-cover" />
                        </div>
                        <div class="flex-auto">
                            <h5 class="text-xl font-medium mb-4">Media heading</h5>
                            <p class="text-white-dark">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="tab === 'contact'">
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </template>
        </div>
    </div>

    <div>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6" x-data="form">
            <!-- Basic -->
            <div class="panel">
                <div class="mb-5">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="5" class="!text-center border-b">All</th>
                                </tr>
                                <!-- Baris pertama untuk header utama -->
                                <tr>
                                    <th rowspan="2">Name</th>
                                    <th colspan="3" class="!text-center border-b">Basic Info</th>
                                    <th rowspan="2" class="text-center">Action</th>
                                </tr>
                                <!-- Baris kedua untuk subkolom -->
                                <tr>
                                    <th>Date</th>
                                    <th>Sale</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="data in tableData" :key="data.id">
                                    <tr>
                                        <td x-text="data.name" class="whitespace-nowrap"></td>
                                        <td x-text="data.date"></td>
                                        <td x-text="data.sale"></td>
                                        <td class="text-center whitespace-nowrap"
                                            :class="{
                                                'text-success': data.status === 'Complete',
                                                'text-secondary': data.status === 'Pending',
                                                'text-info': data.status === 'In Progress',
                                                'text-danger': data.status === 'Canceled'
                                            }"
                                            x-text="data.status"></td>
                                        <td class="text-center">
                                            <button type="button" x-tooltip="Delete">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 m-auto">
                                                    <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                    <path
                                                        d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                    <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" />
                                                    <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" />
                                                    <path opacity="0.5"
                                                        d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                        stroke="currentColor" stroke-width="1.5" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start hightlight js -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <!-- end hightlight js -->

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                tableData: [{
                        id: 1,
                        name: 'John Doe',
                        email: 'johndoe@yahoo.com',
                        date: '10/08/2020',
                        sale: 120,
                        status: 'Complete',
                        register: '5 min ago',
                        progress: '40%',
                        position: 'Developer',
                        office: 'London'
                    },
                    {
                        id: 2,
                        name: 'Shaun Park',
                        email: 'shaunpark@gmail.com',
                        date: '11/08/2020',
                        sale: 400,
                        status: 'Pending',
                        register: '11 min ago',
                        progress: '23%',
                        position: 'Designer',
                        office: 'New York'
                    },
                    {
                        id: 3,
                        name: 'Alma Clarke',
                        email: 'alma@gmail.com',
                        date: '12/02/2020',
                        sale: 310,
                        status: 'In Progress',
                        register: '1 hour ago',
                        progress: '80%',
                        position: 'Accountant',
                        office: 'Amazon'
                    },
                    {
                        id: 4,
                        name: 'Vincent Carpenter',
                        email: 'vincent@gmail.com',
                        date: '13/08/2020',
                        sale: 100,
                        status: 'Canceled',
                        register: '1 day ago',
                        progress: '60%',
                        position: 'Data Scientist',
                        office: 'Canada'
                    },
                ],

                // highlightjs
                codeArr: [],
                toggleCode(name) {
                    if (this.codeArr.includes(name)) {
                        this.codeArr = this.codeArr.filter((d) => d != name);
                    } else {
                        this.codeArr.push(name);

                        setTimeout(() => {
                            document.querySelectorAll('pre.code').forEach(el => {
                                hljs.highlightElement(el);
                            });
                        });
                    }
                }
            }));
        });
    </script>
</x-layout.default>
