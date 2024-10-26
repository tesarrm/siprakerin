<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>
    <style>
        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>

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
                            <circle cx="9" cy="6" r="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M12.5 4.3411C13.0375 3.53275 13.9565 3 15 3C16.6569 3 18 4.34315 18 6C18 7.65685 16.6569 9 15 9C13.9565 9 13.0375 8.46725 12.5 7.6589" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <ellipse cx="9" cy="17" rx="7" ry="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M18 14C19.7542 14.3847 21 15.3589 21 16.5C21 17.5293 19.9863 18.4229 18.5 18.8704" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Guru</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(1)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'kelas'}" @click="tab = 'kelas'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <path opacity="0.5" d="M3 12C3 15.7712 3 19.6569 4.31802 20.8284C5.63604 22 7.75736 22 12 22C16.2426 22 18.364 22 19.682 20.8284C21 19.6569 21 15.7712 21 12" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M14.6603 14.2019L20.8579 12.3426C21.2688 12.2194 21.4743 12.1577 21.6264 12.0355C21.7592 11.9288 21.8626 11.7898 21.9266 11.6319C22 11.4511 22 11.2366 22 10.8077C22 9.12027 22 8.27658 21.6703 7.63268C21.3834 7.07242 20.9276 6.61659 20.3673 6.32971C19.7234 6 18.8797 6 17.1923 6H6.80765C5.12027 6 4.27658 6 3.63268 6.32971C3.07242 6.61659 2.61659 7.07242 2.32971 7.63268C2 8.27658 2 9.12027 2 10.8077C2 11.2366 2 11.4511 2.07336 11.6319C2.13743 11.7898 2.24079 11.9288 2.37363 12.0355C2.52574 12.1577 2.73118 12.2194 3.14206 12.3426L9.33968 14.2019" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M14 12.5H10C9.72386 12.5 9.5 12.7239 9.5 13V15.1615C9.5 15.3659 9.62448 15.5498 9.8143 15.6257L10.5144 15.9058C11.4681 16.2872 12.5319 16.2872 13.4856 15.9058L14.1857 15.6257C14.3755 15.5498 14.5 15.3659 14.5 15.1615V13C14.5 12.7239 14.2761 12.5 14 12.5Z" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.5" d="M9.1709 4C9.58273 2.83481 10.694 2 12.0002 2C13.3064 2 14.4177 2.83481 14.8295 4" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Kelas</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(2)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'siswa'}" @click="tab = 'siswa'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <circle cx="9" cy="6" r="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M12.5 4.3411C13.0375 3.53275 13.9565 3 15 3C16.6569 3 18 4.34315 18 6C18 7.65685 16.6569 9 15 9C13.9565 9 13.0375 8.46725 12.5 7.6589" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <ellipse cx="9" cy="17" rx="7" ry="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M18 14C19.7542 14.3847 21 15.3589 21 16.5C21 17.5293 19.9863 18.4229 18.5 18.8704" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Siswa</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(3)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'industri'}" @click="tab = 'industri'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <path d="M22 22L2 22" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.5" d="M21 22V6C21 4.11438 21 3.17157 20.4143 2.58579C19.8285 2 18.8857 2 17 2H15C13.1144 2 12.1716 2 11.5858 2.58579C11.1143 3.05733 11.0223 3.76022 11.0044 5" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M15 22V9C15 7.11438 15 6.17157 14.4142 5.58579C13.8284 5 12.8856 5 11 5H7C5.11438 5 4.17157 5 3.58579 5.58579C3 6.17157 3 7.11438 3 9V22" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M9 22V19" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.5" d="M6 8H12" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.5" d="M6 11H12" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.5" d="M6 14H12" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Industri</a>
                </li>
            </ul>
        </div>
        <div id="tab-content">
            <div class="tab-content show">

                <div x-data="guru">
                    <div class="panel px-0 m-0 mt-[-20px] shadow-none">
                        <div class="px-5">
                            <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                <div class="flex items-center gap-2 mb-5">
                                    {{-- buttons --}}
                                </div>
                            </div>
                        </div>
                        <div class="invoice-table">
                            <table id="table_guru" class="whitespace-nowrap"></table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-content">
    
                <div x-data="kelas">
                    <div class="panel px-0 m-0 mt-[-20px] shadow-none">
                        <div class="px-5">
                            <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                <div class="flex items-center gap-2 mb-5">
                                    {{-- buttons --}}
                                </div>
                            </div>
                        </div>
                        <div class="invoice-table">
                            <table id="table_kelas" class="whitespace-nowrap"></table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-content">

                <div x-data="siswa">
                    <div class="panel px-0 m-0 mt-[-20px] shadow-none">
                        <div class="px-5">
                            <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                <div class="flex items-center gap-2 mb-5">
                                    {{-- buttons --}}
                                </div>
                            </div>
                        </div>
                        <div class="invoice-table">
                            <table id="table_siswa" class="whitespace-nowrap"></table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-content">

                <div x-data="industri">
                    <div class="panel px-0 m-0 mt-[-20px] shadow-none">
                        <div class="px-5">
                            <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                <div class="flex items-center gap-2 mb-5">
                                    {{-- buttons --}}
                                </div>
                            </div>
                        </div>
                        <div class="invoice-table">
                            <table id="table_industri" class="whitespace-nowrap"></table>
                        </div>
                    </div>
                </div>

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

    {{-- data untuk datatable --}}
    @php
        $dGuru = [];
        foreach ($guru as $d) {
            $dGuru[] = [
                'user_id' => $d->user_id ?? '-',
                'gambar' => $d->gambar, 
                'nama' => $d->nama ?? '-',
                'nip' => $d->nip ?? '-',
                'email' => $d->user->email ?? '-',
                'no_telp' => $d->no_telp ?? '-',
                'jenis_kelamin' => $d->jenis_kelamin ?? '-',
                'peran' => $d->user->peran ?? '-',
                'kelas' => optional($d->hoKelas)->nama 
                    ? optional($d->hoKelas)->nama . " " . optional($d->hoKelas->jurusan)->singkatan . " " . optional($d->hoKelas)->klasifikasi 
                    : '-',
                'action' => $d->id,
            ];
        }

        $dKelas = [];
        foreach ($kelas as $d) {
            $dKelas[] = [
                'nama' => $d->nama . " " . $d->jurusan->singkatan . " " . $d->klasifikasi ?? '-',
                'tahun_ajaran' => $d->tahun_ajaran ?? '-',
                'jurusan' => $d->jurusan->nama ?? '-',
                'bidang_keahlian' => $d->jurusan->bidangKeahlian->nama ?? '-',
                'klasifikasi' => $d->klasifikasi ?? '-',
                'guru' => $d->guru->nama ?? '-',
                'action' => $d->id, 
            ];
        }

        $dSiswa = [];
        foreach ($siswa as $d) {
            $dSiswa[] = [
                'nis' => $d->nis,
                'nama' => $d->nama_lengkap ?? '-',
                'jenis_kelamin' => $d->jenis_kelamin ?? '-',
                'agama' => $d->agama ?? '-',
                'kelas' => $d->kelas->nama . " " . $d->kelas->jurusan->singkatan . " " . $d->kelas->klasifikasi ?? '-',
                'tahun_ajaran' => $pengaturan->tahun_ajaran ?? '-',
                'email' => $d->user->email ?? '-',
                'gambar' => $d->gambar, 
                'action' => $d->id, 
            ];
        }

        $dIndustri = [];
        foreach ($industri as $d) {
            $dIndustri[] = [
                'nama' => $d->nama,
                'alamat' => $d->alamat,
                'kota' => $d->kota->nama,
                'action' => $d->id, 
            ];
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
         * datatable guru
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('guru', () => ({
                selectedRows: [],
                items: @json($dGuru),
                searchText: '',
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
                    this.datatable = new simpleDatatables.DataTable('#table_guru', {
                        data: {
                            headings: [
                                "User Id",
                                "Gambar",
                                "Nama",
                                "NIP",
                                "Email",
                                "No Telp",
                                "Jenis Kelamin",
                                "Peran",
                                "Kelas",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            {
                                select: 0,
                                hidden: true,
                            },
                            {
                                select: 1,
                                hidden: true,
                            },
                            {
                                select: 2,
                                render: function(data, cell, row) {
                                    const gambar = row.cells[1].data; 
                                    const imageUrl = gambar ? `/storage/posts/${gambar}` : '/storage/blank_profile.png'; // Ganti dengan path gambar default
                                    return `<div class="flex items-center font-semibold">
                                                <div class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                                    <img class="h-8 w-8 rounded-full object-cover" src="${imageUrl}" alt="Profile Image"/>
                                                </div>${data}
                                            </div>`;
                                }
                            },
                            {
                                select: 9,
                                render: function(data, cell, row) {
                                    return `<span class="badge badge-outline-dark" @click="aktifGuru('${data}')">Aktifkan</span>`;
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

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.invoice && d.invoice.toLowerCase().includes(this.searchText)) ||
                        (d.name && d.name.toLowerCase().includes(this.searchText)) ||
                        (d.email && d.email.toLowerCase().includes(this.searchText)) ||
                        (d.date && d.date.toLowerCase().includes(this.searchText)) ||
                        (d.amount && d.amount.toLowerCase().includes(this.searchText)) ||
                        (d.status && d.status.toLowerCase().includes(this.searchText))
                    );
                },

            }))
        })

        /*************
         * datatable kelas 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('kelas', () => ({
                selectedRows: [],
                items: @json($dKelas),
                searchText: '',
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
                    this.datatable = new simpleDatatables.DataTable('#table_kelas', {
                        data: {
                            headings: [
                                "Nama",
                                "Tahun Ajaran",
                                "Jurusan",
                                "Bidang Keahlian",
                                "Klasifikasi",
                                "Wali Kelas",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            {
                                select: 6,
                                render: function(data, cell, row) {
                                    return `<span class="badge badge-outline-dark" @click="aktifKelas('${data}')">Aktifkan</span>`;
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

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.invoice && d.invoice.toLowerCase().includes(this.searchText)) ||
                        (d.name && d.name.toLowerCase().includes(this.searchText)) ||
                        (d.email && d.email.toLowerCase().includes(this.searchText)) ||
                        (d.date && d.date.toLowerCase().includes(this.searchText)) ||
                        (d.amount && d.amount.toLowerCase().includes(this.searchText)) ||
                        (d.status && d.status.toLowerCase().includes(this.searchText))
                    );
                },
            }))
        })

        /*************
         * datatable siswa 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('siswa', () => ({
                selectedRows: [],
                items: @json($dSiswa),
                searchText: '',
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
                    this.datatable = new simpleDatatables.DataTable('#table_siswa', {
                        data: {
                            headings: [
                                "NIS",
                                "Nama",
                                "Jenis Kelamin",
                                "Agama",
                                "Kelas",
                                "Tahun Ajaran",
                                "Email",
                                "Gambar",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
          
                            {
                                select: 1,
                                render: function(data, cell, row) {
                                    const gambar = row.cells[7].data; 
                                    // const gambar = ''
                                    const imageUrl = gambar ? `/storage/posts/${gambar}` : '/storage/blank_profile.png'; // Ganti dengan path gambar default
                                    return `<div class="flex items-center font-semibold">
                                                <div class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                                    <img class="h-8 w-8 rounded-full object-cover" src="${imageUrl}" alt="Profile Image"/>
                                                </div>${data}
                                            </div>`;
                                }
                            },
                            {
                                select: 7,
                                hidden: true,
                            },
                            {
                                select: 8,
                                render: function(data, cell, row) {
                                    return `<span class="badge badge-outline-dark" @click="aktifSiswa('${data}')">Aktifkan</span>`;
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

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.invoice && d.invoice.toLowerCase().includes(this.searchText)) ||
                        (d.name && d.name.toLowerCase().includes(this.searchText)) ||
                        (d.email && d.email.toLowerCase().includes(this.searchText)) ||
                        (d.date && d.date.toLowerCase().includes(this.searchText)) ||
                        (d.amount && d.amount.toLowerCase().includes(this.searchText)) ||
                        (d.status && d.status.toLowerCase().includes(this.searchText))
                    );
                },
            }))
        })

        /*************
         * datatable industri 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('industri', () => ({
                selectedRows: [],
                items: @json($dIndustri),
                searchText: '',
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
                    this.datatable = new simpleDatatables.DataTable('#table_industri', {
                        data: {
                            headings: [
                                "Nama",
                                "Alamat",
                                "Kota",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            {
                                select: 3,
                                render: function(data, cell, row) {
                                    return `<span class="badge badge-outline-dark" @click="aktifIndustri('${data}')">Aktifkan</span>`;
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

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.invoice && d.invoice.toLowerCase().includes(this.searchText)) ||
                        (d.name && d.name.toLowerCase().includes(this.searchText)) ||
                        (d.email && d.email.toLowerCase().includes(this.searchText)) ||
                        (d.date && d.date.toLowerCase().includes(this.searchText)) ||
                        (d.amount && d.amount.toLowerCase().includes(this.searchText)) ||
                        (d.status && d.status.toLowerCase().includes(this.searchText))
                    );
                },
            }))
        })

        /*************
         * aktif guru 
         */

        function aktifGuru(id) {
            window.Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: "Data akan diaktifkan!",
                showCancelButton: true,
                confirmButtonText: 'Aktifkan',
                cancelButtonText: 'Batal',
                padding: '2em',
                customClass: 'sweet-alerts'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/guru/${id}/aktif`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.Swal.fire({
                                title: 'Diaktifkan!',
                                text: 'Data berhasil diaktifkan.',
                                icon: 'success',
                                customClass: 'sweet-alerts'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            window.Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mengaktifkan data.',
                                icon: 'error',
                                customClass: 'sweet-alerts'
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        window.Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengaktifkan data.',
                            icon: 'error',
                            customClass: 'sweet-alerts'
                        });
                    });
                }
            });
        }

        /*************
         * aktif kelas 
         */

        function aktifKelas(id) {
            window.Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: "Data akan diaktifkan!",
                showCancelButton: true,
                confirmButtonText: 'Aktifkan',
                cancelButtonText: 'Batal',
                padding: '2em',
                customClass: 'sweet-alerts'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/kelas/${id}/aktif`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.Swal.fire({
                                title: 'Diaktifkan!',
                                text: 'Data berhasil diaktifkan.',
                                icon: 'success',
                                customClass: 'sweet-alerts'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            window.Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mengaktifkan data.',
                                icon: 'error',
                                customClass: 'sweet-alerts'
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        window.Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengaktifkan data.',
                            icon: 'error',
                            customClass: 'sweet-alerts'
                        });
                    });
                }
            });
        }

        /*************
         * aktif siswa 
         */

        function aktifSiswa(id) {
            window.Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: "Data akan diaktifkan!",
                showCancelButton: true,
                confirmButtonText: 'Aktifkan',
                cancelButtonText: 'Batal',
                padding: '2em',
                customClass: 'sweet-alerts'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/siswa/${id}/aktif`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.Swal.fire({
                                title: 'Diaktifkan!',
                                text: 'Data berhasil diaktifkan.',
                                icon: 'success',
                                customClass: 'sweet-alerts'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            window.Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mengaktifkan data.',
                                icon: 'error',
                                customClass: 'sweet-alerts'
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        window.Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengaktifkan data.',
                            icon: 'error',
                            customClass: 'sweet-alerts'
                        });
                    });
                }
            });
        }

        /*************
         * aktif industri 
         */

        function aktifIndustri(id) {
            window.Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: "Data akan diaktifkan!",
                showCancelButton: true,
                confirmButtonText: 'Aktifkan',
                cancelButtonText: 'Batal',
                padding: '2em',
                customClass: 'sweet-alerts'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/industri/${id}/aktif`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.Swal.fire({
                                title: 'Diaktifkan!',
                                text: 'Data berhasil diaktifkan.',
                                icon: 'success',
                                customClass: 'sweet-alerts'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            window.Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mengaktifkan data.',
                                icon: 'error',
                                customClass: 'sweet-alerts'
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        window.Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengaktifkan data.',
                            icon: 'error',
                            customClass: 'sweet-alerts'
                        });
                    });
                }
            });
        }
    </script>
</x-layout.default>
