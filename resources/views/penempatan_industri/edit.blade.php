<x-layout.default>
    <script src="/assets/js/simple-datatables.js"></script>
    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <script src="/assets/js/nice-select2.js"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/css/tom-select.default.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/js/tom-select.complete.min.js"></script> --}}




                        <select  id="seachable-select1" class="selectize">
                            <option selected value="orange">Orange</option>
                            <option value="White">White</option>
                            <option value="Purple">Purple</option>
                        </select>

        <script>

        document.addEventListener("DOMContentLoaded", function(e) {
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("seachable-select1"), options);
        });

        </script>

    {{-- atur data info --}}
    @php
        $items = [];
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

            $items[] = $row;
        }
    @endphp

    {{-- atur data input --}}
    @php
        $output = [
            "laki-laki" => [],
            "perempuan" => []
        ];

        // Mengambil singkatan jurusan dari koleksi $jurusan
        $allJurusan = $jurusan->pluck('singkatan'); 

        // Memproses data untuk setiap kuota industri
        foreach ($data as $d) {
            foreach ($d->kuotaIndustri as $kuota) {
                $jurusanId = $kuota->jurusan->id; // ID jurusan
                $jenisKelamin = strtolower($kuota->jenis_kelamin); // Jenis kelamin (laki-laki atau perempuan)
                $kuotaValue = $kuota->kuota; // Nilai kuota

                // Memasukkan data ke dalam array berdasarkan jenis kelamin dan id jurusan
                if ($jenisKelamin == 'laki-laki') {
                    if (!isset($output['laki-laki'][$jurusanId])) {
                        $output['laki-laki'][$jurusanId] = 0; // Inisialisasi jika belum ada
                    }
                    $output['laki-laki'][$jurusanId] += $kuotaValue;
                } elseif ($jenisKelamin == 'perempuan') {
                    if (!isset($output['perempuan'][$jurusanId])) {
                        $output['perempuan'][$jurusanId] = 0; // Inisialisasi jika belum ada
                    }
                    $output['perempuan'][$jurusanId] += $kuotaValue;
                }
            }
        }
    @endphp

    <div>
        <form action="{{ route('penempatan.storeOrUpdate') }}" method="POST">
            @csrf
            <input type="hidden" name="industri_id" value="{{ $industri->id }}">
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6" style="width: 100%;">
                    <div class=" px-4">
                        <div class="text-lg font-semibold">Penempatan Prakerin</div>
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="mt-4 flex items-center">
                                    <label for="nama" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Nama</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $industri->nama }}" required id="nama" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Isi Nama" />
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="kota_id" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Kota</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $industri->kota->nama }}" required id="kota_id" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Isi Kota" />
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <label for="alamat" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Alamat</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $industri->alamat }}" required id="alamat" type="text"  class="form-input pointer-events-none bg-[#eee] dark:bg-[#1b2e4b] cursor-not-allowed" readonly placeholder="Isi Alamat" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div style="overflow-x: auto;">

                        {{-- table info --}}
                        <div class="text-lg font-semibold mb-2">Penempatan</div>
                        <div x-data="info">
                            <div class="invoice-table">
                                <table id="myTable" class="whitespace-nowrap">
                                    <thead>
                                        <tr>
                                            @foreach ($jurusanLakiLaki as $jurusan)
                                                <th>{{ $jurusan }}</th>
                                            @endforeach
                                            @foreach ($jurusanPerempuan as $jurusan)
                                                <th>{{ $jurusan }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th colspan="{{ $jurusanLakiLaki->count() }}" class="!text-center border-b border-r">Laki-Laki</th>
                                            <th colspan="{{ $jurusanPerempuan->count() }}" class="!text-center border-b">Perempuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- table input --}}
                        <div x-data="form" x-init="initialize()" class="table-responsive">
                            @if($totalLakiLaki + $totalPerempuan > 0)
                            <table class="table-auto" style="margin-bottom: 100px;">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-5">Nama Siswa</th>
                                        <th class="px-4 py-5">Pilihan Kota</th>
                                        <th class="px-4 py-5">Jenis Kelamin</th>
                                        <th class="px-4 py-5">Kelas</th>
                                        <th class="px-4 py-5">Tahun Ajaran</th>
                                        <th class="px-4 py-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(row, index) in tableData" :key="index">
                                        <tr>
                                            <td class="px-4 py-2">
                                                <select 
                                                    :id="'searchable-select-' + index"
                                                    :name="'data['+index+'][id_siswa]'" 
                                                    x-model="row.id_siswa" 
                                                    @change="updateSiswa(row.id_siswa, index)" 
                                                    class="selectize w-full" 
                                                    style="border:none; padding: 5px; padding-right: 30px;"
                                                >
                                                    <option value="">Pilih Siswa</option>
                                                    <template x-for="siswa in siswaData" :key="siswa.id">
                                                        <option :value="siswa.id" :selected="row.id_siswa == siswa.id">
                                                            <span x-text="siswa.nama_lengkap + ' | '"></span>
                                                            <span x-text="siswa.kelas.nama + ' ' + siswa.kelas.jurusan.singkatan + ' ' + siswa.kelas.klasifikasi + ' | '"></span>
                                                            {{-- Logika pengecekan kota --}}
                                                            <span x-show="siswa.pilihankota.kota1.nama === '{{ $industri->kota->nama }}' || siswa.pilihankota.kota2.nama === '{{ $industri->kota->nama }}' || siswa.pilihankota.kota3.nama === '{{ $industri->kota->nama }}'">
                                                                (<span x-text="getMatchingKota(siswa.pilihankota)"></span>)
                                                            </span>
                                                        </option>
                                                    </template>
                                                </select>
                                              </td>
                                            <td class="px-4 py-2">
                                                <input type="text" x-model="row.pilihan" name="pilihan" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" x-model="row.jenis_kelamin" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" x-model="row.kelas" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" x-model="row.tahun_ajaran" name="tahun_ajaran" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                {{-- <button type="button" @click="removeRow(index)" class="text-red-500">Hapus</button> --}}
                                                <a href="javascript:;" x-tooltip="Delete" @click="removeRow(index)" >

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
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <div class="flex mr-7 mt-4">
                                <button type="button" @click="addRow" class="btn btn-sm btn-dark w-8 h-8 p-0 rounded-full ml-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                            </div>
                            @endif
                        </div>
                        </div>

                    </div>

                    <div class="px-4">
                        <div class="flex justify-end items-center mt-6 gap-4">
                            @if($totalLakiLaki + $totalPerempuan > 0)
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
                            @endif

                            <a href="{{url('penempatan')}}" class="btn btn-outline-danger gap-2">
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

    {{-- =========================== --}}
    {{-- BOTTOM --}}
    {{-- =========================== --}}

    {{-- alert toast --}}
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showAlert("{{ session('error') }}");
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
                    icon: 'error',
                    title: message,
                    padding: '2em',
                    customClass: 'sweet-alerts',
                });
            }
        </script>
    @endif

    <script>
        /*************
         * atur posisi header table 
         */
        document.addEventListener('DOMContentLoaded', function() {
            const thead = document.querySelector('#myTable thead');
            const rows = Array.from(thead.querySelectorAll('tr'));
            
            if (rows.length === 2) {
                // Swap rows as needed
                thead.appendChild(rows[0]); // Move first row to the end
                thead.insertBefore(rows[1], rows[0]); // Move last row before the new first row
            }
        });

        /*************
         * datatable info
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('info', () => ({
                selectedRows: [],
                items: @json($items),
                searchText: '',
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
                    const countArr = generateSequence(0, this.dataArr[0].length);

                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            data: this.dataArr
                        },
                        columns: [
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
                        ],
                        searchable: false,
                        paging: false,
                    });
                },

                setTableData() {
                    this.dataArr = [];
                    for (let i = 0; i < this.items.length; i++) {
                        this.dataArr[i] = [];
                        for (let p in this.items[i]) {
                            if (this.items[i].hasOwnProperty(p)) {
                                this.dataArr[i].push(this.items[i][p]);
                            }
                        }
                    }
                },
            }))
        })

        /*************
         * datatable input 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                getMatchingKota(pilihankota) {
                    // Check for matching kota
                    if (pilihankota.kota1.nama === '{{ $industri->kota->nama }}') {
                        return 'Pilihan 1';
                    } else if (pilihankota.kota2.nama === '{{ $industri->kota->nama }}') {
                        return 'Pilihan 2';
                    } else if (pilihankota.kota3.nama === '{{ $industri->kota->nama }}') {
                        return 'Pilihan 3';
                    }
                    return '';
                },

                tableData: @json($siswaTerfilter).map(siswa => ({
                    id_siswa: siswa.id,
                    pilihan: siswa.penempatan.pilihan,
                    jenis_kelamin: siswa.jenis_kelamin,
                    kelas: siswa.kelas.nama + " " + siswa.kelas.jurusan.singkatan + " " + siswa.kelas.klasifikasi,
                    jurusan: siswa.kelas.jurusan.singkatan + " (" + siswa.kelas.jurusan.nama + ")",
                    tahun_ajaran: (() => {
                        let penempatanSiswa = @json($penempatan).find(penempatan => penempatan.siswa_id == siswa.id);
                        return penempatanSiswa ? penempatanSiswa.tahun_ajaran : "";
                    })()
                })),
                siswaData: @json($siswa),
                kuota: @json($output),
                pengaturan: @json($pengaturan),
                jurusanKuota: {},

                initialize() {
                    this.jurusanKuota = {
                        'laki-laki': Object.assign({}, this.kuota['laki-laki']),
                        'perempuan': Object.assign({}, this.kuota['perempuan']),
                    };

                    this.tableData.forEach((row, index) => {
                        this.$nextTick(() => {
                            let selectElement = document.querySelector(`select[name="data[${index}][id_siswa]"]`);
                            if (selectElement) {
                                selectElement.value = row.id_siswa;
                            }
                        });
                    });

                    // search select
                    this.$nextTick(() => {
                        this.tableData.forEach((row, index) => {
                            let selectElement = document.getElementById(`searchable-select-${index}`);
                            // new TomSelect(selectElement, {create: false, sortField: {field: "text", direction: "asc"}});
                            var options = {
                                searchable: true
                            };
                            NiceSelect.bind(selectElement, options);
                        });
                    });
                },

                initSearchableSelect() {
                    this.$nextTick(() => {
                        this.$refs.searchableSelect && NiceSelect.bind(this.$refs.searchableSelect, { searchable: true });
                    });
                },

                addRow() {
                    this.tableData.push({ id_siswa: '', pilihan: '', jenis_kelamin: '', kelas: '', jurusan: '', tahun_ajaran: '' });
                    // search select
                    this.$nextTick(() => {
                        let index = this.tableData.length - 1;
                        let selectElement = document.getElementById(`searchable-select-${index}`);
                        // new TomSelect(selectElement, {
                        //     create: false, 
                        //     sortField: {field: "text", direction: "asc"},
                        //     // options = {
                        //     //     searchable: true
                        //     // };
                        // });
                        var options = {
                            searchable: true
                        };
                        NiceSelect.bind(selectElement, options);
                    });
                },

                removeRow(index) {
                    this.tableData.splice(index, 1);
                },

                updateSiswa(id, index) {
                    const selectedSiswa = this.siswaData.find(s => s.id == id);

                    // Check for duplicate
                    const isDuplicate = this.tableData.some((row, i) => row.id_siswa == id && i != index);
                    if (isDuplicate) {
                        window.Swal.fire({
                            icon: 'warning',
                            title: 'Duplikat Siswa!',
                            text: 'Siswa sudah dipilih di baris lain.',
                            padding: '2em',
                            customClass: 'sweet-alerts'
                        })
                        this.tableData[index].id_siswa = '';
                        return;
                    }

                    if (selectedSiswa) {
                        // Check if siswa has penempatan
                        if (selectedSiswa.penempatan) {
                            console.log(selectedSiswa)
                            window.Swal.fire({
                                icon: 'info',
                                title: 'Siswa Telah Ditempatkan!',
                                text: 'Siswa ini sudah memiliki penempatan di industri.',
                                padding: '2em',
                                customClass: 'sweet-alerts'
                            });
                            this.tableData[index].id_siswa = ''; // Reset pilihan siswa
                            return;
                        }

                        // Validasi kuota
                        let jurusanId = selectedSiswa.kelas.jurusan.id;
                        let jenisKelamin = selectedSiswa.jenis_kelamin.toLowerCase();

                        if (this.jurusanKuota[jenisKelamin][jurusanId] <= 0) {
                            window.Swal.fire({
                                icon: 'warning',
                                title: 'Kuota Penuh!',
                                text: `Kuota ${jenisKelamin} untuk jurusan ini sudah penuh.`,
                                padding: '2em',
                                customClass: 'sweet-alerts'
                            })
                            this.tableData[index].id_siswa = ''; // Reset pilihan siswa
                        } else {
                            this.tableData[index].pilihan = this.getMatchingKota(selectedSiswa.pilihankota);
                            this.tableData[index].jenis_kelamin = selectedSiswa.jenis_kelamin;
                            this.tableData[index].kelas = selectedSiswa.kelas.nama + " " + selectedSiswa.kelas.jurusan.singkatan + " " + selectedSiswa.kelas.klasifikasi;
                            this.tableData[index].jurusan = selectedSiswa.kelas.jurusan.singkatan + " (" + selectedSiswa.kelas.jurusan.nama + ")";
                            this.tableData[index].tahun_ajaran = this.pengaturan.tahun_ajaran;

                            // Kurangi kuota
                            this.jurusanKuota[jenisKelamin][jurusanId]--;
                        }
                    }
                }
            }));
        });

        /*************
         * check matching kota 
         */

        function form() {
            return {
                initialize() {
                    // Any necessary initialization here
                },
                getMatchingKota(pilihankota) {
                    // Check for matching kota
                    if (pilihankota.kota1.nama === '{{ $industri->kota->nama }}') {
                        return 'kota1';
                    } else if (pilihankota.kota2.nama === '{{ $industri->kota->nama }}') {
                        return 'kota2';
                    } else if (pilihankota.kota3.nama === '{{ $industri->kota->nama }}') {
                        return 'kota3';
                    }
                    return '';
                }
            };
        }
    </script>
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function(e) {
            // seachable
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("seachable-select"), options);
        });
    </script> --}}
</x-layout.default>
