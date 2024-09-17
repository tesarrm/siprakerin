<x-layout.default>

    <script src="/assets/js/simple-datatables.js"></script>

   @php
    $items = [];
    $allJurusan = $jurusan->pluck('singkatan'); 

    // Mengelompokkan jurusan berdasarkan jenis kelamin
    $jurusanLakiLaki = $allJurusan->filter(function($singkatan) use ($data) {
        return $data->filter(function($d) use ($singkatan) {
            return $d->kuotaIndustri->where('jenis_kelamin', 'Laki-laki')->where('jurusan.singkatan', $singkatan)->count() > 0;
        })->count() > 0;
    });

    $jurusanPerempuan = $allJurusan->filter(function($singkatan) use ($data) {
        return $data->filter(function($d) use ($singkatan) {
            return $d->kuotaIndustri->where('jenis_kelamin', 'Perempuan')->where('jurusan.singkatan', $singkatan)->count() > 0;
        })->count() > 0;
    });

    foreach ($data as $d) {
        $row = [
        ];

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
        // dd($items);
    }
    @endphp

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

    // dd($output);
    @endphp

    <div>
        <form action="{{ route('penempatan.storeOrUpdate') }}" method="POST">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class=" px-4">
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <div class="text-lg font-semibold">Penempatan Prakerin</div>

                                <input type="hidden" name="industri_id" value="{{ $industri->id }}">

                                <!-- Nama Input -->
                                <div class="mt-4 flex items-center">
                                    <label for="nama" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Nama<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $industri->nama }}" required id="nama" type="text" class="form-input w-full" placeholder="Isi Nama" />
                                        @error('nama')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Alamat Input -->
                                <div class="mt-4 flex items-center">
                                    <label for="alamat" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Alamat<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $industri->alamat }}" required id="alamat" type="text" class="form-input w-full" placeholder="Isi Alamat" />
                                        @error('alamat')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="lg:w-1/2 w-full pt-6">
                                <div class="mt-4 flex items-center">
                                    <label for="kota" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">Kota<span class="text-danger">*</span></label>
                                    <div class="flex-1">
                                        <input value="{{ $industri->kota }}" required id="kota" type="text" class="form-input w-full" placeholder="Isi Kota" />
                                        @error('kota')
                                            <div class="mt-2 text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- table info --}}
                        <div class="text-lg font-semibold mb-2">Penempatan</div>

                            <div x-data="invoiceList">
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
                        <div x-data="form" x-init="initialize()">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-5">Nama Siswa</th>
                                        <th class="px-4 py-5">Id Siswa</th>
                                        <th class="px-4 py-5">Jenis Kelamin</th>
                                        <th class="px-4 py-5">Kelas</th>
                                        <th class="px-4 py-5">Jurusan</th>
                                        <th class="px-4 py-5">Tahun Ajaran</th>
                                        <th class="px-4 py-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(row, index) in tableData" :key="index">
                                        <tr>
                                            <td class="px-4 py-2">
                                                <select :name="'data['+index+'][id_siswa]'" x-model="row.id_siswa" @change="updateSiswa(row.id_siswa, index)" class="form-input w-full" style="border:none; padding: 5px; padding-right: 30px;">
                                                    <option value="">Pilih Siswa</option>
                                                    <template x-for="siswa in siswaData" :key="siswa.id">
                                                        <option :value="siswa.id" x-text="siswa.nama"></option>
                                                    </template>
                                                </select>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" :name="'data['+index+'][id_siswa]'" x-model="row.id_siswa" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" x-model="row.jenis_kelamin" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" x-model="row.kelas" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" x-model="row.jurusan" class="form-input w-full" style="border:none; padding: 0;" readonly />
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
                            {{-- <button type="button" @click="addRow" class="btn btn-primary mt-4 bg-blue-500 text-white px-4 py-2">Tambah Baris</button> --}}
                            <div class="flex mr-6">
                                <button type="button" @click="addRow" class="btn btn-dark w-10 h-10 p-0 rounded-full ml-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="px-4">
                        <div class="flex justify-end items-center mt-4 gap-4">
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

    <!-- AlpineJS Script -->
    {{-- <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                tableData: @json($siswaTerfilter).map(siswa => ({
                    id_siswa: siswa.id,
                    jenis_kelamin: siswa.jenis_kelamin,
                    kelas: siswa.kelas.nama + " " + siswa.kelas.klasifikasi,
                    jurusan: siswa.kelas.jurusan.singkatan + " (" + siswa.kelas.jurusan.nama + ")",
                    tahun_ajaran: (() => {
                        let penempatanSiswa = @json($penempatan).find(penempatan => penempatan.siswa_id == siswa.id);
                        return penempatanSiswa ? penempatanSiswa.tahun_ajaran : "";
                    })()
                })),
                siswaData: @json($siswa),
                initialize() {
                    this.tableData.forEach((row, index) => {
                        this.$nextTick(() => {
                            let selectElement = document.querySelector(`select[name="data[${index}][id_siswa]"]`);
                            if (selectElement) {
                                selectElement.value = row.id_siswa;
                            }
                        });
                    });
                },
                pengaturan: @json($pengaturan),
                addRow() {
                    this.tableData.push({ id_siswa: '', jenis_kelamin: '', kelas: '', jurusan: '', tahun_ajaran: '' });
                },
                removeRow(index) {
                    this.tableData.splice(index, 1);
                },
                updateSiswa(id, index) {
                    const selectedSiswa = this.siswaData.find(s => s.id == id);
                    
                    // Check for duplicate
                    const isDuplicate = this.tableData.some((row, i) => row.id_siswa == id && i != index);
                    if (isDuplicate) {
                        alert('Siswa sudah dipilih di baris lain.');
                        // Reset the selection
                        this.tableData[index].id_siswa = '';
                        return;
                    }
                    
                    if (selectedSiswa) {
                        this.tableData[index].jenis_kelamin = selectedSiswa.jenis_kelamin;
                        this.tableData[index].kelas = selectedSiswa.kelas.nama + " " + selectedSiswa.kelas.klasifikasi;
                        this.tableData[index].jurusan = selectedSiswa.kelas.jurusan.singkatan + " (" + selectedSiswa.kelas.jurusan.nama + ")";
                        this.tableData[index].tahun_ajaran = this.pengaturan.tahun_ajaran;
                    }
                }
            }));
        });
    </script> --}}

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                tableData: @json($siswaTerfilter).map(siswa => ({
                    id_siswa: siswa.id,
                    jenis_kelamin: siswa.jenis_kelamin,
                    kelas: siswa.kelas.nama + " " + siswa.kelas.klasifikasi,
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
                },

                addRow() {
                    this.tableData.push({ id_siswa: '', jenis_kelamin: '', kelas: '', jurusan: '', tahun_ajaran: '' });
                },

                removeRow(index) {
                    this.tableData.splice(index, 1);
                },

                updateSiswa(id, index) {
                    const selectedSiswa = this.siswaData.find(s => s.id == id);

                    // Check for duplicate
                    const isDuplicate = this.tableData.some((row, i) => row.id_siswa == id && i != index);
                    if (isDuplicate) {
                        alert('Siswa sudah dipilih di baris lain.');
                        this.tableData[index].id_siswa = '';
                        return;
                    }

                    if (selectedSiswa) {
                        // Validasi kuota
                        let jurusanId = selectedSiswa.kelas.jurusan.id;
                        let jenisKelamin = selectedSiswa.jenis_kelamin.toLowerCase();

                        if (this.jurusanKuota[jenisKelamin][jurusanId] <= 0) {
                            alert(`Kuota ${jenisKelamin} untuk jurusan ini sudah penuh.`);
                            this.tableData[index].id_siswa = ''; // Reset pilihan siswa
                        } else {
                            this.tableData[index].jenis_kelamin = selectedSiswa.jenis_kelamin;
                            this.tableData[index].kelas = selectedSiswa.kelas.nama + " " + selectedSiswa.kelas.klasifikasi;
                            this.tableData[index].jurusan = selectedSiswa.kelas.jurusan.singkatan + " (" + selectedSiswa.kelas.jurusan.nama + ")";
                            this.tableData[index].tahun_ajaran = this.pengaturan.tahun_ajaran;

                            // Kurangi kuota
                            this.jurusanKuota[jenisKelamin][jurusanId]--;
                        }
                    }
                }
            }));
        });
    </script>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('invoiceList', () => ({
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
                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            data: this.dataArr
                        },
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

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thead = document.querySelector('#myTable thead');
            const rows = Array.from(thead.querySelectorAll('tr'));
            
            if (rows.length === 2) {
                // Swap rows as needed
                thead.appendChild(rows[0]); // Move first row to the end
                thead.insertBefore(rows[1], rows[0]); // Move last row before the new first row
            }
        });
    </script>


</x-layout.default>
