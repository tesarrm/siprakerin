<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

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
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
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
                                <div class="mt-4 flex items-center">
                                    <label for="penilaianke" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Penilaian</span></label>
                                    <div class="flex-1">
                                        <input value="Penilaian ke-{{ $urutan }}" id="penilaianke" type="text" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center">
                                    <div class="text-lg font-semibold">Data Penilaian Siswa</div>
                                </div>
                                <div class="mt-4">
                                    <div x-data="form" x-init="initialize()">
                                        <table class="table-auto w-full">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-5 hidden">ID Siswa</th>
                                                    <th class="px-4 py-5">Nama Siswa</th>
                                                    <th class="px-4 py-5">Jenis Kelamin</th>
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
                                                        <td class="px-4 py-2 align-top">
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
                                                                                <input type="number" :name="'data['+index+'][capaian]['+capaianIndex+'][tujuan]['+tujuanIndex+'][nilai]'" :value="tujuan.nilai" class="form-input inline w-24 ml-2" placeholder="Nilai" />
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
                    <div class="mt-8 px-4">
                        <div class="flex justify-end items-center mt-8 gap-4">
                            <button type="submit" class="btn btn-success gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                    <path
                                        d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path
                                        d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path opacity="0.5" d="M7 8H13" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                                Simpan </button>
                            <a href="{{url('nilai')}}" class="btn btn-outline-danger gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                    <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                        stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M17.5 9.50026H9.96155C8.04979 9.50026 6.5 11.05 6.5 12.9618C6.5 14.8736 8.04978 16.4233 9.96154 16.4233H14.5M17.5 9.50026L15.25 7.42334M17.5 9.50026L15.25 11.5772" 
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Kembali </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- =========================== --}}
    {{-- BOTTOM --}}
    {{-- =========================== --}}

    <script>
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
    </script>
</x-layout.default>
