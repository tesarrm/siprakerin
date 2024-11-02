<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>
    <script src='/assets/js/index.global.min.js'></script>

    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="/assets/js/nice-select2.js"></script>

    <style>
        .cell-content-tanggal {
            text-align: center;
            max-width: 120px; 
            display: block; 
            box-sizing: border-box; 
        }

        .cell-content {
            max-width: 300px; 
            max-height: 200px; 
            overflow: hidden; 
            text-overflow: ellipsis; /* Menampilkan titik-titik (...) jika konten terlalu panjang */
            display: block; 
            box-sizing: border-box; 
        }

        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>

    @php
        // $cud = auth()->user()->can('c_jurnal') && auth()->user()->can('u_jurnal') && auth()->user()->can('d_jurnal');
        $cud = false;
        $cu = auth()->user()->can('c_jurnal') && auth()->user()->can('u_jurnal');
    @endphp

    @if(auth()->user()->hasRole('siswa'))
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
            <div class="panel bg-gradient-to-r h-full">
                <div class="items-center">
                    <div class="text-base text-primary ltr:mr-3 rtl:ml-3"> Industri </div>
                    <div class="text-xl font-bold ltr:mr-3 rtl:ml-3"> {{$penempatan->industri->nama}} </div>
                </div>
            </div>
            <div class="panel h-full p-0">
                <div class="flex p-5">
                    <div
                        class="shrink-0 bg-success/10 text-success rounded-xl w-11 h-11 flex justify-center items-center dark:bg-success dark:text-white-light">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                            <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M8.5 12.5L10.5 14.5L15.5 9.5" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    </div>
                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                        <p class="text-xl dark:text-white-light">{{ $hadir->count() }}</p>
                        <h5 class="text-[#506690] text-xs">Hadir</h5>
                    </div>
                </div>
            </div>
            <div class="panel h-full p-0">
                <div class="flex p-5">
                    <div
                        class="shrink-0 bg-warning/10 text-warning rounded-xl w-11 h-11 flex justify-center items-center dark:bg-warning dark:text-white-light">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                            <path d="M12 7V13" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="12" cy="16" r="1" 
                                fill="currentColor"/>
                            <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                        <p class="text-xl dark:text-white-light">{{ $izin->count() }}</p>
                        <h5 class="text-[#506690] text-xs">Izin</h5>
                    </div>
                </div>
            </div>
            <div class="panel h-full p-0">
                <div class="flex p-5">
                    <div
                        class="shrink-0 bg-danger/10 text-danger rounded-xl w-11 h-11 flex justify-center items-center dark:bg-danger dark:text-white-light">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                            <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                        <p class="text-xl dark:text-white-light">{{ $alpa->count() }}</p>
                        <h5 class="text-[#506690] text-xs">Alpa</h5>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="panel">

        <div id="tabs" x-data="{ tab: 'guru'}">
            <ul class="flex flex-wrap mb-5 border-b border-white-light dark:border-[#191e3a]">
                <li class="tab active">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-secondary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(0)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'guru'}" @click="tab = 'guru'"
                        >
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M6 15.8L7.14286 17L10 14" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 8.8L7.14286 10L10 7" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 9L18 9" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M13 16L18 16" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Jurnal dan Kehadiran</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(1)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'kelas'}" @click="tab = 'kelas'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <circle cx="10" cy="6" r="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M18 17.5C18 19.9853 18 22 10 22C2 22 2 19.9853 2 17.5C2 15.0147 5.58172 13 10 13C14.4183 13 18 15.0147 18 17.5Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M21 10H19H17" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Siswa Izin</a>
                </li>

                @if(auth()->user()->hasRole('siswa'))
                    <li class="tab">
                        <a href="javascript:;"
                            class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                            onclick="showTab(2)"
                            :class="{'border-b !border-secondary text-secondary' : tab === 'kalender'}" 
                            @click="tab = 'kalender'; renderCalendar();
                            ">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                <path d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12Z" 
                                    stroke="currentColor" stroke-width="1.5"/>
                                <path opacity="0.5" d="M7 4V2.5" 
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <path opacity="0.5" d="M17 4V2.5" 
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <path opacity="0.5" d="M2.5 9H21.5" 
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M18 17C18 17.5523 17.5523 18 17 18C16.4477 18 16 17.5523 16 17C16 16.4477 16.4477 16 17 16C17.5523 16 18 16.4477 18 17Z" 
                                    fill="currentColor"/>
                                <path d="M18 13C18 13.5523 17.5523 14 17 14C16.4477 14 16 13.5523 16 13C16 12.4477 16.4477 12 17 12C17.5523 12 18 12.4477 18 13Z" 
                                    fill="currentColor"/>
                                <path d="M13 17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17C11 16.4477 11.4477 16 12 16C12.5523 16 13 16.4477 13 17Z" 
                                    fill="currentColor"/>
                                <path d="M13 13C13 13.5523 12.5523 14 12 14C11.4477 14 11 13.5523 11 13C11 12.4477 11.4477 12 12 12C12.5523 12 13 12.4477 13 13Z" 
                                    fill="currentColor"/>
                                <path d="M8 17C8 17.5523 7.55228 18 7 18C6.44772 18 6 17.5523 6 17C6 16.4477 6.44772 16 7 16C7.55228 16 8 16.4477 8 17Z" 
                                    fill="currentColor"/>
                                <path d="M8 13C8 13.5523 7.55228 14 7 14C6.44772 14 6 13.5523 6 13C6 12.4477 6.44772 12 7 12C7.55228 12 8 12.4477 8 13Z" 
                                    fill="currentColor"/>
                            </svg>
                            Kalender Kehadiran</a>
                    </li>
                @endif
            </ul>
        </div>
        <div id="tab-content">
            <div class="tab-content show">
    
                <div x-data="invoiceList">
                    <div class="panel px-0 py-0 shadow-none">

                        @if(auth()->user()->hasRole('siswa'))
                            <div class="px-5">
                                <div class="md:absolute md:top-0 ltr:md:left-0 rtl:md:right-0">
                                    <div class="flex items-center gap-2 mb-5">
                                        @if(!$lebih)
                                            <a href="/jurnal/create" class="btn btn-primary gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" class="w-5 h-5">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                                Tambah </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                        @endif

                        @if(
                            auth()->user()->hasRole('siswa') ||
                            auth()->user()->hasRole('wali_siswa') 
                        ) 
                        @else
                            <div class="px-5">
                                <div class="md:absolute ltr:md:left-5 rtl:md:right-5">
                                    <div class="flex items-center gap-2 mb-5">
                                        <div class="" style="width: 225px">
                                            <select id="filterKelas" x-model="selectedKelas" @change="filterByKelas" class="selectize">
                                                <option selected value="">Pilih Kelas</option>
                                                @foreach($kelas as $item)
                                                    <option value="{{ $item->nama . ' ' . $item->jurusan->singkatan . ' ' . $item->klasifikasi }}">
                                                        {{ $item->nama . ' ' . $item->jurusan->singkatan . ' ' . $item->klasifikasi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div style="width: 225px">
                                            <select id="filterSiswa" 
                                                x-model="selectedSiswa" 
                                                @change="filterBySiswa" 
                                                class="selectize">
                                                <option selected value="">Pilih Siswa</option>
                                                <template x-for="siswa in siswaOptions" :key="siswa.id">
                                                    <option :value="siswa.id" x-text="siswa.user.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="invoice-table">
                            <table id="myTable"></table>
                        </div>

                    </div>
                </div>

            </div>
            <div class="tab-content">

                <div x-data="siswa">
                    <div class="panel px-0 py-0 shadow-none">

                        @if(
                            auth()->user()->hasRole('siswa') ||
                            auth()->user()->hasRole('wali_siswa')
                        )
                        @else
                            <div class="px-5">
                                <div class="md:absolute ltr:md:left-5 rtl:md:right-5">
                                    <div class="flex items-center gap-2 mb-5">
                                        <div class="" style="width: 150px">
                                            <select id="filterKelas1" x-model="selectedKelas" @change="filterByKelas" class="selectize">
                                                <option selected value="">Pilih Kelas</option>
                                                @foreach($kelas as $item)
                                                    <option value="{{ $item->nama . ' ' . $item->jurusan->singkatan . ' ' . $item->klasifikasi }}">
                                                        {{ $item->nama . ' ' . $item->jurusan->singkatan . ' ' . $item->klasifikasi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="invoice-table">
                            <table id="table_siswa"></table>
                        </div>
                    </div>
                </div>

            </div>

            @if(auth()->user()->hasRole('siswa'))
                <div class="tab-content">
                    <div id='calendar'></div>
                </div>
            @endif
        </div>

    </div>

    {{-- =========================== --}}
    {{-- BOTTOM --}}
    {{-- =========================== --}}
 

    <script>
        /*************
         * toast alert 
         */

        @if(session('status'))
            document.addEventListener('DOMContentLoaded', function () {
                showAlert("{{ session('status') }}");
            });

            async function showAlert(message) {
                const toast = window.Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
                toast.fire({
                    icon: 'success',
                    title: message,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
            }
        @endif

        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function () {
                showAlert("{{ session('error') }}");
            });

            async function showAlert(message) {
                const toast = window.Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
                toast.fire({
                    icon: 'error',
                    title: message,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
            }
        @endif

        /*************
         * data database jurnal 
         */

        @php
            $items = [];
            if($cud){
                foreach ($data as $d) {
                    $items[] = [
                        'id' => $d->id ?? '-',
                        'nis' => $d->siswa->nis ?? '-',
                        'siswa' => $d->siswa->user->name ?? '-',
                        'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                        'tanggal_waktu' => $d->tanggal_waktu ?? '-',
                        'kegiatan' => $d->kegiatan ?? '-',
                        'keterangan' => $d->keterangan ?? '-',
                        'action' => $d->id ?? '-', 
                    ];
                }
            } else if (auth()->user()->hasRole('siswa')) {
                foreach ($data as $d) {
                    $items[] = [
                        'nis' => $d->siswa->nis ?? '-',
                        'siswa' => $d->siswa->user->name ?? '-',
                        'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                        'tanggal_waktu' => $d->tanggal_waktu ?? '-',
                        'kegiatan' => $d->kegiatan ?? '-',
                        'keterangan' => $d->keterangan ?? '-',
                        'action' => $d->id ?? '-', 
                        'created_at' => $d->created_at ?? '-', 
                    ];
                }
            } else {
                foreach ($data as $d) {
                    $items[] = [
                        'nis' => $d->siswa->nis ?? '-',
                        'siswa' => $d->siswa->user->name ?? '-',
                        'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                        'industri' => isset($d->siswa->penempatan->industri) ? $d->siswa->penempatan->industri->nama : '-',
                        'tanggal_waktu' => $d->tanggal_waktu ?? '-',
                        'kegiatan' => $d->kegiatan ?? '-',
                        'keterangan' => $d->keterangan ?? '-',
                        'action' => $d->id ?? '-', 
                    ];
                }
            }
        @endphp

        /*************
         * detail
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("detail", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle1() {
                    this.open = !this.open;
                },
            }));
        });

        document.addEventListener("alpine:init", () => {
            Alpine.data("detail1", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle2() {
                    this.open = !this.open;
                },
            }));
        });

        /*************
         * filter kelas 
         */

        @if(
            auth()->user()->hasRole('siswa') ||
            auth()->user()->hasRole('wali_siswa')
        )
        @else
            document.addEventListener("DOMContentLoaded", function(e) {
                var options = {
                    searchable: true
                };
                NiceSelect.bind(document.getElementById("filterKelas"), options);
            });

            /*************
             * filter kelas 1 
             */

            document.addEventListener("DOMContentLoaded", function(e) {
                var options = {
                    searchable: true
                };
                NiceSelect.bind(document.getElementById("filterKelas1"), options);
            });
        @endif

        /*************
         * tab 
         */

        function showTab(index) {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.tab-content');

            // Hapus kelas aktif dari semua tab dan sembunyikan semua konten
            tabs.forEach(tab => tab.classList.remove('active'));
            contents.forEach(content => content.classList.remove('show'));

            // Tambahkan kelas aktif pada tab yang dipilih dan tampilkan kontennya
            tabs[index].classList.add('active');
            contents[index].classList.add('show');
        }

        /*************
         * calendar 
         */

        let calendar;

        function renderCalendar() {
            if (calendar) {
                calendar.render();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (calendarEl) { // Pastikan elemen ada
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 600,
                    events: function(fetchInfo, successCallback, failureCallback) {
                        fetch('/attendance-data')
                            .then(response => response.json())
                            .then(data => {
                                var events = data.map(event => {
                                    let color;
                                    switch(event.title) {
                                        case 'hadir':
                                            color = '#2196f3';
                                            break;
                                        case 'izin':
                                            color = '#00ab55';
                                            break;
                                        case 'alpa':
                                            color = '#e7515a';
                                            break;
                                        case 'libur':
                                            color = '#3b3f5c';
                                            break;
                                        default:
                                            color = 'gray';
                                    }
                                    return {
                                        title: event.title,
                                        start: event.start,
                                        end: event.end,
                                        backgroundColor: color,
                                        borderColor: color,
                                        textColor: 'white'
                                    };
                                });
                                successCallback(events);
                            })
                            .catch(error => failureCallback(error));
                    }
                });
                calendar.render();
            }
        });

        /*************
         * datatable jurnal
         */

        let headings = [
            "NIS",
            "Nama",
            "Kelas",
            "Industri",
            "Tanggal Waktu",
            "Kegiatan",
            "Keterangan",
            "Aksi",
        ];

        let columns = [
            {
                select: 2,
                render: function(data, cell, row) {
                    if(data != '-'){
                        return `
                            <span class="badge badge-outline-info text-sm whitespace-nowrap">
                                ${data}
                            </span>
                        `;
                    } else {
                        return `
                            ${data}
                        `;
                    }
                }
            },
            {
                select: 3,
                render: function(data, cell, row) {
                    if(data != '-'){
                        return `
                            <span class="badge badge-outline-success text-sm whitespace-nowrap">
                                ${data}
                            </span>
                        `;
                    } else {
                        return `
                            ${data}
                        `;
                    }
                }
            },
            {
                select: 4, 
                render: function(data, cell, row) {
                    return `<div class="cell-content-tanggal">${data}</div>`;
                }
            },
            {
                select: 5, 
                render: function(data, cell, row) {
                    return `<div class="cell-content">${data}</div>`;
                }
            },
            {
                select: 6, 
                render: function(data, cell, row) {
                    return `<div class="cell-content">${data}</div>`;
                }
            },
            {
                select: 7,
                sortable: false,
                render: function(data, cell, row) {
                    const rowId = `row-${data}`; // Buat unique row ID berdasarkan data

                    return `<div class="flex gap-4 items-center">
                                <a href="#" @click="$dispatch('open-detail', { rowId: '${rowId}' })" class="hover:text-info">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path 
                                            opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" 
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        />
                                        <path 
                                            d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" 
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        />
                                    </svg>
                                </a>
                                <div x-data="detail" @open-detail.window="if ($event.detail.rowId === '${rowId}') toggle1()">
                                    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                        <div class="flex items-start justify-center min-h-screen px-4"
                                            @click.self="open = false">
                                            <div x-show="open" x-transition x-transition.duration.300
                                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                <div
                                                    class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                    <h5 class="font-bold text-lg">Detail</h5>
                                                    <button type="button" class="text-white-dark hover:text-dark"
                                                        @click="toggle1">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                            height="24px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="w-6 h-6">
                                                            <line x1="18" y1="6" x2="6"
                                                                y2="18"></line>
                                                            <line x1="6" y1="6" x2="18"
                                                                y2="18"></line>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div class="flex xl:flex-row flex-col gap-2.5">
                                                    <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                                                        <div class=" px-4">
                                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                                                                <div>
                                                                    <label for="tanggal">Tanggal Waktu<span class="text-danger">*</span></label>
                                                                    <input value="${row.cells[4].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                </div>
                                                            </div>
                                                            <div class="items-center">
                                                                <div class="text-lg font-semibold mb-4">Kegiatan</div>
                                                                <textarea id="alasan" rows="10" name="alasan" class="form-textarea pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly" 
                                                                    placeholder="Isi Alasan" required>${row.cells[5].data}</textarea>
                                                            </div>
                                                            <div class="mt-6 items-center">
                                                                <div class="text-lg font-semibold mb-4">Keterangan</div>
                                                                <textarea id="alasan" rows="10" name="alasan" class="form-textarea h-min bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly" 
                                                                    placeholder="Isi Alasan" required>${row.cells[6].data}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="mt-8 px-4">
                                                            <div class="flex justify-end items-center mt-8 gap-4">
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    @click="toggle1">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                }
            }                                
 
        ];

        if (@json(auth()->user()->hasRole('siswa'))) {
            headings = [
                "NIS",
                "Nama",
                "Kelas",
                "Tanggal Waktu",
                "Kegiatan",
                "Keterangan",
                "Aksi",
                "Created At",
            ];
            columns = [
                {
                    select: 7,
                    hidden: true,
                },
                {
                    select: 2,
                    render: function(data, cell, row) {
                        if(data != '-'){
                            return `
                                <span class="badge badge-outline-info text-sm">
                                    ${data}
                                </span>
                            `;
                        } else {
                            return `
                                ${data}
                            `;
                        }
                    }
                },
                {
                    select: 3, 
                    render: function(data, cell, row) {
                        return `<div class="cell-content-tanggal">${data}</div>`;
                    }
                },
                {
                    select: 4, 
                    render: function(data, cell, row) {
                        return `<div class="cell-content">${data}</div>`;
                    }
                },
                {
                    select: 5, 
                    render: function(data, cell, row) {
                        return `<div class="cell-content">${data}</div>`;
                    }
                },
                // {
                //     select: 6,
                //     sortable: false,
                //     render: function(data, cell, row) {
                //         return `<div class="flex gap-4 items-center">
                //                     <a href="/jurnal/${data}/edit" class="hover:text-info">
                //                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
                //                             <path
                //                                 opacity="0.5"
                //                                 d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                //                                 stroke="currentColor"
                //                                 stroke-width="1.5"
                //                                 stroke-linecap="round"
                //                             ></path>
                //                             <path
                //                                 d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                //                                 stroke="currentColor"
                //                                 stroke-width="1.5"
                //                             ></path>
                //                             <path
                //                                 opacity="0.5"
                //                                 d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                //                                 stroke="currentColor"
                //                                 stroke-width="1.5"
                //                             ></path>
                //                         </svg>
                //                     </a>
                //                     <a href="/jurnal/${data}" class="hover:text-info">
                //                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                //                             <path 
                //                                 opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" 
                //                                 stroke="currentColor"
                //                                 stroke-width="1.5"
                //                             />
                //                             <path 
                //                                 d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" 
                //                                 stroke="currentColor"
                //                                 stroke-width="1.5"
                //                             />
                //                         </svg>
                //                     </a>
                //                 </div>`;
                //     }
                // }
                {
                    select: 6,
                    sortable: false,
                    render: function(data, cell, row) {
                        const options = { timeZone: 'Asia/Jakarta', year: 'numeric', month: '2-digit', day: '2-digit' };
                        const today = new Intl.DateTimeFormat('id-ID', options).format(new Date());
                        const formattedToday = today.split('/').reverse().join('-');
                        // const today = new Date().toISOString().slice(0, 10); // Mendapatkan tanggal hari ini dalam format "YYYY-MM-DD"
                        const createdAt = row.cells[7].data.slice(0, 10); // Mengambil tanggal dari created_at (tanpa waktu)

                        const showButton = createdAt == formattedToday ? `
                            <a href="/jurnal/${data}/edit" class="hover:text-info">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
                                    <path
                                        opacity="0.5"
                                        d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    ></path>
                                    <path
                                        d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    ></path>
                                    <path
                                        opacity="0.5"
                                        d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    ></path>
                                </svg>
                            </a>
                            <a href="#" class="hover:text-danger" @click="deleteSingleRow('${data}')">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path
                                        d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    ></path>
                                    <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path
                                        opacity="0.5"
                                        d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    ></path>
                                </svg>
                            </a>
                            ` : '';
                        
                        return `<div>
                                    <div class="flex gap-4 items-center">
                                        <a href="/jurnal/${data}" class="hover:text-info">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path 
                                                    opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" 
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />
                                                <path 
                                                    d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" 
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />
                                            </svg>
                                        </a>
                                        ${showButton}
                                    </div>
                                </div>`;
                    }
                }
            ];
        }

        if (@json($cud)) {
            headings = [
                '<input type="checkbox" class="form-checkbox" :checked="checkAllCheckbox" :value="checkAllCheckbox" @change="checkAll($event.target.checked)"/>',
                "NIS",
                "Nama",
                "Kelas",
                "Tanggal Waktu",
                "Kegiatan",
                "Keterangan",
                "Aksi"
            ];
            columns = [
                {
                    select: 0,
                    sortable: false,
                    render: function(data, cell, row) {
                        return `<input type="checkbox" class="form-checkbox mt-1" :id="'chk' + ${data}" :value="(${data})" x-model.number="selectedRows" />`;
                    }
                },
                {
                    select: 5, 
                    render: function(data, cell, row) {
                        return `<div class="cell-content">${data}</div>`;
                    }
                },
                {
                    select: 6, 
                    render: function(data, cell, row) {
                        return `<div class="cell-content">${data}</div>`;
                    }
                },
                {
                    select: 7,
                    sortable: false,
                    render: function(data, cell, row) {
                        return `<div class="flex gap-4 items-center">
                                    <a href="/jurnal/${data}/edit" class="hover:text-info">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
                                            <path
                                                opacity="0.5"
                                                d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            ></path>
                                            <path
                                                d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            ></path>
                                            <path
                                                opacity="0.5"
                                                d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            ></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="hover:text-danger" @click="deleteSingleRow('${data}')">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                            <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path
                                                d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                            ></path>
                                            <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path
                                                opacity="0.5"
                                                d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                            ></path>
                                        </svg>
                                    </a>
                                </div>`;
                    }
                }
            ];
        }

        document.addEventListener("alpine:init", () => {
            Alpine.data('invoiceList', () => ({
                selectedRows: [],
                items: @json($items),
                searchText: '',
                datatable: null,
                dataArr: [],
                siswaOptions: [], 
                selectedKelas: '',
                selectedSiswa: '',
                cud: @json($cud),

                init() {
                    this.setTableData();
                    this.initializeTable();
                    this.$watch('items', value => {
                        this.datatable.destroy()
                        this.setTableData();
                        this.initializeTable();
                    });
                    this.$watch('selectedRows', value => {
                        this.datatable.destroy()
                        this.setTableData();
                        this.initializeTable();
                    });
                    @if(
                        auth()->user()->hasRole('siswa') ||
                        auth()->user()->hasRole('wali_siswa')
                    )
                    @else
                        this.$nextTick(() => {
                            let selectElement = document.getElementById('filterSiswa');

                            var options = {
                                searchable: true
                            };
                            NiceSelect.bind(selectElement, options);
                        });
                    @endif
                },

                initializeTable() {
                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            headings:headings, 
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100, 250, 500],
                        columns: columns, 
                        firstLast: true,
                        firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        labels: {
                            perPage: "<span class='ml-2'>{select}</span>",
                            noRows: "No data available",
                        },
                        layout: {
                            top: "{search}",
                            bottom: "{info}{select}{pager}",
                        },
                    });
                },

                checkAllCheckbox() {
                    if (this.items.length && this.selectedRows.length === this.items.length) {
                        return true;
                    } else {
                        return false;
                    }
                },

                checkAll(isChecked) {
                    if (isChecked) {
                        this.selectedRows = this.items.map((d) => {
                            return d.id;
                        });
                    } else {
                        this.selectedRows = [];
                    }
                },

                setTableData() {
                    this.dataArr = [];
                    for (let i = 0; i < this.items.length; i++) {
                        this.dataArr[i] = [];
                        for (let p in this.items[i]) {
                            if (this.items[i].hasOwnProperty(p)) {
                                this.dataArr[i].push(this.items[i][p]);
                            }
                        }
                    }
                },

                refreshTable() {
                    this.datatable.destroy();
                    this.setTableData();
                    this.initializeTable();
                    @if(!auth()->user()->hasRole('siswa'))
                        this.$nextTick(() => {
                            let selectElement = document.getElementById('filterSiswa');

                            if (selectElement && selectElement.nextElementSibling && selectElement.nextElementSibling.classList.contains('nice-select')) {
                                // Hapus elemen dropdown NiceSelect secara manual
                                selectElement.nextElementSibling.remove();
                                // Tampilkan kembali elemen select asli
                                selectElement.style.display = "inline-block";
                            }

                            var options = {
                                searchable: true
                            };
                            NiceSelect.bind(selectElement, options);
                        });
                    @endif
                },

                filterBySiswa() {
                    // console.log('halo')
                    // this.refreshTable(); 
                    if(this.selectedSiswa){
                        fetch(`{{ route('jurnal.filter') }}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pastikan CSRF token disertakan
                            },
                            body: JSON.stringify({
                                siswa: this.selectedSiswa // Mengambil nilai dari selectedKelas
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // console.log(data);
                            this.items = data; // Menyimpan data dari server
                            // this.refreshTable();  // Memperbarui tabel
                        })
                        .catch(error => console.error('Error fetching data:', error));
                    }else{
                        this.items = @json($items);
                    }

                },

                filterByKelas() {
                    if (this.selectedKelas) {
                        fetch(`{{ route('siswa.filterJurnal') }}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                kelas: this.selectedKelas
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // console.log(data);
                            this.siswaOptions = data;  // Perbarui siswaOptions dengan data dari server
                            this.selectedSiswa = '';   // Reset pilihan siswa setelah kelas diubah
                            this.refreshTable();
                        })
                        .catch(error => console.error('Error fetching data:', error));
                    } else {
                        this.siswaOptions = [];  // Kosongkan opsi siswa jika tidak ada kelas yang dipilih
                        this.selectedSiswa = ''; // Reset pilihan siswa
                        this.items = [];
                        this.refreshTable(); 
                    }
                },

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.nis && d.nis.toLowerCase().includes(this.searchText)) ||
                        (d.siswa && d.siswa.toLowerCase().includes(this.searchText)) ||
                        (d.kelas && d.kelas.toLowerCase().includes(this.searchText)) ||
                        (d.tanggal_waktu && d.tanggal_waktu.toLowerCase().includes(this.searchText)) ||
                        (d.kegiatan && d.kegiatan.toLowerCase().includes(this.searchText)) ||
                        (d.keterangan && d.keterangan.toLowerCase().includes(this.searchText))
                    );
                },

                deleteRow() {
                    if (this.selectedRows.length > 0) {
                        window.Swal.fire({
                            icon: 'warning',
                            title: 'Apakah Anda yakin?',
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            showCancelButton: true,
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal',
                            padding: '2em',
                            customClass: 'sweet-alerts'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch('/guru/delete-multiple', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        ids: this.selectedRows
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.Swal.fire({
                                            title: 'Dihapus!',
                                            text: 'Data berhasil dihapus.',
                                            icon: 'success',
                                            customClass: 'sweet-alerts'
                                        });
                                        this.items = this.items.filter((item) => !this.selectedRows.includes(item.id));
                                        this.selectedRows = [];
                                    } else {
                                        window.Swal.fire({
                                            title: 'Gagal!',
                                            text: 'Terjadi kesalahan saat menghapus data.',
                                            icon: 'error',
                                            customClass: 'sweet-alerts'
                                        });
                                    }
                                })
                                .catch(error => {
                                    window.Swal.fire({
                                        title: 'Error!',
                                        text: 'Terjadi kesalahan saat menghapus data.',
                                        icon: 'error',
                                        customClass: 'sweet-alerts'
                                    });
                                });
                            }
                        });
                    } else {
                        window.Swal.fire({
                            title: 'Tidak ada data yang dipilih',
                            text: 'Silakan pilih data yang ingin dihapus.',
                            icon: 'info',
                            customClass: 'sweet-alerts'
                        });
                    }
                },

                deleteSingleRow(id) {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        padding: '2em',
                        customClass: 'sweet-alerts'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/jurnal/${id}/delete`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    window.Swal.fire({
                                        title: 'Dihapus!',
                                        text: 'Data berhasil dihapus.',
                                        icon: 'success',
                                        customClass: 'sweet-alerts'
                                    });
                                    this.items = this.items.filter(item => item.id != id);
                                } else {
                                    console.log(data.success)
                                    window.Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat menghapus data.',
                                        icon: 'error',
                                        customClass: 'sweet-alerts'
                                    });
                                }
                            })
                            .catch(error => {
                                console.log(error)
                                window.Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error',
                                    customClass: 'sweet-alerts'
                                });
                            });
                        }
                    });
                }
            }))
        })

        /*************
         * datatable izin 
         */

        @if(
            auth()->user()->hasRole('wali_siswa')
        )
            @php
                $dIzin = [];
                foreach ($dataIzin as $d) {
                    $dIzin [] = [
                        'nis' => $wali_siswa->siswa->nis ?? '-',
                        'nama' => $wali_siswa->siswa->user->name?? '-',
                        'jenis_kelamin' => $wali_siswa->siswa->jenis_kelamin ?? '-',
                        'kelas' => $wali_siswa->siswa->kelas->nama . " " . $wali_siswa->siswa->kelas->jurusan->singkatan . " " . $wali_siswa->siswa->kelas->klasifikasi ?? '-',
                        'tanggal' => $d->tanggal ?? '-',
                        'catatan' => $d->catatan ?? '-',
                        'action' => $d->id ?? '-', 
                        'created_at' => $d->created_at ?? '-', 
                        'gambar' => $d->gambar ?? '-', 
                    ];
                }
            @endphp
        @else
            @php
                $dIzin = [];
                foreach ($dataIzin as $d) {
                    $dIzin [] = [
                        'nis' => $d->siswa->nis ?? '-',
                        'nama' => $d->siswa->user->name?? '-',
                        'jenis_kelamin' => $d->siswa->jenis_kelamin ?? '-',
                        'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                        'tanggal' => $d->tanggal ?? '-',
                        'catatan' => $d->catatan ?? '-',
                        'action' => $d->id ?? '-', 
                        'created_at' => $d->created_at ?? '-', 
                        'gambar' => $d->gambar ?? '-', 
                    ];
                }
            @endphp
        @endif

        /*************
         * datatable 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('siswa', () => ({
                selectedRows: [],
                items: @json($dIzin),
                searchText: '',
                datatable: null,
                selectedKelas: '', 
                dataArr: [],

                init() {
                    this.setTableData();
                    this.initializeTable();
                    this.$watch('items', value => {
                        // this.datatable.destroy()
                        // this.setTableData();
                        // this.initializeTable();
                        this.refreshTable();
                    });
                    this.$watch('selectedRows', value => {
                        // this.datatable.destroy()
                        // this.setTableData();
                        // this.initializeTable();
                        this.refreshTable();
                    });
                },

                initializeTable() {
                    this.datatable = new simpleDatatables.DataTable('#table_siswa', {
                        data: {
                            headings: [
                                "NIS",
                                "Nama",
                                "Jenis Kelamin",
                                "Kelas",
                                "Tanggal",
                                "Catatan",
                                "Aksi",
                                "Created At",
                                "Gambar",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            {
                                select: [7, 8],
                                hidden: true,
                            },
                            {
                                select: 3,
                                render: function(data, cell, row) {
                                    if(data != '-'){
                                        return `
                                            <div style="min-width: 100px;">
                                                <span class="badge badge-outline-info text-sm">
                                                    ${data}
                                                </span>
                                            </div>
                                        `;
                                    } else {
                                        return `
                                            ${data}
                                        `;
                                    }
                                }
                            },
                            {
                                select: 5, 
                                render: function(data, cell, row) {
                                    return `<div class="cell-content">${data}</div>`;
                                }
                            },
                            {
                                select: 6,
                                sortable: false,
                                render: function(data, cell, row) {
                                    const today = new Date().toISOString().slice(0, 10); // Mendapatkan tanggal hari ini dalam format "YYYY-MM-DD"
                                    const createdAt = row.cells[7].data.slice(0, 10); // Mengambil tanggal dari created_at (tanpa waktu)
                                    const rowId = `row-${data}`; // Buat unique row ID berdasarkan data
                                    
                                    @if(auth()->user()->hasRole('siswa'))
                                    const showButton = createdAt == today ? `
                                        <a href="/izin/${data}/edit" class="hover:text-info">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
                                                <path
                                                    opacity="0.5"
                                                    d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                ></path>
                                                <path
                                                    d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                ></path>
                                                <path
                                                    opacity="0.5"
                                                    d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                ></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="hover:text-danger" @click="deleteSingleRow('${data}')">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                                <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path
                                                    d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                ></path>
                                                <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path
                                                    opacity="0.5"
                                                    d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                ></path>
                                            </svg>
                                        </a>
                                        ` : '';
                                        @else
                                        const showButton = ''; 
                                        @endif
                                    
                                    return `<div>
                                                <div class="flex gap-4 items-center">
                                                    <a href="#" @click="$dispatch('open-detail', { rowId: '${rowId}' })" class="hover:text-info">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path 
                                                                opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" 
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                            />
                                                            <path 
                                                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" 
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                            />
                                                        </svg>
                                                    </a>
                                                    ${showButton}

                                                    <div x-data="detail1" @open-detail.window="if ($event.detail.rowId === '${rowId}') toggle2()">
                                                        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                            <div class="flex items-start justify-center min-h-screen px-4"
                                                                @click.self="open = false">
                                                                <div x-show="open" x-transition x-transition.duration.300
                                                                    class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                                    <div
                                                                        class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                        <h5 class="font-bold text-lg">Detail</h5>
                                                                        <button type="button" class="text-white-dark hover:text-dark"
                                                                            @click="toggle2">

                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                                height="24px" viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="1.5"
                                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                                class="w-6 h-6">
                                                                                <line x1="18" y1="6" x2="6"
                                                                                    y2="18"></line>
                                                                                <line x1="6" y1="6" x2="18"
                                                                                    y2="18"></line>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                    <div class="flex xl:flex-row flex-col gap-2.5">
                                                                        <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                                                                            <div class="px-4"  >
                                                                                <div class="text-lg font-semibold">Surat Izin</div>
                                                                                <div class="flex xl:flex-row flex-col gap-6">
                                                                                    <div class="space-y-5 px-0 flex-1 py-6" >
                                                                                        <div class="mb-5 border rounded-xl overflow-hidden">
                                                                                            <img class="object-cover w-full h-full" src="{{ asset('storage/posts') }}/${row.cells[8].data}"> 
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="xl:w-96 w-full xl:mt-0 mt-6 space-y-5">
                                                                                        <div class="grid grid-cols-1 gap-4">
                                                                                            <div>
                                                                                                <label for="tanggal1">Tanggal<span class="text-danger">*</span></label>
                                                                                                <input value="${row.cells[4].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="catatan">Catatan</label>
                                                                                            <textarea id="catatan" rows="10" name="catatan" class="form-textarea bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly 
                                                                                                placeholder="Isi Catatan" required>${row.cells[5].data}</textarea>
                                                                                        </div>
                                                                                        {{-- button --}}
                                                                                        <div class="flex justify-end items-center mt-8 gap-4">
                                                                                            <button type="button" class="btn btn-outline-danger"
                                                                                                @click="toggle2">Batal</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>`;
                                }
                            }
                        ],
                        firstLast: true,
                        firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        labels: {
                            perPage: "<span class='ml-2'>{select}</span>",
                            noRows: "No data available",
                        },
                        layout: {
                            top: "{search}",
                            bottom: "{info}{select}{pager}",
                        },
                    });
                },

                checkAllCheckbox() {
                    if (this.items.length && this.selectedRows.length === this.items.length) {
                        return true;
                    } else {
                        return false;
                    }
                },

                checkAll(isChecked) {
                    if (isChecked) {
                        this.selectedRows = this.items.map((d) => {
                            return d.id;
                        });
                    } else {
                        this.selectedRows = [];
                    }
                },

                setTableData() {
                    // this.dataArr = [];
                    // for (let i = 0; i < this.items.length; i++) {
                    //     this.dataArr[i] = [];
                    //     for (let p in this.items[i]) {
                    //         if (this.items[i].hasOwnProperty(p)) {
                    //             this.dataArr[i].push(this.items[i][p]);
                    //         }
                    //     }
                    // }

                    this.dataArr = this.items
                        .filter(item => {
                            // Jika selectedKelas tidak kosong, hanya tampilkan yang sesuai
                            return this.selectedKelas === '' || item.kelas === this.selectedKelas;
                        })
                        .map(item => {
                            return Object.values(item); // Mengonversi setiap item ke array data
                        });
                },

                refreshTable() {
                    this.datatable.destroy();
                    this.setTableData();
                    this.initializeTable();
                },

                filterByKelas() {
                    this.refreshTable(); 
                },

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.nis && d.nis.toLowerCase().includes(this.searchText)) ||
                        (d.nama && d.nama.toLowerCase().includes(this.searchText)) ||
                        (d.jenis_kelamin && d.jenis_kelamin.toLowerCase().includes(this.searchText)) ||
                        (d.kelas && d.kelas.toLowerCase().includes(this.searchText)) ||
                        (d.tanggal && d.tanggal.toLowerCase().includes(this.searchText)) ||
                        (d.catatan && d.catatan.toLowerCase().includes(this.searchText))
                    );
                },

                deleteSingleRow(id) {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        padding: '2em',
                        customClass: 'sweet-alerts'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/izin/${id}/delete`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    window.Swal.fire({
                                        title: 'Dihapus!',
                                        text: 'Data berhasil dihapus.',
                                        icon: 'success',
                                        customClass: 'sweet-alerts'
                                    });
                                    this.items = this.items.filter(item => item.id != id);
                                } else {
                                    window.Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat menghapus data.',
                                        icon: 'error',
                                        customClass: 'sweet-alerts'
                                    });
                                }
                            })
                            .catch(error => {
                                console.log(error)
                                window.Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error',
                                    customClass: 'sweet-alerts'
                                });
                            });
                        }
                    });
                }

            }))
        })
    </script>
</x-layout.default>
