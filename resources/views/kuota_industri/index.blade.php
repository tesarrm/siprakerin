
<x-layout.default>

    <script src="/assets/js/simple-datatables.js"></script>

    @php
        $items = [];
        $allJurusan = $jurusan->pluck('singkatan');

        // Mengelompokkan jurusan berdasarkan jenis kelamin untuk heading tabel
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

       foreach ($data as $d) {
            $row = [
                'nama' => $d->nama,
                'alamat' => $d->alamat,
                'kota' => $d->kota->nama,
                'tahun_ajaran' => $d->tahun_ajaran,
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

            $row['Aksi'] = $d->id;

            $items[] = $row;
        }
    @endphp

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>

    <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
        <div x-data="penempatan">
            <div class="invoice-table">
                <table id="myTable" class="whitespace-nowrap">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Tahun Ajaran</th>
                            @foreach ($jurusanLakiLaki as $jurusan)
                                <th>{{ $jurusan }}</th>
                            @endforeach
                            @foreach ($jurusanPerempuan as $jurusan)
                                <th>{{ $jurusan }}</th>
                            @endforeach
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th colspan="{{ $jurusanLakiLaki->count() }}" class="!text-center border-b border-r">Laki-Laki</th>
                            <th colspan="{{ $jurusanPerempuan->count() }}" class="!text-center border-b">Perempuan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
            
            if (rows.length === 2) {
                // Swap rows as needed
                thead.appendChild(rows[0]); // Move first row to the end
                thead.insertBefore(rows[1], rows[0]); // Move last row before the new first row
            }
        });
    </script>

    {{-- script untuk datatable --}}
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('penempatan', () => ({
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
                                                <a href="/kuotaindustri/${data}/edit" class="hover:text-info">
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
            }))
        })
    </script>

</x-layout.default>
