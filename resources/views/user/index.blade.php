
<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    <div x-data="dataList">
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
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

    {{-- data datatable --}}
    @php
        $items = [];
        foreach ($data as $d) {
            $items[] = [
                'nama' => $d->name,
                'email' => $d->email,
                'peran' => $d->peran,
                'action' => $d->id, // Gunakan ID ini untuk aksi
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
                                "Nama",
                                "Email",
                                "Peran",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100, 250],
                        columns: [
                            {
                                select: 1,
                                render: (data, cell, row) => {
                                    return `<a href="mailto:${data}" class="text-primary hover:underline">${ data }</a>`
                                },
                            },
                            {
                                select: 2,
                                render: function(data, cell, row) {
                                    const roles = row.cells[2].data.split(', '); 

                                    // Urutan prioritas roles
                                    const roleOrder = [
                                        'admin', 
                                        'koordinator', 
                                        'pembimbing', 
                                        'wali_kelas', 
                                        'siswa', 
                                        'guru',

                                        'karyawan',
                                        'industri',
                                        'wali_siswa',
                                    ];

                                    // Mengurutkan roles berdasarkan urutan pada roleOrder
                                    const sortedRoles = roles.sort((a, b) => {
                                        return roleOrder.indexOf(a) - roleOrder.indexOf(b);
                                    });

                                    let badges = ''; 

                                    sortedRoles.forEach(element => {
                                        let badgeClass = '';

                                        switch (element) {
                                            case 'admin':
                                                badgeClass = 'badge bg-primary/20 text-primary rounded-full'; 
                                                break;
                                            case 'koordinator':
                                                badgeClass = 'badge bg-primary/20 text-primary rounded-full'; 
                                                break;
                                            case 'pembimbing':
                                                badgeClass = 'badge bg-info/20 text-info rounded-full'; 
                                                break;
                                            case 'wali_kelas':
                                                badgeClass = 'badge bg-info/20 text-info rounded-full'; 
                                                break;
                                            case 'siswa':
                                                badgeClass = 'badge bg-success/20 text-success rounded-ful';
                                                break;
                                            case 'guru':
                                                badgeClass = 'badge bg-success/20 text-success rounded-ful';
                                                break;
                                            case 'karyawan':
                                                badgeClass = 'badge bg-secondary/20 text-secondary rounded-ful';
                                                break;
                                            case 'industri':
                                                badgeClass = 'badge bg-secondary/20 text-secondary rounded-ful';
                                                break;
                                            case 'wali_siswa':
                                                badgeClass = 'badge bg-danger/20 text-danger rounded-ful';
                                                break;
                                            default:
                                                badgeClass = 'badge bg-dark/20 text-dark rounded-fu'; 
                                        }

                                        badges += `
                                            <span class="badge ${badgeClass} rounded-full">
                                                ${element}
                                            </span>
                                        `;
                                    });

                                    return badges; // Mengembalikan string badge yang dibangun
                                }
                            },
                            {
                                select: 3,
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
                                                        <li><a href="#" @click="$dispatch('open-detail', { rowId: '${rowId}' })">Detail</a></li>
                                                        <li><a href="#"  @click="$dispatch('open-berhenti', { rowId: '${rowId}' })">Edit Role</a></li>
                                                        <li><a href="#">Reset Password</a></li>
                                                    </ul>
                                                </div>

                                                <div 
                                                    x-data="{
                                                        roles: '${row.cells[2].data}'.split(', '),
                                                        isChecked(role) {
                                                            return this.roles.includes(role);
                                                        },
                                                        toggle2() {
                                                            this.open = !this.open;
                                                        },
                                                        open: false
                                                    }" 
                                                    @open-berhenti.window="if ($event.detail.rowId === '${rowId}') toggle2()"
                                                >
                                                    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                        <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                                            <div x-show="open" x-transition x-transition.duration.300
                                                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-xl my-8">
                                                                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                    <h5 class="font-bold text-lg">Edit Role</h5>
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
                                                                    <form action="{{ url('user') }}/${data}/role" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="flex xl:flex-row flex-col gap-6">
                                                                            <div class="space-y-5 w-full px-0 flex-1">
                                                                                <div class="grid grid-cols-2 mt-3 gap-4">
                                                                                    <div>
                                                                                        <input name="admin" type="checkbox" class="form-checkbox" :checked="isChecked('admin')" />Admin
                                                                                    </div>
                                                                                    <div>
                                                                                        <input name="koordinator" type="checkbox" class="form-checkbox" :checked="isChecked('koordinator')" />Koordinator
                                                                                    </div>
                                                                                    <div>
                                                                                        <input name="pembimbing" type="checkbox" class="form-checkbox" :checked="isChecked('pembimbing')" />Pembimbing 
                                                                                    </div>
                                                                                    <div>
                                                                                        <input name="wali_kelas" type="checkbox" class="form-checkbox" :checked="isChecked('wali_kelas')" />Wali Kelas
                                                                                    </div>
                                                                                    <div>
                                                                                        <input name="guru" type="checkbox" class="form-checkbox" :checked="isChecked('guru')" />Guru
                                                                                    </div>
                                                                                    <div>
                                                                                        <input name="siswa" type="checkbox" class="form-checkbox" :checked="isChecked('siswa')" />Siswa
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex justify-end items-center mt-8">
                                                                            <button type="button" class="btn btn-outline-danger" @click="toggle2">Batal</button>
                                                                            <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Ubah</button>
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
                        (d.email && d.email.toLowerCase().includes(this.searchText)) ||
                        (d.peran && d.peran.toLowerCase().includes(this.searchText))
                    );
                },

            }))
        })

        /*************
         * modal 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("berhenti", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle2() {
                    this.open = !this.open;
                },
            }));
        });
    </script>

</x-layout.default>
