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
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
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
                                        <textarea id="capaian_pembelajaran_{{ $index + 1 }}" rows="5" name="capaian_pembelajaran[{{ $index }}][nama]" class="form-textarea" required>{{ old('capaian_pembelajaran.' . $index . '.nama', $capaian->nama) }}</textarea>

                                        <div id="tujuan-wrapper-{{ $index + 1 }}" class="grid grid-cols-1 gap-4 mt-4 ml-6 tujuan-container">
                                            @foreach($capaian->tujuanPembelajaran as $tujuanIndex => $tujuan)
                                                <div>
                                                    <label for="tujuan_pembelajaran_{{ $index + 1 }}_{{ $tujuanIndex + 1 }}">
                                                        Tujuan Pembelajaran {{ $tujuanIndex + 1 }}
                                                    </label>
                                                    <textarea id="tujuan_pembelajaran_{{ $index + 1 }}_{{ $tujuanIndex + 1 }}" rows="3" name="capaian_pembelajaran[{{ $index }}][tujuan_pembelajaran][]" class="form-textarea" required>{{ old('capaian_pembelajaran.' . $index . '.tujuan_pembelajaran.' . $tujuanIndex, $tujuan->nama) }}</textarea>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="flex gap-4 ml-6 mt-2">
                                            <button type="button" class="btn btn-primary mt-2" onclick="addTujuan({{ $index + 1 }})">Add Tujuan</button>
                                            <button type="button" class="btn btn-danger mt-2" onclick="removeTujuan({{ $index + 1 }})">Remove Tujuan</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Buttons to add and remove textarea -->
                        <div class="mt-4 flex gap-4">
                            <button type="button" class="btn btn-primary" onclick="addTextarea()">Add Capaian Pembelajaran</button>
                            <button type="button" class="btn btn-danger" onclick="removeTextarea()">Delete Capaian Pembelajaran</button>
                        </div>
                    </div>

                    <div class="mt-8 px-4">
                        <div class="flex justify-end items-center mt-8 gap-4">
                            <button type="submit" class="btn btn-success gap-2">
                                Simpan 
                            </button>

                            <button type="button" class="btn btn-outline-danger gap-2">
                                Kembali 
                            </button>
                        </div>
                    </div>
                </div>
                <div class="xl:w-96 w-full xl:mt-0 mt-6">
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts to dynamically add/remove textarea inputs -->
    <script>
        let capaianCounter = @json($capaian->count());

        // Function to add new Capaian Pembelajaran along with its Tujuan Pembelajaran
        function addTextarea() {
            const wrapper = document.getElementById('textarea-wrapper');
            const newCapaian = `
                <div class="capaian-container">
                    <label class="text-base mt-2" for="capaian_pembelajaran_${capaianCounter}">Capaian Pembelajaran ${capaianCounter + 1}</label>
                    <textarea id="capaian_pembelajaran_${capaianCounter}" rows="5" name="capaian_pembelajaran[${capaianCounter}][nama]" class="form-textarea" 
                        placeholder="Isi capaian pembelajaran ${capaianCounter + 1}" required></textarea>

                    <div id="tujuan-wrapper-${capaianCounter}" class="grid grid-cols-1 gap-4 mt-4 ml-6 tujuan-container">
                        <div>
                            <label for="tujuan_pembelajaran_${capaianCounter}_1">Tujuan Pembelajaran 1</label>
                            <textarea id="tujuan_pembelajaran_${capaianCounter}_1" rows="3" name="capaian_pembelajaran[${capaianCounter}][tujuan_pembelajaran][]" class="form-textarea"
                                placeholder="Isi Tujuan Pembelajaran 1" required></textarea>
                        </div>
                    </div>
                    <!-- Button to add tujuan -->
                    <div class="flex gap-4 ml-6 mt-2">
                        <button type="button" class="btn btn-primary mt-2" onclick="addTujuan(${capaianCounter})">Add Tujuan</button>
                        <button type="button" class="btn btn-danger mt-2" onclick="removeTujuan(${capaianCounter})">Remove Tujuan</button>
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
                    <textarea id="tujuan_pembelajaran_${capaianIndex}_${tujuanCount}" rows="3" name="capaian_pembelajaran[${capaianIndex}][tujuan_pembelajaran][]" class="form-textarea"
                        placeholder="Isi Tujuan Pembelajaran ${tujuanCount}" required></textarea>
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
