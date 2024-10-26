<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


    <div>
        <form action="{{ url('jurnal/' . $data['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class=" px-4">
                        <div class="text-lg font-semibold mb-4">Data Jurnal</div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label for="tanggal">Tanggal<span class="text-danger">*</span></label>
                                <div x-data="tanggal">
                                    <input id="basic" x-model="date1" name="tanggal" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled  />
                                </div>
                                @error('tanggal')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="preloading-time">Waktu Mulai<span class="text-danger">*</span></label>
                                <div x-data="time_start">
                                    <input id="preloading-time" name="time_start" x-model="date4" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled  />
                                </div>
                                @error('time_start')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="preloading-time2">Waktu Selesai<span class="text-danger">*</span></label>
                                <div x-data="time_end">
                                    <input id="preloading-time2" name="time_end" x-model="date4" class="form-input disabled:pointer-events-none disabled:bg-[#eee] dark:disabled:bg-[#1b2e4b] cursor-not-allowed" disabled />
                                </div>
                                @error('time_end')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="items-center">
                            <div class="text-lg font-semibold mb-4">Kegiatan</div>
                            <textarea id="kegiatan" name="kegiatan" hidden></textarea>
                            <div id="summernote">{{ $data['kegiatan'] }}</div>
                            @error('kegiatan')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-6 items-center">
                            <div class="text-lg font-semibold mb-4">Keterangan</div>
                            <textarea id="keterangan" name="keterangan" hidden></textarea>
                            <div id="summernote1">{{ $data['keterangan'] }}</div>
                            @error('keterangan')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-8 px-4">
                        <div class="flex justify-end items-center mt-8 gap-4">
                            <a href="{{url('jurnal')}}" class="btn btn-outline-danger gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                    <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                        stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M17.5 9.50026H9.96155C8.04979 9.50026 6.5 11.05 6.5 12.9618C6.5 14.8736 8.04978 16.4233 9.96154 16.4233H14.5M17.5 9.50026L15.25 7.42334M17.5 9.50026L15.25 11.5772" 
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Kembali</a>
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
         * tanggal, time start, time end jurnal 
         */

        document.addEventListener('alpine:init', () => {
            Alpine.data('tanggal', () => ({
                date1: @json($data['tanggal']),
                init() {
                    flatpickr("#basic", {
                        dateFormat: "d-m-Y",
                        defaultDate: this.date1,
                        locale: {
                            firstDayOfWeek: 1 
                        }
                    });
                }
            }));

            Alpine.data('time_start', () => ({
                date4: @json($data['time_start']),
                init() {
                    flatpickr("#preloading-time", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        defaultDate: this.date4,
                        locale: {
                            firstDayOfWeek: 1
                        }
                    });
                }
            }));

            Alpine.data('time_end', () => ({
                date4: @json($data['time_end']),
                init() {
                    flatpickr("#preloading-time2", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                        defaultDate: this.date4,
                        locale: {
                            firstDayOfWeek: 1
                        }
                    });
                }
            }));
        });

        /*************
         * summernote kegiatan dan keterangan 
         */

        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Kegiatan',
                tabsize: 2,
                height: 300,  // Mengatur tinggi editor
                toolbar: false,  // Menyembunyikan toolbar
                codeviewFilter: true,  // Memfilter HTML yang berbahaya
                codeviewIframeFilter: true,  // Memfilter konten iframe berbahaya
                callbacks: {
                    onInit: function() {
                        $('#summernote').summernote('code', @json($data['kegiatan']));
                        $('#summernote').summernote('disable');  // Menonaktifkan editor (readonly)
                    }
                }
            });


            $('#summernote1').summernote({
                placeholder: 'Kegiatan',
                tabsize: 2,
                height: 300,  // Mengatur tinggi editor
                toolbar: false,  // Menyembunyikan toolbar
                codeviewFilter: true,  // Memfilter HTML yang berbahaya
                codeviewIframeFilter: true,  // Memfilter konten iframe berbahaya
                callbacks: {
                    onInit: function() {
                        $('#summernote1').summernote('code', @json($data['kegiatan']));
                        $('#summernote1').summernote('disable');  // Menonaktifkan editor (readonly)
                    }
                }
            });

        });

        /*************
         * summernote submit 
         */

        $(document).ready(function() {
            $('form').on('submit', function() {
                $('#kegiatan').val($('#summernote').summernote('code'));
                $('#keterangan').val($('#summernote1').summernote('code'));
            });
        });
    </script>
</x-layout.default>
