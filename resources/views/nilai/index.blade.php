@if(!auth()->user()->hasRole('siswa')) 
<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    @if(!auth()->user()->hasRole('wali_kelas')) 
    <div x-data="dataList">
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="invoice-table" style="word-wrap: word">
                <table id="myTable" class="whitespace-nowrap"></table>
            </div>
        </div>
    </div>
    @else
    <div x-data="dataInfo">
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="invoice-table" style="word-wrap: word">
                <table id="tableInfo" class="whitespace-nowrap"></table>
            </div>
        </div>
    </div>
    @endif

    {{-- =========================== --}}
    {{-- BOTTOM --}}
    {{-- =========================== --}}

    @if(!auth()->user()->hasRole('wali_kelas')) 
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
                    'nama' => $d->nama ?? '-',
                    'alamat' => $d->alamat ?? '-',
                    'kota' => $d->kota->nama ?? '-',
                    // 'tahun_ajaran' => $d->tahun_ajaran ?? '-',
                    'total_siswa' => $d->penempatan_industri_count?? '-',
                    'action' => $d->id ?? '-',
                ];
            }
        @endphp

        <script>
            /*************
             * datatable 
             */

            document.addEventListener("alpine:init", () => {
                Alpine.data('dataList', () => ({
                    selectedRows: [],
                    items: @json($items),
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
                        this.datatable = new simpleDatatables.DataTable('#myTable', {
                            data: {
                                headings: [
                                    "Nama Industri",
                                    "Alamat",
                                    "Kota",
                                    // "Tahun Ajaran",
                                    "Total Siswa",
                                    "Aksi",
                                ],
                                data: this.dataArr
                            },
                            perPage: 10,
                            perPageSelect: [10, 20, 30, 50, 100],
                            columns: [
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
                                    select: 4,
                                    sortable: false,
                                    render: function(data, cell, row) {
                                        return `<div class="flex gap-4 items-center">
                                                    <a href="/nilai/${data}/edit" class="hover:text-info">
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
                            (d.nama && d.nama.toLowerCase().includes(this.searchText))
                        );
                    },

                }))
            })
        </script>
    @else
        {{-- data datatable --}}
        @php
            $items = [];
            foreach ($nilai as $d) {
                $items[] = [
                    'nama' => $d->siswa->nama ?? '-',
                    'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                    'industri' => $d->siswa->penempatan->industri->nama ?? '-',
                    'action' => $d->siswa->id ?? '-',
                ];
            }
        @endphp

        <script>
            /*************
             * datatable 
             */

            document.addEventListener("alpine:init", () => {
                Alpine.data('dataInfo', () => ({
                    selectedRows: [],
                    items: @json($items),
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
                        this.datatable = new simpleDatatables.DataTable('#tableInfo', {
                            data: {
                                headings: [
                                    "Nama",
                                    "Kelas",
                                    "Industri",
                                    "Aksi",
                                ],
                                data: this.dataArr
                            },
                            perPage: 10,
                            perPageSelect: [10, 20, 30, 50, 100],
                            columns: [
                                {
                                    select: 3,
                                    sortable: false,
                                    render: function(data, cell, row) {
                                        return `<div class="flex gap-4 items-center">
                                                    <a href="/nilai/${data}/show" class="hover:text-info">
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
                            (d.nama && d.nama.toLowerCase().includes(this.searchText))
                        );
                    },

                }))
            })
        </script>
    @endif
</x-layout.default>

@else

<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    {{-- style tab --}}
    <style>
        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>

    <style>
        .ordered-list {
            list-style-type: none; /* Menghilangkan bullet default */
            padding-left: 0; /* Menghilangkan padding */
        }
        .ordered-list li {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Align input to the right */
            margin-bottom: 8px; /* Space between list items */
            gap: 5px;
        }
        .ordered-list li span {
            display: block; /* Setiap tujuan sebagai blok */
            padding-left: 20px; /* Indentasi kiri untuk tujuan */
            text-indent: -15px; /* Menggeser angka keluar */
            position: relative;
        }
        .ordered-list li span::before {
            content: '';
            position: absolute;
            left: 0;
            text-align: right;
        }
    </style>

    <div>
        <form action="{{ url('nilai') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6">
                    <div class=" px-4">
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="text-lg font-semibold">Penilaian Siswa</div>
                                <input value="{{ $industri->id }}" type="text" name="industri_id" class="hidden"/>
                                <div class="mt-4 flex items-center">
                                    <label for="industri" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Industri</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $industri->nama }}" id="industri" type="text" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center">
                                    <div class="text-lg font-semibold">Data Penilaian Siswa</div>
                                </div>
                                <div class="mt-4">

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
                                            <div x-data="form" x-init="initialize()">
                                                <table class="table-auto w-full">
                                                    <thead>
                                                        <tr>
                                                            <th class="px-4 py-5 hidden">ID Siswa</th>
                                                            <th class="px-4 py-5">Nama Siswa</th>
                                                            <th class="px-4 py-5 hidden">Jenis Kelamin</th>
                                                            <th class="px-4 py-5">Kelas</th>
                                                            <th class="px-4 py-5">Jurusan</th>
                                                            <th class="px-4 py-5">Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template x-for="(row, index) in tableData" :key="index">
                                                            <tr>
                                                                <td class="px-4 py-2 align-top hidden">
                                                                    <input type="text" :name="'data['+index+'][siswa_id]'" x-model="row.siswa_id" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                                </td>
                                                                <td class="px-4 py-2 align-top">
                                                                    <input type="text" x-model="row.nama" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                                </td>
                                                                <td class="px-4 py-2 align-top hidden">
                                                                    <input type="text" x-model="row.jenis_kelamin" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                                </td>
                                                                <td class="px-4 py-2 align-top">
                                                                    {{-- <input type="text" x-model="row.kelas" class="form-input w-full" style="border:none; padding: 0;" readonly /> --}}
                                                                    <span x-text="row.kelas" class="badge badge-outline-info text-sm"></span>
                                                                </td>
                                                                <td class="px-4 py-2 align-top">
                                                                    {{-- <input type="text" x-model="row.jurusan" class="form-input w-full" style="border:none; padding: 0;" readonly /> --}}
                                                                    <span x-text="row.jurusan" class="badge badge-outline-success text-sm"></span>
                                                                </td>
                                                                <td class="px-4 py-2 max-w-xl">
                                                                    <template x-for="(capaian, capaianIndex) in row.capaian" :key="capaianIndex">
                                                                        <div class="mb-4" style="line-height: 1.7;">
                                                                            <strong x-text="capaian.nama"></strong>
                                                                            <ol class="ordered-list">
                                                                                <template x-for="(tujuan, tujuanIndex) in capaian.tujuan" :key="tujuanIndex">
                                                                                    <li>
                                                                                        <span x-text="tujuanIndex + 1 + '. ' + tujuan.nama"></span>
                                                                                        <!-- Tambahkan hidden input untuk tujuan_pembelajaran_id -->
                                                                                        <input type="hidden" :name="'data['+index+'][capaian]['+capaianIndex+'][tujuan]['+tujuanIndex+'][id]'" :value="tujuan.id" />
                                                                                        <input type="number" :name="'data['+index+'][capaian]['+capaianIndex+'][tujuan]['+tujuanIndex+'][nilai]'" :value="tujuan.nilai" class="form-input inline w-24 ml-2 pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Nilai" />
                                                                                    </li>
                                                                                </template>
                                                                            </ol>
                                                                        </div>
                                                                    </template>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div x-data="form2" x-init="initialize()">
                                                <table class="table-auto w-full">
                                                    <thead>
                                                        <tr>
                                                            <th class="px-4 py-5 hidden">ID Siswa</th>
                                                            <th class="px-4 py-5">Nama Siswa</th>
                                                            <th class="px-4 py-5 hidden">Jenis Kelamin</th>
                                                            <th class="px-4 py-5">Kelas</th>
                                                            <th class="px-4 py-5">Jurusan</th>
                                                            <th class="px-4 py-5">Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template x-for="(row, index) in tableData" :key="index">
                                                            <tr>
                                                                <td class="px-4 py-2 align-top hidden">
                                                                    <input type="text" :name="'data['+index+'][siswa_id]'" x-model="row.siswa_id" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                                </td>
                                                                <td class="px-4 py-2 align-top">
                                                                    <input type="text" x-model="row.nama" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                                </td>
                                                                <td class="px-4 py-2 align-top hidden">
                                                                    <input type="text" x-model="row.jenis_kelamin" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                                </td>
                                                                <td class="px-4 py-2 align-top">
                                                                    {{-- <input type="text" x-model="row.kelas" class="form-input w-full" style="border:none; padding: 0;" readonly /> --}}
                                                                    <span x-text="row.kelas" class="badge badge-outline-info text-sm"></span>
                                                                </td>
                                                                <td class="px-4 py-2 align-top">
                                                                    {{-- <input type="text" x-model="row.jurusan" class="form-input w-full" style="border:none; padding: 0;" readonly /> --}}
                                                                    <span x-text="row.jurusan" class="badge badge-outline-success text-sm"></span>
                                                                </td>
                                                                <td class="px-4 py-2 max-w-xl">
                                                                    <template x-for="(capaian, capaianIndex) in row.capaian" :key="capaianIndex">
                                                                        <div class="mb-4" style="line-height: 1.7;">
                                                                            <strong x-text="capaian.nama"></strong>
                                                                            <ol class="ordered-list">
                                                                                <template x-for="(tujuan, tujuanIndex) in capaian.tujuan" :key="tujuanIndex">
                                                                                    <li>
                                                                                        <span x-text="tujuanIndex + 1 + '. ' + tujuan.nama"></span>
                                                                                        <!-- Tambahkan hidden input untuk tujuan_pembelajaran_id -->
                                                                                        <input type="hidden" :name="'data['+index+'][capaian]['+capaianIndex+'][tujuan]['+tujuanIndex+'][id]'" :value="tujuan.id" />
                                                                                        <input type="number" :name="'data['+index+'][capaian]['+capaianIndex+'][tujuan]['+tujuanIndex+'][nilai]'" :value="tujuan.nilai" class="form-input inline w-24 ml-2 pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Nilai" />
                                                                                    </li>
                                                                                </template>
                                                                            </ol>
                                                                        </div>
                                                                    </template>
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
                        </div>
                    </div>
                    {{-- <div class="mt-8 px-4">
                        <div class="flex justify-end items-center mt-8 gap-4">
                            <button type="submit" class="btn btn-success gap-2">
                                Simpan 
                            </button>
                            <button type="button" class="btn btn-outline-danger gap-2">
                                Kembali 
                            </button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </form>
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
         * datatable 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                tableData: @json($penempatan).map(penempatan => {
                    return {
                        siswa_id: penempatan.siswa.id,
                        nama: penempatan.siswa.nama_lengkap,
                        jenis_kelamin: penempatan.siswa.jenis_kelamin,
                        kelas: penempatan.siswa.kelas.nama + " " + penempatan.siswa.kelas.jurusan.singkatan + " " + penempatan.siswa.kelas.klasifikasi,
                        jurusan: penempatan.siswa.kelas.jurusan.nama,
                        capaian: penempatan.capaian ? penempatan.capaian : '',
                    }
                }),

                initialize() {
                    this.tableData.forEach((row, index) => {
                        this.$nextTick(() => {
                            let selectElement = document.querySelector(`select[name="data[${index}][id_siswa]"]`);
                            if (selectElement) {
                                selectElement.value = row.id_siswa;
                            }
                        });
                    });
                },
            }));
        });

        document.addEventListener("alpine:init", () => {
            Alpine.data("form2", () => ({
                tableData: @json($penempatan2).map(penempatan => {
                    return {
                        siswa_id: penempatan.siswa.id,
                        nama: penempatan.siswa.nama_lengkap,
                        jenis_kelamin: penempatan.siswa.jenis_kelamin,
                        kelas: penempatan.siswa.kelas.nama + " " + penempatan.siswa.kelas.jurusan.singkatan + " " + penempatan.siswa.kelas.klasifikasi,
                        jurusan: penempatan.siswa.kelas.jurusan.nama,
                        capaian: penempatan.capaian ? penempatan.capaian : '',
                    }
                }),

                initialize() {
                    this.tableData.forEach((row, index) => {
                        this.$nextTick(() => {
                            let selectElement = document.querySelector(`select[name="data[${index}][id_siswa]"]`);
                            if (selectElement) {
                                selectElement.value = row.id_siswa;
                            }
                        });
                    });
                },
            }));
        });
    </script>
</x-layout.default>
@endif