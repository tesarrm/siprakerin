<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <script src="/assets/js/flatpickr-id.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <script src="/assets/js/jquery-3.4.1.slim.min.js"></script>
    <link href="/assets/css/summernote/summernote-lite.min.css" rel="stylesheet">
    <script src="/assets/js/summernote-lite.min.js"></script>

    <script src="/assets/js/filepond.js"></script>
    <script src="/assets/js/filepond-plugin-image-preview.js"></script>
    <link href="/assets/css/filepond.css" rel="stylesheet" />
    <link href="/assets/css/filepond-plugin-image-preview.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>

    <div>
        @if($libur)
        <div
            class="relative flex items-center mb-4 border p-3.5 rounded before:inline-block before:absolute before:top-1/2 ltr:before:right-0 rtl:before:left-0 rtl:before:rotate-180 before:-mt-2 before:border-r-8 before:border-t-8 before:border-b-8 before:border-t-transparent before:border-b-transparent before:border-r-inherit text-danger bg-danger-light border-danger ltr:border-r-[64px] rtl:border-l-[64px] dark:bg-danger-dark-light  ltr:xl:mr-6 rtl:xl:ml-6">
            <span class="absolute ltr:-right-11 rtl:-left-11 inset-y-0 text-white w-6 h-6 m-auto">

                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                    <circle opacity="0.5" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="1.5" />
                    <path d="M12 7V13" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" />
                    <circle cx="12" cy="16" r="1" fill="currentColor" />
                </svg>
            </span>
            <div class="w-full flex justify-between">
                <span class="ltr:pr-2 rtl:pl-2"><strong class="ltr:mr-1 rtl:ml-1">Peringatan!</strong>
                    Hari ini libur di industri Anda. 
                </span>
                <span>
                    Klik checkbox jika Anda masuk
                    <input type="checkbox" id="toggle-checkbox1" onclick="toggleForms2()" class="form-checkbox border-red-500" style="margin-top: -3px;" />
                </span>
            </div>
        </div>
        @endif

        <div onload="toggleForms2()">
            <div id="form3">
                <div class="flex xl:flex-row flex-col gap-2.5">
                    <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6" onload="toggleForms()">
                        <div class="px-4 mb-4">
                            <div class="text-lg font-semibold mb-4">Jurnal dan Kehadiran</div>
                            <input type="checkbox" id="toggle-checkbox" onclick="toggleForms()" class="form-checkbox" />
                            <span>Izin Tidak Masuk</span>
                        </div>

                        {{-- form jurnal --}}
                        <form action="{{ url('jurnal') }}" method="POST" enctype="multipart/form-data" id="form1">
                            @csrf
                            <div class=" px-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                                    <div>
                                        <label for="tanggal">Tanggal<span class="text-danger">*</span></label>
                                        <div x-data="tanggal">
                                            <input id="basic" x-model="date1" name="tanggal" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly />
                                        </div>
                                        @error('tanggal')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="preloading-time">Waktu Mulai<span class="text-danger">*</span></label>
                                        <div x-data="time_start">
                                            <input id="preloading-time" name="time_start" x-model="date4" class="form-input" />
                                        </div>
                                        @error('time_start')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="preloading-time2">Waktu Selesai<span class="text-danger">*</span></label>
                                        <div x-data="time_end">
                                            <input id="preloading-time2" name="time_end" x-model="date4" class="form-input" />
                                        </div>
                                        @error('time_end')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="items-center">
                                    <div class="text-lg font-semibold mb-4">Kegiatan</div>
                                    <textarea id="kegiatan" name="kegiatan" hidden></textarea>
                                    <div id="summernote"></div>
                                    @error('kegiatan')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-6 items-center">
                                    <div class="text-lg font-semibold mb-4">Keterangan</div>
                                    <textarea id="keterangan" name="keterangan" hidden></textarea>
                                    <div id="summernote1"></div>
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

                                    <a href="{{url('jurnal')}}" class="btn btn-outline-danger gap-2">
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
                        </form>

                        {{-- form izin --}}
                        <form action="{{ url('izin') }}" method="POST" enctype="multipart/form-data" id="form2" style="display: none;">
                            @csrf
                            <div class="px-4"  >
                                <div class="text-lg font-semibold">Surat Izin</div>
                                <div class="flex xl:flex-row flex-col gap-6">
                                    <div class="space-y-5 px-0 flex-1 py-6" >
                                        <div class="mb-5">
                                            <input type="file" id="gambar" name="gambar">
                                            @error('gambar')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="xl:w-96 w-full xl:mt-0 mt-6 space-y-5">
                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <label for="tanggal1">Tanggal<span class="text-danger">*</span></label>
                                                <div x-data="tanggal1">
                                                    <input id="basic" x-model="date1" name="tanggal" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly />
                                                </div>
                                                @error('tanggal')
                                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <label for="catatan">Catatan</label>
                                            <textarea id="catatan" rows="10" name="catatan" class="form-textarea" 
                                                placeholder="Isi Catatan" required></textarea>
                                            @error('catatan')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- button --}}
                                        <div class="px-4">
                                            <div class="flex justify-end items-center mt-8 gap-4">
                                                <button id="button-submit" type="submit" class="btn btn-success gap-2">
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

                                                <a href="{{url('jurnal')}}" class="btn btn-outline-danger gap-2">
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
                                                    Kembali </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================== --}}
    {{-- BOTTOM --}}
    {{-- =========================== --}}

    <script>
        /*************
         * checkbox izin tidak masuk 
         */

        function toggleForms() {
            const checkbox = document.getElementById('toggle-checkbox');
            const form1 = document.getElementById('form1');
            const form2 = document.getElementById('form2');
            
            if (checkbox.checked) {
                form1.style.display = 'none';
                form2.style.display = 'block';
            } else {
                form1.style.display = 'block';
                form2.style.display = 'none';
            }
        }

        /*************
         * checkbox libur 
         */

        const form3 = document.getElementById('form3');
        if(@json($libur)){
            form3.style.display = 'none';
        }
        function toggleForms2() {
            const checkbox1 = document.getElementById('toggle-checkbox1');
            const form3 = document.getElementById('form3');
            
            if (checkbox1.checked) {
                form3.style.display = 'block';
            } else {
                form3.style.display = 'none';
            }
        }

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
        const submitButton = document.querySelector('button[id="button-submit"]');
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

        /*************
         * tanggal jurnal 
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
         * tanggal izin 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("tanggal1", () => ({
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
         * time start jurnal 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("time_start", () => ({
                date4: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false }), 
                init() {
                    flatpickr(document.getElementById('preloading-time'), {
                        defaultDate: this.date4,
                        noCalendar: true,
                        enableTime: true,
                        dateFormat: 'H:i'
                    })
                }
            }));
        });

        /*************
         * time end jurnal 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("time_end", () => ({
                date4: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false }), 
                init() {
                    flatpickr(document.getElementById('preloading-time2'), {
                        defaultDate: this.date4,
                        noCalendar: true,
                        enableTime: true,
                        dateFormat: 'H:i'
                    })
                }
            }));
        });

        /*************
         * summernote kegiatan 
         */

        $('#summernote').summernote({
            placeholder: 'Complete toolbar example',
            tabsize: 2,
            height: 300,  // Mengatur tinggi editor
            toolbar: [
            // Style group
            ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            // Font group
            ['font', ['fontname', 'fontsize', 'fontsizeunit', 'color', 'forecolor', 'backcolor']],
            // Font style group
            ['fontstyle', ['bold', 'italic', 'underline', 'strikethrough']],
            // Font case group
            ['case', ['superscript', 'subscript']],
            // Paragraph group
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            // Insert group
            ['insert', ['link', 'picture', 'video', 'hr']],
            // Table group
            ['table', ['table']],
            // View group
            ['view', ['fullscreen', 'codeview', 'help']],
            // Misc group
            ['misc', ['undo', 'redo']]
            ],
            fontNames: ['Arial', 'Courier New', 'Helvetica', 'Times New Roman', 'Verdana'],  // Font yang tersedia
            fontNamesIgnoreCheck: ['Comic Sans MS'],  // Font tambahan meski tidak ada di sistem
            lineHeights: ['1', '1.5', '2', '2.5', '3'],  // Opsi tinggi baris
            fontsizeUnits: ['px', 'pt'],  // Satuan ukuran font
            codeviewFilter: true,  // Memfilter HTML yang berbahaya
            codeviewIframeFilter: true  // Memfilter konten iframe berbahaya
        });

        /*************
         * summernote keterangan 
         */

        $('#summernote1').summernote({
            placeholder: 'Complete toolbar example',
            tabsize: 2,
            height: 200,  // Mengatur tinggi editor
            toolbar: [
            // Style group
            ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            // Font group
            ['font', ['fontname', 'fontsize', 'fontsizeunit', 'color', 'forecolor', 'backcolor']],
            // Font style group
            ['fontstyle', ['bold', 'italic', 'underline', 'strikethrough']],
            // Font case group
            ['case', ['superscript', 'subscript']],
            // Paragraph group
            ['para', ['ul', 'ol', 'paragraph', 'height']],
            // Insert group
            ['insert', ['link', 'picture', 'video', 'hr']],
            // Table group
            ['table', ['table']],
            // View group
            ['view', ['fullscreen', 'codeview', 'help']],
            // Misc group
            ['misc', ['undo', 'redo']]
            ],
            fontNames: ['Arial', 'Courier New', 'Helvetica', 'Times New Roman', 'Verdana'],  // Font yang tersedia
            fontNamesIgnoreCheck: ['Comic Sans MS'],  // Font tambahan meski tidak ada di sistem
            lineHeights: ['1', '1.5', '2', '2.5', '3'],  // Opsi tinggi baris
            fontsizeUnits: ['px', 'pt'],  // Satuan ukuran font
            codeviewFilter: true,  // Memfilter HTML yang berbahaya
            codeviewIframeFilter: true  // Memfilter konten iframe berbahaya
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
