<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    <div x-data="dataList">
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
        foreach ($siswa as $d) {
            $items[] = [
                'nama' => $d->nama_lengkap ?? '-',
                'industri' => $d->penempatan->industri->nama ?? '-',
                'tanggal_awal' => $d->penempatan->industri->tanggal_awal ?? '-',
                'tanggal_akhir' => $d->penempatan->industri->tanggal_akhir ?? '-',
                'siswa_waktu' => $d->penempatan->sisa_waktu ?? '-',
                'status' => $d->penempatan->status ?? '-',
                'action' => $d->id ?? '-', 

                'kota1' => $d->pilihankota->kota1->nama ?? '-', 
                'kota2' => $d->pilihankota->kota2->nama ?? '-', 
                'kota3' => $d->pilihankota->kota3->nama ?? '-', 
                'industri_id' => $d->penempatan->industri->id ?? '-',
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
                                "Industri",
                                "Awal PKL",
                                "Akhir PKL",
                                "Sisa Waktu",
                                "Status",
                                "Aksi",

                                "X",
                                "X",
                                "X",
                                "X",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            {
                                select: [7,8,9,10],
                                hidden: true,
                            },
                            {
                                select: 6,
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
                                                        <li><a href="pkl/${data}">Detail</a></li>
                                                        <li><a href="#" @click="$dispatch('open-detail', { rowId: '${rowId}' })">Pindah</a></li>
                                                        <li><a href="#" @click="$dispatch('open-berhenti', { rowId: '${rowId}' })">Berhenti</a></li>
                                                        <li><a href="#" @click="$dispatch('open-lanjut', { rowId: '${rowId}' })">Lanjut</a></li>
                                                    </ul>
                                                </div>

                                                <!-- model pindah -->
                                                <div 
                                                    x-data="detail(false, '${row.cells[3].data}', '${row.cells[4].data}')" 
                                                    @open-detail.window="if ($event.detail.rowId === '${rowId}') toggle1()"
                                                    >
                                                    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                        <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                                            <div x-show="open" x-transition x-transition.duration.300
                                                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                    <h5 class="font-bold text-lg">Pindah Industri</h5>
                                                                    <button type="button" class="text-white-dark hover:text-dark" @click="toggle1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                                            class="w-6 h-6">
                                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <div x-data="{rowc2: '${row.cells[2].data}'}"  class="p-5 pt-0 overflow-hidden max-h-[80vh] overflow-y-auto">

                                                                    <form action="{{ url('pkl') }}/${data}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="flex xl:flex-row flex-col gap-6">
                                                                            <div class="space-y-5 w-full px-0 flex-1">
                                                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                    <div>
                                                                                        <label for="siswa">Siswa<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[1].data}" required id="siswa" type="text" name="siswa" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="kota1">Pilihan Kota 1<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[8].data}" required id="kota1" type="text" name="kota1" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="kota2">Pilihan Kota 2<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[9].data}" required id="kota2" type="text" name="kota2" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="kota3">Pilihan Kota 3<span class="text-danger">*</span></label>
                                                                                        <input  value="${row.cells[10].data}" required id="kota3" type="text" name="kota3" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div x-data="{
                                                                                        pilihanKota: {
                                                                                            kota1: '${row.cells[8].data}',
                                                                                            kota2: '${row.cells[9].data}',
                                                                                            kota3: '${row.cells[10].data}'
                                                                                        },
                                                                                        filterIndustri(industri) {
                                                                                            return (
                                                                                                industri.kota.nama === this.pilihanKota.kota1 ||
                                                                                                industri.kota.nama === this.pilihanKota.kota2 ||
                                                                                                industri.kota.nama === this.pilihanKota.kota3
                                                                                            );
                                                                                        }
                                                                                    }">
                                                                                        <label for="industri">Industri<span class="text-danger">*</span></label>
                                                                                        <select required id="industri_id" name="industri_id" class="form-select w-full" 
                                                                                            @change="updateDates($event.target.value)">
                                                                                            <option value="">Pilih Industri</option>
                                                                                            @foreach($industri as $item)
                                                                                                <template x-if="filterIndustri({{ json_encode($item) }})">
                                                                                                    <option value="{{ $item->id }}" 
                                                                                                        data-tanggal-awal="{{ $item->tanggal_awal }}" 
                                                                                                        data-tanggal-akhir="{{ $item->tanggal_akhir }}"
                                                                                                        x-bind:selected="rowc2 === '{{ $item->nama }}' ? true : false">
                                                                                                        {{ $item->nama . " (" . $item->kota->nama . ")" }} 
                                                                                                    </option>
                                                                                                </template>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="tanggal_awal">Tanggal Awal<span class="text-danger">*</span></label>
                                                                                        <input 
                                                                                            value="${row.cells[3].data}" 
                                                                                            x-model="tanggalAwal" 
                                                                                            required 
                                                                                            id="tanggal_awal" 
                                                                                            type="text" 
                                                                                            name="tanggal_awal" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="tanggal_akhir">Tanggal Akhir<span class="text-danger">*</span></label>
                                                                                        <input 
                                                                                            value="${row.cells[4].data}" 
                                                                                            x-model="tanggalAkhir" 
                                                                                            required 
                                                                                            id="tanggal_akhir" 
                                                                                            type="text" 
                                                                                            name="tanggal_akhir" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="alasan">Alasan</label>
                                                                                        <textarea id="alasan" rows="5" name="alasan" class="form-textarea" 
                                                                                            placeholder="Isi Alasan" required></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="flex justify-end items-center mt-8">
                                                                            <button type="button" class="btn btn-outline-danger" @click="toggle1">Discard</button>
                                                                            <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Pindah</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- model berhenti -->
                                                <div 
                                                    x-data="berhenti(false, '${row.cells[3].data}', '${row.cells[4].data}')" 
                                                    @open-berhenti.window="if ($event.detail.rowId === '${rowId}') toggle2()"
                                                    >
                                                    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                        <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                                            <div x-show="open" x-transition x-transition.duration.300
                                                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                    <h5 class="font-bold text-lg">Berhenti Prakerin</h5>
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
                                                                    <form action="{{ url('pkl') }}/${data}/berhenti" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="flex xl:flex-row flex-col gap-6">
                                                                            <div class="space-y-5 w-full px-0 flex-1">
                                                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                    <div>
                                                                                        <label for="siswa">Siswa<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[1].data}" required id="siswa" type="text" name="siswa" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="industri">Industri<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[2].data}" required id="industri" type="text" name="industri" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="tanggal_awal">Awal PKL<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[3].data}" required id="tanggal_awal" type="text" name="industri" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="tanggal_akhir">Akhir PKL<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[3].data}" required id="tanggal_akhir" type="text" name="industri" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="alasan">Alasan</label>
                                                                                        <textarea id="alasan" rows="5" name="alasan" class="form-textarea" 
                                                                                            placeholder="Isi Alasan" required></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex justify-end items-center mt-8">
                                                                            <button type="button" class="btn btn-outline-danger" @click="toggle2">Discard</button>
                                                                            <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Berhenti</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- model lanjut-->
                                                <div 
                                                    x-data="lanjut(false, '${row.cells[3].data}', '${row.cells[4].data}')" 
                                                    @open-lanjut.window="if ($event.detail.rowId === '${rowId}') toggle1()"
                                                    >
                                                    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden" :class="open && '!block'" style="text-wrap: wrap;">
                                                        <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                                            <div x-show="open" x-transition x-transition.duration.300
                                                                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-8">
                                                                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                    <h5 class="font-bold text-lg">Pindah Industri</h5>
                                                                    <button type="button" class="text-white-dark hover:text-dark" @click="toggle1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                                            class="w-6 h-6">
                                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <div x-data="{rowc2: '${row.cells[2].data}'}"  class="p-5 pt-0 overflow-hidden max-h-[80vh] overflow-y-auto">

                                                                    <form action="{{ url('pkl') }}/${data}/lanjut" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="flex xl:flex-row flex-col gap-6">
                                                                            <div class="space-y-5 w-full px-0 flex-1">
                                                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                    <div>
                                                                                        <label for="siswa">Siswa<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[1].data}" required id="siswa" type="text" name="siswa" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="kota1">Pilihan Kota 1<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[8].data}" required id="kota1" type="text" name="kota1" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="kota2">Pilihan Kota 2<span class="text-danger">*</span></label>
                                                                                        <input value="${row.cells[9].data}" required id="kota2" type="text" name="kota2" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="kota3">Pilihan Kota 3<span class="text-danger">*</span></label>
                                                                                        <input  value="${row.cells[10].data}" required id="kota3" type="text" name="kota3" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div x-data="{
                                                                                        pilihanKota: {
                                                                                            kota1: '${row.cells[8].data}',
                                                                                            kota2: '${row.cells[9].data}',
                                                                                            kota3: '${row.cells[10].data}'
                                                                                        },
                                                                                        filterIndustri(industri) {
                                                                                            return (
                                                                                                industri.kota.nama === this.pilihanKota.kota1 ||
                                                                                                industri.kota.nama === this.pilihanKota.kota2 ||
                                                                                                industri.kota.nama === this.pilihanKota.kota3
                                                                                            );
                                                                                        }
                                                                                    }">
                                                                                        <label for="industri">Industri<span class="text-danger">*</span></label>
                                                                                        <select required id="industri_id" name="industri_id" class="form-select w-full" 
                                                                                            @change="updateDates($event.target.value)">
                                                                                            <option value="">Pilih Industri</option>
                                                                                            @foreach($industri as $item)
                                                                                                <template x-if="filterIndustri({{ json_encode($item) }})">
                                                                                                    <option value="{{ $item->id }}" 
                                                                                                        data-tanggal-awal="{{ $item->tanggal_awal }}" 
                                                                                                        data-tanggal-akhir="{{ $item->tanggal_akhir }}"
                                                                                                        x-bind:selected="rowc2 === '{{ $item->nama }}' ? true : false">
                                                                                                        {{ $item->nama . " (" . $item->kota->nama . ")" }} 
                                                                                                    </option>
                                                                                                </template>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="tanggal_awal">Tanggal Awal<span class="text-danger">*</span></label>
                                                                                        <input 
                                                                                            value="${row.cells[3].data}" 
                                                                                            x-model="tanggalAwal" 
                                                                                            required 
                                                                                            id="tanggal_awal" 
                                                                                            type="text" 
                                                                                            name="tanggal_awal" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label for="tanggal_akhir">Tanggal Akhir<span class="text-danger">*</span></label>
                                                                                        <input 
                                                                                            value="${row.cells[4].data}" 
                                                                                            x-model="tanggalAkhir" 
                                                                                            required 
                                                                                            id="tanggal_akhir" 
                                                                                            type="text" 
                                                                                            name="tanggal_akhir" 
                                                                                            class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" 
                                                                                            disabled />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="flex justify-end items-center mt-8">
                                                                            <button type="button" class="btn btn-outline-danger" @click="toggle1">Discard</button>
                                                                            <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Lanjut</button>
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
         * pindah 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("detail", (initialOpenState = false, rowCells3Data = '', rowCells4Data = '') => ({
                open: initialOpenState,
                tanggalAwal: '',
                tanggalAkhir: '',

                toggle1() {
                    this.open = !this.open;

                    // Check if tanggalAwal and tanggalAkhir are empty, then set default values from row cells
                    if (!this.tanggalAwal) {
                        this.tanggalAwal = rowCells3Data;
                    }
                    if (!this.tanggalAkhir) {
                        this.tanggalAkhir = rowCells4Data;
                    }
                },

                updateDates(industriId) {
                    const industriOption = document.querySelector(`#industri_id option[value="${industriId}"]`);
                    if (industriOption) {
                        this.tanggalAwal = industriOption.dataset.tanggalAwal;
                        this.tanggalAkhir = industriOption.dataset.tanggalAkhir;
                    } else {
                        this.tanggalAwal = rowCells3Data; // Revert to default if no industri selected
                        this.tanggalAkhir = rowCells4Data;
                    }
                },
            }));
        });

        /*************
         * berhenti 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("berhenti", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle2() {
                    this.open = !this.open;
                },
            }));
        });

        /*************
         * lanjut 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("lanjut", (initialOpenState = false, rowCells3Data = '', rowCells4Data = '') => ({
                open: initialOpenState,
                tanggalAwal: '',
                tanggalAkhir: '',

                toggle1() {
                    this.open = !this.open;

                    // Check if tanggalAwal and tanggalAkhir are empty, then set default values from row cells
                    if (!this.tanggalAwal) {
                        this.tanggalAwal = rowCells3Data;
                    }
                    if (!this.tanggalAkhir) {
                        this.tanggalAkhir = rowCells4Data;
                    }
                },

                updateDates(industriId) {
                    const industriOption = document.querySelector(`#industri_id option[value="${industriId}"]`);
                    if (industriOption) {
                        this.tanggalAwal = industriOption.dataset.tanggalAwal;
                        this.tanggalAkhir = industriOption.dataset.tanggalAkhir;
                    } else {
                        this.tanggalAwal = rowCells3Data; // Revert to default if no industri selected
                        this.tanggalAkhir = rowCells4Data;
                    }
                },
            }));
        });
    </script>
</x-layout.default>