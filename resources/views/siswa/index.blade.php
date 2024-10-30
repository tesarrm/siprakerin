<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="/assets/js/nice-select2.js"></script>

    <div x-data="dataList">
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
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
                        <a href="/siswa/create" class="btn btn-primary gap-2">
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
                                        <li><a href="javascript:;" @click="$dispatch('open-modal')">Import</a></li>
                                        <li><a href="/siswa-export" @click="toggle">Export</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- isi modal --}}
                        <div x-data="modal" @open-modal.window="toggle">
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
                                            <form action="/siswa-import" method="POST" enctype="multipart/form-data">
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
                        {{-- select kelas --}}
                        <div style="width: 150px">
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
            <div class="invoice-table">
                <table id="myTable" class="whitespace-nowrap"></table>
            </div>

            {{-- pagination max 250 --}}
            @if($data->total() > 250)
                <div id="pageplus" class="flex justify-center mt-4">
                    <ul class="flex items-center m-auto">
                        {{-- Tombol halaman sebelumnya --}}
                        <li>
                            <a href="{{ $data->previousPageUrl() }}"  
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
                            $start = max(1, $data->currentPage() - 2);
                            $end = min($data->lastPage(), $data->currentPage() + 2);
                        @endphp

                        {{-- Tampilkan halaman pertama jika tidak dalam rentang --}}
                        @if ($start > 1)
                            <li>
                                <a href="{{ $data->url(1) }}"
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
                                <a href="{{ $data->url($i) }}"
                                class="flex justify-center font-semibold px-3.5 py-2 transition 
                                        {{ ($data->currentPage() == $i) ? 
                                            'bg-primary text-white dark:text-white-light dark:bg-primary' : 
                                            'bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary'
                                        }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor

                        {{-- Tampilkan halaman terakhir jika tidak dalam rentang --}}
                        @if ($end < $data->lastPage())
                            @if ($end < $data->lastPage() - 1)
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
                                <a href="{{ $data->url($data->lastPage()) }}"
                                class="flex justify-center font-semibold px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                    {{ $data->lastPage() }}
                                </a>
                            </li>
                        @endif

                        {{-- Tombol halaman berikutnya --}}
                        <li>
                            <a href="{{ $data->nextPageUrl() }}" 
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

    {{-- alert toast import excel error --}}
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const errors = @json($errors->all());
                displayAlerts(errors);
            });

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
        </script>
    @endif

    {{-- data datatable --}}
    @php
        $items = [];
        foreach ($data as $d) {
            $items[] = [
                'id' => $d->id ?? '-',
                'nama' => $d->user->name ?? '-',
                'nis' => $d->nis ?? '-',
                'email' => $d->user->email ?? '-',
                'jenis_kelamin' => $d->jenis_kelamin ?? '-',
                'agama' => $d->agama ?? '-',
                'kelas' => $d->kelas->nama . " " . $d->kelas->jurusan->singkatan . " " . $d->kelas->klasifikasi ?? '-',
                'tahun_ajaran' => $d->tahunAjaran->nama ?? '-',
                'gambar' => $d->user->gambar, 
                'action' => $d->id ?? '-', 

                '_user_id' => $d->user_id ?? '-', // 10
                '_kelas_id' => $d->kelas->nama ?? '-',
                '_aktif' => $d->aktif ?? '-',
                '_gambar' => $d->user->gambar,
                '_nis' => $d->nis ?? '-',
                '_nisn' => $d->nisn ?? '-',
                '_nama_lengkap' => $d->user->name ?? '-',
                '_nama' => $d->user->name ?? '-',
                '_tempat_lahir' => $d->tempat_lahir ?? '-',
                '_tanggal_lahir' => $d->tanggal_lahir ?? '-',
                '_jenis_kelamin' => $d->jenis_kelamin ?? '-', //20
                '_agama' => $d->agama ?? '-',
                '_alamat' => $d->alamat ?? '-',
                '_no_telp' => $d->no_telp ?? '-',
                '_email' => $d->user->email ?? '-',
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
         * filter kelas 
         */

        document.getElementById('filterKelas').addEventListener('change', function() {
            let selectedKelas = this.value;
            if(selectedKelas) {
                document.getElementById('pagePlus').style.display = 'none';
            } else {
                document.getElementById('pagePlus').style.display = 'flex';
            }
        });

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

        /*************
         * datatable 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('dataList', () => ({
                selectedRows: [],
                items: @json($items),
                searchText: '',
                selectedKelas: '', 
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
                                '<input type="checkbox" class="form-checkbox" :checked="checkAllCheckbox" :value="checkAllCheckbox" @change="checkAll($event.target.checked)"/>',
                                "Nama",
                                "NIS",
                                "Email",
                                "Jenis Kelamin",
                                "Agama",
                                "Kelas",
                                "Tahun Ajaran",
                                "Gambar",
                                "Aksi",

                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                                "X",
                            ],
                            data: this.dataArr
                        },
                        perPage: this.perPage || 10,
                        perPageSelect: [10, 20, 30, 50, 100, 250],
                        columns: [
                            {
                                select: [10, 11,12,13,14,15,16,17,18,19,20,21,22,23,24],
                                hidden: true,
                            },
                            {
                                select: 0,
                                sortable: false,
                                render: function(data, cell, row) {
                                    return `<input type="checkbox" class="form-checkbox mt-1" :id="'chk' + ${data}" :value="(${data})" x-model.number="selectedRows" />`;
                                }
                            },
                            {
                                select: 1,
                                render: function(data, cell, row) {
                                    const gambar = row.cells[8].data; 
                                    const id = row.cells[0].data; 
                                    const imageUrl = gambar ? `/storage/posts/${gambar}` : '/assets/images/blank_profile.png'; // Ganti dengan path gambar default

                                    return `<div class="flex items-center font-semibold">
                                                <div class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                                    <img class="h-8 w-8 rounded-full object-cover" src="${imageUrl}" alt="Profile Image"/>
                                                </div>
                                                <a href="/siswa/${id}/edit" class="hover:underline">${ data }</a>
                                            </div>`;
                                }
                            },
                            {
                                select: 3,
                                render: (data, cell, row) => {
                                    return `<a href="mailto:${data}" class="text-primary hover:underline">${ data }</a>`
                                },
                            },
                            {
                                select: 6,
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
                                select: 8,
                                hidden: true,
                            },
                            {
                                select: 9,
                                sortable: false,
                                render: function(data, cell, row) {
                                    const rowId = `row-${data}`; // Buat unique row ID berdasarkan data

                                    const gambar = row.cells[13].data; 
                                    const imageUrl = gambar ? `/storage/posts/${gambar}` : '/assets/images/blank_profile.png'; 

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
                                                        <li><a href="#" @click="$dispatch('open-detail', { rowId: '${rowId}' })">Detail</a></li>
                                                        <li><a href="/siswa/${data}/edit">Edit</a></li>
                                                        <li><a href="#" @click="resetPassword('${row.cells[10].data}')">Reset Password</a></li>
                                                        <li><a href="#" @click="nonaktif('${data}')">Nonaktifkan</a></li>
                                                        <li><a href="#" @click="deleteSingleRow('${data}')">Hapus</a></li>
                                                    </ul>
                                                </div>

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
                                                                <div class="p-5 pt-0 overflow-hidden max-h-[80vh] overflow-y-auto">
                                                                    <div class="flex xl:flex-row flex-col gap-6">
                                                                        <div class="xl:w-80 w-full xl:mt-0 mt-6">
                                                                            <div class="mb-4">
                                                                                <img src="${imageUrl}" alt="image"
                                                                                    class="xl:w-52 xl:h-52 w-60 h-60 rounded-full object-cover mx-auto border border-[#eee] border-4" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="space-y-5 w-full px-0 flex-1">
                                                                            <div class="text-lg font-semibold">Informasi Umum</div>
                                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                <div>
                                                                                    <label>NIS<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[14].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>NISN<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[15].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>Nama Lengkap<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[16].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>Nama<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[17].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>Jenis Kelamin<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[20].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>Kelas<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[5].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>Email<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[24].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-lg font-semibold pt-2">Detail</div>
                                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                <div>
                                                                                    <label>Tempat Lahir</label>
                                                                                    <input value="${row.cells[18].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>Tanggal Lahir</label>
                                                                                    <input value="${row.cells[19].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>Alamat</label>
                                                                                    <input value="${row.cells[22].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>No Telp</label>
                                                                                    <input value="${row.cells[23].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label>Agama</label>
                                                                                    <input value="${row.cells[21].data}" required type="text" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex justify-end items-center mt-8">
                                                                        <button type="button" class="btn btn-outline-danger"
                                                                            @click="toggle1">Batal</button>
                                                                        <a href="/guru/${data}/edit" class="btn btn-primary ltr:ml-4 rtl:mr-4"
                                                                            >Edit</a>
                                                                    </div>
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
                        (d.nis && d.nis.toLowerCase().includes(this.searchText)) ||
                        (d.nama && d.nama.toLowerCase().includes(this.searchText)) ||
                        (d.jenis_kelamin && d.jenis_kelamin.toLowerCase().includes(this.searchText)) ||
                        (d.agama && d.agama.toLowerCase().includes(this.searchText)) ||
                        (d.kelas && d.kelas.toLowerCase().includes(this.searchText)) ||
                        (d.tahun_ajaran && d.tahun_ajaran.toLowerCase().includes(this.searchText)) ||
                        (d.email && d.email.toLowerCase().includes(this.searchText)) ||
                        (d.gambar && d.gambar.toLowerCase().includes(this.searchText))
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
                                fetch('/siswa/delete-multiple', {
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
                            fetch(`/siswa/${id}/delete`, {
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
                            fetch(`/siswa/${id}/nonaktif`, {
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
                },

                filterByKelas() {
                    if(this.selectedKelas){
                        fetch(`{{ route('siswa.filter') }}`, {
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
                            this.refreshTable();  // Memperbarui tabel
                        })
                        .catch(error => console.error('Error fetching data:', error));
                    }else{
                        this.items = @json($items);
                    }
                },

                resetPassword(user_id) {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Apakah Anda yakin?',
                        text: "Data akan direset password!",
                        showCancelButton: true,
                        confirmButtonText: 'Reset',
                        cancelButtonText: 'Batal',
                        padding: '2em',
                        customClass: 'sweet-alerts'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/siswa/${user_id}/reset`, {
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
                                        title: 'Direset Password!',
                                        text: 'Data berhasil direset password.',
                                        icon: 'success',
                                        customClass: 'sweet-alerts'
                                    });
                                } else {
                                    window.Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat mereset password data.',
                                        icon: 'error',
                                        customClass: 'sweet-alerts'
                                    });
                                }
                            })
                            .catch(error => {
                                console.log(error)
                                window.Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat mereset password data.',
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
