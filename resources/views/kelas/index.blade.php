<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

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
                        <a href="/kelas/create" class="btn btn-primary gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="w-5 h-5">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Tambah </a>
                    </div>
                </div>
            </div>
            <div class="invoice-table">
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
        foreach ($data as $d) {
            $items[] = [
                'id' => $d->id ?? '-',
                'nama' => $d->nama . " " . $d->jurusan->singkatan . " " . $d->klasifikasi ?? '-',
                'klasifikasi' => $d->klasifikasi ?? '-',
                'jurusan' => $d->jurusan->nama ?? '-',
                'sub_jurusan' => $d->jurusan2->nama ?? '-',
                'guru' => $d->guru->user->name?? '-',
                'action' => $d->id ?? '-', 
            ];
        }
    @endphp

    <script>
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
                    // console.log(this.dataArr ? this.dataArr.length - 1: 99)
                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            headings: [
                                '<input type="checkbox" class="form-checkbox" :checked="checkAllCheckbox" :value="checkAllCheckbox" @change="checkAll($event.target.checked)"/>',
                                "Nama",
                                "Klasifikasi",
                                "Jurusan",
                                "Sub Jurusan",
                                "Wali Kelas",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: this.perPage || 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
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
                                    return `<a href="/kelas/${id}/edit" class="hover:underline">${ data }</a>`;
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
                                render: function(data, cell, row) {
                                    if(data != '-'){
                                        return `
                                            <span class="badge badge-outline-success text-sm">
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
                                select: 5,
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
                                                        <li><a href="/kelas/${data}/edit">Edit</a></li>
                                                        <li><a href="#" @click="nonaktif('${data}')">Nonaktifkan</a></li>
                                                        <li><a href="#" @click="deleteSingleRow('${data}')">Hapus</a></li>
                                                    </ul>
                                                </div>

                                                <div x-data="detail" @open-detail.window="if ($event.detail.rowId === '${rowId}') toggle1()">
                                                    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                        <div class="flex items-start justify-center min-h-screen px-4"
                                                            @click.self="open = false">
                                                            <div x-show="open" x-transition x-transition.duration.300
                                                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-xl my-8">
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
                                                                        <div class="space-y-5 w-full px-0 flex-1">
                                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                <div>
                                                                                    <label for="nama">Kelas<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[14]?.data}" required id="nama" type="text" name="nama" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[14]?.data}" required id="tahun_ajaran" type="text" name="tahun_ajaran" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label for="jurusan_id">Jurusan<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[19]?.data}" required id="jurusan_id" type="text" name="jurusan_id" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label for="klasifikasi">Klasifikasi<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[8]?.data}" required id="klasifikasi" type="text" name="klasifikasi" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                                <div>
                                                                                    <label for="guru_id">Wali Kelas<span class="text-danger">*</span></label>
                                                                                    <input value="${row.cells[5]?.data}" required id="guru_id" type="text" name="guru_id" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex justify-end items-center mt-8">
                                                                        <button type="button" class="btn btn-outline-danger"
                                                                            @click="toggle1">Discard</button>
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
                        (d.nama && d.nama.toLowerCase().includes(this.searchText)) ||
                        (d.tahun_ajaran && d.tahun_ajaran.toLowerCase().includes(this.searchText)) ||
                        (d.jurusan && d.jurusan.toLowerCase().includes(this.searchText)) ||
                        (d.bidang_keahlian && d.bidang_keahlian.toLowerCase().includes(this.searchText)) ||
                        (d.klasifikasi && d.klasifikasi.toLowerCase().includes(this.searchText)) ||
                        (d.guru && d.guru.toLowerCase().includes(this.searchText))
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
                                fetch('/kelas/delete-multiple', {
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
                            fetch(`/kelas/${id}/delete`, {
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

        function nonaktif(id) {
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
                    fetch(`/kelas/${id}/nonaktif`, {
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
                            }).then(() => {
                                location.reload();
                            });
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
    </script>
</x-layout.default>
