
<x-layout.default>

    {{-- @php
    $items = [];
    $allJurusan = $jurusan->pluck('singkatan'); // Mengambil semua nama jurusan dari variabel $jurusan

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
            'nama' => $d->nama,
            'alamat' => $d->alamat,
            // 'total_kuota' => 0, // Inisialisasi untuk total kuota per jurusan
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

        // Hitung total kuota untuk laki-laki + perempuan
        $row['total_kuota'] = $totalLakiLaki + $totalPerempuan;
        $row['terisi'] = 0;
        $row['status'] = "Belum dikekolah";
        $row['Aksi'] = $d->id;

        $items[] = $row;
        // dd($items);
    }
    @endphp --}}

    @php
        $items = [];
        $allJurusan = $jurusan->pluck('singkatan');

        // Mengelompokkan jurusan berdasarkan jenis kelamin untuk heading tabel
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
                'nama' => $d->nama,
                'alamat' => $d->alamat,
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

            // Hitung total kuota untuk laki-laki + perempuan
            $row['total_kuota'] = $totalLakiLaki + $totalPerempuan;
            $row['terisi'] = $d->total_terisi;
            $row['status'] = $row['terisi'] == 0
                ? 'Belum dikelolah'
                : ($row['total_kuota'] <= $row['terisi']
                    ? 'Kuota Terpenuhi'
                    : 'Kuota Terisi');
            $row['Aksi'] = $d->id;

            $items[] = $row;
        }
    @endphp

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <div class="mb-5" x-data="{ tab: 'penempatan' }">
                <div>
                    <ul class="flex flex-wrap mb-5 border-b border-white-light dark:border-[#191e3a]">
                        <li>
                            <a href="javascript:;"
                                class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 before:absolute hover:text-secondary before:bottom-0 before:w-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                                :class="{ 'before:!w-full text-secondary': tab === 'penempatan' }"
                                @click="tab='penempatan'">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                    <path opacity="0.5"
                                        d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path d="M12 15L12 18" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>

                                Penempatan</a>
                        </li>
                        <li>
                            <a href="javascript:;"
                                class="p-5 py-3 -mb-[1px] flex items-center relative before:transition-all before:duration-700 hover:text-secondary before:absolute before:w-0 before:bottom-0 before:left-0 before:right-0 before:m-auto before:h-[1px] before:bg-secondary hover:before:w-full"
                                :class="{ 'before:!w-full text-secondary': tab === 'data' }"
                                @click="tab='data'">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                    <circle cx="12" cy="6" r="4"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <ellipse opacity="0.5" cx="12" cy="17" rx="7"
                                        ry="4" stroke="currentColor" stroke-width="1.5" />
                                </svg>

                                Data Penempatan Siswa</a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1 text-sm ">
                    <template x-if="tab === 'penempatan'">

                        {{-- dipindah disini --}}
                            <div x-data="invoiceList">
                                <div class="invoice-table">
                                    <table id="myTable" class="whitespace-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Alamat</th>
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
                                                <th colspan="{{ $jurusanLakiLaki->count() + $jurusanPerempuan->count() + 1 }}" class="!text-center border-b">Jumlah Penempatan Kuota</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                    </template>
                    <template x-if="tab === 'data'">
                        <div x-data="siswa">
                            <div class="invoice-table">
                                <table id="table2" class="whitespace-nowrap"></table>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>

    {{-- alert toast --}}
    @if(session('status'))
        <script>
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
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thead = document.querySelector('#myTable thead');
            const rows = Array.from(thead.querySelectorAll('tr'));
            
            if (rows.length === 3) {
                // Swap rows as needed
                thead.appendChild(rows[0]); // Move first row to the end
                thead.insertBefore(rows[1], rows[0]); // Move last row before the new first row
            }
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
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
            
                            {
                                select: this.dataArr[0].length - 1,
                                sortable: false,
                                render: function(data, cell, row) {
                                    return `<div class="flex gap-4 items-center">
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

                deleteRow() {
                    if (this.selectedRows.length > 0) {
                        window.Swal.fire({
                            icon: 'warning',
                            title: 'Apakah Anda yakin?',
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            showCancelButton: true,
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal',
                            padding: '2em',
                            customClass: 'sweet-alerts'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch('/guru/delete-multiple', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        ids: this.selectedRows
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.Swal.fire({
                                            title: 'Dihapus!',
                                            text: 'Data berhasil dihapus.',
                                            icon: 'success',
                                            customClass: 'sweet-alerts'
                                        });
                                        this.items = this.items.filter((item) => !this.selectedRows.includes(item.id));
                                        this.selectedRows = [];
                                    } else {
                                        window.Swal.fire({
                                            title: 'Gagal!',
                                            text: 'Terjadi kesalahan saat menghapus data.',
                                            icon: 'error',
                                            customClass: 'sweet-alerts'
                                        });
                                    }
                                })
                                .catch(error => {
                                    window.Swal.fire({
                                        title: 'Error!',
                                        text: 'Terjadi kesalahan saat menghapus data.',
                                        icon: 'error',
                                        customClass: 'sweet-alerts'
                                    });
                                });
                            }
                        });
                    } else {
                        window.Swal.fire({
                            title: 'Tidak ada data yang dipilih',
                            text: 'Silakan pilih data yang ingin dihapus.',
                            icon: 'info',
                            customClass: 'sweet-alerts'
                        });
                    }
                }


            }))
        })

        function confirmDelete(id) {
            window.Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                padding: '2em',
                customClass: 'sweet-alerts'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/industri/${id}/delete`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.Swal.fire({
                                title: 'Dihapus!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success',
                                customClass: 'sweet-alerts'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            window.Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error',
                                customClass: 'sweet-alerts'
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        window.Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error',
                            customClass: 'sweet-alerts'
                        });
                    });
                }
            });
        }
    </script>

    {{-- data untuk datatable --}}
    @php
    $items = [];
    foreach ($penempatan as $d) {
        $items[] = [
            'id' => $d->id,
            'nama' => $d->siswa->nama,
            'industri' => $d->industri->nama,
            'action' => $d->id, // Gunakan ID ini untuk aksi
        ];
    }
    @endphp

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('siswa', () => ({
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
                    this.datatable = new simpleDatatables.DataTable('#table2', {
                        data: {
                            headings: [
                                '<input type="checkbox" class="form-checkbox" :checked="checkAllCheckbox" :value="checkAllCheckbox" @change="checkAll($event.target.checked)"/>',
                                "Nama",
                                "Industri",
                                "Aksi",
                            ],
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            {
                                select: 0,
                                sortable: false,
                                render: function(data, cell, row) {
                                    return `<input type="checkbox" class="form-checkbox mt-1" :id="'chk' + ${data}" :value="(${data})" x-model.number="selectedRows" />`;
                                }
                            },
                            {
                                select: 3,
                                sortable: false,
                                render: function(data, cell, row) {
                                    return `<div class="flex gap-4 items-center">

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

    </script>

</x-layout.default>
