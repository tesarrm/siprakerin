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
                                <div class="text-lg font-semibold">Penempatan Prakerin</div>
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
                                    <div class="text-lg font-semibold">Data Monitoring Siswa</div>
                                </div>
                                <div class="mt-4">
                                    <div x-data="form" x-init="initialize()">
                                        <table class="table-auto w-full">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-5">ID Siswa</th>
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
                                                        <td class="px-4 py-2 align-top">
                                                            <input type="text" :name="'data['+index+'][siswa_id]'" x-model="row.siswa_id" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2 align-top">
                                                            <input type="text" x-model="row.nama" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2 align-top">
                                                            <input type="text" x-model="row.jenis_kelamin" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2 align-top">
                                                            <input type="text" x-model="row.kelas" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2 align-top">
                                                            <input type="text" x-model="row.jurusan" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2 max-w-xl">
                                                            <template x-for="(capaian, capaianIndex) in row.capaian" :key="capaianIndex">
                                                                <div class="mb-4">
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
                                Simpan 
                            </button>
                            <button type="button" class="btn btn-outline-danger gap-2">
                                Kembali 
                            </button>
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
                        nama: penempatan.siswa.nama,
                        jenis_kelamin: penempatan.siswa.jenis_kelamin,
                        kelas: penempatan.siswa.kelas.nama + " " + penempatan.siswa.kelas.jurusan.singkatan,
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
