<x-layout.default>
    <div>

{{-- <form action="{{ route('kuota-industri.storeOrUpdate') }}" method="POST">
    @csrf
    <input type="hidden" name="industri_id" value="{{ $industri_id }}">
    
    <div class="flex">
        <!-- Kolom untuk Laki-laki -->
        <div class="flex-1 pr-4">
            <h3 class="text-lg font-semibold mb-4">Laki-laki</h3>
            @foreach($jurusans as $jurusan)
                <div class="flex items-center mb-2">
                    <label for="laki_{{ $jurusan->id }}" class="w-1/2">{{ $jurusan->nama }}</label>
                    <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                    <input type="number" name="kuota[{{ $jurusan->id }}][kuota]" class="form-input w-full" placeholder="Kuota Laki-laki">
                </div>
            @endforeach
        </div>

        <!-- Kolom untuk Perempuan -->
        <div class="flex-1 pl-4">
            <h3 class="text-lg font-semibold mb-4">Perempuan</h3>
            @foreach($jurusans as $jurusan)
                <div class="flex items-center mb-2">
                    <label for="perempuan_{{ $jurusan->id }}" class="w-1/2">{{ $jurusan->nama }}</label>
                    <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                    <input type="number" name="kuota[{{ $jurusan->id }}][kuota]" class="form-input w-full" placeholder="Kuota Perempuan">
                </div>
            @endforeach
        </div>
    </div>
    
    <button type="submit" class="btn btn-success mt-4">Simpan</button>
</form> --}}

{{-- <form action="{{ route('kuota-industri.storeOrUpdate') }}" method="POST">
    @csrf
    <input type="hidden" name="industri_id" value="{{ $industri_id }}">
    
    <div class="flex">
        <!-- Kolom Laki-laki -->
        <div class="flex-1 p-4">
            <h3 class="text-lg font-semibold">Laki-laki</h3>
            <div class="space-y-4">
                @foreach($jurusans as $jurusan)
                    <div class="flex items-center mb-2">
                        <label for="laki_{{ $jurusan->id }}" class="w-1/3">{{ $jurusan->nama }}</label>
                        <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                        
                        <input type="hidden" name="kuota[{{ $jurusan->id }}][jenis_kelamin]" value="Laki-laki">
                        
                        <input type="number" name="kuota[{{ $jurusan->id }}][kuota]" class="form-input w-1/2" placeholder="Kuota">
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Kolom Perempuan -->
        <div class="flex-1 p-4">
            <h3 class="text-lg font-semibold">Perempuan</h3>
            <div class="space-y-4">
                @foreach($jurusans as $jurusan)
                    <div class="flex items-center mb-2">
                        <label for="perempuan_{{ $jurusan->id }}" class="w-1/3">{{ $jurusan->nama }}</label>
                        <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                        
                        <input type="hidden" name="kuota[{{ $jurusan->id }}][jenis_kelamin]" value="Perempuan">
                        
                        <input type="number" name="kuota[{{ $jurusan->id }}][kuota]" class="form-input w-1/2" placeholder="Kuota">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-success">Simpan</button>
</form> --}}

    {{-- <form action="{{ route('kuota-industri.storeOrUpdate') }}" method="POST">
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
                                    <label for="jurusan_{{ $jurusan->id }}_laki" class="w-1/2">{{ $jurusan->nama }}</label>
                                    <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                                    <input type="number" name="kuota[{{ $jurusan->id }}][laki_kuota]" class="form-input w-full" placeholder="Kuota Laki-laki">
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Kolom untuk Perempuan -->
                        <div class="w-1/2 pl-4">
                            <div class="text-lg font-semibold mb-4">Kuota Perempuan</div>
                            @foreach($jurusans as $jurusan)
                                <div class="flex items-center mb-2">
                                    <label for="jurusan_{{ $jurusan->id }}_perempuan" class="w-1/2">{{ $jurusan->nama }}</label>
                                    <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                                    <input type="number" name="kuota[{{ $jurusan->id }}][perempuan_kuota]" class="form-input w-full" placeholder="Kuota Perempuan">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </form> --}}

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
                                <label for="jurusan_{{ $jurusan->id }}_laki" class="w-1/2">{{ $jurusan->nama }}</label>
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
                                <label for="jurusan_{{ $jurusan->id }}_perempuan" class="w-1/2">{{ $jurusan->nama }}</label>
                                <input type="hidden" name="kuota[{{ $jurusan->id }}][jurusan_id]" value="{{ $jurusan->id }}">
                                <input type="number" name="kuota[{{ $jurusan->id }}][perempuan_kuota]" 
                                    class="form-input w-full" 
                                    value="{{ old('kuota.'.$jurusan->id.'.perempuan_kuota', $kuotas[$jurusan->id]['perempuan']) }}" 
                                    placeholder="Kuota Perempuan">
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
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
