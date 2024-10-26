<x-layout.default>
    <script src="/assets/js/simple-datatables.js"></script>

    <div>
        <form action="{{ route('penempatan.storeOrUpdate') }}" method="POST">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class=" px-4">
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="text-lg font-semibold">Penempatan Prakerin</div>
                                <div class="mt-4 flex items-center">
                                    <label for="nis" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">NIS</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $data->siswa->nis ?? '-' }}" required id="nis" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="nama" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Nama</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $data->siswa->nama ?? '-' }}" required id="nama" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="jenis_kelamin" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Jenis Kelamin</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $data->siswa->jenis_kelamin ?? '-' }}" required id="jenis_kelamin" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="kelas" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Kelas</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $data->siswa->kelas->nama . " " . $data->siswa->kelas->jurusan->singkatan . " " . $data->siswa->kelas->klasifikasi }}" required id="kelas" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="alamat" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Alamat</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $data->siswa->alamat ?? '-' }}" required id="alamat" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="no_telp" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">No Telp</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $data->siswa->no_telp ?? '-' }}" required id="no_telp" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="email" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Email</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $data->siswa->user->email ?? '-' }}" required id="email" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="email" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Pilihan Kota</span></label>
                                    <div class="flex-1">

                                        <div x-data="pilihan_kota">
                                            <div class="table-responsive">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th class="py-4">Pilihan 1</th>
                                                            <th class="py-4">Pilihan 2</th>
                                                            <th class="py-4">Pilihan 3</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template x-for="data in tableData" :key="data.id">
                                                            <tr>
                                                                <td class="py-4" x-text="data.pilihan_1"></td>
                                                                <td class="py-4" x-text="data.pilihan_2"></td>
                                                                <td class="py-4" x-text="data.pilihan_3"></td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="email" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Penempatan Industri</span></label>
                                    <div class="flex-1">

                                        <div x-data="penempatan">
                                            <div class="table-responsive">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th class="py-4">Nama Industri</th>
                                                            <th class="py-4">Alamat</th>
                                                            <th class="py-4">Kota</th>
                                                            <th class="py-4">Pilihan Kota</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template x-for="data in tableData" :key="data.id">
                                                            <tr>
                                                                <td class="py-4" x-text="data.nama"></td>
                                                                <td class="py-4" x-text="data.alamat"></td>
                                                                <td class="py-4" x-text="data.kota"></td>
                                                                <td class="py-4" x-text="data.pilihan"></td>
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

                    <div class="px-4">
                        <div class="flex justify-end items-center mt-6 gap-4">
                              <a href="{{url('penempatan')}}" class="btn btn-outline-danger gap-2">
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

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("pilihan_kota", () => ({
                tableData: [{
                        pilihan_1: @json($pilihan_kota->kota1->nama),
                        pilihan_2: @json($pilihan_kota->kota2->nama),
                        pilihan_3: @json($pilihan_kota->kota3->nama),
                    },
                ],
            }));
        });
    </script> 
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("penempatan", () => ({
                tableData: [{
                        nama: @json($penempatan->industri->nama),
                        alamat: @json($penempatan->industri->alamat),
                        kota: @json($penempatan->industri->kota->nama),
                        pilihan: @json($penempatan->pilihan),
                    },
                ],
            }));
        });
    </script> 

</x-layout.default>
