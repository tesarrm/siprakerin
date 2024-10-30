<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="/assets/js/nice-select2.js"></script>

    {{-- style tab --}}
    <style>
        .tab-content {
            display: none;
        }
        .show {
            display: block;
        }
    </style>

    {{-- atur data --}}
    @php
        $items = [];

        if(auth()->user()->hasRole('wali_siswa')) {
            $allJurusan = $jurusan->pluck('singkatan');

            // buat heading
            $jurusanLakiLaki = $allJurusan->filter(function($singkatan) use ($data) {
                return $data->filter(function($d) use ($singkatan) {
                    return $d->kuotaIndustri->where('jenis_kelamin', 'Laki-laki')->where('jurusan.singkatan', $singkatan);
                });
            });
            $jurusanPerempuan = $allJurusan->filter(function($singkatan) use ($data) {
                return $data->filter(function($d) use ($singkatan) {
                    return $d->kuotaIndustri->where('jenis_kelamin', 'Perempuan')->where('jurusan.singkatan', $singkatan);
                });
            });

            // buat data
            foreach ($data as $d) {
                $row = [
                    'nama' => $d->nama,
                    'alamat' => $d->alamat,
                    'kota' => $d->kota->nama,
                ];

                // Hitung total kuota laki-laki dan perempuan
                $totalLakiLaki = 0;
                $totalPerempuan = 0;

                foreach ($d->kuotaIndustri as $kuota) {
                    $jurusanSingkatan = $kuota->jurusan->singkatan;
                    $jenisKelamin = $kuota->jenis_kelamin == 'Laki-laki' ? 'L' : 'P';
                    $formattedKey = "{$jenisKelamin}-{$jurusanSingkatan}";
                    $row[$formattedKey] = $kuota->kuota;

                    // Tambahkan kuota laki-laki dan perempuan ke total
                    if ($jenisKelamin == 'L') {
                        $totalLakiLaki += $kuota->kuota;
                    } else {
                        $totalPerempuan += $kuota->kuota;
                    }
                }

                // Isi semua jurusan dengan kuota, set 0 jika tidak ada kuota
                foreach ($allJurusan as $jurusanSingkatan) {
                    $row["L-{$jurusanSingkatan}"] = $row["L-{$jurusanSingkatan}"] ?? 0;
                    $row["P-{$jurusanSingkatan}"] = $row["P-{$jurusanSingkatan}"] ?? 0;
                }

                $row['total_kuota'] = $totalLakiLaki + $totalPerempuan;
                $row['terisi'] = $d->total_terisi;
                $row['Aksi'] = $d->id;

                $items[] = $row;
            }
        } else {
            $allJurusan = $jurusan->pluck('singkatan');

            // buat heading
            $jurusanLakiLaki = $allJurusan->filter(function($singkatan) use ($data) {
                return $data->filter(function($d) use ($singkatan) {
                    return $d->kuotaIndustri->where('jenis_kelamin', 'Laki-laki')->where('jurusan.singkatan', $singkatan);
                });
            });
            $jurusanPerempuan = $allJurusan->filter(function($singkatan) use ($data) {
                return $data->filter(function($d) use ($singkatan) {
                    return $d->kuotaIndustri->where('jenis_kelamin', 'Perempuan')->where('jurusan.singkatan', $singkatan);
                });
            });

            // buat data
            foreach ($data as $d) {
                $row = [
                    'nama' => $d->nama,
                    'alamat' => $d->alamat,
                    'kota' => $d->kota->nama,
                ];

                // Hitung total kuota laki-laki dan perempuan
                $totalLakiLaki = 0;
                $totalPerempuan = 0;

                foreach ($d->kuotaIndustri as $kuota) {
                    $jurusanSingkatan = $kuota->jurusan->singkatan;
                    $jenisKelamin = $kuota->jenis_kelamin == 'Laki-laki' ? 'L' : 'P';
                    $formattedKey = "{$jenisKelamin}-{$jurusanSingkatan}";
                    $row[$formattedKey] = $kuota->kuota;

                    // Tambahkan kuota laki-laki dan perempuan ke total
                    if ($jenisKelamin == 'L') {
                        $totalLakiLaki += $kuota->kuota;
                    } else {
                        $totalPerempuan += $kuota->kuota;
                    }
                }

                // Isi semua jurusan dengan kuota, set 0 jika tidak ada kuota
                foreach ($allJurusan as $jurusanSingkatan) {
                    $row["L-{$jurusanSingkatan}"] = $row["L-{$jurusanSingkatan}"] ?? 0;
                    $row["P-{$jurusanSingkatan}"] = $row["P-{$jurusanSingkatan}"] ?? 0;
                }

                $row['total_kuota'] = $totalLakiLaki + $totalPerempuan;
                $row['terisi'] = $d->total_terisi;
                $row['status'] = $row['terisi'] == 0
                    ? 'Belum Dikelolah'
                    : ($row['total_kuota'] <= $row['terisi']
                        ? 'Kuota Terpenuhi'
                        : 'Kuota Terisi');

                $row['Aksi'] = $d->id;

                $items[] = $row;
            }
        }
    @endphp

    <div class="panel">

        @if(!auth()->user()->hasRole('wali_kelas'))

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
                            <path d="M2 17.5C2 16.5654 2 16.0981 2.20096 15.75C2.33261 15.522 2.52197 15.3326 2.75 15.201C3.09808 15 3.56538 15 4.5 15C5.43462 15 5.90192 15 6.25 15.201C6.47803 15.3326 6.66739 15.522 6.79904 15.75C7 16.0981 7 16.5654 7 17.5C7 18.4346 7 18.9019 6.79904 19.25C6.66739 19.478 6.47803 19.6674 6.25 19.799C5.90192 20 5.43462 20 4.5 20C3.56538 20 3.09808 20 2.75 19.799C2.52197 19.6674 2.33261 19.478 2.20096 19.25C2 18.9019 2 18.4346 2 17.5Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.5" d="M9.5 17.5C9.5 16.5654 9.5 16.0981 9.70096 15.75C9.83261 15.522 10.022 15.3326 10.25 15.201C10.5981 15 11.0654 15 12 15C12.9346 15 13.4019 15 13.75 15.201C13.978 15.3326 14.1674 15.522 14.299 15.75C14.5 16.0981 14.5 16.5654 14.5 17.5C14.5 18.4346 14.5 18.9019 14.299 19.25C14.1674 19.478 13.978 19.6674 13.75 19.799C13.4019 20 12.9346 20 12 20C11.0654 20 10.5981 20 10.25 19.799C10.022 19.6674 9.83261 19.478 9.70096 19.25C9.5 18.9019 9.5 18.4346 9.5 17.5Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path opacity="0.7" d="M17 17.5C17 16.5654 17 16.0981 17.201 15.75C17.3326 15.522 17.522 15.3326 17.75 15.201C18.0981 15 18.5654 15 19.5 15C20.4346 15 20.9019 15 21.25 15.201C21.478 15.3326 21.6674 15.522 21.799 15.75C22 16.0981 22 16.5654 22 17.5C22 18.4346 22 18.9019 21.799 19.25C21.6674 19.478 21.478 19.6674 21.25 19.799C20.9019 20 20.4346 20 19.5 20C18.5654 20 18.0981 20 17.75 19.799C17.522 19.6674 17.3326 19.478 17.201 19.25C17 18.9019 17 18.4346 17 17.5Z" 
                                stroke="currentColor" stroke-width="1.5"/>
                            <path d="M4.5 15V9C4.5 6.64298 4.5 5.46447 5.23223 4.73223C5.96447 4 7.14298 4 9.5 4H14.5C16.857 4 18.0355 4 18.7678 4.73223C19.5 5.46447 19.5 6.64298 19.5 9V12M19.5 12L21.5 10M19.5 12L17.5 10" 
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Penempatan</a>
                </li>
                <li class="tab">
                    <a href="javascript:;"
                        class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                        onclick="showTab(1)"
                        :class="{'border-b !border-secondary text-secondary' : tab === 'kelas'}" @click="tab = 'kelas'"
                        ">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                            <circle cx="12" cy="6" r="4"
                                stroke="currentColor" stroke-width="1.5" />
                            <ellipse opacity="0.5" cx="12" cy="17" rx="7"
                                ry="4" stroke="currentColor" stroke-width="1.5" />
                        </svg>
                        Penempatan Siswa</a>
                </li>
            </ul>
        </div>
        <div id="tab-content">
            <div class="tab-content show">

                <div x-data="dataList">

                    <div class="px-5">
                        <div class="md:absolute ltr:md:left-5 rtl:md:right-5">
                            <div class="flex items-center gap-2 mb-5">

                                <div class="" style="width: 225px">
                                    <select id="filterKelas" x-model="selectedKelas" @change="filterByKelas" class="selectize">
                                        <option selected ="">Pilih Kota</option>
                                        @foreach($kota as $item)
                                            <option value="{{ $item->nama}}">
                                                {{ $item->nama}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="invoice-table">
                        <table id="myTable" class="whitespace-nowrap">
                            @if(auth()->user()->hasRole('wali_siswa'))
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Kota</th>
                                        @foreach ($jurusanLakiLaki as $jurusan)
                                            <th>{{ $jurusan }}</th>
                                        @endforeach
                                        @foreach ($jurusanPerempuan as $jurusan)
                                            <th>{{ $jurusan }}</th>
                                        @endforeach
                                        <th>Total</th>
                                        <th>Terisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th colspan="{{ $jurusanLakiLaki->count() }}" class="!text-center border-b border-r">Laki-Laki</th>
                                        <th colspan="{{ $jurusanPerempuan->count() }}" class="!text-center border-b">Perempuan</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th colspan="{{ $jurusanLakiLaki->count() + $jurusanPerempuan->count() + 1 }}" class="!text-center border-b">Jumlah Penempatan Kuota</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            @else
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Kota</th>
                                        @foreach ($jurusanLakiLaki as $jurusan)
                                            <th>{{ $jurusan }}</th>
                                        @endforeach
                                        @foreach ($jurusanPerempuan as $jurusan)
                                            <th>{{ $jurusan }}</th>
                                        @endforeach
                                        <th>Total</th>
                                        <th>Terisi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th colspan="{{ $jurusanLakiLaki->count() }}" class="!text-center border-b border-r">Laki-Laki</th>
                                        <th colspan="{{ $jurusanPerempuan->count() }}" class="!text-center border-b">Perempuan</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th colspan="{{ $jurusanLakiLaki->count() + $jurusanPerempuan->count() + 1 }}" class="!text-center border-b">Jumlah Penempatan Kuota</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- pagination max 100 --}}
                @if($data->total() > 100)
                    <div id="pageplus" class="flex justify-center mt-3">
                        <ul class="flex items-center m-auto">
                            <li>
                                <a href="{{ $data->previouspageurl() }}"  
                                    class="flex justify-center font-semibold ltr:rounded-l-full rtl:rounded-r-full px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180">
                                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $data->lastpage(); $i++)
                                <li>
                                    <a href="{{ $data->url($i) }}"
                                        class="flex justify-center font-semibold px-3.5 py-2 transition 
                                            {{ ($data->currentpage() == $i) ? 
                                                'bg-primary text-white dark:text-white-light dark:bg-primary' : 
                                                'bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary'
                                            }}">{{ $i * 100 }}</a>
                                </li>
                            @endfor
                            <li>
                                <a href="{{ $data->nextpageurl() }}" 
                                    class="flex justify-center font-semibold ltr:rounded-r-full rtl:rounded-l-full px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180">
                                        <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>
            <div class="tab-content">

                @endif

                <div x-data="siswa">

                    @if(!auth()->user()->can('r_dashwalikelas'))
                    <div class="px-5">
                        <div class="md:absolute ltr:md:left-5 rtl:md:right-5">
                            <div class="flex items-center gap-2 mb-5">

                                <div class="" style="width: 225px">
                                    <select id="filterKelas1" x-model="selectedKelas" @change="filterByKelas" class="selectize">
                                        <option selected value="">Pilih Kelas</option>
                                        @foreach($kelas as $item)
                                            <option value="{{ $item->nama . ' ' . $item->jurusan->singkatan . ' ' . $item->klasifikasi }}">
                                                {{ $item->nama . ' ' . $item->jurusan->singkatan . ' ' . $item->klasifikasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="invoice-table">
                        <table id="table_siswa" class="whitespace-nowrap"></table>
                    </div>

                    {{-- pagination max 250 --}}
                    @if($penempatan->total() > 250)
                        <div id="pageplus" class="flex justify-center mt-3">
                            <ul class="flex items-center m-auto">
                                <li>
                                    <a href="{{ $penempatan->previouspageurl() }}"  
                                        class="flex justify-center font-semibold ltr:rounded-l-full rtl:rounded-r-full px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180">
                                            <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $penempatan->lastpage(); $i++)
                                    <li>
                                        <a href="{{ $penempatan->url($i) }}"
                                            class="flex justify-center font-semibold px-3.5 py-2 transition 
                                                {{ ($penempatan->currentpage() == $i) ? 
                                                    'bg-primary text-white dark:text-white-light dark:bg-primary' : 
                                                    'bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary'
                                                }}">{{ $i * 250 }}</a>
                                    </li>
                                @endfor
                                <li>
                                    <a href="{{ $penempatan->nextpageurl() }}" 
                                        class="flex justify-center font-semibold ltr:rounded-r-full rtl:rounded-l-full px-3.5 py-2 transition bg-white-light text-dark hover:text-white hover:bg-primary dark:text-white-light dark:bg-[#191e3a] dark:hover:bg-primary">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rtl:rotate-180">
                                            <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif

                </div>

                    @if(!auth()->user()->hasRole('wali_kelas'))

            </div>
        </div>

        @endif
    </div>

    {{-- =========================== --}}
    {{-- BOTTOM --}}
    {{-- =========================== --}}



    <script>
        /*************
         * toast alert 
         */

        @if(session('status'))
            document.addEventListener('DOMContentLoaded', function () {
                showAlert("{{ session('status') }}");
            });

            async function showAlert(message) {
                const toast = window.Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
                toast.fire({
                    icon: 'success',
                    title: message,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
            }
        @endif

        /*************
         * filter kelas 
         */

        document.addEventListener("DOMContentLoaded", function(e) {
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("filterKelas"), options);
        });

        /*************
         * filter kelas1 
         */

        document.addEventListener("DOMContentLoaded", function(e) {
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("filterKelas1"), options);
        });

        /*************
         * atur posisi header table 
         */

        document.addEventListener('DOMContentLoaded', function() {
            const thead = document.querySelector('#myTable thead');
            const rows = Array.from(thead.querySelectorAll('tr'));
            
            if (rows.length === 3) {
                // Swap rows as needed
                thead.appendChild(rows[0]); // Move first row to the end
                thead.insertBefore(rows[1], rows[0]); // Move last row before the new first row
            }
        });

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

        /*************
         * datatable 
         */

        @php
            $dSiswa = [];
            foreach ($penempatan as $d) {
                $dSiswa[] = [
                    'nis' => $d->siswa->nis ?? '-',
                    'nama' => $d->siswa->user->name?? '-',
                    'jenis_kelamin' => $d->siswa->jenis_kelamin ?? '-',
                    'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                    'industri' => $d->industri->nama ?? '-',
                    'kota' => $d->industri->kota->nama ?? '-',
                    'tahun_ajaran' => $d->siswa->tahunAjaran->nama ?? "-",
                    'action' => $d->id ?? '-', 
                ];
            }
        @endphp

        document.addEventListener("alpine:init", () => {
            Alpine.data('dataList', () => ({
                selectedRows: [],
                items: @json($items),
                searchText: '',
                selectedKelas: '', // Tambahkan untuk pilihan kelas
                datatable: null,
                dataArr: [],

                init() {
                    this.setTableData();
                    this.initializeTable();
                    this.$watch('items', value => {
                        this.datatable.destroy()
                        this.setTableData();
                        this.initializeTable();
                    });
                    this.$watch('selectedRows', value => {
                        this.datatable.destroy()
                        this.setTableData();
                        this.initializeTable();
                    });
                },

                initializeTable() {
                    function generateSequence(start, count) {
                        return Array.from({ length: count }, (_, i) => start + i);
                    }
                    const countArr = generateSequence(3, {{$jurusanLakiLaki->count() + $jurusanPerempuan->count()}});

                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: 
                            @if(auth()->user()->hasRole('wali_siswa'))
                                [
                                    {
                                        select: 2,
                                        render: function(data, cell, row) {
                                            if(data != '-'){
                                                return `
                                                    <span class="badge badge-outline-info text-sm">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else {
                                                return `
                                                    ${data}
                                                `;
                                            }
                                        }
                                    },
                                    {
                                        select: countArr,
                                        render: function(data, cell, row) {
                                            if(data != '-'){
                                                return `
                                                    <span class="badge bg-[#e6e9ed] dark:bg-[#1b2e4b] text-[#6a6e73] dark:text-[#888ea8] rounded-full text-sm">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else {
                                                return `
                                                    ${data}
                                                `;
                                            }
                                        }
                                    },
                                    {
                                        select: @json($jurusanLakiLaki->count() + $jurusanPerempuan->count()) + 4,
                                        render: function(data, cell, row) {
                                            if(data == 'Belum Dikelolah'){
                                                return `
                                                    <span class="badge bg-dark/20 text-dark rounded-full">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else if(data == 'Kuota Terisi'){
                                                return `
                                                    <span class="badge bg-warning/20 text-warning rounded-full">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else if(data == 'Kuota Terpenuhi'){
                                                return `
                                                    <span class="badge bg-danger/20 text-danger rounded-full">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else {
                                                return `
                                                    ${data}
                                                `;
                                            }
                                        }
                                    },
                                    {
                                        select: @json($jurusanLakiLaki).length + @json($jurusanPerempuan).length + 5,
                                        sortable: false,
                                        render: function(data, cell, row) {
                                            const rowId = `row-${data}`; 
                                            return `<div>
                                                        <div class="flex gap-4 items-center">
                                                            <a href="/penempatan/${data}" class="hover:text-info">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path 
                                                                        opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" 
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                    />
                                                                    <path 
                                                                        d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" 
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                    />
                                                                </svg>
                                                            </a>
                                                    </div>`;
                                        }
                                    }
                                ],
                            @else
                                [
                                    {
                                        select: 0,
                                        sortable: false,
                                        render: function(data, cell, row) {
                                            const select = 6 + {{$jurusanLakiLaki->count() + $jurusanPerempuan->count()}};
                                            const id = row.cells[select].data; 
                                            return `<a href="/penempatan/${id}/edit" class="hover:underline">${ data }</a>`;
                                        }
                                    },
                                    {
                                        select: 2,
                                        render: function(data, cell, row) {
                                            if(data != '-'){
                                                return `
                                                    <span class="badge badge-outline-info text-sm">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else {
                                                return `
                                                    ${data}
                                                `;
                                            }
                                        }
                                    },
                                    {
                                        select: countArr,
                                        render: function(data, cell, row) {
                                            if(data != '-'){
                                                return `
                                                    <span class="badge bg-[#e6e9ed] dark:bg-[#1b2e4b] text-[#6a6e73] dark:text-[#888ea8] rounded-full text-sm">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else {
                                                return `
                                                    ${data}
                                                `;
                                            }
                                        }
                                    },
                                    {
                                        select: @json($jurusanLakiLaki->count() + $jurusanPerempuan->count()) + 5,
                                        render: function(data, cell, row) {
                                            if(data == 'Belum Dikelolah'){
                                                return `
                                                    <span class="badge bg-dark/20 text-dark rounded-full">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else if(data == 'Kuota Terisi'){
                                                return `
                                                    <span class="badge bg-warning/20 text-warning rounded-full">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else if(data == 'Kuota Terpenuhi'){
                                                return `
                                                    <span class="badge bg-danger/20 text-danger rounded-full">
                                                        ${data}
                                                    </span>
                                                `;
                                            } else {
                                                return `
                                                    ${data}
                                                `;
                                            }
                                        }
                                    },
                                    {
                                        select: @json($jurusanLakiLaki).length + @json($jurusanPerempuan).length + 6,
                                        sortable: false,
                                        render: function(data, cell, row) {
                                            const rowId = `row-${data}`; 
                                            return `<div>
                                                        <div class="flex gap-4 items-center">
                                                            <a href="/penempatan/${data}/edit" class="hover:text-info">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
                                                                    <path
                                                                        opacity="0.5"
                                                                        d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                        stroke-linecap="round"
                                                                    ></path>
                                                                    <path
                                                                        d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                    ></path>
                                                                    <path
                                                                        opacity="0.5"
                                                                        d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                    ></path>
                                                                </svg>
                                                            </a>
                                                            <a href="/penempatan/${data}" class="hover:text-info">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path 
                                                                        opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" 
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                    />
                                                                    <path 
                                                                        d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" 
                                                                        stroke="currentColor"
                                                                        stroke-width="1.5"
                                                                    />
                                                                </svg>
                                                            </a>
                                                    </div>`;
                                        }
                                    }
                                ],
                            @endif
                        firstLast: true,
                        firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        labels: {
                            perPage: "<span class='ml-2'>{select}</span>",
                            noRows: "No data available",
                        },
                        layout: {
                            top: "{search}",
                            bottom: "{info}{select}{pager}",
                        },
                    });
                },

                setTableData() {
                    // this.dataArr = [];
                    // for (let i = 0; i < this.items.length; i++) {
                    //     this.dataArr[i] = [];
                    //     for (let p in this.items[i]) {
                    //         if (this.items[i].hasOwnProperty(p)) {
                    //             this.dataArr[i].push(this.items[i][p]);
                    //         }
                    //     }
                    // }

                    this.dataArr = this.items
                        .filter(item => {
                            // Jika selectedKelas tidak kosong, hanya tampilkan yang sesuai
                            return this.selectedKelas === '' || item.kota === this.selectedKelas;
                        })
                        .map(item => {
                            return Object.values(item); // Mengonversi setiap item ke array data
                        });
                },

                refreshTable() {
                    this.datatable.destroy();
                    this.setTableData();
                    this.initializeTable();
                },

                updateTableHeader() {
                    const thead = document.querySelector('#myTable thead');
                    const rows = Array.from(thead.querySelectorAll('tr'));

                    if (rows.length === 3) {
                        // Swap rows as needed
                        thead.appendChild(rows[0]); // Move first row to the end
                        thead.insertBefore(rows[1], rows[0]); // Move last row before the new first row
                    }
                },

                filterByKelas() {
                    this.refreshTable(); 
                    this.updateTableHeader();
                },

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.invoice && d.invoice.toLowerCase().includes(this.searchText)) ||
                        (d.name && d.name.toLowerCase().includes(this.searchText)) ||
                        (d.email && d.email.toLowerCase().includes(this.searchText)) ||
                        (d.date && d.date.toLowerCase().includes(this.searchText)) ||
                        (d.amount && d.amount.toLowerCase().includes(this.searchText)) ||
                        (d.status && d.status.toLowerCase().includes(this.searchText))
                    );
                },
            }))
        })


        /*************
         * penempatan siswa datatable
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('siswa', () => ({
                selectedRows: [],
                items: @json($dSiswa),
                searchText: '',
                datatable: null,
                selectedKelas: '', // Tambahkan untuk pilihan kelas
                dataArr: [],

                init() {
                    this.setTableData();
                    this.initializeTable();
                    this.$watch('items', value => {
                        this.datatable.destroy()
                        this.setTableData();
                        this.initializeTable();
                    });
                    this.$watch('selectedRows', value => {
                        this.datatable.destroy()
                        this.setTableData();
                        this.initializeTable();
                    });
                },

                initializeTable() {
                    this.datatable = new simpleDatatables.DataTable('#table_siswa', {
                        data: {
                            headings: [
                                "NIS",
                                "Nama",
                                "Jenis Kelamin",
                                "Kelas",
                                "Industri",
                                "Kota",
                                "Tahun Ajaran",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100, 250],
                        columns: [
                            {
                                select: 3,
                                render: function(data, cell, row) {
                                    if(data != '-'){
                                        return `
                                            <span class="badge badge-outline-info text-sm">
                                                ${data}
                                            </span>
                                        `;
                                    } else {
                                        return `
                                            ${data}
                                        `;
                                    }
                                }
                            },
                            {
                                select: 4,
                                render: function(data, cell, row) {
                                    if(data != '-'){
                                        return `
                                            <span class="badge badge-outline-success text-sm">
                                                ${data}
                                            </span>
                                        `;
                                    } else {
                                        return `
                                            ${data}
                                        `;
                                    }
                                }
                            },
                            {
                                select: 5,
                                render: function(data, cell, row) {
                                    if(data != '-'){
                                        return `
                                            <span class="badge badge-outline-warning text-sm">
                                                ${data}
                                            </span>
                                        `;
                                    } else {
                                        return `
                                            ${data}
                                        `;
                                    }
                                }
                            },
                            {
                                select: 7,
                                sortable: false,
                                render: function(data, cell, row) {
                                    const rowId = `row-${data}`; 
                                    return `<div>
                                                <div class="flex gap-4 items-center">
                                                    <a href="/penempatan/${data}/siswa" class="hover:text-info">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path 
                                                                opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" 
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                            />
                                                            <path 
                                                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" 
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                            />
                                                        </svg>
                                                    </a>
                                            </div>`;
                                }
                            }
                        ],
                        firstLast: true,
                        firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        labels: {
                            perPage: "<span class='ml-2'>{select}</span>",
                            noRows: "No data available",
                        },
                        layout: {
                            top: "{search}",
                            bottom: "{info}{select}{pager}",
                        },
                    });
                },

                checkAllCheckbox() {
                    if (this.items.length && this.selectedRows.length === this.items.length) {
                        return true;
                    } else {
                        return false;
                    }
                },

                checkAll(isChecked) {
                    if (isChecked) {
                        this.selectedRows = this.items.map((d) => {
                            return d.id;
                        });
                    } else {
                        this.selectedRows = [];
                    }
                },

                setTableData() {
                    // this.dataArr = [];
                    // for (let i = 0; i < this.items.length; i++) {
                    //     this.dataArr[i] = [];
                    //     for (let p in this.items[i]) {
                    //         if (this.items[i].hasOwnProperty(p)) {
                    //             this.dataArr[i].push(this.items[i][p]);
                    //         }
                    //     }
                    // }
                    this.dataArr = this.items
                        .filter(item => {
                            // Jika selectedKelas tidak kosong, hanya tampilkan yang sesuai
                            return this.selectedKelas === '' || item.kelas === this.selectedKelas;
                        })
                        .map(item => {
                            return Object.values(item); // Mengonversi setiap item ke array data
                        });
                },

                refreshTable() {
                    this.datatable.destroy();
                    this.setTableData();
                    this.initializeTable();
                },

                filterByKelas() {
                    this.refreshTable(); 
                },

                searchInvoice() {
                    return this.items.filter((d) =>
                        (d.nama && d.nama.toLowerCase().includes(this.searchText)) ||
                        (d.alamat && d.alamat.toLowerCase().includes(this.searchText)) ||
                        (d.kota && d.kota.toLowerCase().includes(this.searchText)) ||
                        (d.total_kuota && d.total_kuota.toLowerCase().includes(this.searchText)) ||
                        (d.terisi && d.terisi.toLowerCase().includes(this.searchText)) ||
                        (d.status && d.status.toLowerCase().includes(this.searchText))
                    );
                },

            }))
        })

        /*************
         * filter kelas 
         */

        // document.addEventListener("DOMContentLoaded", function(e) {
        //     var options = {
        //         searchable: true
        //     };
        //     NiceSelect.bind(document.getElementById("filterKelas"), options);
        // });

    </script>
</x-layout.default>
