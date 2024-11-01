<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    <div x-data="dataList">
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">

            @if(
                auth()->user()->hasRole('wali_siswa') ||
                auth()->user()->hasRole('guru')
            )
            @else
                <div class="px-5">
                    <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                        <div class="flex items-center gap-2 mb-5">
                            <button type="button" class="btn btn-danger gap-2" @click="deleteRow()">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                    <path
                                        d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                    <path opacity="0.5"
                                        d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                                Hapus </button>
                            <a href="/industri/create" class="btn btn-primary gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-5 h-5">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Tambah </a>
                            {{-- menu dropdown --}}
                            <div class="relative inline-flex align-middle flex-col items-start justify-center">
                                <div class="relative">
                                    <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                                        <button type="button" class="btn dropdown-toggle btn-outline-dark"
                                            @click="toggle">Menu

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4 ltr:ml-2 rtl:mr-2 inline-block shrink-0">
                                                <path d="M19 9L12 15L5 9" stroke="currentColor" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                            class="ltr:right-0 rtl:left-0 whitespace-nowrap">
                                            {{-- <li><a href="javascript:;" @click="$dispatch('open-modal')">Import</a></li> --}}
                                            <li><a href="javascript:;" @click="$dispatch('open-modal', { type: 'import' })">Import</a></li>
                                            <li><a href="javascript:;" @click="$dispatch('open-modal', { type: 'import-kuota' })">Import dengan Kuota</a></li>
                                            <li><a href="/siswa-export" @click="toggle">Export</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- isi modal --}}
                            <div x-data="modal" @open-modal.window="event.detail.type === 'import' ? open = true : open = false">
                                <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
                                    <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-md my-8">
                                            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                <h5 class="font-bold text-lg">Impor Excel</h5>
                                                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="w-6 h-6">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="p-5">
                                                <form action="/industri-import" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div>
                                                        <label for="ctnFile">Unduh Template</label>
                                                        <a href="{{ url('siswa-template')}}" class="flex max-w-max btn btn-danger">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                                                <path opacity="0.5"
                                                                    d="M3 15C3 17.8284 3 19.2426 3.87868 20.1213C4.75736 21 6.17157 21 9 21H15C17.8284 21 19.2426 21 20.1213 20.1213C21 19.2426 21 17.8284 21 15"
                                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path d="M12 3V16M12 16L16 11.625M12 16L8 11.625" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                            &nbsp;&nbsp;Excel
                                                        </a>
                                                        <span class="text-white-dark text-xs">Jangan ubah bagian header!</span>
                                                    </div>
                                                    <div class="mt-6">
                                                        <label for="ctnFile">Impor Excel</label>
                                                        <input id="ctnFile" type="file" name="excel" class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary" required />
                                                    </div>
                                                    <div class="flex justify-end items-center mt-8">
                                                        <button type="button" class="btn btn-outline-danger" @click="toggle">Discard</button>
                                                        <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle">Impor</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- isi modal --}}
                            {{-- <div x-data="modal" @open-modal.window="toggle"> --}}
                            <div x-data="modal" @open-modal.window="event.detail.type === 'import-kuota' ? open = true : open = false">
                                <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
                                    <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                        <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-md my-8">
                                            <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                <h5 class="font-bold text-lg">Impor Excel</h5>
                                                <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                        class="w-6 h-6">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="p-5">
                                                <form action="/industrikuota-import" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div>
                                                        <label for="ctnFile">Unduh Template</label>
                                                        <a href="{{ url('siswa-template')}}" class="flex max-w-max btn btn-danger">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                                                <path opacity="0.5"
                                                                    d="M3 15C3 17.8284 3 19.2426 3.87868 20.1213C4.75736 21 6.17157 21 9 21H15C17.8284 21 19.2426 21 20.1213 20.1213C21 19.2426 21 17.8284 21 15"
                                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path d="M12 3V16M12 16L16 11.625M12 16L8 11.625" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                            &nbsp;&nbsp;Excel
                                                        </a>
                                                        <span class="text-white-dark text-xs">Jangan ubah bagian header!</span>
                                                    </div>
                                                    <div class="mt-6">
                                                        <label for="ctnFile">Impor Excel</label>
                                                        <input id="ctnFile" type="file" name="excel" class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary" required />
                                                    </div>
                                                    <div class="flex justify-end items-center mt-8">
                                                        <button type="button" class="btn btn-outline-danger" @click="toggle">Discard</button>
                                                        <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle">Impor</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="invoice-table">
                <table id="myTable" class="whitespace-nowrap"></table>
            </div>

            {{-- pagination max 100 --}}
            @if($data->total() > 100)
                <div id="pageplus" class="flex justify-center mt-3">
                    <ul class="flex items-center m-auto">
                        <li>
                            <a href="{{ $data->previouspageurl() }}"  
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
                        @for ($i = 1; $i <= $data->lastpage(); $i++)
                            <li>
                                <a href="{{ $data->url($i) }}"
                                    class="flex justify-center font-semibold px-3.5 py-2 transition 
                                        {{ ($data->currentpage() == $i) ? 
                                            'bg-primary text-white dark:text-white-light dark:bg-primary' : 
                                            'bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary'
                                        }}">{{ $i * 100 }}</a>
                            </li>
                        @endfor
                        <li>
                            <a href="{{ $data->nextpageurl() }}" 
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

        /*************
         * excel alert 
         */

        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function () {
                const errors = @json($errors->all());
                displayAlerts(errors);
            });

            console.log(@json($errors->all()));

            async function displayAlerts(errors) {
                for (const error of errors) {
                    await showAlert(error);
                }
            }

            async function showAlert(message) {
                const toast = window.Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });

                await toast.fire({
                    icon: 'error',
                    title: message,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
            }
        @endif
        
        /*************
         * datatable 
         */

        @if(
            auth()->user()->hasRole('wali_siswa') ||
            auth()->user()->hasRole('guru')
        )
            @php
                $items = [];
                foreach ($data as $d) {
                    $items[] = [
                        'nama' => $d->nama ?? '-',
                        'alamat' => $d->alamat ?? '-',
                        'kota' => $d->kota->nama ?? '-',
                    ];
                }
            @endphp

            let headings = [
                "Nama",
                "Alamat",
                "Kota",
            ]

            let columns = [
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
            ]
        @else
            @php
                $items = [];
                foreach ($data as $d) {
                    $items[] = [
                        'id' => $d->id ?? '-',
                        'nama' => $d->nama ?? '-',
                        'alamat' => $d->alamat ?? '-',
                        'kota' => $d->kota->nama ?? '-',
                        'action' => $d->id ?? '-',
                    ];
                }
            @endphp

            let headings = [
                '<input type="checkbox" class="form-checkbox" :checked="checkAllCheckbox" :value="checkAllCheckbox" @change="checkAll($event.target.checked)"/>',
                "Nama",
                "Alamat",
                "Kota",
                "Aksi",
            ]

            let columns = [
                {
                    select: 0,
                    sortable: false,
                    render: function(data, cell, row) {
                        return `<input type="checkbox" class="form-checkbox mt-1" :id="'chk' + ${data}" :value="(${data})" x-model.number="selectedRows" />`;
                    }
                },
                {
                    select: 1,
                    sortable: false,
                    render: function(data, cell, row) {
                        const id = row.cells[0].data; 
                        return `<a href="/industri/${id}/edit" class="hover:underline">${ data }</a>`;
                    }
                },
                {
                    select: 3,
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
                    select: 4,
                    sortable: false,
                    render: function(data, cell, row) {
                        const rowId = `row-${data}`; // Buat unique row ID berdasarkan data

                        const gambar = row.cells[13]?.data; 
                        const imageUrl = gambar ? `/storage/posts/${gambar}` : '/storage/blank_profile.png'; 

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
                                            <li><a href="/industri/${data}/edit">Edit</a></li>
                                            <li><a href="#" @click="nonaktif('${data}')">Nonaktifkan</a></li>
                                            <li><a href="#" @click="deleteSingleRow('${data}')">Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>`;
                    },
                }
            ]
        @endif

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
                        this.refreshTable();
                    });
                    this.$watch('selectedRows', value => {
                        this.refreshTable();
                    });
                },

                initializeTable() {
                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            headings: headings,
                            data: this.dataArr
                        },
                        perPage: this.perPage || 10,
                        perPageSelect: [10, 20, 30, 50, 100],
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

                    this.perPage = this.datatable.options.perPage;
                },

                refreshTable() {
                    this.perPage = this.datatable.options.perPageSelect.find(select => select == this.datatable.options.perPage) || 10; 

                    this.datatable.destroy();
                    this.setTableData();
                    this.initializeTable();
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

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.nama && d.nama.toLowerCase().includes(this.searchText)) ||
                        (d.alamat && d.alamat.toLowerCase().includes(this.searchText)) ||
                        (d.kota && d.kota.toLowerCase().includes(this.searchText)) ||
                        (d.tahun_ajaran && d.tahun_ajaran.toLowerCase().includes(this.searchText))
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
                                fetch('/industri/delete-multiple', {
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
                            fetch(`/industri/${id}/delete`, {
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
                },

                nonaktif(id) {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Apakah Anda yakin?',
                        text: "Data akan dinonaktifkan!",
                        showCancelButton: true,
                        confirmButtonText: 'Nonaktif',
                        cancelButtonText: 'Batal',
                        padding: '2em',
                        customClass: 'sweet-alerts'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/industri/${id}/nonaktif`, {
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
                                        title: 'Dinonaktifkan!',
                                        text: 'Data berhasil dinonaktifkan.',
                                        icon: 'success',
                                        customClass: 'sweet-alerts'
                                    });
                                    this.items = this.items.filter(item => item.id != id);
                                } else {
                                    window.Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat menonaktifkan data.',
                                        icon: 'error',
                                        customClass: 'sweet-alerts'
                                    });
                                }
                            })
                            .catch(error => {
                                console.log(error)
                                window.Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menonaktifkan data.',
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
         * detail
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("modal", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle() {
                    this.open = !this.open;
                },
            }));
        });
    </script>
</x-layout.default>
