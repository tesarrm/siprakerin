
<x-layout.default>

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>

    <div x-data="dataList">
        <script src="/assets/js/simple-datatables.js"></script>

        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="invoice-table" style="word-wrap: word">
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
        // foreach ($data as $d) {
        //     $items[] = [
        //         'nama' => $d->nama ?? '-',
        //         'guru_id' => $d->id ?? '-',
        //         'industri' => $d->industri == "" ? '-' : $d->industri,
        //         'action' => $d->id ?? '-',
        //     ];
        // }
        foreach ($data as $d) {
            $industriCount = $d->industri ? count(explode(',', $d->industri)) : 0;
            
            $items[] = [
                'nama' => $d->nama ?? '-',
                'guru_id' => $d->id ?? '-',
                'industri_count' => $industriCount,
                'action' => $d->id ?? '-',
                'industri' => $d->industri == "" ? '-' : $d->industri,
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
                                "Nama",
                                "Guru Id",
                                "Total Industri",
                                "Aksi",
                                "Industri",
                            ],
                            data: this.dataArr
                        },
                        perPage: this.perPage || 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            {
                                select: [1, 4], 
                                hidden: true,
                            },
                            {
                                select: 2,
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
                                select: 3,
                                sortable: false,
                                render: function(data, cell, row) {
                                    const rowId = `row-${data}`; 

                                    // isi row.cells[3].data =  '2, 3, 4, 5'
                                    // isinya adalah id industri yang berelasi dengan guru 
                                    // const industri = row.cells[2].data.split(', ')
                                    // console.log(industri);

                                    // console.log(row.cells[2].data)

                                    return `<div class="flex gap-4 items-center">
                                                <a href="#" @click="$dispatch('open-detail', { rowId: '${rowId}' })" class="hover:text-info">
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

                                                <!-- model pindah -->
                                                <div 
                                                    x-data="detail(false)" 
                                                    @open-detail.window="if ($event.detail.rowId === '${rowId}') toggle1()"
                                                    >
                                                    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                        <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                                            <div x-show="open" x-transition x-transition.duration.300
                                                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-xl my-8">
                                                                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                    <h5 class="font-bold text-lg">Pembimbing Industri</h5>
                                                                    <button type="button" class="text-white-dark hover:text-dark" @click="toggle1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                                            class="w-6 h-6">
                                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <div class="p-5 pt-0 overflow-hidden max-h-[80vh] overflow-y-auto">

                                                                    <form action="{{ url('guruindustri/${row.cells[1].data}/industri') }}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div>
                                                                            <label for="guru">Guru<span class="text-danger">*</span></label>
                                                                            <input value="${row.cells[0].data}" required id="guru" type="text" name="guru"
                                                                                class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed"
                                                                                disabled />
                                                                        </div>
                                                                        
                                                                        <div x-data="{
                                                                                industriList: '${row.cells[4].data}'.split(', '), // Inisialisasi industri
                                                                                addIndustri() {
                                                                                    this.industriList.push(''); // Tambah input baru
                                                                                },
                                                                                removeIndustri(index) {
                                                                                    this.industriList.splice(index, 1); // Hapus input
                                                                                }
                                                                            }">
                                                                            <div class="space-y-4">
                                                                                <label for="industri" style="margin-bottom: -10px;" class="mt-3">Industri<span class="text-danger">*</span></label>
                                                                                <template x-for="(industri, index) in industriList" :key="index">
                                                                                    <div class="flex gap-2 items-center">
                                                                                        <select x-model="industriList[index]" name="industri_id[]" class="form-select w-full" required>
                                                                                            <option value="">Pilih Industri</option>
                                                                                            @foreach($industri as $item)
                                                                                                <option value="{{ $item->id }}" :selected="industri == '{{ $item->id }}'">{{ $item->nama }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <button 
                                                                                            type="button" 
                                                                                            @click="removeIndustri(index)" 
                                                                                            x-tooltip="Hapus" 
                                                                                            x-show="industriList.length > 1"
                                                                                        >
                                                                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                                                                fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                                                class="w-5 h-5 text-danger">
                                                                                                <circle opacity="0.5" cx="12" cy="12"
                                                                                                    r="10" stroke="currentColor"
                                                                                                    stroke-width="1.5" />
                                                                                                <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                                                                                    stroke="currentColor" stroke-width="1.5"
                                                                                                    stroke-linecap="round" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </div>
                                                                                </template>
                                                                            </div>
                                                                            <div class="mt-4">
                                                                                <button 
                                                                                    type="button" 
                                                                                    @click="addIndustri()" 
                                                                                    x-tooltip="Tambah" 
                                                                                    class="btn btn-outline-info btn-sm"
                                                                                >
                                                                                    Tambah
                                                                                </button>
                                                                            </div>
                                                                            <div class="flex justify-end items-center mt-8">
                                                                                <button type="button" class="btn btn-outline-danger"
                                                                                    @click="toggle1">Batal</button>
                                                                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Ubah</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                        (d.bidang_keahlian && d.bidang_keahlian.toLowerCase().includes(this.searchText))
                    );
                },
            }))
        })

        document.addEventListener("alpine:init", () => {
            Alpine.data("detail", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle1() {
                    this.open = !this.open;
                },
            }));
        });
    </script>

</x-layout.default>
