<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <script src="/assets/js/flatpickr-id.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>

    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="/assets/js/nice-select2.js"></script>

    <div>
        <form action="{{ url('pelanggaran') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel xl:w-[600px] px-0 w-full xl:mt-0 mt-6">
                    <div class="px-4">
                        <div class="text-lg font-semibold mb-4">Data Pelanggaran</div>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="tanggal">Tanggal<span class="text-danger">*</span></label>
                                <div x-data="tanggal">
                                    <input id="basic" x-model="date1" name="tanggal" class="form-input w-full" />
                                </div>
                                @error('tanggal')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="kelas_id">Kelas<span class="text-danger">*</span></label>
                                <select required id="kelas_id" name="kelas_id" class="selectize w-full">
                                    <option selected value="">Pilih Kelas</option>
                                    @foreach($kelas as $item)
                                        <option value="{{$item->id}}">
                                            {{ $item->nama . ' ' . $item->jurusan->singkatan . ' ' . $item->klasifikasi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="siswa_id">Siswa<span class="text-danger">*</span></label>
                                <select required id="siswa_id" name="siswa_id" class="selectize w-full">
                                    <option selected value="">Pilih Siswa</option>
                                    <!-- Opsi siswa akan diisi berdasarkan kelas yang dipilih -->
                                </select>
                                @error('siswa_id')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="pelanggaran">Pelanggaran</label>
                                <textarea id="pelanggaran" rows="5" name="pelanggaran" class="form-textarea" 
                                    placeholder="Isi Pelanggaran" required></textarea>
                                @error('pelanggaran')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="solusi">Solusi</label>
                                <textarea id="solusi" rows="5" name="solusi" class="form-textarea" 
                                    placeholder="Isi Solusi" required></textarea>
                                @error('solusi')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
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

                            <a href="{{url('pelanggaran')}}" class="btn btn-outline-danger gap-2">
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
         * tanggal 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("tanggal", () => ({
                date1: '', // Inisialisasi kosong, akan diisi di init()
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

        /*************
         * filter siswa 
         */

        // document.addEventListener('DOMContentLoaded', function() {
        //     // Simpan data siswa dalam bentuk JSON untuk filter
        //     let siswa = @json($siswa);

        //     // Referensi elemen select kelas dan siswa
        //     let kelasSelect = document.getElementById('kelas_id');
        //     let siswaSelect = document.getElementById('siswa_id');

        //     // Ketika kelas dipilih, filter siswa
        //     kelasSelect.addEventListener('change', function() {
        //         let kelasId = this.value; // Dapatkan kelas yang dipilih
        //         let siswaOptions = '<option value="">Pilih Siswa</option>'; // Default option

        //         if (kelasId) {
        //             // Filter siswa berdasarkan kelas_id
        //             let filteredSiswa = siswa.filter(function(s) {
        //                 return s.kelas_id == kelasId;
        //             });

        //             // Loop dan buat opsi siswa
        //             filteredSiswa.forEach(function(value) {
        //                 siswaOptions += '<option value="' + value.id + '">' + value.nama_lengkap + '</option>';
        //             });
        //         }

        //         // Isi select siswa dengan opsi yang difilter
        //         siswaSelect.innerHTML = siswaOptions;

        //         // filter siswa 
        //         document.addEventListener("DOMContentLoaded", function(e) {
        //             var options = {
        //                 searchable: true
        //             };
        //             NiceSelect.bind(document.getElementById("siswa_id"), options);
        //         });
        //     });
        // });

        document.addEventListener('DOMContentLoaded', function() {
            // Simpan data siswa dalam bentuk JSON untuk filter
            let siswa = @json($siswa);

            // Referensi elemen select kelas dan siswa
            let kelasSelect = document.getElementById('kelas_id');
            let siswaSelect = document.getElementById('siswa_id');

            // Inisialisasi Nice Select untuk kelas
            NiceSelect.bind(kelasSelect, { searchable: true });

            // Ketika kelas dipilih, filter siswa
            kelasSelect.addEventListener('change', function() {
                let kelasId = this.value; // Dapatkan kelas yang dipilih
                let siswaOptions = '<option selected value="">Pilih Siswa</option>'; // Default option

                if (kelasId) {
                    // Filter siswa berdasarkan kelas_id
                    let filteredSiswa = siswa.filter(function(s) {
                        return s.kelas_id == kelasId;
                    });

                    // Loop dan buat opsi siswa
                    filteredSiswa.forEach(function(value) {
                        siswaOptions += '<option value="' + value.id + '">' + value.user.name + '</option>';
                    });
                }

                // Hapus binding sebelumnya
                // siswaSelect.niceSelect && siswaSelect.niceSelect.destroy();

                if (siswaSelect && siswaSelect.nextElementSibling && siswaSelect.nextElementSibling.classList.contains('nice-select')) {
                    // Hapus elemen dropdown NiceSelect secara manual
                    siswaSelect.nextElementSibling.remove();
                    // Tampilkan kembali elemen select asli
                    siswaSelect.style.display = "inline-block";
                }

                // Isi select siswa dengan opsi yang difilter
                siswaSelect.innerHTML = siswaOptions;

                // Bind ulang Nice Select untuk siswa setelah opsi diperbarui
                NiceSelect.bind(siswaSelect, { searchable: true });
            });
        });

        /*************
         * filter siswa 
         */

        document.addEventListener("DOMContentLoaded", function(e) {
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("siswa_id"), options);
        });

    </script>
</x-layout.default>
