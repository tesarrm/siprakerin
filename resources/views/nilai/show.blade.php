<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    {{-- style tab --}}
    <style>
        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>

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
                                <div class="mt-6 flex items-center">
                                    <div class="text-lg font-semibold">Data Monitoring Siswa</div>
                                </div>
                                <div class="mt-4">

                                    <div id="tabs" x-data="{ tab: 'jadwal'}">
                                        <ul class="flex flex-wrap mb-5 border-b border-white-light dark:border-[#191e3a]">
                                            <li class="tab active">
                                                <a href="javascript:;"
                                                    class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-secondary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                                                    onclick="showTab(0)"
                                                    :class="{'border-b !border-secondary text-secondary' : tab === 'jadwal'}" @click="tab = 'jadwal'"
                                                    >
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                                        <path opacity="0.5"
                                                            d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                                            stroke="currentColor" stroke-width="1.5" />
                                                        <path d="M12 15L12 18" stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" />
                                                    </svg>
                                                    Penilaian 1</a>
                                            </li>
                                            <li class="tab">
                                                <a href="javascript:;"
                                                    class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                                                    onclick="showTab(1)"
                                                    :class="{'border-b !border-secondary text-secondary' : tab === 'hasil'}" @click="tab = 'hasil'"
                                                    ">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                                        <circle cx="12" cy="6" r="4"
                                                            stroke="currentColor" stroke-width="1.5" />
                                                        <ellipse opacity="0.5" cx="12" cy="17" rx="7"
                                                            ry="4" stroke="currentColor" stroke-width="1.5" />
                                                    </svg>
                                                    Penilaian 2</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div id="tab-content">
                                        <div class="tab-content show">
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
                                                                                        <input type="number" :name="'data['+index+'][capaian]['+capaianIndex+'][tujuan]['+tujuanIndex+'][nilai]'" :value="tujuan.nilai" class="form-input inline w-24 ml-2 pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Nilai" />
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
                                        <div class="tab-content">
                                            <div x-data="form2" x-init="initialize()">
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
                                                                                        <input type="number" :name="'data['+index+'][capaian]['+capaianIndex+'][tujuan]['+tujuanIndex+'][nilai]'" :value="tujuan.nilai" class="form-input inline w-24 ml-2 pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Nilai" />
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

        document.addEventListener("alpine:init", () => {
            Alpine.data("form2", () => ({
                tableData: @json($penempatan2).map(penempatan => {
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
