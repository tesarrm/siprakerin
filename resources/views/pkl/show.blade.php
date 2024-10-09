<x-layout.default>
    <style>
        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script src="/assets/js/simple-datatables.js"></script>


    <div>
        <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-5">
            <div class="panel">
                <div class="mb-5">
                    <div class="flex flex-col justify-center items-center">
                        <img src="{{ $siswa->gambar ? asset('storage/posts/' . $siswa->gambar) : asset('storage/blank_profile.png') }}" 
                            alt="image" class="w-24 h-24 rounded-full object-cover mb-5" />
                        <p class="font-semibold text-primary text-xl">{{ $siswa->nama_lengkap }}</p>
                    </div>
                        <ul class="mt-5 flex flex-col space-y-4 font-semibold text-white-dark">
                            <li class="border-b pb-2">
                                <div class="flex justify-between">
                                    <div class="w-full">NIS</div>
                                    <div class="w-full items-end text-end">{{$siswa->nis}}</div>
                                </div>
                            </li>
                            <li class="border-b pb-2">
                                <div class="flex justify-between">
                                    <div class="w-full">Jenis Kelamin</div>
                                    <div class="w-full items-end text-end">{{$siswa->jenis_kelamin}}</div>
                                </div>
                            </li>
                            <li class="border-b pb-2">
                                <div class="flex justify-between">
                                    <div class="w-full">Kelas</div>
                                    <div class="w-full items-end text-end">{{$siswa->kelas->nama . " " . $siswa->kelas->jurusan->singkatan . " " . $siswa->kelas->klasifikasi}}</div>
                                </div>
                            </li>
                            <li class="border-b pb-2">
                                <div class="flex justify-between">
                                    <div class="w-full">Tahun Ajaran</div>
                                    <div class="w-full items-end text-end">{{$siswa->kelas->tahun_ajaran}}</div>
                                </div>
                            </li>
                            <li class="border-b pb-2">
                                <div class="flex justify-between">
                                    <div class="w-full">Email</div>
                                    <div class="w-full items-end text-end">{{$siswa->user->email}}</div>
                                </div>
                            </li>
                            <li class="border-b pb-2">
                                <div class="flex justify-between">
                                    <div class="w-full">No Telp</div>
                                    <div class="w-full items-end text-end">{{$siswa->no_telp}}</div>
                                </div>
                            </li>
                            <li class="border-b pb-2">
                                <div class="flex justify-between">
                                    <div class="w-full">Industri</div>
                                    <div class="w-full items-end text-end">{{$siswa->penempatan->industri->nama}}</div>
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

    {{-- tab --}}
    <script>
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
    </script>
    <script>
        let calendar;

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 400,
                events: function(fetchInfo, successCallback, failureCallback) {
                    // Ambil data dari endpoint backend (Laravel)
                    fetch('/attendance-data')
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
    </script>

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

    <script>
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
