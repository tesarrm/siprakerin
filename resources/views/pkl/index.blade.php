@if(
    auth()->user()->hasRole('siswa') ||
    auth()->user()->hasRole('wali_siswa')
) 
    <x-layout.default>
        <style>
            .tab-content {
                display: none;
            }
            .show {
                display: block;
            }
        </style>

        <div>
            <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-5">
                <div class="panel">
                    <div class="mb-5">
                        <div class="flex flex-col justify-center items-center">
                            <img src="{{ $siswa->gambar ? asset('storage/posts/' . $siswa->gambar) : asset('storage/blank_profile.png') }}" 
                                alt="image" class="w-24 h-24 rounded-full object-cover mb-5" />
                            <p class="font-semibold text-primary text-xl">{{ $siswa->user->name}}</p>
                        </div>
                            <ul class="mt-5 flex flex-col space-y-4 font-semibold text-white-dark">
                                <li class="border-b pb-2">
                                    <div class="flex justify-between">
                                        <div class="w-full">NIS</div>
                                        <div class="w-full items-end text-end">{{$siswa->nis ?? '-'}}</div>
                                    </div>
                                </li>
                                <li class="border-b pb-2">
                                    <div class="flex justify-between">
                                        <div class="w-full">Jenis Kelamin</div>
                                        <div class="w-full items-end text-end">{{$siswa->jenis_kelamin ?? '-'}}</div>
                                    </div>
                                </li>
                                <li class="border-b pb-2">
                                    <div class="flex justify-between">
                                        <div class="w-full">Kelas</div>
                                        <div class="w-full items-end text-end">{{$siswa->kelas->nama . " " . $siswa->kelas->jurusan->singkatan . " " . $siswa->kelas->klasifikasi ?? '-'}}</div>
                                    </div>
                                </li>
                                <li class="border-b pb-2">
                                    <div class="flex justify-between">
                                        <div class="w-full">Tahun Ajaran</div>
                                        <div class="w-full items-end text-end">{{$siswa->kelas->tahun_ajaran ?? '-'}}</div>
                                    </div>
                                </li>
                                <li class="border-b pb-2">
                                    <div class="flex justify-between">
                                        <div class="w-full">Email</div>
                                        <div class="w-full items-end text-end">{{$siswa->user->email ?? '-'}}</div>
                                    </div>
                                </li>
                                <li class="border-b pb-2">
                                    <div class="flex justify-between">
                                        <div class="w-full">No Telp</div>
                                        <div class="w-full items-end text-end">{{$siswa->no_telp ?? '-'}}</div>
                                    </div>
                                </li>
                                <li class="border-b pb-2">
                                    <div class="flex justify-between">
                                        <div class="w-full">Industri</div>
                                        <div class="w-full items-end text-end">{{$siswa->penempatan->industri->nama ?? '-'}}</div>
                                    </div>
                                </li>
                            </ul>
                    </div>
                </div>
                <div class="panel lg:col-span-2 xl:col-span-3">
                    <div class="mb-5">
                        <h5 class="font-semibold text-lg dark:text-white-light">Kehadiran</h5>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
                        <div class="flex">
                            <div
                                class="shrink-0 bg-primary/10 text-primary rounded-xl w-11 h-11 flex justify-center items-center dark:bg-primary dark:text-white-light">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <circle cx="12" cy="6" r="4" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path opacity="0.5" d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5" d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <ellipse cx="12" cy="17" rx="6" ry="4"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path opacity="0.5"
                                        d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5"
                                        d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{$hadir->count()}}</p>
                                <h5 class="text-[#506690] text-xs">Hadir</h5>
                            </div>
                        </div>
                        <div class="flex">
                            <div
                                class="shrink-0 bg-primary/10 text-primary rounded-xl w-11 h-11 flex justify-center items-center dark:bg-primary dark:text-white-light">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <circle cx="12" cy="6" r="4" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path opacity="0.5" d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5" d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <ellipse cx="12" cy="17" rx="6" ry="4"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path opacity="0.5"
                                        d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5"
                                        d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{$izin->count()}}</p>
                                <h5 class="text-[#506690] text-xs">Izin</h5>
                            </div>
                        </div>
                        <div class="flex">
                            <div
                                class="shrink-0 bg-primary/10 text-primary rounded-xl w-11 h-11 flex justify-center items-center dark:bg-primary dark:text-white-light">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <circle cx="12" cy="6" r="4" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path opacity="0.5" d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5" d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <ellipse cx="12" cy="17" rx="6" ry="4"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path opacity="0.5"
                                        d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5"
                                        d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{$alpa->count()}}</p>
                                <h5 class="text-[#506690] text-xs">Alpa</h5>
                            </div>
                        </div>
                        <div class="flex">
                            <div
                                class="shrink-0 bg-primary/10 text-primary rounded-xl w-11 h-11 flex justify-center items-center dark:bg-primary dark:text-white-light">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <circle cx="12" cy="6" r="4" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path opacity="0.5" d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5" d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <ellipse cx="12" cy="17" rx="6" ry="4"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path opacity="0.5"
                                        d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5"
                                        d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="ltr:ml-3 rtl:mr-3 font-semibold">
                                <p class="text-xl dark:text-white-light">{{$sisa_hari}}</p>
                                <h5 class="text-[#506690] text-xs">Sisa Hari</h5>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="panel">
                    <div class="mb-5">
                        <h5 class="font-semibold text-lg dark:text-white-light">Pelanggaran</h5>
                    </div>

                    <div x-data="pelanggaran">
                        <div class="invoice-table" style="word-wrap: word">
                            <table id="myTable" class="whitespace-nowrap"></table>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="mb-5">
                        <h5 class="font-semibold text-lg dark:text-white-light">Nilai</h5>
                    </div>

                    <div id="tabs" x-data="{ tab: 'jadwal'}">
                        <ul class="flex flex-wrap mb-5 border-b border-white-light dark:border-[#191e3a]">
                            <li class="tab active">
                                <a href="javascript:;"
                                    class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-secondary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                                    onclick="showTab(0)"
                                    :class="{'border-b !border-secondary text-secondary' : tab === 'jadwal'}" @click="tab = 'jadwal'"
                                    >
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                        <path opacity="0.5"
                                            d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <path d="M12 15L12 18" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                    Penilaian 1</a>
                            </li>
                            <li class="tab">
                                <a href="javascript:;"
                                    class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                                    onclick="showTab(1)"
                                    :class="{'border-b !border-secondary text-secondary' : tab === 'hasil'}" @click="tab = 'hasil'"
                                    ">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                        <circle cx="12" cy="6" r="4"
                                            stroke="currentColor" stroke-width="1.5" />
                                        <ellipse opacity="0.5" cx="12" cy="17" rx="7"
                                            ry="4" stroke="currentColor" stroke-width="1.5" />
                                    </svg>
                                    Penilaian 2</a>
                            </li>
                        </ul>
                    </div>

                    <div id="tab-content">
                        <div class="tab-content show">

                            @foreach($nilai as $capaianIndex => $capaian)
                                <div class="mb-4">
                                    <strong>{{ $capaian->nama }}</strong>
                                    <ol class="ordered-list">
                                        @foreach($capaian->tujuanPembelajaran as $tujuanIndex => $tujuan)
                                            <li class="flex justify-between mb-1">
                                                <span>{{ ($tujuanIndex + 1) . '. ' . $tujuan->nama }}</span>
                                                <!-- Tambahkan hidden input untuk tujuan_pembelajaran_id -->
                                                <input type="text" value="{{ $tujuan->nilai->where('urutan', 1)->first()->nilai}}" class="form-input w-20 pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Nilai" />
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endforeach

                        </div>
                        <div class="tab-content">

                            @foreach($nilai as $capaianIndex => $capaian)
                                <div class="mb-4">
                                    <strong>{{ $capaian->nama }}</strong>
                                    <ol class="ordered-list">
                                        @foreach($capaian->tujuanPembelajaran as $tujuanIndex => $tujuan)
                                            <li class="flex justify-between mb-1">
                                                <span>{{ ($tujuanIndex + 1) . '. ' . $tujuan->nama }}</span>
                                                <!-- Tambahkan hidden input untuk tujuan_pembelajaran_id -->
                                                <input type="text" value="{{ $tujuan->nilai->where('urutan', 2)->first()->nilai}}" class="form-input w-20 pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Nilai" />
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- =========================== --}}
        {{-- BOTTOM --}}
        {{-- =========================== --}}


        <script>
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

            document.addEventListener('DOMContentLoaded', function() {

                // Ambil id dari URL
                var pathArray = window.location.pathname.split('/');
                var id = pathArray[pathArray.length - 1]; // Ambil bagian terakhir dari URL (id)

                var calendarEl = document.getElementById('calendar');

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 400,
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // Ambil data dari endpoint backend (Laravel)
                        fetch(`/attendance-data?id=${id}`)
                            .then(response => response.json())
                            .then(data => {
                                // Map data ke format FullCalendar
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
                                            color = 'gray'; // Warna default jika status tidak terdefinisi
                                    }

                                    return {
                                        title: event.title,
                                        start: event.start,
                                        end: event.end,
                                        backgroundColor: color, // Set warna berdasarkan status
                                        borderColor: color,     // Sama seperti warna background
                                        textColor: 'white'      // Set warna teks agar terlihat jelas
                                    };
                                });
                                successCallback(events); // Berhasil mengambil dan merender event
                            })
                            .catch(error => failureCallback(error)); // Tangani error
                    }
                });

                calendar.render();
            });

            /*************
             * datatable 
             */

            @php
                $items = [];
                foreach ($pelanggaran as $d) {
                    $items[] = [
                        'tanggal' => $d->tanggal,
                        'pelanggaran' => $d->pelanggaran,
                        'solusi' => $d->solusi,
                    ];
                }
            @endphp

            document.addEventListener("alpine:init", () => {
                Alpine.data('pelanggaran', () => ({
                    selectedRows: [],
                    items: @json($items),
                    datatable: null,
                    dataArr: [],

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
                    },

                    initializeTable() {
                        this.datatable = new simpleDatatables.DataTable('#myTable', {
                            data: {
                                headings: [
                                    "Tanggal",
                                    "Pelanggaran",
                                    "Solusi",
                                ],
                                data: this.dataArr
                            },
                            perPage: 10,
                            perPageSelect: [10, 20, 30, 50, 100],
                            columns: [
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
                                top: "",
                                bottom: "{info}{select}{pager}",
                            },
                        });
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
                }))
            })
        </script>
    </x-layout.default>
