<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>

    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="/assets/js/nice-select2.js"></script>

    <div x-data="invoiceList">
        <script src="/assets/js/simple-datatables.js"></script>

        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="px-5">
                <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                    <div class="flex items-center gap-2 mb-5">

                        {{-- <div class="" style="width: 150px">
                            <select id="filterKelas" x-model="selectedKelas" @change="filterByKelas" class="form-input">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $item)
                                    <option value="{{ $item->nama . ' ' . $item->klasifikasi }}">
                                        {{ $item->nama . ' ' . $item->klasifikasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

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

                        {{-- isi modal --}}
                        <div x-data="modal" @open-modal.window="toggle">
                            <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
                                <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                    <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-sm my-8">
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
                                            <form action="/guru-import" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div>
                                                    <label for="ctnFile">Unduh Template</label>
                                                    <button type="button" class="btn btn-danger">
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
                                                    </button>
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
            <div class="invoice-table">
                <table id="myTable" class="whitespace-nowrap"></table>
            </div>
        </div>
    </div>

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
    $items = [];
    foreach ($data as $d) {
        $items[] = [
            'siswa' => $d['siswa']->user->name,
            'kelas' => $d['siswa']->kelas->nama . " " . $d['siswa']->kelas->jurusan->singkatan . " " . $d['siswa']->kelas->klasifikasi,
            'kota_1' => $d['kota1'],
            'kota_2' => $d['kota2'],
            'kota_3' => $d['kota3'],
            'status' => $d['status'],
            'action' => $d['siswa']->id, // Gunakan ID ini untuk aksi
        ];
    }
    @endphp

    {{-- script untuk datatable --}}
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('invoiceList', () => ({
                selectedRows: [],
                items: @json($items),
                searchText: '',
                selectedKelas: '', // Tambahkan untuk pilihan kelas
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
                                "Siswa",
                                "Kelas",
                                "Pilihan 1",
                                "Pilihan 2",
                                "Pilihan 3",
                                "Status",
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
                                select: 5,
                                render: function(data, cell, row) {
                                    if(data == 'on'){
                                        return `
                                            <span class="badge bg-success/20 text-success rounded-full">
                                                Confirm 
                                            </span>
                                        `;
                                    } else {
                                        return `
                                            <span class="badge bg-dark/20 text-dark rounded-full">
                                                Proses 
                                            </span>
                                        `;
                                    }
                                }
                            },
                            {
                                select: 6,
                                sortable: false,
                                render: function(data, cell, row) {
                                    return `<div class="flex gap-4 items-center">
                                                <button @click="unconfirm('${data}')" class="hover:text-danger">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" 
                                                        fill="none" xmlns="http://www.w3.org/2000/svg" 
                                                        class="w-5 h-5">

                                                        <circle opacity="0.5" cx="12" cy="12"
                                                            r="10" stroke="currentColor"
                                                            stroke-width="1.5" />
                                                        <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" />
                                                    </svg>
                                                </button>
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

                refreshTable() {
                    this.datatable.destroy();
                    this.setTableData();
                    this.initializeTable();
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

                // setTableData() {
                //     this.dataArr = this.items
                //         .filter(item => {
                //             // Jika selectedKelas tidak kosong, hanya tampilkan yang sesuai
                //             return this.selectedKelas === '' || item.kelas === this.selectedKelas;
                //         })
                //         .map(item => {
                //             return Object.values(item); // Mengonversi setiap item ke array data
                //         });
                // },

                filterByKelas() {
                    this.refreshTable(); // Muat ulang tabel ketika filter berubah
                },

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.siswa && d.siswa.toLowerCase().includes(this.searchText)) ||
                        (d.kelas && d.kelas.toLowerCase().includes(this.searchText)) ||
                        (d.kota_1 && d.kota_1.toLowerCase().includes(this.searchText)) ||
                        (d.kota_2 && d.kota_2.toLowerCase().includes(this.searchText)) ||
                        (d.kota_3 && d.kota_3.toLowerCase().includes(this.searchText)) ||
                        (d.status && d.status.toLowerCase().includes(this.searchText))
                    );
                },

                filterByKelas() {
                    if(this.selectedKelas){
                        fetch(`{{ route('pilihankota.filter') }}`, {
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
                    }else{
                        this.items = @json($items);
                    }
                },

                unconfirm(id) {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Apakah Anda yakin?',
                        text: "Data akan diunconfirm!",
                        showCancelButton: true,
                        confirmButtonText: 'Unconfirm',
                        cancelButtonText: 'Batal',
                        padding: '2em',
                        customClass: 'sweet-alerts'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/siswa/${id}/unconfirm`, {
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
                                        text: 'Data berhasil diunconfirm.',
                                        icon: 'success',
                                        customClass: 'sweet-alerts'
                                    });
                                    this.items = this.items.filter(item => item.id != id);
                                } else {
                                    window.Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat unconfirm data.',
                                        icon: 'error',
                                        customClass: 'sweet-alerts'
                                    });
                                }
                            })
                            .catch(error => {
                                console.log(error)
                                window.Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat unconfirm data.',
                                    icon: 'error',
                                    customClass: 'sweet-alerts'
                                });
                            });
                        }
                    });
                },
            }))
        })

        /*************
         * filter kelas 
         */

        document.addEventListener("DOMContentLoaded", function(e) {
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("filterKelas"), options);
        });

    </script>
</x-layout.default>
