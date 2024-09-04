<x-layout.default>
    <div x-data="invoiceAdd">
        <form action="{{ url('guru') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="xl:w-96 w-full xl:mt-0 mt-6">
                    <div class="panel">
                        <div class="mb-5">
                            <div class="text-lg font-semibold">Foto Profil</div>
                            <input type="file" id="gambar" name="gambar" class="mt-4">
                        </div>
                    </div>
                </div>
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class=" px-4">
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="text-lg font-semibold">Data Guru</div>
                                <div class="mt-4 flex items-center">
                                    <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">NIP<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <input required id="reciever-name" type="text" name="nip" class="form-input w-full" 
                                            placeholder="Isi NIP" />
                                        @error('nip')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Nama Guru<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <input required id="reciever-name" type="text" name="nama_guru" class="form-input w-full"
                                            placeholder="Isi Nama Guru" />
                                        @error('nama_guru')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center mt-4">
                                    <label for="jenis_kelamin" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Jenis Kelamin<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <select required id="jenis_kelamin" name="jenis_kelamin" class="form-select w-full">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                                <div class="flex items-center mt-4">
                                    <label for="peran" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Peran<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <select required id="peran" name="peran" class="form-select w-full">
                                            <option value="">Pilih Peran</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        @error('peran')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                                <div class="flex items-center mt-4">
                                    <label for="wali_kelas" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Wali Kelas</label>
                                    <div class="flex-1">
                                        <select id="wali_kelas" name="wali_kelas" class="form-select w-full">
                                            <option value="">Pilih Kelas</option>
                                            <option value="United States">Laki-Laki</option>
                                            <option value="United Kingdom">Perempuan</option>
                                        </select>
                                        @error('wali_kelas')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                            </div>
                            <div class="lg:w-1/2 w-full">
                                <div class="flex items-center mt-11">
                                    <label for="acno" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Username<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <input required id="acno" type="text" name="username" class="form-input w-full"
                                            placeholder="Isi Username" />
                                        @error('username')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center mt-4">
                                    <label for="bank-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Password<span class="text-danger">*</span></label>
                                    <input required id="bank-name" type="password" name="password" class="form-input flex-1"
                                        placeholder="Isi Password" />
                                </div>
                                <div class="flex items-center mt-4">
                                    <label for="swift-code" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Konfirmasi Password<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <input required id="swift-code" type="password" name="konfirmasi_password" class="form-input w-full"
                                            placeholder="Isi Konfirmasi Password" />
                                        @error('password')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
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
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('invoiceAdd', () => ({
                items: [],
                selectedFile: null,
                params: {
                    title: '',
                    invoiceNo: '',
                    to: {
                        name: '',
                        email: '',
                        address: '',
                        phone: ''
                    },

                    invoiceDate: '',
                    dueDate: '',
                    bankInfo: {
                        no: '',
                        name: '',
                        swiftCode: '',
                        country: '',
                        ibanNo: ''
                    },
                    notes: '',
                },
                currencyList: [
                    'USD - US Dollar',
                    'GBP - British Pound',
                    'IDR - Indonesian Rupiah',
                    'INR - Indian Rupee',
                    'BRL - Brazilian Real',
                    'EUR - Germany (Euro)',
                    'TRY - Turkish Lira',
                ],
                selectedCurrency: 'USD - US Dollar',
                tax: null,
                discount: null,
                shippingCharge: null,
                paymentMethod: '',

                init() {
                    //set default data
                    this.items.push({
                        id: 1,
                        title: '',
                        description: '',
                        rate: 0,
                        quantity: 0,
                        amount: 0
                    });
                },

                addItem() {
                    let maxId = 0;
                    if (this.items && this.items.length) {
                        maxId = this.items.reduce((max, character) => (character.id > max ? character
                            .id : max), this.items[0].id);
                    }
                    this.items.push({
                        id: maxId + 1,
                        title: '',
                        description: '',
                        rate: 0,
                        quantity: 0,
                        amount: 0
                    });
                },

                removeItem(item) {
                    this.items = this.items.filter((d) => d.id != item.id);
                }
            }));
        });
    </script>

    <!-- start hightlight js -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <!-- end hightlight js -->

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    {{-- filepond --}}
    {{-- <script>
        FilePond.registerPlugin(FilePondPluginImagePreview)

        // Get a reference to the file input element
        const inputElement = document.querySelector('input[type="file"]');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement);

        FilePond.setOptions({
            server: {
                process: '/tmp-upload',
                revert: '/tmp-delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        })
    </script> --}}

<script>
    FilePond.registerPlugin(FilePondPluginImagePreview)

    // Get a reference to the file input element
    const inputElement = document.querySelector('input[type="file"]');

    // Create a FilePond instance
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

    // Listen for page unload (when user navigates away from the page)
    window.addEventListener('beforeunload', function(event) {
        // Check if there is a file in FilePond
        if (pond.getFiles().length > 0) {
            // Trigger revert for each file
            pond.getFiles().forEach(fileItem => {
                pond.removeFile(fileItem.id, {
                    revert: true
                });
            });
        }
    });
</script>
</x-layout.default>
