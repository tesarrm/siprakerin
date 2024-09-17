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
                        <div class="text-lg font-semibold">Data Bidang Keahlian</div>
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="lg:w-1/3 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="mt-4 flex items-center">
                                    <label for="tanggal" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Tanggal<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <div x-data="tanggal" x-init="init()">
                                            <input id="basic" x-model="date1" name="tanggal" class="form-input" />
                                        </div>
                                        @error('tanggal')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="lg:w-1/3 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="mt-4 flex items-center">
                                    <label for="singkatan" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Waktu Mulai<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <div x-data="time_start" x-init="init()">
                                            <input id="preloading-time" name="time_start" x-model="date4" class="form-input" />
                                        </div>
                                        @error('time_start')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="lg:w-1/3 w-full">
                                <div class="mt-4 flex items-center">
                                    <label for="singkatan" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Waktu Selesai<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <div x-data="time_end" x-init="init()">
                                            <input id="preloading-time2" name="time_end" x-model="date4" class="form-input" />
                                        </div>
                                        @error('time_end')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
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
                                Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tanggal', () => ({
                date1: @json($data['tanggal']),
                init() {
                    flatpickr("#basic", {
                        dateFormat: "d-m-Y",
                        defaultDate: this.date1,
                        locale: {
                            firstDayOfWeek: 1 // Set start of the week to Monday
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

        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Kegiatan',
                tabsize: 2,
                height: 300,  // Mengatur tinggi editor
                toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['font', ['fontname', 'fontsize', 'fontsizeunit', 'color', 'forecolor', 'backcolor']],
                ['fontstyle', ['bold', 'italic', 'underline', 'strikethrough']],
                ['case', ['superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['insert', ['link', 'picture', 'video', 'hr']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['misc', ['undo', 'redo']]
                ],
                fontNames: ['Arial', 'Courier New', 'Helvetica', 'Times New Roman', 'Verdana'],  // Font yang tersedia
                fontNamesIgnoreCheck: ['Comic Sans MS'],  // Font tambahan meski tidak ada di sistem
                lineHeights: ['1', '1.5', '2', '2.5', '3'],  // Opsi tinggi baris
                fontsizeUnits: ['px', 'pt'],  // Satuan ukuran font
                codeviewFilter: true,  // Memfilter HTML yang berbahaya
                codeviewIframeFilter: true,  // Memfilter konten iframe berbahaya
                callbacks: {
                    onInit: function() {
                        $('#summernote').summernote('code', @json($data['kegiatan']));
                    }
                }
            });

            $('#summernote1').summernote({
                placeholder: 'Keterangan',
                tabsize: 2,
                height: 300,  // Mengatur tinggi editor
                toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['font', ['fontname', 'fontsize', 'fontsizeunit', 'color', 'forecolor', 'backcolor']],
                ['fontstyle', ['bold', 'italic', 'underline', 'strikethrough']],
                ['case', ['superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['insert', ['link', 'picture', 'video', 'hr']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview', 'help']],
                ['misc', ['undo', 'redo']]
                ],
                fontNames: ['Arial', 'Courier New', 'Helvetica', 'Times New Roman', 'Verdana'],  // Font yang tersedia
                fontNamesIgnoreCheck: ['Comic Sans MS'],  // Font tambahan meski tidak ada di sistem
                lineHeights: ['1', '1.5', '2', '2.5', '3'],  // Opsi tinggi baris
                fontsizeUnits: ['px', 'pt'],  // Satuan ukuran font
                codeviewFilter: true,  // Memfilter HTML yang berbahaya
                codeviewIframeFilter: true,  // Memfilter konten iframe berbahaya
                callbacks: {
                    onInit: function() {
                        $('#summernote1').summernote('code', @json($data['keterangan']));
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function() {
                $('#kegiatan').val($('#summernote').summernote('code'));
                $('#keterangan').val($('#summernote1').summernote('code'));
            });
        });
    </script>
</x-layout.default>
