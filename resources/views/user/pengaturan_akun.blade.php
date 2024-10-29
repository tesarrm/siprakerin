<x-layout.default>
    <script src="/assets/js/simple-datatables.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">

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

    <style>
        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>

    <div>
        {{-- tab --}}
        <div id="tabs" x-data="{ tab: 'guru'}">
            <ul class="flex flex-wrap mb-5 border-b border-white-light dark:border-[#191e3a]">
                <li class="tab active">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-secondary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(0)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'guru'}" @click="tab = 'guru'"
                        >
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M6 15.8L7.14286 17L10 14" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 8.8L7.14286 10L10 7" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 9L18 9" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M13 16L18 16" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Informasi</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(1)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'kelas'}" @click="tab = 'kelas'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <circle cx="10" cy="6" r="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M18 17.5C18 19.9853 18 22 10 22C2 22 2 19.9853 2 17.5C2 15.0147 5.58172 13 10 13C14.4183 13 18 15.0147 18 17.5Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M21 10H19H17" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Keamanan</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(2)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'pengaturan'}" @click="tab = 'pengaturan'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <circle cx="10" cy="6" r="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M18 17.5C18 19.9853 18 22 10 22C2 22 2 19.9853 2 17.5C2 15.0147 5.58172 13 10 13C14.4183 13 18 15.0147 18 17.5Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M21 10H19H17" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Pengaturan</a>
                </li>
            </ul>
        </div>
        <div id="tab-content">
            <div class="tab-content show">
                @if(auth()->user()->hasRole('siswa'))
                    <form action="{{ url('pengaturan-akun') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex xl:flex-row flex-col gap-2.5">
                            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                                <div class="panel">
                                    <div class="mb-8">
                                        <div class="text-lg font-semibold">Foto Profil</div>
                                        <input type="file" id="gambar" name="gambar" class="mt-4">
                                    </div>
                                </div>
                            </div>
                            <div class="panel space-y-5 px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                                <div class="px-4">
                                    <div class="text-lg font-semibold mt-6">Indentitas Diri</div>
                                    <div class="grid grid-cols-1 mt-4 mb-6 sm:grid-cols-2 gap-4">
                                        {{-- <div>
                                            <label for="nama_lengkap">Nama Lengkap<span class="text-danger">*</span></label>
                                            <input value="{{ $siswa->nama_lengkap }}" required id="nama_lengkap" type="text" name="nama_lengkap" class="form-input w-full"
                                                placeholder="Isi Nama Lengkap" />
                                            @error('nama_lengkap')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div> --}}
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
                                            <div x-data="form">
                                                <input id="basic" x-model="date1" class="form-input" name="tanggal_lahir" />
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
                                            <input 
                                                value="{{$siswa->jenis_kelamin}}" 
                                                required 
                                                id="jenis_kelamin" 
                                                type="text" 
                                                class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" 
                                                readonly
                                                placeholder="Isi Jenis Kelamin" 
                                            />
                                            @error('jenis_kelamin')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="kelas_id">Jenis Kelamin<span class="text-danger">*</span></label>
                                            <input 
                                                value="{{$siswa->kelas->nama . " " . $siswa->kelas->jurusan->singkatan . " " . $siswa->kelas->klasifikasi}}" 
                                                required 
                                                id="kelas_id" 
                                                type="text" 
                                                class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" 
                                                readonly
                                                placeholder="Isi Kelas" 
                                            />
                                            @error('kelas_id')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @elseif(auth()->user()->hasRole('guru'))
                    <form action="{{ url('pengaturan-akun') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex xl:flex-row flex-col gap-2.5">
                            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                                <div class="panel">
                                    <div class="mb-8">
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
                                            <input value="{{$guru->nip}}" required id="nip" type="text" name="nip" class="form-input w-full" 
                                                placeholder="Isi NIP" />
                                            @error('nip')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="nama">Nama<span class="text-danger">*</span></label>
                                            <input value="{{$guru->nama}}" required id="nama" type="text" name="nama" class="form-input w-full"
                                                placeholder="Isi Nama" />
                                            @error('nama')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
                                            <select required id="jenis_kelamin" name="jenis_kelamin" class="form-select w-full">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki" @selected($guru->jenis_kelamin == 'Laki-laki')>Laki-laki</option>
                                                <option value="Perempuan" @selected($guru->jenis_kelamin == 'Perempuan')>Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="email">Email<span class="text-danger">*</span></label>
                                            <input value="{{$guru->user->email}}" required id="email" type="text" name="email" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly
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
                                            <input value="{{$guru->no_ktp}}" id="no_ktp" type="text" name="no_ktp" class="form-input w-full" 
                                                placeholder="Isi No KTP" />
                                            @error('no_ktp')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input value="{{$guru->tempat_lahir}}" id="tempat_lahir" type="text" name="tempat_lahir" class="form-input w-full" 
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
                                                <option @selected($guru->golongan_darah == 'A+') value="A+">A+</option>
                                                <option @selected($guru->golongan_darah == 'B+') value="B+">B+</option>
                                                <option @selected($guru->golongan_darah == 'AB+') value="AB+">AB+</option>
                                                <option @selected($guru->golongan_darah == 'O+') value="O+">O+</option>
                                                <option @selected($guru->golongan_darah == 'A-') value="A-">A-</option>
                                                <option @selected($guru->golongan_darah == 'B-') value="B-">B-</option>
                                                <option @selected($guru->golongan_darah == 'AB-') value="AB-">AB-</option>
                                                <option @selected($guru->golongan_darah == 'O-') value="O-">O-</option>
                                            </select>
                                            @error('golongan_darah')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="kecamatan">Kecamatan</label>
                                            <input value="{{$guru->kecamatan}}" id="kecamatan" type="text" name="kecamatan" class="form-input w-full" 
                                                placeholder="Isi Kecamatan" />
                                            @error('kecamatan')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="alamat">Alamat</label>
                                            <input value="{{$guru->alamat}}" id="alamat" type="text" name="alamat" class="form-input w-full" 
                                                placeholder="Isi Alamat" />
                                            @error('alamat')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="rt">RT</label>
                                            <input value="{{$guru->rt}}" id="rt" type="number" name="rt" class="form-input w-full" 
                                                placeholder="Isi RT" />
                                            @error('rt')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="rw">RW</label>
                                            <input value="{{$guru->rw}}" id="rw" type="number" name="rw" class="form-input w-full" 
                                                placeholder="Isi RW" />
                                            @error('rw')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="kode_pos">Kode Pos</label>
                                            <input value="{{$guru->kode_pos}}" id="kode_pos" type="number" name="kode_pos" class="form-input w-full" 
                                                placeholder="Isi Kode Pos" />
                                            @error('kode_pos')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="no_telp">No Telp</label>
                                            <input value="{{$guru->no_telp}}" id="no_telp" type="text" name="no_telp" class="form-input w-full" 
                                                placeholder="Isi No Telp" />
                                            @error('no_telp')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="no_hp">No HP</label>
                                            <input value="{{$guru->no_hp}}" id="no_hp" type="text" name="no_hp" class="form-input w-full" 
                                                placeholder="Isi No HP" />
                                            @error('no_hp')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="agama">Agama</label>
                                            <select required id="agama" name="agama" class="form-select w-full">
                                                <option value="">Pilih Agama</option>
                                                <option @selected($guru->agama == 'Islam') value="Islam">Islam</option>
                                                <option @selected($guru->agama == 'Kristen') value="Kristen">Kristen</option>
                                                <option @selected($guru->agama == 'Katolik') value="Katolik">Katolik</option>
                                                <option @selected($guru->agama == 'Hindu') value="Hindu">Hindu</option>
                                                <option @selected($guru->agama == 'Buddha') value="Buddha">Buddha</option>
                                                <option @selected($guru->agama == 'Konghuchu') value="Konghuchu">Konghuchu</option>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @elseif(auth()->user()->hasRole('admin'))
                    <form action="{{ url('pengaturan-akun') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex xl:flex-row flex-col gap-2.5">
                            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                                <div class="panel">
                                    <div class="mb-8">
                                        <div class="text-lg font-semibold">Foto Profil</div>
                                        <input type="file" id="gambar" name="gambar" class="mt-4">
                                    </div>
                                </div>
                            </div>
                            <div class="panel space-y-5 px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                                <div class="px-4">
                                    <div class="text-lg font-semibold">Indentitas Diri</div>
                                    <div class="grid grid-cols-1 mt-4 mb-6 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="nama">Nama<span class="text-danger">*</span></label>
                                            <input value="{{ $user->name}}" required id="nama" type="text" name="nama" class="form-input w-full"
                                                placeholder="Isi Nama" />
                                            @error('nama')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>

            <div class="tab-content">
                <form action="{{ url('ubah-password') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex xl:flex-row flex-col gap-2.5">
                        <div class="panel px-0 w-full xl:mt-0 mt-6">
                            <div class="px-4">
                                <div class="pb-2 mb-4 text-lg font-semibold border-b">Ubah Password</div>
                                <div class="lg:pr-[300px]">
                                    <div class="flex justify-around lg:flex-row flex-col">
                                        <div class="lg:w-2/3 w-full mb-6"">
                                            <div class="mt-4 flex">
                                                <label for="reciever-name" class="ltr:mr-4 rtl:ml-2 w-1/4 mb-0 text-end">
                                                    Password Lama<span class="text-danger">*</span>
                                                </label>
                                                <div class="flex-1">
                                                    <div>
                                                        <input required id="current_password" type="password" name="current_password" class="form-input flex-1"
                                                            placeholder="Isi Password Lama" />
                                                    </div>
                                                    @error('current_password')
                                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-4 flex">
                                                <label for="reciever-name" class="ltr:mr-4 rtl:ml-2 w-1/4 mb-0 text-end">
                                                    Password Baru<span class="text-danger">*</span>
                                                </label>
                                                <div class="flex-1">
                                                    <div>
                                                        <input required id="new_password" type="password" name="new_password" class="form-input flex-1"
                                                            placeholder="Isi Password Baru" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex">
                                                <label for="reciever-name" class="ltr:mr-4 rtl:ml-2 w-1/4 mb-0 text-end">
                                                    Konfirmasi Password Baru<span class="text-danger">*</span>
                                                </label>
                                                <div class="flex-1">
                                                    <div>
                                                        <input required id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-input flex-1"
                                                            placeholder="Isi Konfirmasi Password Baru" />
                                                    </div>
                                                    @error('new_password')
                                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-2 flex">
                                                <label for="reciever-name" class="ltr:mr-4 rtl:ml-2 w-1/4 mb-0 text-end">
                                                </label>
                                                <div class="flex-1">
                                                    <div class="flex justify-start items-center mt-8 gap-4">
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
                                                            Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-content">
            </div>
        </div>
    </div>

    {{-- alert toast --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showAlert("{{ session('success') }}");
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

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showAlert("{{ session('error') }}");
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
                    icon: 'error',
                    title: message,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
            }
        </script>
    @endif

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

        /**
         * file pond
         */ 
        FilePond.registerPlugin(FilePondPluginImagePreview);
        let isSubmit = false;

        // gambar
        const inputElement = document.querySelector('input[id="gambar"]');
        const pond = FilePond.create(inputElement);
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
            }
        });

        // If there is an existing image, load it into FilePond
        @if(auth()->user()->hasRole('siswa'))
            @if($siswa->user->gambar)
            pond.addFile("{{ asset('storage/posts/' . $siswa->user->gambar) }}")
                .then(file => {
                    console.log('Existing file loaded', file);
                })
                .catch(error => {
                    console.error('Failed to load existing file', error);
                });
            @endif
        @endif
        @if(auth()->user()->hasRole('guru'))
            @if($guru->user->gambar)
            pond.addFile("{{ asset('storage/posts/' . $guru->user->gambar) }}")
                .then(file => {
                    console.log('Existing file loaded', file);
                })
                .catch(error => {
                    console.error('Failed to load existing file', error);
                });
            @endif
        @endif
        @if(auth()->user()->hasRole('admin'))
            @if($user->gambar)
            pond.addFile("{{ asset('storage/posts/' . $user->gambar) }}")
                .then(file => {
                    console.log('Existing file loaded', file);
                })
                .catch(error => {
                    console.error('Failed to load existing file', error);
                });
            @endif
        @endif

        /*************
         * tanggal lahir
         */

        @if(auth()->user()->hasRole('siswa'))
            document.addEventListener("alpine:init", () => {
                Alpine.data("form", () => ({
                    date1: @json($siswa->tanggal_lahir), // Inisialisasi kosong, akan diisi di init()
                    init() {
                        // Membuat instance Date dan mengonversinya ke format 'd F Y'
                        let today = new Date();
                        let options = { day: 'numeric', month: 'long', year: 'numeric' }; // Format: d F Y (contoh: 13 September 2024)
                        // this.date1 = today.toLocaleDateString('id-ID', options);

                        flatpickr(document.getElementById('basic'), {
                            dateFormat: 'd F Y', // Format sesuai keinginan
                            defaultDate: today, // Menggunakan tanggal hari ini
                            locale: 'id', // Bahasa Indonesia
                        });
                    }
                }));
            });
        @endif
        @if(auth()->user()->hasRole('guru'))
            document.addEventListener("alpine:init", () => {
                Alpine.data("form", () => ({
                    date1: @json($guru->tanggal_lahir), // Inisialisasi kosong, akan diisi di init()
                    init() {
                        // Membuat instance Date dan mengonversinya ke format 'd F Y'
                        let today = new Date();
                        let options = { day: 'numeric', month: 'long', year: 'numeric' }; // Format: d F Y (contoh: 13 September 2024)
                        // this.date1 = today.toLocaleDateString('id-ID', options);

                        flatpickr(document.getElementById('basic'), {
                            dateFormat: 'd F Y', // Format sesuai keinginan
                            defaultDate: today, // Menggunakan tanggal hari ini
                            locale: 'id', // Bahasa Indonesia
                        });
                    }
                }));
            });
        @endif
    </script>
</x-layout.default>
