<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <script src="/assets/js/flatpickr-id.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="/assets/js/nice-select2.js"></script>

    <div x-data="industriesData()">
        <form action="{{ url('monitoring/' . $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel xl:w-[600px] px-0 w-full xl:mt-0 mt-6">
                    <div class="px-4">
                        <div class="text-lg font-semibold mb-4">Data Jadwal Monitoring</div>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="tahun_ajaran">Tahun Ajaran<span class="text-danger">*</span></label>
                                <input 
                                    value="{{$data->tahunAjaran->nama}}" 
                                    id="tahun_ajaran" 
                                    type="text" 
                                    class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" 
                                    readonly
                                    placeholder="Isi Tahun Ajaran" 
                                />
                            </div>
                            <div>
                                <label for="industri_id">Industri<span class="text-danger">*</span></label>
                                <select required id="industri_id" name="industri_id" class="selectize w-full" x-model="selectedIndustri" @change="updateGuru">
                                    <option value="">Pilih Industri</option>
                                    @foreach($industri as $item)
                                        <option value="{{ $item->id }}" @selected($data->industri_id == $item->id)>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('industri_id')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="guru">Guru<span class="text-danger">*</span></label>
                                <input 
                                    type="hidden" 
                                    name="guru" 
                                    :value="guruId"
                                />
                                <input required 
                                    id="guru" 
                                    type="text" 
                                    class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" placeholder="Guru Pembimbing" 
                                    x-model="guruName" 
                                    readonly />
                                @error('guru')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal">Tanggal<span class="text-danger">*</span></label>
                                <div x-data="tanggal">
                                    <input value="{{ $data->tanggal }}" id="basic" x-model="date1" name="tanggal" class="form-input" />
                                </div>
                                @error('tanggal')
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

                            <a href="{{url('jadwalmonitoring')}}" class="btn btn-outline-danger gap-2">
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
                <div class="flex-1 py-6"></div>
            </div>
        </form>
    </div>

    <script>
        /*************
         * Tanggal 
         */
        document.addEventListener("alpine:init", () => {
            Alpine.data("tanggal", () => ({
                date1: @json($data->tanggal), // Inisialisasi kosong, akan diisi di init()
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

        /*************
         * Industri dan Guru 
         */
        function industriesData() {
            return {
                selectedIndustri: @json($data->industri_id), // Set industri yang sudah tersimpan
                guruName: @json($data->guru->user->name), // Set nama guru dari data yang sudah tersimpan
                guruId: @json($data->guru->id),// Kosongkan jika tidak ada guru

                // Data industri dan guru terkait
                industries: @json($industri), // Industri dan guru dari backend

                // Fungsi untuk update nama guru saat industri dipilih
                updateGuru() {
                    const selectedIndustri = this.industries.find(item => item.id == this.selectedIndustri);
                    if (selectedIndustri && selectedIndustri.gurus.length > 0) {
                        this.guruName = selectedIndustri.gurus[0].user.name; // Isi guru dengan guru pertama yang terkait
                        this.guruId = selectedIndustri.gurus[0].id; // Isi guru dengan guru pertama yang terkait
                    } else {
                        this.guruName = ''; // Kosongkan jika tidak ada guru
                        this.guruId= ''; // Kosongkan jika tidak ada guru
                    }
                }
            }
        }

        /*************
         * filter industri 
         */

        document.addEventListener("DOMContentLoaded", function(e) {
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("industri_id"), options);
        });
    </script>
</x-layout.default>
