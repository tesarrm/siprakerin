<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <style>
        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>

    {{-- <div class="panel">
        <div id="tabs" x-data="{ tab: 'guru'}">
            <ul class="flex flex-wrap mb-5 border-b border-white-light dark:border-[#191e3a]">
                <li class="tab active">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-secondary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(0)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'guru'}" @click="tab = 'guru'"
                        >
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <circle cx="9" cy="6" r="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M12.5 4.3411C13.0375 3.53275 13.9565 3 15 3C16.6569 3 18 4.34315 18 6C18 7.65685 16.6569 9 15 9C13.9565 9 13.0375 8.46725 12.5 7.6589" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <ellipse cx="9" cy="17" rx="7" ry="4" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M18 14C19.7542 14.3847 21 15.3589 21 16.5C21 17.5293 19.9863 18.4229 18.5 18.8704" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Guru</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(1)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'kelas'}" @click="tab = 'kelas'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <path opacity="0.5" d="M3 12C3 15.7712 3 19.6569 4.31802 20.8284C5.63604 22 7.75736 22 12 22C16.2426 22 18.364 22 19.682 20.8284C21 19.6569 21 15.7712 21 12" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M14.6603 14.2019L20.8579 12.3426C21.2688 12.2194 21.4743 12.1577 21.6264 12.0355C21.7592 11.9288 21.8626 11.7898 21.9266 11.6319C22 11.4511 22 11.2366 22 10.8077C22 9.12027 22 8.27658 21.6703 7.63268C21.3834 7.07242 20.9276 6.61659 20.3673 6.32971C19.7234 6 18.8797 6 17.1923 6H6.80765C5.12027 6 4.27658 6 3.63268 6.32971C3.07242 6.61659 2.61659 7.07242 2.32971 7.63268C2 8.27658 2 9.12027 2 10.8077C2 11.2366 2 11.4511 2.07336 11.6319C2.13743 11.7898 2.24079 11.9288 2.37363 12.0355C2.52574 12.1577 2.73118 12.2194 3.14206 12.3426L9.33968 14.2019" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M14 12.5H10C9.72386 12.5 9.5 12.7239 9.5 13V15.1615C9.5 15.3659 9.62448 15.5498 9.8143 15.6257L10.5144 15.9058C11.4681 16.2872 12.5319 16.2872 13.4856 15.9058L14.1857 15.6257C14.3755 15.5498 14.5 15.3659 14.5 15.1615V13C14.5 12.7239 14.2761 12.5 14 12.5Z" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path opacity="0.5" d="M9.1709 4C9.58273 2.83481 10.694 2 12.0002 2C13.3064 2 14.4177 2.83481 14.8295 4" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Kelas</a>
                </li>
            </ul>
        </div>
        <div id="tab-content">
            <div class="tab-content show">

            </div>
            <div class="tab-content"> --}}

                <form action="{{url('pusatunduhan/download')}}" method="POST">
                    @csrf
                    <div class="pt-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mb-6 text-white">

                            @if(!$data)
                                @foreach($data as $d)
                                    <div
                                        class="w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                                        <div class="py-7 px-6">
                                            <div class="-mt-7 mb-7 -mx-6 rounded-tl rounded-tr h-[215px] overflow-hidden">

                                                {{-- Tentukan gambar berdasarkan ekstensi file --}}
                                                @php
                                                    $extension = pathinfo($d->file, PATHINFO_EXTENSION);
                                                    $imageSrc = match ($extension) {
                                                        'pdf' => '/assets/images/pdf-file.png',
                                                        'doc', 'docx' => '/assets/images/office-word.png',
                                                        'xls', 'xlsx' => '/assets/images/office-excel.png',
                                                        default => '/assets/images/other-file.png',
                                                    };
                                                @endphp

                                                <img src="{{ $imageSrc }}" alt="file image" class="w-full h-full object-cover" />
                                            </div>
                                            <h5 class="text-[#3b3f5c] text-xl font-semibold mb-4 dark:text-white-light">
                                                {{ $d->nama }}
                                            </h5>
                                            <input class="hidden" type="text" name="file" value="{{ $d->file }}">
                                            <button type="submit" class="btn btn-primary mt-6">
                                                Unduh
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-black dark:text-white text-center">Dokumen tidak ada!</div>
                            @endif

                        </div>
                    </div>
                </form>

            {{-- </div>
        </div>
    </div> --}}


    <script>
        /*************
         * tab 
         */
        
        function showTab(index) {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.tab-content');

            // Hapus kelas aktif dari semua tab dan sembunyikan semua konten
            tabs.forEach(tab => tab.classList.remove('active'));
            contents.forEach(content => content.classList.remove('show'));

            // Tambahkan kelas aktif pada tab yang dipilih dan tampilkan kontennya
            tabs[index].classList.add('active');
            contents[index].classList.add('show');
        }
    </script>

</x-layout.default>
