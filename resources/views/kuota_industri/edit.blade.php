<x-layout.default>
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
