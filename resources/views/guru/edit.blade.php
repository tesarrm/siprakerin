<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>

    <script src="/assets/js/filepond.js"></script>
    <script src="/assets/js/filepond-plugin-image-preview.js"></script>
    <link href="/assets/css/filepond.css" rel="stylesheet" />
    <link href="/assets/css/filepond-plugin-image-preview.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <script src="/assets/js/flatpickr-id.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <div>
        <form action="{{ url('guru/'. $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="xl:w-96 w-full xl:mt-0 mt-6">
                    <div class="panel">
                        <div class="mb-5">
                            <div class="text-lg font-semibold">Foto Profil</div>
                            <input type="file" id="gambar" name="gambar" class="mt-4">
                        </div>
                    </div>
                </div>
                <div class="panel space-y-5 px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class="px-4">
                        <div class="text-lg font-semibold">Informasi Umum</div>
                        <div class="grid grid-cols-1 mt-4 mb-6 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="nip">NIP<span class="text-danger">*</span></label>
                                <input value="{{$data->nip}}" required id="nip" type="text" name="nip" class="form-input w-full" 
                                    placeholder="Isi NIP" />
                                @error('nip')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="nama">Nama<span class="text-danger">*</span></label>
                                <input value="{{$data->user->name}}" required id="nama" type="text" name="nama" class="form-input w-full"
                                    placeholder="Isi Nama" />
                                @error('nama')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
                                <select required id="jenis_kelamin" name="jenis_kelamin" class="form-select w-full">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" @selected($data->jenis_kelamin == 'Laki-laki')>Laki-laki</option>
                                    <option value="Perempuan" @selected($data->jenis_kelamin == 'Perempuan')>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input value="{{$data->user->email}}" required id="email" type="text" name="email" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly
                                    placeholder="Isi Email" />
                                @error('email')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="px-4">
                        <div class="text-lg font-semibold mt-4">Detail</div>
                        <div class="grid grid-cols-1 mt-4 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="no_ktp">No KTP</label>
                                <input value="{{$data->no_ktp}}" id="no_ktp" type="text" name="no_ktp" class="form-input w-full" 
                                    placeholder="Isi No KTP" />
                                @error('no_ktp')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input value="{{$data->tempat_lahir}}" id="tempat_lahir" type="text" name="tempat_lahir" class="form-input w-full" 
                                    placeholder="Isi Tempat Lahir" />
                                @error('tempat_lahir')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <div x-data="form">
                                    <input id="basic" x-model="date1" class="form-input" name="tanggal_lahir" />
                                </div>
                                @error('tanggal_lahir')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="golongan_darah">Golongan Darah</label>
                                <select required id="golongan_darah" name="golongan_darah" class="form-select w-full">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option @selected($data->golongan_darah == 'A+') value="A+">A+</option>
                                    <option @selected($data->golongan_darah == 'B+') value="B+">B+</option>
                                    <option @selected($data->golongan_darah == 'AB+') value="AB+">AB+</option>
                                    <option @selected($data->golongan_darah == 'O+') value="O+">O+</option>
                                    <option @selected($data->golongan_darah == 'A-') value="A-">A-</option>
                                    <option @selected($data->golongan_darah == 'B-') value="B-">B-</option>
                                    <option @selected($data->golongan_darah == 'AB-') value="AB-">AB-</option>
                                    <option @selected($data->golongan_darah == 'O-') value="O-">O-</option>
                                </select>
                                @error('golongan_darah')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="kecamatan">Kecamatan</label>
                                <input value="{{$data->kecamatan}}" id="kecamatan" type="text" name="kecamatan" class="form-input w-full" 
                                    placeholder="Isi Kecamatan" />
                                @error('kecamatan')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="alamat">Alamat</label>
                                <input value="{{$data->alamat}}" id="alamat" type="text" name="alamat" class="form-input w-full" 
                                    placeholder="Isi Alamat" />
                                @error('alamat')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="rt">RT</label>
                                <input value="{{$data->rt}}" id="rt" type="number" name="rt" class="form-input w-full" 
                                    placeholder="Isi RT" />
                                @error('rt')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="rw">RW</label>
                                <input value="{{$data->rw}}" id="rw" type="number" name="rw" class="form-input w-full" 
                                    placeholder="Isi RW" />
                                @error('rw')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="kode_pos">Kode Pos</label>
                                <input value="{{$data->kode_pos}}" id="kode_pos" type="number" name="kode_pos" class="form-input w-full" 
                                    placeholder="Isi Kode Pos" />
                                @error('kode_pos')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="no_telp">No Telp</label>
                                <input value="{{$data->no_telp}}" id="no_telp" type="text" name="no_telp" class="form-input w-full" 
                                    placeholder="Isi No Telp" />
                                @error('no_telp')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="no_hp">No HP</label>
                                <input value="{{$data->no_hp}}" id="no_hp" type="text" name="no_hp" class="form-input w-full" 
                                    placeholder="Isi No HP" />
                                @error('no_hp')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="agama">Agama</label>
                                <select required id="agama" name="agama" class="form-select w-full">
                                    <option value="">Pilih Agama</option>
                                    <option @selected($data->agama == 'Islam') value="Islam">Islam</option>
                                    <option @selected($data->agama == 'Kristen') value="Kristen">Kristen</option>
                                    <option @selected($data->agama == 'Katolik') value="Katolik">Katolik</option>
                                    <option @selected($data->agama == 'Hindu') value="Hindu">Hindu</option>
                                    <option @selected($data->agama == 'Buddha') value="Buddha">Buddha</option>
                                    <option @selected($data->agama == 'Konghuchu') value="Konghuchu">Konghuchu</option>
                                </select>
                                @error('agama')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- button --}}
                    <div class="px-4">
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

                            <a href="{{url('guru')}}" class="btn btn-outline-danger gap-2">
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
         * gambar filepond 
         */

        FilePond.registerPlugin(FilePondPluginImagePreview)

        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement);

        FilePond.setOptions({
            server: {
                process: '/tmp-upload',
                revert: '/tmp-delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        let isSubmit = false;

        // Tambahkan event listener pada tombol submit
        const submitButton = document.querySelector('button[type="submit"]');
        submitButton.addEventListener('click', function () {
            isSubmit = true;
        });

        // Listen for page unload (when user navigates away from the page)
        window.addEventListener('beforeunload', function(event) {
            // Jika tombol submit belum ditekan, jalankan proses revert FilePond
            if (!isSubmit && pond.getFiles().length > 0) {
                pond.getFiles().forEach(fileItem => {
                    pond.removeFile(fileItem.id, {
                        revert: true
                    });
                });
            }
        });

        // If there is an existing image, load it into FilePond
        @if($data->user->gambar)
        pond.addFile("{{ asset('storage/posts/' . $data->user->gambar) }}")
            .then(file => {
                console.log('Existing file loaded', file);
            })
            .catch(error => {
                console.error('Failed to load existing file', error);
            });
        @endif

        /*************
         * tanggal lahir
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                date1: @json($data->tanggal_lahir), // Inisialisasi kosong, akan diisi di init()
                init() {
                    // Membuat instance Date dan mengonversinya ke format 'd F Y'
                    let today = new Date();
                    let options = { day: 'numeric', month: 'long', year: 'numeric' }; // Format: d F Y (contoh: 13 September 2024)
                    this.date1 = today.toLocaleDateString('id-ID', options);

                    flatpickr(document.getElementById('basic'), {
                        dateFormat: 'd F Y', // Format sesuai keinginan
                        defaultDate: today, // Menggunakan tanggal hari ini
                        locale: 'id', // Bahasa Indonesia
                    });
                }
            }));
        });
    </script>
</x-layout.default>
