<x-layout.default>
    <div>
        <script src="/assets/js/simple-datatables.js"></script>

        <form action="{{ url('hasilmonitoring') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class=" px-4">
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="text-lg font-semibold">Penempatan Prakerin</div>
                                <input type="text" name="monitoring_id" value="{{ $jadwal_monitoring->id }}" class="hidden">
                                <div class="mt-4 flex items-center">
                                    <label for="nama_guru" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Nama Guru</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $jadwal_monitoring->guru->nama }}" id="nama_guru" type="text" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="industri" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Industri</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $jadwal_monitoring->industri->nama }}" id="industri" type="text" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="alamat" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Alamat</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $jadwal_monitoring->industri->alamat }}" id="alamat" type="text" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center">
                                    <div class="text-lg font-semibold">Data Monitoring Siswa</div>
                                </div>
                                <div class="mt-4">
                                    {{-- table input --}}
                                    <div x-data="form" x-init="initialize()">
                                        <table class="table-auto w-full">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-5">ID Siswa</th>
                                                    <th class="px-4 py-5">Nama Siswa</th>
                                                    <th class="px-4 py-5">Jenis Kelamin</th>
                                                    <th class="px-4 py-5">Kelas</th>
                                                    <th class="px-4 py-5">Kedisiplinan</th>
                                                    <th class="px-4 py-5">Sikap</th>
                                                    <th class="px-4 py-5">Kerjasama</th>
                                                    <th class="px-4 py-5">Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="(row, index) in tableData" :key="index">
                                                    <tr>
                                                        <td class="px-4 py-2">
                                                            <input type="text" :name="'data['+index+'][siswa_id]'" x-model="row.siswa_id" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            <input type="text" x-model="row.nama" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            <input type="text" x-model="row.jenis_kelamin" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            <input type="text" x-model="row.kelas" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            <div style="width: 80px;">
                                                                <input type="text" :name="'data['+index+'][kedisiplinan]'" x-model="row.kedisiplinan" class="form-input w-full" />
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            <div style="width: 80px;">
                                                                <input type="text" :name="'data['+index+'][sikap]'" x-model="row.sikap" class="form-input w-full" />
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            <div style="width: 80px;">
                                                                <input type="text" :name="'data['+index+'][kerjasama]'" x-model="row.kerjasama" class="form-input w-full" />
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-2">
                                                            <div style="width: 300px;">
                                                                <textarea rows="3" :name="'data['+index+'][catatan]'" x-model="row.catatan" class="form-textarea"></textarea>
                                                            </div>
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

                            <button type="button" class="btn btn-outline-danger gap-2">

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
                                Kembali </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- start hightlight js -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <!-- end hightlight js -->

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <script>
        console.log(@json($hasil_monitoring))
        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                // tableData: @json($penempatan).map(penempatan => ({
                //     siswa_id: penempatan.siswa.id,
                //     nama: penempatan.siswa.nama,
                //     jenis_kelamin: penempatan.siswa.jenis_kelamin,
                //     kelas: penempatan.siswa.kelas.nama + " " + penempatan.siswa.kelas.jurusan.singkatan + " " + penempatan.siswa.kelas.klasifikasi,
                //     kedisiplinan: penempatan.kedisiplinan,
                //     sikap: penempatan.sikap,
                //     kerjasama: penempatan.kerjasama,
                //     catatan: penempatan.catatan,
                // })),

            tableData: @json($penempatan).map(penempatan => {
                // Temukan data hasil monitoring berdasarkan siswa_id
                let monitoring = @json($hasil_monitoring).find(m => m.siswa_id === penempatan.siswa.id);

                // Jika data monitoring ditemukan, gunakan nilainya, jika tidak gunakan nilai dari penempatan
                return {
                    siswa_id: penempatan.siswa.id,
                    nama: penempatan.siswa.nama,
                    jenis_kelamin: penempatan.siswa.jenis_kelamin,
                    kelas: penempatan.siswa.kelas.nama + " " + penempatan.siswa.kelas.jurusan.singkatan + " " + penempatan.siswa.kelas.klasifikasi,
                    kedisiplinan: monitoring ? monitoring.kedisiplinan : penempatan.kedisiplinan,
                    sikap: monitoring ? monitoring.sikap : penempatan.sikap,
                    kerjasama: monitoring ? monitoring.kerjasama : penempatan.kerjasama,
                    catatan: monitoring ? monitoring.catatan : penempatan.catatan,
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
