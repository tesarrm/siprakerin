<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <script src="/assets/js/flatpickr-id.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <div>
        <form action="{{ url('industri') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel xl:w-[800px] px-0 w-full xl:mt-0 mt-6">
                    <div class="px-4 mb-6">
                        <div class="text-lg font-semibold mb-4">Data Industri</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- <div>
                                <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                                <input value="{{ $pengaturan->tahun_ajaran }} "required id="tahun_ajaran" type="text" name="tahun_ajaran" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly/>
                                @error('tahun_ajaran')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div>
                                <label for="nama">Nama<span class="text-danger">*</span></label>
                                <input required id="nama" type="text" name="nama" class="form-input w-full" 
                                placeholder="Isi Nama"/>
                                @error('nama')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="kota_id">Kota<span class="text-danger">*</span></label>
                                <select required id="kota_id" name="kota_id" class="form-select w-full">
                                    <option value="">Pilih Kota</option>
                                    @foreach($kota as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kota_id')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="alamat">Alamat<span class="text-danger">*</span></label>
                                <input required id="alamat" type="text" name="alamat" class="form-input w-full" 
                                placeholder="Isi Alamat"/>
                                @error('alamat')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="tanggal_awal">Tanggal Awal<span class="text-danger">*</span></label>
                                <div x-data="tanggal_awal">
                                    <input id="tanggal_awal" x-model="date1" name="tanggal_awal" class="form-input w-full" />
                                </div>
                                @error('tanggal_awal')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="tanggal_akhir">Tanggal Akhir<span class="text-danger">*</span></label>
                                <div x-data="tanggal_akhir">
                                    <input id="tanggal_akhir" x-model="date1" name="tanggal_akhir" class="form-input w-full" />
                                </div>
                                @error('tanggal_akhir')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="tanggal_akhir">Hari Libur</label>
                            <div class="grid grid-cols-1 sm:grid-cols-7 mt-3">
                                <div>
                                    <input name="senin" type="checkbox" class="form-checkbox" />Senin 
                                </div>
                                <div>
                                    <input name="selasa" type="checkbox" class="form-checkbox" />Selasa 
                                </div>
                                <div>
                                    <input name="rabu" type="checkbox" class="form-checkbox" />Rabu 
                                </div>
                                <div>
                                    <input name="kamis" type="checkbox" class="form-checkbox" />Kamis 
                                </div>
                                <div>
                                    <input name="jumat" type="checkbox" class="form-checkbox" />Jumat 
                                </div>
                                <div>
                                    <input name="sabtu" type="checkbox" class="form-checkbox" />Sabtu 
                                </div>
                                <div>
                                    <input name="minggu" type="checkbox" class="form-checkbox" />Minggu 
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="px-4">
                        <div class="text-lg font-semibold mt-4">Informasi Akun</div>
                        <div class="grid grid-cols-1 mt-4 mb-6 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_akun">Nama<span class="text-danger">*</span></label>
                                <input required id="nama_akun" type="text" name="nama_akun" class="form-input w-full"
                                    placeholder="Isi Nama" />
                                @error('nama_akun')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="no_hp">No HP</label>
                                <input id="no_hp" type="text" name="no_hp" class="form-input w-full" 
                                    placeholder="Isi No HP" />
                                @error('no_hp')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="no_telp">No Telp</label>
                                <input id="no_telp" type="text" name="no_telp" class="form-input w-full" 
                                    placeholder="Isi No Telp" />
                                @error('no_telp')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="username">Username<span class="text-danger">*</span></label>
                                <input required id="username" type="text" name="username" class="form-input w-full"
                                    placeholder="Isi Username" />
                                @error('username')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input id="email" type="text" name="email" class="form-input w-full"
                                    placeholder="Isi Email" />
                                @error('email')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="password">Password</label>
                                <input required id="password" type="password" name="password" class="form-input flex-1"
                                    placeholder="Isi Password" />
                            </div>
                            <div>
                                <label for="confirmation-password">Konfirmasi Password</label>
                                <input required id="confirmation-password" type="password" name="confirmation-password" class="form-input flex-1"
                                    placeholder="Isi Konfirmasi Password" />
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

                            <a href="{{url('industri')}}" class="btn btn-outline-danger gap-2">
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
                <div class="flex-1 py-6">
                </div>
            </div>
        </form>
    </div>

    {{-- =========================== --}}
    {{-- BOTTOM --}}
    {{-- =========================== --}}

    <script>
        /*************
         * tanggal awal 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("tanggal_awal", () => ({
                date1: '', // Inisialisasi kosong, akan diisi di init()
                init() {
                    // Membuat instance Date dan mengonversinya ke format 'd F Y'
                    let today = new Date();
                    let options = { day: 'numeric', month: 'long', year: 'numeric' }; // Format: d F Y (contoh: 13 September 2024)
                    this.date1 = today.toLocaleDateString('id-ID', options);

                    flatpickr(document.getElementById('tanggal_awal'), {
                        dateFormat: 'd F Y', // Format sesuai keinginan
                        defaultDate: today, // Menggunakan tanggal hari ini
                        locale: 'id', // Bahasa Indonesia
                    });
                }
            }));
        });

        /*************
         * tanggal akhir 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("tanggal_akhir", () => ({
                date1: '', // Inisialisasi kosong, akan diisi di init()
                init() {
                    // Membuat instance Date dan mengonversinya ke format 'd F Y'
                    let today = new Date();
                    let options = { day: 'numeric', month: 'long', year: 'numeric' }; // Format: d F Y (contoh: 13 September 2024)
                    this.date1 = today.toLocaleDateString('id-ID', options);

                    flatpickr(document.getElementById('tanggal_akhir'), {
                        dateFormat: 'd F Y', // Format sesuai keinginan
                        defaultDate: today, // Menggunakan tanggal hari ini
                        locale: 'id', // Bahasa Indonesia
                    });
                }
            }));
        });
    </script>
</x-layout.default>
