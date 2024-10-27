<x-layout.default>
    <!-- Include necessary styles and scripts -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/nouislider.min.css') }}">
    <script src="/assets/js/nouislider.min.js"></script>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>

    <div>
        <form action="{{ url('capaian') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel xl:w-[800px] px-0 w-full xl:mt-0 mt-6">
                    <div class="px-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="text-lg font-semibold mb-4">Data Industri</div>

                            <input class="hidden" type="text" name="jurusan_id" value="{{ $jurusan->id }}" />

                            <!-- Wrapper for dynamic textarea inputs -->
                            <div id="textarea-wrapper" class="grid grid-cols-1 gap-4">
                                @foreach($jurusan->capaianPembelajaran as $index => $capaian)
                                    <div class="capaian-container">
                                        <label for="capaian_pembelajaran_{{ $index + 1 }}" class="text-base">
                                            Capaian Pembelajaran {{ $index + 1 }}
                                        </label>
                                        <textarea 
                                            id="capaian_pembelajaran_{{ $index + 1 }}" 
                                            rows="2" 
                                            name="capaian_pembelajaran[{{ $index }}][nama]" 
                                            class="form-textarea" 
                                            required
                                        >{{ old('capaian_pembelajaran.' . $index . '.nama', $capaian->nama) }}</textarea>

                                        <div id="tujuan-wrapper-{{ $index + 1 }}" class="grid grid-cols-1 gap-4 mt-4 ml-6 tujuan-container">
                                            @foreach($capaian->tujuanPembelajaran as $tujuanIndex => $tujuan)
                                                <div>
                                                    <label for="tujuan_pembelajaran_{{ $index + 1 }}_{{ $tujuanIndex + 1 }}">
                                                        Tujuan Pembelajaran {{ $tujuanIndex + 1 }}
                                                    </label>
                                                    <input 
                                                        id="tujuan_pembelajaran_{{ $index + 1 }}_{{ $tujuanIndex + 1 }}" 
                                                        name="capaian_pembelajaran[{{ $index }}][tujuan_pembelajaran][]" 
                                                        class="form-input" 
                                                        value="{{ old('capaian_pembelajaran.' . $index . '.tujuan_pembelajaran.' . $tujuanIndex, $tujuan->nama) }}" 
                                                        required>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="flex gap-4 ml-6 mt-2">
                                            <ul class="flex items-center justify-center gap-2">
                                                <li>
                                                    <a href="javascript:;" x-tooltip="Tambah" onclick="addTujuan({{ $index + 1 }})">
                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                                            class="w-5 h-5 text-primary">
                                                            <circle opacity="0.5" cx="12" cy="12" r="10" 
                                                                stroke="currentColor" stroke-width="1.5"/>
                                                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" 
                                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" x-tooltip="Hapus" onclick="removeTujuan({{ $index + 1 }})">
                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                                            class="w-5 h-5 text-danger">
                                                            <circle opacity="0.5" cx="12" cy="12"
                                                                r="10" stroke="currentColor"
                                                                stroke-width="1.5" />
                                                            <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" />
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Buttons to add and remove textarea -->
                        <div class="mt-4 flex gap-4">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTextarea()">Tambah</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeTextarea()">Hapus</button>
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
                                Simpan 
                            </button>

                            <a href="{{url('capaian')}}" class="btn btn-outline-danger gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                    <path opacity="0.5" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" 
                                        stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M17.5 9.50026H9.96155C8.04979 9.50026 6.5 11.05 6.5 12.9618C6.5 14.8736 8.04978 16.4233 9.96154 16.4233H14.5M17.5 9.50026L15.25 7.42334M17.5 9.50026L15.25 11.5772" 
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Kembali 
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-1 py-6">
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts to dynamically add/remove textarea inputs -->
    <script>
        let capaianCounter = @json($capaianCount);
        console.log(capaianCounter);

        // Function to add new Capaian Pembelajaran along with its Tujuan Pembelajaran
        function addTextarea() {
            const wrapper = document.getElementById('textarea-wrapper');
            const newCapaian = `
                <div class="capaian-container">
                    <label class="text-base mt-2" for="capaian_pembelajaran_${capaianCounter}">Capaian Pembelajaran ${capaianCounter + 1}</label>
                    <textarea 
                        id="capaian_pembelajaran_${capaianCounter}" 
                        rows="2" 
                        name="capaian_pembelajaran[${capaianCounter}][nama]" 
                        class="form-textarea" 
                        placeholder="Isi Capaian Pembelajaran ${capaianCounter + 1}" 
                        required></textarea>

                    <div id="tujuan-wrapper-${capaianCounter}" class="grid grid-cols-1 gap-4 mt-4 ml-6 tujuan-container">
                        <div>
                            <label for="tujuan_pembelajaran_${capaianCounter}_1">Tujuan Pembelajaran 1</label>
                            <input
                                id="tujuan_pembelajaran_${capaianCounter}_1" 
                                name="capaian_pembelajaran[${capaianCounter}][tujuan_pembelajaran][]" 
                                class="form-input"
                                placeholder="Isi Tujuan Pembelajaran 1" 
                                required>
                        </div>
                    </div>
                    <!-- Button to add tujuan -->
                    <div class="flex gap-4 ml-6 mt-2">
                        <ul class="flex items-center justify-center gap-2">
                            <li>
                                <a href="javascript:;" x-tooltip="Tambah" onclick="addTujuan(${capaianCounter})">
                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-primary">
                                        <circle opacity="0.5" cx="12" cy="12" r="10" 
                                            stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" 
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" x-tooltip="Hapus" onclick="removeTujuan(${capaianCounter})">
                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-danger">
                                        <circle opacity="0.5" cx="12" cy="12"
                                            r="10" stroke="currentColor"
                                            stroke-width="1.5" />
                                        <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                            stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', newCapaian);
            capaianCounter++;
        }

        // Function to remove the last Capaian Pembelajaran
        function removeTextarea() {
            const wrapper = document.getElementById('textarea-wrapper');
            if (wrapper.children.length > 1) {
                wrapper.removeChild(wrapper.lastElementChild);
                capaianCounter--;
            }
        }

        // Function to dynamically add Tujuan Pembelajaran under specific Capaian Pembelajaran
        function addTujuan(capaianIndex) {
            const tujuanWrapper = document.getElementById(`tujuan-wrapper-${capaianIndex}`);
            const tujuanCount = tujuanWrapper.children.length + 1;
            const newTujuan = `
                <div>
                    <label for="tujuan_pembelajaran_${capaianIndex}_${tujuanCount}">Tujuan Pembelajaran ${tujuanCount}</label>
                    <input
                        id="tujuan_pembelajaran_${capaianIndex}_${tujuanCount}" 
                        name="capaian_pembelajaran[${capaianIndex}][tujuan_pembelajaran][]" 
                        class="form-input"
                        placeholder="Isi Tujuan Pembelajaran ${tujuanCount}" 
                        required>
                </div>
            `;
            tujuanWrapper.insertAdjacentHTML('beforeend', newTujuan);
        }

        function removeTujuan(capaianIndex) {
            const tujuanWrapper = document.getElementById(`tujuan-wrapper-${capaianIndex}`);
            if (tujuanWrapper.children.length > 1) {
                tujuanWrapper.removeChild(tujuanWrapper.lastElementChild);
            }
        }
    </script>
</x-layout.default>
