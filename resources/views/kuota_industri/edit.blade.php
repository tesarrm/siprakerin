<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>

    <div>
        <form action="{{ route('kuota-industri.storeOrUpdate') }}" method="POST">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class=" px-4">
                        <input type="hidden" name="industri_id" value="{{ $industri_id }}">
                        
                        <div class="flex">
                            <!-- Kolom untuk Laki-laki -->
                            <div class="w-1/2 pr-4">
                                <div class="text-lg font-semibold mb-4">Kuota Laki-laki</div>
                                @foreach($jurusans as $jurusan)
                                    <div class="flex items-center mb-2">
                                        <label for="jurusan_{{ $jurusan->id }}_laki" class="w-3/4">{{ $jurusan->singkatan . " (" . $jurusan->nama . ")" }}</label>
                                        <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                                        <input type="number" name="kuota[{{ $jurusan->id }}][laki_kuota]" 
                                            class="form-input w-full" 
                                            value="{{ old('kuota.'.$jurusan->id.'.laki_kuota', $kuotas[$jurusan->id]['laki']) }}" 
                                            placeholder="Kuota Laki-laki">
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Kolom untuk Perempuan -->
                            <div class="w-1/2 pl-4">
                                <div class="text-lg font-semibold mb-4">Kuota Perempuan</div>
                                @foreach($jurusans as $jurusan)
                                    <div class="flex items-center mb-2">
                                        <label for="jurusan_{{ $jurusan->id }}_perempuan" class="w-3/4">{{ $jurusan->singkatan . " (" . $jurusan->nama . ")" }}</label>
                                        <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                                        <input type="number" name="kuota[{{ $jurusan->id }}][perempuan_kuota]" 
                                            class="form-input w-full" 
                                            value="{{ old('kuota.'.$jurusan->id.'.perempuan_kuota', $kuotas[$jurusan->id]['perempuan']) }}" 
                                            placeholder="Kuota Perempuan">
                                    </div>
                                @endforeach
                            </div>
                        </div>

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

                            <a href="{{url('kuotaindustri')}}" class="btn btn-outline-danger gap-2">
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
        </form>
     </div>
</x-layout.default>
