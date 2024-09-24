
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
                        <path opacity="0.5"
                            d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                            stroke="currentColor" stroke-width="1.5" />
                        <path d="M12 15L12 18" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" />
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
                        <circle cx="12" cy="6" r="4"
                            stroke="currentColor" stroke-width="1.5" />
                        <ellipse opacity="0.5" cx="12" cy="17" rx="7"
                            ry="4" stroke="currentColor" stroke-width="1.5" />
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
                        <circle cx="12" cy="6" r="4"
                            stroke="currentColor" stroke-width="1.5" />
                        <ellipse opacity="0.5" cx="12" cy="17" rx="7"
                            ry="4" stroke="currentColor" stroke-width="1.5" />
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
                        <circle cx="12" cy="6" r="4"
                            stroke="currentColor" stroke-width="1.5" />
                        <ellipse opacity="0.5" cx="12" cy="17" rx="7"
                            ry="4" stroke="currentColor" stroke-width="1.5" />
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
        </div>
    </div>
</div>

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
            'kelas' => $d->hoKelas->nama ?? '-',
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
            'nama' => $d->nama ?? '-',
            'jenis_kelamin' => $d->jenis_kelamin ?? '-',
            'agama' => $d->agama ?? '-',
            'kelas' => $d->kelas->nama ?? '-',
            'tahun_ajaran' => $pengaturan->tahun_ajaran ?? '-',
            'email' => $d->user->email ?? '-',
            'gambar' => $d->gambar, 
            'action' => $d->id, 
        ];
    }

    @endphp

    {{-- script untuk datatable --}}
    <script>
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
