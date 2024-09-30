<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <div>
        <form action="{{ url('monitoring/' . $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    {{-- <div class=" px-4">
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="text-lg font-semibold">Data Bidang Keahlian</div>
                                <div class="flex items-center mt-4">
                                    <label for="guru_id" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Nama Guru<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <select required id="guru_id" name="guru_id" class="form-select w-full">
                                            <option value="">Pilih Guru</option>
                                            @foreach($guru as $item)
                                                <option value="{{ $item->id }}" @selected($data->guru_id == $item->id)>{{ $item->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                        @error('guru_id')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center mt-4">
                                    <label for="industri_id" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Nama Industri<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <select required id="industri_id" name="industri_id" class="form-select w-full">
                                            <option value="">Pilih Industri</option>
                                            @foreach($industri as $item)
                                                <option value="{{ $item->id }}" @selected($data->industri_id == $item->id)>{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('industri_id')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="tanggal" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Tanggal<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <div x-data="tanggal">
                                            <input value="{{ $data->tanggal }}" id="basic" x-model="date1" name="tanggal" class="form-input" />
                                        </div>
                                        @error('tanggal')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="lg:w-1/2 w-full">
                            </div>
                        </div>
                    </div> --}}
                    <div class="px-4">
                        <div class="text-lg font-semibold mb-4">Data Jadwal Monitoring</div>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="guru_id">Guru<span class="text-danger">*</span></label>
                                <select required id="guru_id" name="guru_id" class="form-select w-full">
                                    <option value="">Pilih Guru</option>
                                    @foreach($guru as $item)
                                        <option value="{{ $item->id }}" @selected($data->guru_id == $item->id)>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('guru_id')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="industri_id">Industri<span class="text-danger">*</span></label>
                                <select required id="industri_id" name="industri_id" class="form-select w-full">
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
                <div class="xl:w-[60%] w-full xl:mt-0 mt-6">
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
        document.addEventListener("alpine:init", () => {
            Alpine.data("tanggal", () => ({
                date1: @json($data['tanggal']), 
                init() {
                    flatpickr(document.getElementById('basic'), {
                        dateFormat: 'd F Y', // Format sesuai keinginan
                        defaultDate: this.date1, // Menggunakan tanggal hari ini
                        locale: 'id', // Bahasa Indonesia
                    });
                }
            }));
        });
    </script>
</x-layout.default>
