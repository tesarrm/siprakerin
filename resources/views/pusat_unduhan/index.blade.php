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
                            <path d="M20 7L4 7" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.7" d="M15 12L4 12" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.4" d="M9 17H4" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        List </a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(1)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'kelas'}" @click="tab = 'kelas'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <path d="M12 22H15C18.866 22 22 18.866 22 15V12C22 7.28595 22 4.92893 20.5355 3.46447C19.0711 2 16.714 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355C4.92893 22 7.28595 22 12 22Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M15 22C15 20.1387 15 19.2081 15.2447 18.4549C15.7393 16.9327 16.9327 15.7393 18.4549 15.2447C19.2081 15 20.1387 15 22 15" 
                                stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        Card</a>
                </li>
            </ul>
        </div>
        <div id="tab-content">
            <div class="tab-content show">

                <div x-data="dataList">
                    <div class="px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
                        <div class="px-5">
                            <div class="md:absolute">
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
                                    <a href="/pusatunduhan/create" class="btn btn-primary gap-2">
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

            </div>
            <div class="tab-content">

                <form action="{{url('pusatunduhan/download')}}" method="POST">
                    @csrf
                    <div class="pt-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mb-6 text-white">

                            @if(!empty($data))
                                @foreach($data as $d)
                                    <div
                                        class="w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                                        <div class="py-7 px-6">
                                            <div class="-mt-7 mb-7 -mx-6 rounded-tl rounded-tr h-[215px] overflow-hidden">

                                                {{-- Tentukan gambar berdasarkan ekstensi file --}}
                                                @php
                                                    $extension = pathinfo($d->file, PATHINFO_EXTENSION);
                                                    $imageSrc = match ($extension) {
                                                        'pdf' => '/assets/images/pdf-file.png',
                                                        'doc', 'docx' => '/assets/images/office-word.png',
                                                        'xls', 'xlsx' => '/assets/images/office-excel.png',
                                                        default => '/assets/images/other-file.png',
                                                    };
                                                @endphp

                                                <img src="{{ $imageSrc }}" alt="file image" class="w-full h-full object-cover" />
                                            </div>
                                            <h5 class="text-[#3b3f5c] text-xl font-semibold mb-4 dark:text-white-light">
                                                {{ $d->nama }}
                                            </h5>
                                            <input class="hidden" type="text" name="file" value="{{ $d->file }}">
                                            <button type="submit" class="btn btn-primary mt-6">
                                                Unduh
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-black dark:text-white text-center">Dokumen tidak ada!</div>
                            @endif

                        </div>
                    </div>
                </form>

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
                'nama' => $d->nama ?? '-',
                'action' => $d->id ?? '-', 
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
                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            headings: [
                                '<input type="checkbox" class="form-checkbox" :checked="checkAllCheckbox" :value="checkAllCheckbox" @change="checkAll($event.target.checked)"/>',
                                "Nama",
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
                                    return `<a href="/pusatunduhan/${id}/edit" class="hover:underline">${ data }</a>`;
                                }
                            },
                            {
                                select: 2,
                                sortable: false,
                                render: function(data, cell, row) {
                                    return `<div class="flex gap-4 items-center">
                                                <a href="/pusatunduhan/${data}/edit" class="hover:text-info">
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
                                                <a href="#" class="hover:text-danger" @click="deleteSingleRow('${data}')">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                                        <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                        <path
                                                            d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                        ></path>
                                                        <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                        <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                        <path
                                                            opacity="0.5"
                                                            d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
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
                        (d.nama && d.nama.toLowerCase().includes(this.searchText))
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
                                fetch('/pusatunduhan/delete-multiple', {
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
                            fetch(`/pusatunduhan/${id}/delete`, {
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
    </script>

</x-layout.default>