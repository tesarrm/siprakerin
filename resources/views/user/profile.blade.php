<x-layout.default>
    <script src="/assets/js/simple-datatables.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <div>
        <form action="{{ url('profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="xl:w-96 w-full xl:mt-0 mt-6">
                    <div class="panel">
<div class="mb-8">
    <div class="text-lg font-semibold">Foto Profil</div>
    <input type="file" id="gambar" name="gambar" class="mt-4">
</div>
<div class="mb-5">
    <div class="text-lg font-semibold">Pas Foto</div>
    <input type="file" id="pas_foto" name="pas_foto" class="mt-4">
</div>
                    </div>
                </div>
                <div class="panel space-y-5 px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class="px-4">
                        <div class="text-lg font-semibold mt-6">Indentitas Diri</div>
                        <div class="grid grid-cols-1 mt-4 mb-6 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_lengkap">Nama Lengkap<span class="text-danger">*</span></label>
                                <input value="{{ $siswa->nama_lengkap }}" required id="nama_lengkap" type="text" name="nama_lengkap" class="form-input w-full"
                                    placeholder="Isi Nama Lengkap" />
                                @error('nama_lengkap')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="nama">Nama Panggilan<span class="text-danger">*</span></label>
                                <input value="{{ $siswa->nama}}" required id="nama" type="text" name="nama" class="form-input w-full"
                                    placeholder="Isi Nama" />
                                @error('nama')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="nis">NIS<span class="text-danger">*</span></label>
                                <input value="{{ $siswa->nis}}" required id="nis" type="text" name="nis" class="form-input w-full" 
                                    placeholder="Isi NIS" />
                                @error('nis')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="nisn">NISN<span class="text-danger">*</span></label>
                                <input value="{{ $siswa->nisn}}" required id="nisn" type="text" name="nisn" class="form-input w-full" 
                                    placeholder="Isi NISN" />
                                @error('nisn')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input value="{{ $siswa->tempat_lahir}}" id="tempat_lahir" type="text" name="tempat_lahir" class="form-input w-full" 
                                    placeholder="Isi Tempat Lahir" />
                                @error('tempat_lahir')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <div x-data="tanggal_lahir">
                                    <input value="{{ $siswa->tanggal_lahir}}" id="basic" x-model="date1" name="tanggal_lahir" class="form-input"
                                    placeholder="Isi Tanggal Lahir" />
                                </div>
                                @error('tanggal_lahir')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="agama">Agama</label>
                                <select required id="agama" name="agama" class="form-select w-full">
                                    <option value="">Pilih Agama</option>
                                    <option @selected($siswa->agama == 'Islam') value="Islam">Islam</option>
                                    <option @selected($siswa->agama == 'Kristen') value="Kristen">Kristen</option>
                                    <option @selected($siswa->agama == 'Katolik') value="Katolik">Katolik</option>
                                    <option @selected($siswa->agama == 'Hindu') value="Hindu">Hindu</option>
                                    <option @selected($siswa->agama == 'Buddha') value="Buddha">Buddha</option>
                                    <option @selected($siswa->agama == 'Konghuchu') value="Konghuchu">Konghuchu</option>
                                </select>
                                @error('agama')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="alamat">Alamat</label>
                                <input value="{{ $siswa->alamat}}" id="alamat" type="text" name="alamat" class="form-input w-full" 
                                    placeholder="Isi Alamat" />
                                @error('alamat')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="kode_pos">Kode Pos</label>
                                <input value="{{ $data->kode_pos ?? ''}}" id="kode_pos" type="number" name="kode_pos" class="form-input w-full" 
                                    placeholder="Isi Kode Pos" />
                                @error('kode_pos')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="no_telp">No Telp</label>
                                <input value="{{ $siswa->no_telp}}" id="no_telp" type="text" name="no_telp" class="form-input w-full" 
                                    placeholder="Isi No Telp" />
                                <span class="text-white-dark text-xs">( apabila ada perubahan nomor telp. / hp. harap diinformasikan ke sekolah )</span>
                                @error('no_telp')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
                                <select required id="jenis_kelamin" name="jenis_kelamin" class="form-select w-full">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" @selected($siswa->jenis_kelamin == 'Laki-laki')>Laki-laki</option>
                                    <option value="Perempuan" @selected($siswa->jenis_kelamin == 'Perempuan')>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="golongan_darah">Golongan Darah</label>
                                <select required id="golongan_darah" name="golongan_darah" class="form-select w-full">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option @selected($data->golongan_darah ?? ''  == 'A+') value="A+">A+</option>
                                    <option @selected($data->golongan_darah ?? '' == 'B+') value="B+">B+</option>
                                    <option @selected($data->golongan_darah ?? '' == 'AB+') value="AB+">AB+</option>
                                    <option @selected($data->golongan_darah ?? '' == 'O+') value="O+">O+</option>
                                    <option @selected($data->golongan_darah ?? '' == 'A-') value="A-">A-</option>
                                    <option @selected($data->golongan_darah ?? '' == 'B-') value="B-">B-</option>
                                    <option @selected($data->golongan_darah ?? '' == 'AB-') value="AB-">AB-</option>
                                    <option @selected($data->golongan_darah ?? '' == 'O-') value="O-">O-</option>
                                </select>
                                @error('golongan_darah')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="tinggi_badan">Tinggi Badan</label>
                                <input value="{{ $data->tinggi_badan ?? ''}}" id="tinggi_badan" type="number" name="tinggi_badan" class="form-input w-full" 
                                    placeholder="Isi Tinggi Badan" />
                                @error('tinggi_badan')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="hobi">Hobi</label>
                                <input value="{{ $data->hobi ?? ''}}" id="hobi" type="text" name="hobi" class="form-input w-full" 
                                    placeholder="Isi Hobi" />
                                @error('hobi')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="keahlian">Keahlian/Keterampilan</label>
                                <input value="{{ $data->keahlian ?? ''}}" id="keahlian" type="text" name="keahlian" class="form-input w-full" 
                                    placeholder="Isi Keahlian/Ketermapilan" />
                                @error('keahlian')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="organisasi">Organisasi yang pernah diikuti</label>
                                <input value="{{ $data->organisasi ?? ''}}" id="organisasi" type="text" name="organisasi" class="form-input w-full" 
                                    placeholder="Isi Organisasi yang pernah diikuti" />
                                @error('organisasi')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="pendidikan">Pendidikan</label>

                            <div x-data="pendidikan" x-init="initialize()">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-5">Tingkat Pendidikan</th>
                                            <th class="px-4 py-5">Tahun Pendidikan</th>
                                            <th class="px-4 py-5">Alamat Pendidikan</th>
                                            <th class="px-4 py-5">Berijasah/tidak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Gunakan x-for untuk looping data -->
                                        <template x-for="row in pendidikan" :key="row.id">
                                            <tr>
                                                <td class="px-4 border-r">
                                                    <span x-text="row.tingkat_pendidikan"></span>
                                                </td>
                                                <td class="px-4 flex items-center">
                                                    <span>Th&nbsp;</span><input type="number" :name="`tahun_awal_${row.id}`" x-model="row.tahun_awal" class="form-input w-full" />
                                                    <span>&nbsp;&nbsp;sd.&nbsp;th&nbsp;</span><input type="number" :name="`tahun_akhir_${row.id}`" x-model="row.tahun_akhir" class="form-input w-full" />
                                                </td>
                                                <td class="px-4">
                                                    <input type="text" :name="`tempat_${row.id}`" x-model="row.tempat" class="form-input w-full" />
                                                </td>
                                                {{-- <td class="px-4">
                                                    <input type="text" :name="`berijasah_${row.id}`" x-model="row.berijasah" class="form-input w-full" />
                                                    </td> --}}
                                                <td class="px-4">
                                                    <select :name="`berijasah_${row.id}`" x-model="row.berijasah" class="form-input w-full" >
                                                        <option value="Berijasah">Berijasah</option>
                                                        <option value="Tidak Berijasah">Tidak</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            @error('pendidikan')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="px-4">
                        <div class="text-lg font-semibold mt-4 mb-4">Daftar Riwayat Kelauarga</div>
                        <div>
                            <div x-data="keluarga" x-init="initialize()">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-5"></th>
                                            <th class="px-4 py-5">Ayah</th>
                                            <th class="px-4 py-5">Ibu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Gunakan x-for untuk looping data -->
                                        <template x-for="row in dataKeluarga" :key="row.id">
                                            <tr>
                                                <td class="px-4 border-r">
                                                    <span x-text="row.label"></span>
                                                </td>
                                                <td class="px-4">
                                                    <input type="text" :name="`ayah_${row.label.toLowerCase()}`" x-model="row.ayah" class="form-input w-full" />
                                                </td>
                                                <td class="px-4">
                                                    <input type="text" :name="`ibu_${row.label.toLowerCase()}`" x-model="row.ibu" class="form-input w-full" />
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            @error('keluarga')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="mt-4 mb-2">Keluarga/relasi yang mudah dihubungi apabila terjadi hal-hal darurat:</label>

                            <div x-data="keluarga_relasi" x-init="initialize()">
                                <table class="table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-5">No</th>
                                            <th class="px-4 py-5">Nama</th>
                                            <th class="px-4 py-5">Alamat</th>
                                            <th class="px-4 py-5">No Telp</th>
                                            <th class="px-4 py-5">Hub Keluarga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Gunakan x-for untuk looping data -->
                                        <template x-for="(row, index) in dataKeluargaRelasi" :key="row.id">
                                            <tr>
                                                <td class="px-4 border-r">
                                                    <span x-text="index + 1"></span>
                                                </td>
                                                <td class="px-4">
                                                    <input type="text" :name="`nama_${index}`" x-model="row.nama" class="form-input w-full" />
                                                </td>
                                                <td class="px-4">
                                                    <input type="text" :name="`alamat_${index}`" x-model="row.alamat" class="form-input w-full" />
                                                </td>
                                                <td class="px-4">
                                                    <input type="text" :name="`no_telp_${index}`" x-model="row.no_telp" class="form-input w-full" />
                                                </td>
                                                <td class="px-4">
                                                    <input type="text" :name="`hub_keluarga_${index}`" x-model="row.hub_keluarga" class="form-input w-full" />
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            @error('keluarga_relasi')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="px-4">
                        <div class="text-lg font-semibold mt-4 mb-4">Riwayat Kesehatan</div>
                        <div>
                            <label for="penyakit">Penyakit yang pernah diderita<span class="text-danger">*</span></label>
                            <input value="{{ $data->penyakit ?? '' }}" required id="penyakit" type="text" name="penyakit" class="form-input w-full"
                                placeholder="Isi Penyakit" />
                            @error('penyakit')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
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
        /**
         * file pond
         */ 
    FilePond.registerPlugin(FilePondPluginImagePreview);
    let isSubmit = false;

    // gambar
    const inputElement = document.querySelector('input[id="gambar"]');
    const inputElement2 = document.querySelector('input[id="pas_foto"]');
    const pond = FilePond.create(inputElement);
    const pond2 = FilePond.create(inputElement2);
    const submitButton = document.querySelector('button[type="submit"]');

    FilePond.setOptions({
        server: {
            process: '/tmp-upload',
            revert: '/tmp-delete',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });

    // Tambahkan event listener pada tombol submit
    submitButton.addEventListener('click', function () {
        isSubmit = true;
    });

    // Handle revert saat user navigate away tanpa submit
    window.addEventListener('beforeunload', function (event) {
        if (!isSubmit) {
            if (pond.getFiles().length > 0) {
                pond.getFiles().forEach(fileItem => {
                    pond.removeFile(fileItem.id, {
                        revert: true
                    });
                });
            }

            if (pond2.getFiles().length > 0) {
                pond2.getFiles().forEach(fileItem => {
                    pond2.removeFile(fileItem.id, {
                        revert: true
                    });
                });
            }
        }
    });

    // Load existing image for gambar
    @if($siswa->gambar)
    pond.addFile("{{ asset('storage/posts/' . $siswa->gambar) }}")
        .then(file => {
            console.log('Existing gambar file loaded', file);
        })
        .catch(error => {
            console.error('Failed to load existing gambar file', error);
        });
    @endif

    // Load existing image for pas_foto
    @if($siswa->pas_foto)
    pond2.addFile("{{ asset('storage/posts/' . $siswa->pas_foto) }}")
        .then(file => {
            console.log('Existing pas_foto file loaded', file);
        })
        .catch(error => {
            console.error('Failed to load existing pas_foto file', error);
        });
    @endif
 

        /**
         * tanggal lahir 
         */ 
        console.log(@json($siswa).tanggal_lahir)
        document.addEventListener("alpine:init", () => {
            Alpine.data("tanggal_lahir", () => ({
                date1: @json($siswa).tanggal_lahir ? @json($siswa).tanggal_lahir : '', 
                init() {
                    flatpickr(document.getElementById('basic'), {
                        dateFormat: 'Y-m-d',
                        defaultDate: this.date1,
                    })
                }
            }));
        });

        /**
         * datatable pendidikan 
         */ 
        document.addEventListener('alpine:init', () => {
            Alpine.data('pendidikan', () => ({
                pendidikan: [], // Inisialisasi array pendidikan
                data: @json($data),

                initialize() {
                    // Data pendidikan bisa Anda ganti sesuai kebutuhan
                    this.pendidikan = [
                        {
                            id: 1,
                            tingkat_pendidikan: 'Sekolah Dasar',
                            tahun_awal: this.data?.tahun_awal_1,
                            tahun_akhir: this.data?.tahun_akhir_1,
                            tempat: this.data?.tempat_1,
                            berijasah: this.data?.berijasah_1
                        },
                        {
                            id: 2,
                            tingkat_pendidikan: 'SLTP / MTs',
                            tahun_awal: this.data?.tahun_awal_2,
                            tahun_akhir: this.data?.tahun_akhir_2,
                            tempat: this.data?.tempat_2,
                            berijasah: this.data?.berijasah_2
                        },
                        {
                            id: 3,
                            tingkat_pendidikan: 'SMA / SMK',
                            tahun_awal: this.data?.tahun_awal_3,
                            tahun_akhir: this.data?.tahun_akhir_3,
                            tempat: this.data?.tempat_3,
                            berijasah: this.data?.berijasah_3
                        },
                    ];
                }
            }));
        });

        /**
         * datatable keluarga 
         */ 
        document.addEventListener('alpine:init', () => {
            Alpine.data('keluarga', () => ({
                dataKeluarga: [],
                data: @json($data),

                initialize() {
                    // Inisialisasi data keluarga, sesuaikan dengan data yang Anda butuhkan
                    this.dataKeluarga = [
                        {
                            id: 1,
                            label: 'Nama',
                            ayah: this.data?.ayah_nama,
                            ibu: this.data?.ibu_nama 
                        },
                        {
                            id: 2,
                            label: 'Usia',
                            ayah: this.data?.ayah_usia,
                            ibu: this.data?.ibu_usia
                        },
                        {
                            id: 3,
                            label: 'Pendidikan terakhir',
                            ayah: this.data?.ayah_pendidikan_terakhir,
                            ibu: this.data?.ibu_pendidikan_terakhir
                        },
                        {
                            id: 4,
                            label: 'Pekerjaan',
                            ayah: this.data?.ayah_pekerjaan,
                            ibu: this.data?.ibu_pekerjaan
                        },
                        {
                            id: 5,
                            label: 'Alamat',
                            ayah: this.data?.ayah_alamat,
                            ibu: this.data?.ibu_alamat
                        },
                        {
                            id: 6,
                            label: 'No Telp',
                            ayah: this.data?.ayah_no_telp,
                            ibu: this.data?.ibu_no_telp
                        },
                    ];
                }
            }));
        });

        /**
         * datatable keluarga relasi
         */ 
        document.addEventListener('alpine:init', () => {
            Alpine.data('keluarga_relasi', () => ({
                dataKeluargaRelasi: [],
                data: @json($data),

                initialize() {
                    // Inisialisasi data relasi keluarga, sesuaikan dengan kebutuhan
                    this.dataKeluargaRelasi = [
                        {
                            id: 1,
                            nama: this.data?.nama_0,
                            alamat: this.data?.alamat_0,
                            no_telp: this.data?.no_telp_0,
                            hub_keluarga: this.data?.hub_keluarga_0 
                        },
                        {
                            id: 2,
                            nama: this.data?.nama_1,
                            alamat: this.data?.alamat_1,
                            no_telp: this.data?.no_telp_1,
                            hub_keluarga: this.data?.hub_keluarga_1 
                        },
                        {
                            id: 3,
                            nama: this.data?.nama_2,
                            alamat: this.data?.alamat_2,
                            no_telp: this.data?.no_telp_2,
                            hub_keluarga: this.data?.hub_keluarga_2
                        },
                    ];
                }
            }));
        });
    </script>
    
</x-layout.default>