@else
    <x-layout.default>
        <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
        <script src="/assets/js/swiper-bundle.min.js"></script>
        <script src="/assets/js/simple-datatables.js"></script>

        <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
        <script src="/assets/js/nice-select2.js"></script>

        {{-- calendar --}}
        <script src='/assets/js/index.global.min.js'></script> 
        <script src="/assets/js/simple-datatables.js"></script>



        <div x-data="dataList">
            <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
                @if(!auth()->user()->hasRole('wali_kelas')) 
                <div class="px-5">
                    <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                        <div class="flex items-center gap-2 mb-5">

                            <div class="" style="width: 150px">
                                <select id="filterKelas" x-model="selectedKelas" @change="filterByKelas" class="selectize">
                                    <option selected value="">Pilih Kelas</option>
                                    @foreach($kelas as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama . ' ' . $item->jurusan->singkatan . ' ' . $item->klasifikasi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="" style="width: 150px">
                                <select id="filterIndustri" x-model="selectedIndustri" @change="filterByIndustri" class="selectize">
                                    <option selected value="">Pilih Industri</option>
                                    @foreach($industri as $item)
                                        <option value="{{ $item->nama }}">
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                @endif

                <div class="invoice-table" style="word-wrap: word">
                    <table id="myTable" class="whitespace-nowrap"></table>
                </div>
            </div>
        </div>

        {{-- =========================== --}}
        {{-- BOTTOM --}}
        {{-- =========================== --}}


        {{-- alert toast --}}
        @if(session('status'))
            <script>
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
            </script>
        @endif

        {{-- data datatable --}}
        @php
            $items = [];
            foreach ($siswa as $d) {
                $items[] = [
                    'nama' => $d->user->name?? '-',
                    'kelas' => $d->kelas->nama . " " . $d->kelas->jurusan->singkatan . " " . $d->kelas->klasifikasi ?? '-',
                    'industri' => $d->penempatan->industri->nama ?? '-',
                    'tanggal_awal' => $d->penempatan->industri->tanggal_awal ?? '-',
                    'tanggal_akhir' => $d->penempatan->industri->tanggal_akhir ?? '-',
                    'siswa_waktu' => $d->penempatan->sisa_waktu ?? '-',
                    'status' => $d->penempatan->status ?? '-',
                    'action' => $d->id ?? '-', 

                    'kota1' => $d->pilihankota->kota1->nama ?? '-', 
                    'kota2' => $d->pilihankota->kota2->nama ?? '-', 
                    'kota3' => $d->pilihankota->kota3->nama ?? '-', 
                    'industri_id' => $d->penempatan->industri->id ?? '-',
                ];
            }
        @endphp

        <script>
            /*************
             * filter kelas 
             */

            document.addEventListener("DOMContentLoaded", function(e) {
                var options = {
                    searchable: true
                };
                NiceSelect.bind(document.getElementById("filterKelas"), options);
            });

            /*************
             * filter industri 
             */

            document.addEventListener("DOMContentLoaded", function(e) {
                var options = {
                    searchable: true
                };
                NiceSelect.bind(document.getElementById("filterIndustri"), options);
            });

            /*************
             * datatable 
             */

            document.addEventListener("alpine:init", () => {
                Alpine.data('dataList', () => ({
                    selectedRows: [],
                    items: @json($items),
                    searchText: '',
                    selectedKelas: '',
                    selectedIndustri: '',
                    datatable: null,
                    dataArr: [],

                    init() {
                        this.setTableData();
                        this.initializeTable();
                        this.$watch('items', value => {
                            this.refreshTable();
                        });
                        this.$watch('selectedRows', value => {
                            this.refreshTable();
                        });
                    },

                    initializeTable() {
                        this.datatable = new simpleDatatables.DataTable('#myTable', {
                            data: {
                                headings: [
                                    "Nama",
                                    "Kelas",
                                    "Industri",
                                    "Awal PKL",
                                    "Akhir PKL",
                                    "Sisa Waktu",
                                    "Status",
                                    "Aksi",

                                    "X",
                                    "X",
                                    "X",
                                    "X",
                                ],
                                data: this.dataArr
                            },
                            perPage: 10,
                            perPageSelect: [10, 20, 30, 50, 100],
                            columns: [
                                {
                                    select: [8,9,10, 11],
                                    hidden: true,
                                },
                                {
                                    select: 1,
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
                                    select: 2,
                                    render: function(data, cell, row) {
                                        if(data != '-'){
                                            return `
                                                <span class="badge badge-outline-warning text-sm">
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
                                    select: 6,
                                    render: function(data, cell, row) {
                                        if(data == 'Prakerin'){
                                            return `
                                                <span class="badge bg-info/20 text-info rounded-full">
                                                    ${data}
                                                </span>
                                            `;
                                        } else if(data == 'Selesai'){
                                            return `
                                                <span class="badge bg-success/20 text-success rounded-full">
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
                                    select: 7,
                                    sortable: false,
                                    render: function(data, cell, row) {
                                        const rowId = `row-${data}`; // Buat unique row ID berdasarkan data

                                        return `<div class="items-center">
                                                    <div x-data="dropdown" @click.outside="open = false"
                                                        class="dropdown w-max">
                                                        <a href="javascript:;" class="inline-block" @click="toggle">

                                                            <svg class="w-5 h-5 opacity-70 m-auto" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <circle cx="5" cy="12" r="2"
                                                                    stroke="currentColor" stroke-width="1.5"></circle>
                                                                <circle opacity="0.5" cx="12" cy="12"
                                                                    r="2" stroke="currentColor" stroke-width="1.5">
                                                                </circle>
                                                                <circle cx="19" cy="12" r="2"
                                                                    stroke="currentColor" stroke-width="1.5"></circle>
                                                            </svg>
                                                        </a>
                                                        <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                                            class="ltr:right-0 rtl:left-0">
                                                            <li><a href="pkl/${data}">Detail</a></li>
                                                            @if(!auth()->user()->hasRole('pembimbing') && !auth()->user()->hasRole('wali_kelas'))
                                                            <li><a href="#" @click="$dispatch('open-detail', { rowId: '${rowId}' })">Pindah</a></li>
                                                            <li><a href="#" @click="$dispatch('open-berhenti', { rowId: '${rowId}' })">Berhenti</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>

                                                    <!-- model pindah -->
                                                    <div 
                                                        x-data="detail(false, '${row.cells[4].data}', '${row.cells[5].data}')" 
                                                        @open-detail.window="if ($event.detail.rowId === '${rowId}') toggle1()"
                                                        >
                                                        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                                                <div x-show="open" x-transition x-transition.duration.300
                                                                    class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                        <h5 class="font-bold text-lg">Pindah Industri</h5>
                                                                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="w-6 h-6">
                                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                    <div x-data="{rowc2: '${row.cells[11].data}'}"  class="p-5 pt-0 overflow-hidden max-h-[80vh] overflow-y-auto">

                                                                        <form action="{{ url('pkl') }}/${data}" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="flex xl:flex-row flex-col gap-6">
                                                                                <div class="space-y-5 w-full px-0 flex-1">
                                                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                        <div>
                                                                                            <label for="siswa">Siswa<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[2].data}" required id="siswa" type="text" name="siswa" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="kota1">Pilihan Kota 1<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[8].data}" required id="kota1" type="text" name="kota1" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="kota2">Pilihan Kota 2<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[9].data}" required id="kota2" type="text" name="kota2" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="kota3">Pilihan Kota 3<span class="text-danger">*</span></label>
                                                                                            <input  value="${row.cells[10].data}" required id="kota3" type="text" name="kota3" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div x-data="{
                                                                                            pilihanKota: {
                                                                                                kota1: '${row.cells[8].data}',
                                                                                                kota2: '${row.cells[9].data}',
                                                                                                kota3: '${row.cells[10].data}'
                                                                                            },
                                                                                            filterIndustri(industri) {
                                                                                                return (
                                                                                                    industri.kota.nama === this.pilihanKota.kota1 ||
                                                                                                    industri.kota.nama === this.pilihanKota.kota2 ||
                                                                                                    industri.kota.nama === this.pilihanKota.kota3
                                                                                                );
                                                                                            }
                                                                                        }">
                                                                                            <label for="industri">Industri<span class="text-danger">*</span></label>
                                                                                            <select required id="industri_id" name="industri_id" class="selectize w-full industri-select" 
                                                                                                @change="updateDates($event.target.value)">
                                                                                                <option value="">Pilih Industri</option>
                                                                                                @foreach($industri as $item)
                                                                                                    <template x-if="filterIndustri({{ json_encode($item) }})">
                                                                                                        <option value="{{ $item->id }}" 
                                                                                                            data-tanggal-awal="{{ $item->tanggal_awal }}" 
                                                                                                            data-tanggal-akhir="{{ $item->tanggal_akhir }}"
                                                                                                            x-bind:selected="rowc2 === '{{ $item->id }}' ? true : false">
                                                                                                            {{ $item->nama . " (" . $item->kota->nama . ")" }} 
                                                                                                        </option>
                                                                                                    </template>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="tanggal_awal">Tanggal Awal<span class="text-danger">*</span></label>
                                                                                            <input 
                                                                                                value="${row.cells[4].data}" 
                                                                                                x-model="tanggalAwal" 
                                                                                                required 
                                                                                                id="tanggal_awal" 
                                                                                                type="text" 
                                                                                                name="tanggal_awal" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="tanggal_akhir">Tanggal Akhir<span class="text-danger">*</span></label>
                                                                                            <input 
                                                                                                value="${row.cells[5].data}" 
                                                                                                x-model="tanggalAkhir" 
                                                                                                required 
                                                                                                id="tanggal_akhir" 
                                                                                                type="text" 
                                                                                                name="tanggal_akhir" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="alasan">Alasan</label>
                                                                                            <textarea id="alasan" rows="5" name="alasan" class="form-textarea" 
                                                                                                placeholder="Isi Alasan" required></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex justify-end items-center mt-8">
                                                                                <button type="button" class="btn btn-outline-danger"
                                                                                    @click="toggle1">Batal</button>
                                                                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Pindah</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- model berhenti -->
                                                    <div 
                                                        x-data="berhenti(false, '${row.cells[4].data}', '${row.cells[5].data}')" 
                                                        @open-berhenti.window="if ($event.detail.rowId === '${rowId}') toggle2()"
                                                        >
                                                        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                                                <div x-show="open" x-transition x-transition.duration.300
                                                                    class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                        <h5 class="font-bold text-lg">Berhenti Prakerin</h5>
                                                                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="w-6 h-6">
                                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                            </svg>
                                                                        </button>
                                                                    </div>

                                                                    <div class="p-5 pt-0 overflow-hidden max-h-[80vh] overflow-y-auto">
                                                                        <form action="{{ url('pkl') }}/${data}/berhenti" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="flex xl:flex-row flex-col gap-6">
                                                                                <div class="space-y-5 w-full px-0 flex-1">
                                                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                        <div>
                                                                                            <label for="siswa">Siswa<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[2].data}" required id="siswa" type="text" name="siswa" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="industri">Industri<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[3].data}" required id="industri" type="text" name="industri" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="tanggal_awal">Awal PKL<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[4].data}" required id="tanggal_awal" type="text" name="industri" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="tanggal_akhir">Akhir PKL<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[5].data}" required id="tanggal_akhir" type="text" name="industri" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="alasan">Alasan</label>
                                                                                            <textarea id="alasan" rows="5" name="alasan" class="form-textarea" 
                                                                                                placeholder="Isi Alasan" required></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex justify-end items-center mt-8">
                                                                                <button type="button" class="btn btn-outline-danger"
                                                                                    @click="toggle2">Batal</button>
                                                                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Berhenti</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- model lanjut-->
                                                    <div 
                                                        x-data="lanjut(false, '${row.cells[4].data}', '${row.cells[5].data}')" 
                                                        @open-lanjut.window="if ($event.detail.rowId === '${rowId}') toggle1()"
                                                        >
                                                        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                                                <div x-show="open" x-transition x-transition.duration.300
                                                                    class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                        <h5 class="font-bold text-lg">Pindah Industri</h5>
                                                                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                                                class="w-6 h-6">
                                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                    <div x-data="{rowc2: '${row.cells[11].data}'}"  class="p-5 pt-0 overflow-hidden max-h-[80vh] overflow-y-auto">

                                                                        <form action="{{ url('pkl') }}/${data}/lanjut" method="POST" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="flex xl:flex-row flex-col gap-6">
                                                                                <div class="space-y-5 w-full px-0 flex-1">
                                                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                        <div>
                                                                                            <label for="siswa">Siswa<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[2].data}" required id="siswa" type="text" name="siswa" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="kota1">Pilihan Kota 1<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[8].data}" required id="kota1" type="text" name="kota1" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="kota2">Pilihan Kota 2<span class="text-danger">*</span></label>
                                                                                            <input value="${row.cells[9].data}" required id="kota2" type="text" name="kota2" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="kota3">Pilihan Kota 3<span class="text-danger">*</span></label>
                                                                                            <input  value="${row.cells[10].data}" required id="kota3" type="text" name="kota3" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div x-data="{
                                                                                            pilihanKota: {
                                                                                                kota1: '${row.cells[8].data}',
                                                                                                kota2: '${row.cells[9].data}',
                                                                                                kota3: '${row.cells[10].data}'
                                                                                            },
                                                                                            filterIndustri(industri) {
                                                                                                return (
                                                                                                    industri.kota.nama === this.pilihanKota.kota1 ||
                                                                                                    industri.kota.nama === this.pilihanKota.kota2 ||
                                                                                                    industri.kota.nama === this.pilihanKota.kota3
                                                                                                );
                                                                                            }
                                                                                        }">
                                                                                            <label for="industri">Industri<span class="text-danger">*</span></label>
                                                                                            <select required id="industri_id" name="industri_id" class="selectize w-full industri-select" 
                                                                                                @change="updateDates($event.target.value)">
                                                                                                <option value="">Pilih Industri</option>
                                                                                                @foreach($industri as $item)
                                                                                                    <template x-if="filterIndustri({{ json_encode($item) }})">
                                                                                                        <option value="{{ $item->id }}" 
                                                                                                            data-tanggal-awal="{{ $item->tanggal_awal }}" 
                                                                                                            data-tanggal-akhir="{{ $item->tanggal_akhir }}"
                                                                                                            x-bind:selected="rowc2 === '{{ $item->id }}' ? true : false">
                                                                                                            {{ $item->nama . " (" . $item->kota->nama . ")" }} 
                                                                                                        </option>
                                                                                                    </template>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="tanggal_awal">Tanggal Awal<span class="text-danger">*</span></label>
                                                                                            <input 
                                                                                                value="${row.cells[4].data}" 
                                                                                                x-model="tanggalAwal" 
                                                                                                required 
                                                                                                id="tanggal_awal" 
                                                                                                type="text" 
                                                                                                name="tanggal_awal" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                        <div>
                                                                                            <label for="tanggal_akhir">Tanggal Akhir<span class="text-danger">*</span></label>
                                                                                            <input 
                                                                                                value="${row.cells[5].data}" 
                                                                                                x-model="tanggalAkhir" 
                                                                                                required 
                                                                                                id="tanggal_akhir" 
                                                                                                type="text" 
                                                                                                name="tanggal_akhir" 
                                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                                disabled />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex justify-end items-center mt-8">
                                                                                <button type="button" class="btn btn-outline-danger"
                                                                                    @click="toggle1">Batal</button>
                                                                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Lanjut</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                    },
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

                    setTableData() {
                        this.dataArr = this.items
                            .filter(item => {
                                // Jika selectedKelas tidak kosong, hanya tampilkan yang sesuai
                                return this.selectedIndustri === '' || item.industri === this.selectedIndustri;
                            })
                            .map(item => {
                                return Object.values(item); // Mengonversi setiap item ke array data
                            });

                        // this.dataArr = [];
                        // for (let i = 0; i < this.items.length; i++) {
                        //     this.dataArr[i] = [];
                        //     for (let p in this.items[i]) {
                        //         if (this.items[i].hasOwnProperty(p)) {
                        //             this.dataArr[i].push(this.items[i][p]);
                        //         }
                        //     }
                        // }
                        // this.dataArr = this.items
                        //     .filter(item => {
                        //         // Jika selectedKelas tidak kosong, hanya tampilkan yang sesuai
                        //         const kelasMatch = this.selectedKelas === '' || item.kelas === this.selectedKelas;

                        //         // Jika selectedIndustri tidak kosong, hanya tampilkan yang sesuai
                        //         const industriMatch = this.selectedIndustri === '' || item.industri === this.selectedIndustri;

                        //         // Mengembalikan true jika keduanya cocok
                        //         return kelasMatch && industriMatch;
                        //     })
                        //     .map(item => {
                        //         return Object.values(item); // Mengonversi setiap item ke array data
                        // });
                    },

                    searchInvoice() {
                        return this.items.filter((d) =>
                            (d.nama && d.nama.toLowerCase().includes(this.searchText)) ||
                            (d.kelas && d.kelas.toLowerCase().includes(this.searchText)) ||
                            (d.industri && d.industri.toLowerCase().includes(this.searchText)) ||
                            (d.tanggal_awal && d.tanggal_awal.toLowerCase().includes(this.searchText)) ||
                            (d.tanggal_akhir && d.tanggal_akhir.toLowerCase().includes(this.searchText)) ||
                            (d.sisa_waktu && d.sisa_waktu.toLowerCase().includes(this.searchText)) ||
                            (d.status && d.status.toLowerCase().includes(this.searchText))
                        );
                    },

                    refreshTable() {
                        this.datatable.destroy();
                        this.setTableData();
                        this.initializeTable();
                    },

                    filterByIndustri() {
                        this.refreshTable(); 
                    },

                    filterByKelas() {
                        // this.refreshTable(); 

                        if (this.selectedKelas) {
                            fetch(`{{ route('siswa.filterPkl') }}`, {
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
                                this.items = data; // Menyimpan data dari server
                                // this.refreshTable();  // Memperbarui tabel
                            })
                            .catch(error => console.error('Error fetching data:', error));
                        } else {
                            this.items = @json($items);
                        }
                    },
                }))
            })

            /*************
             * pindah 
             */

            document.addEventListener("alpine:init", () => {
                Alpine.data("detail", (initialOpenState = false, rowCells3Data = '', rowCells4Data = '') => ({
                    open: initialOpenState,
                    tanggalAwal: '',
                    tanggalAkhir: '',

                    toggle1() {
                        this.open = !this.open;

                        // Check if tanggalAwal and tanggalAkhir are empty, then set default values from row cells
                        if (!this.tanggalAwal) {
                            this.tanggalAwal = rowCells3Data;
                        }
                        if (!this.tanggalAkhir) {
                            this.tanggalAkhir = rowCells4Data;
                        }

                        // Alpine.nextTick(() => {
                        //     let selectElement = document.getElementById('industri_id');

                        //     if (selectElement && selectElement.nextElementSibling && selectElement.nextElementSibling.classList.contains('nice-select')) {
                        //         // Hapus elemen dropdown NiceSelect secara manual
                        //         selectElement.nextElementSibling.remove();
                        //         // Tampilkan kembali elemen select asli
                        //         selectElement.style.display = "inline-block";
                        //     }

                        //     var options = {
                        //         searchable: true
                        //     };
                        //     NiceSelect.bind(selectElement, options);
                        // });

                        if(this.open){
                            Alpine.nextTick(() => {
                                // Pilih semua elemen select dengan class industri-select
                                document.querySelectorAll('.industri-select').forEach(selectElement => {
                                    if (selectElement.nextElementSibling && selectElement.nextElementSibling.classList.contains('nice-select')) {
                                        // Hapus elemen dropdown NiceSelect secara manual jika sudah ada
                                        selectElement.nextElementSibling.remove();
                                        // Tampilkan kembali elemen select asli
                                        selectElement.style.display = "inline-block";
                                    }

                                    // Terapkan NiceSelect pada elemen yang dipilih
                                    var options = { searchable: true };
                                    NiceSelect.bind(selectElement, options);
                                });
                            });
                        } else {
                            Alpine.nextTick(() => {
                                // Pilih semua elemen select dengan class industri-select
                                document.querySelectorAll('.industri-select').forEach(selectElement => {
                                    if (selectElement.nextElementSibling && selectElement.nextElementSibling.classList.contains('nice-select')) {
                                        // Hapus elemen dropdown NiceSelect secara manual jika sudah ada
                                        selectElement.nextElementSibling.remove();
                                        // Tampilkan kembali elemen select asli
                                        selectElement.style.display = "inline-block";
                                    }
                                });
                            });
                        }
                    },

                    updateDates(industriId) {
                        const industriOption = document.querySelector(`#industri_id option[value="${industriId}"]`);
                        if (industriOption) {
                            this.tanggalAwal = industriOption.dataset.tanggalAwal;
                            this.tanggalAkhir = industriOption.dataset.tanggalAkhir;
                        } else {
                            this.tanggalAwal = rowCells3Data; // Revert to default if no industri selected
                            this.tanggalAkhir = rowCells4Data;
                        }
                    },
                    // init() {
                    //     console.log('halo')
                    //     // Reinitialize NiceSelect after Alpine component is initialized
                    //     Alpine.nextTick(() => {
                    //         NiceSelect.bind(document.getElementById("industri_id"), { searchable: true });
                    //     });
                    // }
                }));
            });
            

            /*************
             * berhenti 
             */

            document.addEventListener("alpine:init", () => {
                Alpine.data("berhenti", (initialOpenState = false) => ({
                    open: initialOpenState,

                    toggle2() {
                        this.open = !this.open;
                    },
                }));
            });

            /*************
             * lanjut 
             */

            document.addEventListener("alpine:init", () => {
                Alpine.data("lanjut", (initialOpenState = false, rowCells3Data = '', rowCells4Data = '') => ({
                    open: initialOpenState,
                    tanggalAwal: '',
                    tanggalAkhir: '',

                    toggle1() {
                        this.open = !this.open;

                        // Check if tanggalAwal and tanggalAkhir are empty, then set default values from row cells
                        if (!this.tanggalAwal) {
                            this.tanggalAwal = rowCells3Data;
                        }
                        if (!this.tanggalAkhir) {
                            this.tanggalAkhir = rowCells4Data;
                        }
                    },

                    updateDates(industriId) {
                        const industriOption = document.querySelector(`#industri_id option[value="${industriId}"]`);
                        if (industriOption) {
                            this.tanggalAwal = industriOption.dataset.tanggalAwal;
                            this.tanggalAkhir = industriOption.dataset.tanggalAkhir;
                        } else {
                            this.tanggalAwal = rowCells3Data; // Revert to default if no industri selected
                            this.tanggalAkhir = rowCells4Data;
                        }
                    },
                }));
            });
        </script>
    </x-layout.default>
@endif
