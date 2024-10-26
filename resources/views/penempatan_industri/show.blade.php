<x-layout.default>
    <script src="/assets/js/simple-datatables.js"></script>

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
        }
    @endphp

    {{-- atur data output --}}
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
            <div class="flex xl:flex-row flex-col gap-2.5">
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                    <div class=" px-4">
                        <div class="text-lg font-semibold">Penempatan Prakerin</div>
                        <div class="flex justify-between lg:flex-row flex-col">
                            <div class="w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                                <input type="hidden" name="industri_id" value="{{ $industri->id }}">
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

                        <div class="text-lg font-semibold mb-4">Siswa yang Ditempatkan</div>
                        {{-- table input --}}
                        <div x-data="form" x-init="initialize()">
                            @if($totalLakiLaki + $totalPerempuan > 0)
                            <table class="table-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-5">Nama Siswa</th>
                                        <th class="px-4 py-5">Jenis Kelamin</th>
                                        <th class="px-4 py-5">Kelas</th>
                                        <th class="px-4 py-5">Tahun Ajaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(row, index) in tableData" :key="index">
                                        <tr>
                                            <td class="px-4 py-4">
                                                <input type="text" x-model="row.nama" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-4">
                                                <input type="text" x-model="row.jenis_kelamin" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-4">
                                                <input type="text" x-model="row.kelas" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                            <td class="px-4 py-4">
                                                <input type="text" x-model="row.tahun_ajaran" name="tahun_ajaran" class="form-input w-full" style="border:none; padding: 0;" readonly />
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>

                    <div class="px-4">
                        <div class="flex justify-end items-center mt-6 gap-4">
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

    <script>
        /*************
         * datatable
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                tableData: @json($siswaTerfilter).map(siswa => ({
                    id_siswa: siswa.id,
                    nama: siswa.nama,
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
    </script>
</x-layout.default>
