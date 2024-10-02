<x-layout.default>
    <div>
        <form action="{{ url('pilihankota/' . $siswa->id . '/membuat' ) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                @if(!$data->status)
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class="px-4">
                        <div class="text-lg font-semibold mb-4">Data Pilihan Kota</div>
                        <div class="grid grid-cols-1 gap-4">
                            <input type="text" hidden name="siswa_id" value="{{ $siswa->id }}">
                            <div>
                                <label for="kota_id_1">Pilihan 1</label>
                                <select required id="kota_id_1" name="kota_id_1" class="form-select w-full">
                                    <option value="">Pilih Pilihan 1</option>
                                    @foreach($kota as $item)
                                        <option value="{{ $item->id }}" @selected($data->kota_id_1 == $item->id)>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kota_id_1')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="kota_id_2">Pilihan 2</label>
                                <select required id="kota_id_2" name="kota_id_2" class="form-select w-full">
                                    <option value="">Pilih Pilihan 2</option>
                                    @foreach($kota as $item)
                                        <option value="{{ $item->id }}" @selected($data->kota_id_2 == $item->id)>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kota_id_2')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="kota_id_3">Pilihan 3</label>
                                <select required id="kota_id_3" name="kota_id_3" class="form-select w-full">
                                    <option value="">Pilih Pilihan 3</option>
                                    @foreach($kota as $item)
                                        <option value="{{ $item->id }}" @selected($data->kota_id_3 == $item->id)>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kota_id_3')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="alasan">Alasan</label>
                                <textarea id="alasan" rows="3" name="alasan" class="form-textarea" 
                                    placeholder="Isi Alasan" required>{{ $data->alasan }}</textarea>
                                @error('alasan')
                                    <div class="mt-2 text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <input type="checkbox" name="status" class="form-checkbox" @checked($data->status) />
                                <span>Konfirmasi pilihan kota</span>
                                @error('status')
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
                                Submit</button>
                        </div>
                    </div>
                </div>
                <div class="xl:w-[60%] w-full xl:mt-0 mt-6">
                </div>
                @else
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class=" px-4">
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="text-lg font-semibold">Data Pilihan Kota</div>
                                <div class="mt-4 flex items-center">
                                    <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Nama</label>
                                    <div class="flex-1">
                                        <input value="{{ old('nama', $siswa->nama) }}" required id="reciever-name" type="text" name="nama" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly  />
                                        @error('nama')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="reciever-name" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Kelas</label>
                                    <div class="flex-1">
                                        <input value="{{ $siswa->kelas->nama." ".$siswa->kelas->jurusan->singkatan." ".$siswa->kelas->klasifikasi }}" required id="reciever-name" type="text" name="nama" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly  />
                                    </div>
                                </div>

                                <div class="flex items-center mt-4">
                                    <label for="kota_id_1" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Pilihan 1</label>
                                    <div class="flex-1">
                                        <select required id="kota_id_1" name="kota_id_1" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly>
                                            <option value="">Pilih Pilihan 1</option>
                                            @foreach($kota as $item)
                                                <option value="{{ $item->id }}" @selected($data->kota_id_1 == $item->id)>{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kota_id_1')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center mt-4">
                                    <label for="kota_id_2" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Pilihan 2</label>
                                    <div class="flex-1">
                                        <select required id="kota_id_2" name="kota_id_2" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly>
                                            <option value="">Pilih Pilihan 2</option>
                                            @foreach($kota as $item)
                                                <option value="{{ $item->id }}" @selected($data->kota_id_2 == $item->id)>{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kota_id_2')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center mt-4">
                                    <label for="kota_id_3" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Pilihan 3</label>
                                    <div class="flex-1">
                                        <select required id="kota_id_3" name="kota_id_3" class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly>
                                            <option value="">Pilih Pilihan 3</option>
                                            @foreach($kota as $item)
                                                <option value="{{ $item->id }}" @selected($data->kota_id_3 == $item->id)>{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kota_id_3')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center mt-4">
                                    <label for="kota_id_3" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Alasan</label>
                                    <div class="flex-1">
                                        <textarea id="alasan" rows="3" name="alasan" class="form-textarea pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly" 
                                            placeholder="Isi Alasan" required>{{ $data->alasan }}</textarea>
                                        @error('alasan')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 px-4">
                        <div class="flex justify-end items-center mt-8 gap-4">
                            <a href="/pilihankota-pdf" class="btn btn-warning gap-2">

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
                                Cetak </a>
                            <button type="submit" class="btn btn-primary gap-2">

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
                                Cetak</button>
                        </div>
                    </div>
                </div>
                <div class="xl:w-96 w-full xl:mt-0 mt-6">
                </div>
                @endif
            </div>
        </form>
    </div>

    <!-- start hightlight js -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <!-- end hightlight js -->

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
</x-layout.default>
