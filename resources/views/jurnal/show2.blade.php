<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link
        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet"
    />

    <div>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <form action="{{ url('izin') }}" method="POST" enctype="multipart/form-data" id="form2">
                    @csrf
                    <div class="px-4"  >
                        <div class="text-lg font-semibold">Surat Izin</div>
                        <div class="flex xl:flex-row flex-col gap-6">
                            <div class="space-y-5 px-0 flex-1 py-6" >
                                <div class="mb-5 border rounded-xl overflow-hidden">
                                    <img class="object-cover w-full h-full" src="{{ asset('storage/posts/' . $izin->gambar) }}"> 
                                </div>
                            </div>
                            <div class="xl:w-96 w-full xl:mt-0 mt-6 space-y-5">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="tanggal1">Tanggal<span class="text-danger">*</span></label>
                                        <div x-data="tanggal1">
                                            <input id="basic" x-model="date1" name="tanggal" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="catatan">Catatan</label>
                                    <textarea id="catatan" rows="10" name="catatan" class="form-textarea bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly 
                                        placeholder="Isi Catatan" required>{{ $izin->catatan }}</textarea>
                                </div>
                                {{-- button --}}
                                <div class="px-4">
                                    <div class="flex justify-end items-center mt-8 gap-4">
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
