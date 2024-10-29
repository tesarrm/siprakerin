<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="/assets/js/nice-select2.js"></script>

    <style>
        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>
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


    <div class="panel">

            @if(
                !auth()->user()->hasRole('siswa') && 
                !auth()->user()->hasRole('wali_kelas') && 
                !auth()->user()->hasRole('koordinator')
                )

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
                        Jadwal Monitoring</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(1)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'hasil'}" @click="tab = 'hasil'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <circle cx="11.5" cy="11.5" r="9.5" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M18.5 18.5L22 22" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Hasil Monitoring</a>
                </li>
            </ul>
        </div>

        <div id="tab-content">
            <div class="tab-content show">

                <div x-data="invoiceList">

                    <div class="px-5">
                        <div class="md:absolute">
                            <div class="flex items-center gap-2 mb-5">
                                <div class="" style="width: 200px">
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

                    <div class="invoice-table">
                        <table id="myTable" class="whitespace-nowrap"></table>
                    </div>
                </div>

            </div>
            <div class="tab-content">

                @endif

                <div x-data="hasil">

                    @if(
                        !auth()->user()->hasRole('wali_kelas') &&
                        !auth()->user()->hasRole('siswa')
                    ) 
                    <div class="px-5">
                        <div class="md:absolute">
                            <div class="flex items-center gap-2 mb-5">

                                <div class="" style="width: 200px">
                                    <select id="filterKelas" x-model="selectedKelas" @change="filterByKelas" class="selectize">
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
                        <table id="table_hasil"></table>
                    </div>

                    @if(!auth()->user()->hasRole('siswa')) 
                        {{-- pagination max 250 --}}
                        @if($hasil->total() > 250)
                            <div id="pageplus" class="flex justify-center mt-4">
                                <ul class="flex items-center m-auto">
                                    {{-- Tombol halaman sebelumnya --}}
                                    <li>
                                        <a href="{{ $hasil->previousPageUrl() }}"  
                                            class="flex justify-center font-semibold ltr:rounded-l-full rtl:rounded-r-full px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180">
                                                <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </li>

                                    {{-- Tentukan batas halaman yang terlihat --}}
                                    @php
                                        $start = max(1, $hasil->currentPage() - 2);
                                        $end = min($hasil->lastPage(), $hasil->currentPage() + 2);
                                    @endphp

                                    {{-- Tampilkan halaman pertama jika tidak dalam rentang --}}
                                    @if ($start > 1)
                                        <li>
                                            <a href="{{ $hasil->url(1) }}"
                                            class="flex justify-center font-semibold px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                                1
                                            </a>
                                        </li>
                                        @if ($start > 2)
                                            <li><span class="px-3">...</span></li>
                                        @endif
                                    @endif

                                    {{-- Loop melalui halaman dalam rentang yang ditentukan --}}
                                    @for ($i = $start; $i <= $end; $i++)
                                        <li>
                                            <a href="{{ $hasil->url($i) }}"
                                            class="flex justify-center font-semibold px-3.5 py-2 transition 
                                                    {{ ($hasil->currentPage() == $i) ? 
                                                        'bg-primary text-white dark:text-white-light dark:bg-primary' : 
                                                        'bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary'
                                                    }}">
                                                {{ $i }}
                                            </a>
                                        </li>
                                    @endfor

                                    {{-- Tampilkan halaman terakhir jika tidak dalam rentang --}}
                                    @if ($end < $hasil->lastPage())
                                        @if ($end < $hasil->lastPage() - 1)
                                            <li>
                                                <div
                                                    class="flex justify-center font-semibold px-3.5 py-2 transition 
                                                        bg-white-light text-dark dark:text-white-light dark:bg-[#191e3a] 
                                                        ">
                                                    <span class="px-3 ">...</span>
                                                </div>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{ $hasil->url($hasil->lastPage()) }}"
                                            class="flex justify-center font-semibold px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                                {{ $hasil->lastPage() }}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Tombol halaman berikutnya --}}
                                    <li>
                                        <a href="{{ $hasil->nextPageUrl() }}" 
                                            class="flex justify-center font-semibold ltr:rounded-r-full rtl:rounded-l-full px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180">
                                                <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @endif

                </div>

                @if(
                    !auth()->user()->hasRole('siswa') && 
                    !auth()->user()->hasRole('wali_kelas') && 
                    !auth()->user()->hasRole('koordinator')
                    )

            </div>
        </div>

            @endif

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
        foreach ($data as $d) {
            $items[] = [
                'nama_guru' => $d->guru->user->name ?? '-',
                'nama_industri' => $d->industri->nama ?? '-',
                'tanggal' => $d->tanggal ?? '-',
                'status' => $d->status ?? '-',
                'action' => $d->id ?? '-',
            ];
        }
    @endphp

    {{-- data datatable hasil --}}
    @php
        $dHasil = [];

        if(
            auth()->user()->hasRole('wali_kelas') || 
            auth()->user()->hasRole('koordinator')
        ){
            foreach ($hasil as $d) {
                $dHasil[] = [
                    'nama' => $d->monitoring->guru->user->name?? '-',
                    'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                    'industri' => $d->siswa->penempatan->industri->nama?? '-',
                    'tanggal' => $d->monitoring->tanggal?? '-',
                    'hadir' => $d->hadir ?? '-',
                    'izin' => $d->izin ?? '-',
                    'alpa' => $d->alpa ?? '-',
                    'catatan' => $d->catatan ?? '-',
                ];
            }
        } else if (
            auth()->user()->hasRole('siswa') 
        ) {
            foreach ($hasil as $d) {
                $dHasil[] = [
                    'nama' => $d->monitoring->guru->user->name?? '-',
                    'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                    'industri' => $d->siswa->penempatan->industri->nama?? '-',
                    'tanggal' => $d->monitoring->tanggal?? '-',
                    'hadir' => $d->hadir ?? '-',
                    'izin' => $d->izin ?? '-',
                    'alpa' => $d->alpa ?? '-',
                    'catatan' => $d->catatan ?? '-',
                ];
            }
        } else {
            foreach ($hasil as $d) {
                $dHasil[] = [
                    'nama' => $d->siswa->user->name?? '-',
                    'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                    'industri' => $d->siswa->penempatan->industri->nama?? '-',
                    'tanggal' => $d->monitoring->tanggal?? '-',
                    'hadir' => $d->hadir ?? '-',
                    'izin' => $d->izin ?? '-',
                    'alpa' => $d->alpa ?? '-',
                    'catatan' => $d->catatan ?? '-',
                ];
            }
        }
    @endphp

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
         * datatable hasil
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('invoiceList', () => ({
                selectedRows: [],
                items: @json($items),
                searchText: '',
                selectedIndustri: '',
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
                                "Nama Guru",
                                "Nama Industri",
                                "Tanggal",
                                "Status",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100, 250],
                        columns: [
                            {
                                select: 1,
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
                                    if(data == 'Belum Monitoring'){
                                        return `
                                            <span class="badge bg-dark/20 text-dark rounded-full">
                                                ${data}
                                            </span>
                                        `;
                                    } else if(data == 'Sudah Monitoring'){
                                        return `
                                            <span class="badge bg-info/20 text-info rounded-full">
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
                                sortable: false,
                                render: function(data, cell, row) {
                                    return `<div class="flex gap-4 items-center">
                                                <a href="/hasilmonitoring/${data}/edit" class="hover:text-info">
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
                                                </a>`;
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
                            return this.selectedIndustri === '' || item.nama_industri === this.selectedIndustri;
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

                filterByIndustri() {
                    this.refreshTable(); 
                },

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.nama_industri && d.nama_industri.toLowerCase().includes(this.searchText)) ||
                        (d.tanggal && d.tanggal.toLowerCase().includes(this.searchText)) ||
                        (d.status && d.status.toLowerCase().includes(this.searchText))
                    );
                },
            }))
        })

        /*************
         * datatable 
         */

        let headings
        if(
            @json(auth()->user()->hasRole('wali_kelas')) || 
            @json(auth()->user()->hasRole('koordinator'))
        ){
            headings = [
                "Pemonitoring",
                "Kelas",
                "Industri",
                "Tanggal",
                "Hadir",
                "Izin",
                "Alpa",
                "Catatan",
            ];
        } else if (
            @json(auth()->user()->hasRole('siswa')) 
        ) {
            headings = [
                "Pemonitoring",
                "Kelas",
                "Industri",
                "Tanggal",
                "Hadir",
                "Izin",
                "Alpa",
                "Catatan",
            ];
        } else {
            headings = [
                "Nama Siswa",
                "Kelas",
                "Industri",
                "Tanggal",
                "Hadir",
                "Izin",
                "Alpa",
                "Catatan",
            ];
        }

        document.addEventListener("alpine:init", () => {
            Alpine.data('hasil', () => ({
                selectedRows: [],
                items: @json($dHasil),
                searchText: '',
                selectedKelas: '',
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
                    this.datatable = new simpleDatatables.DataTable('#table_hasil', {
                        data: {
                            headings: headings,
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            @if(auth()->user()->hasRole('siswa')) 
                            {
                                select: 1,
                                hidden: true,
                            },
                            @else
                            {
                                select: 1,
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
                            @endif
                            {
                                select: 2,
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
                                select: [4, 5, 6],
                                render: function(data, cell, row) {
                                    if(data != '-'){
                                        return `
                                            <span class="badge bg-[#e6e9ed] dark:bg-[#1b2e4b] text-[#6a6e73] dark:text-[#888ea8] rounded-full text-sm">
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
                                render: function(data, cell, row) {
                                    return `<div class="cell-content">${data}</div>`;
                                }
                            },
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
                            return Object.values(item); 
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
                        (d.nama && d.nama.toLowerCase().includes(this.searchText)) ||
                        (d.kelas && d.kelas.toLowerCase().includes(this.searchText)) ||
                        (d.hadir && d.hadir.toLowerCase().includes(this.searchText)) ||
                        (d.izin && d.izin.toLowerCase().includes(this.searchText)) ||
                        (d.alpa && d.alpa.toLowerCase().includes(this.searchText)) ||
                        (d.catatan && d.catatan.toLowerCase().includes(this.searchText))
                    );
                },
            }))
        })

        /*************
         * filter industri 
         */

        @if(!auth()->user()->hasRole('siswa'))
            @if(!auth()->user()->hasRole('koordinator'))
                document.addEventListener("DOMContentLoaded", function(e) {
                    var options = {
                        searchable: true
                    };
                    NiceSelect.bind(document.getElementById("filterIndustri"), options);
                });
            @endif

            /*************
             * filter kelas 
             */

            document.addEventListener("DOMContentLoaded", function(e) {
                var options = {
                    searchable: true
                };
                NiceSelect.bind(document.getElementById("filterKelas"), options);
            });
        @endif
    </script>
</x-layout.default>
