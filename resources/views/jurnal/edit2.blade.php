<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <form action="{{ url('izin/' . $izin->id) }}" method="POST" enctype="multipart/form-data" id="form2">
                    @csrf
                    @method('PUT')
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
                                    <textarea id="catatan" rows="3" name="catatan" class="form-textarea" 
                                        placeholder="Isi Catatan" required>{{$izin->catatan}}</textarea>
                                    @error('catatan')
                                        <div class="mt-2 text-danger">{{ $message }}</div>
                                    @enderror
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
                    </div>
                </form>
            </div>
        </div>
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
        @if($izin->gambar)
        pond.addFile("{{ asset('storage/posts/' . $izin->gambar) }}")
            .then(file => {
                console.log('Existing file loaded', file);
            })
            .catch(error => {
                console.error('Failed to load existing file', error);
            });
        @endif

        /*************
         * tanggal jurnal 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("tanggal1", () => ({
                date1: @json($izin->tanggal), // Inisialisasi kosong, akan diisi di init()
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
