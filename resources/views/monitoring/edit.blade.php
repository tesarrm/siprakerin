<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

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
                                <label for="industri_id">Industri<span class="text-danger">*</span></label>
                                <select required id="industri_id" name="industri_id" class="form-select w-full" x-model="selectedIndustri" @change="updateGuru">
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
                                <input required id="guru" type="text" name="guru" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" placeholder="Guru Pembimbing" x-model="guruName" readonly />
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
                                Simpan
                            </button>
                            <a href="{{ url('monitoring') }}" class="btn btn-outline-danger gap-2">
                                Kembali
                            </a>
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
                date1: @json($data['tanggal']), 
                init() {
                    flatpickr(document.getElementById('basic'), {
                        dateFormat: 'd F Y', // Format sesuai keinginan
                        defaultDate: this.date1, // Menggunakan tanggal dari database
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
                guruName: @json($data->guru->nama), // Set nama guru dari data yang sudah tersimpan

                // Data industri dan guru terkait
                industries: @json($industri), // Industri dan guru dari backend

                // Fungsi untuk update nama guru saat industri dipilih
                updateGuru() {
                    const selectedIndustri = this.industries.find(item => item.id == this.selectedIndustri);
                    if (selectedIndustri && selectedIndustri.gurus.length > 0) {
                        this.guruName = selectedIndustri.gurus[0].nama; // Isi guru dengan guru pertama yang terkait
                    } else {
                        this.guruName = ''; // Kosongkan jika tidak ada guru
                    }
                }
            }
        }
    </script>
</x-layout.default>
