
<x-layout.default>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/swiper-bundle.min.css') }}">
    <script src="/assets/js/swiper-bundle.min.js"></script>
    <script src="/assets/js/simple-datatables.js"></script>

    {{-- atur data --}}
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
                'nama' => $d->nama,
                'alamat' => $d->alamat,
                'kota' => $d->kota->nama,
                // 'tahun_ajaran' => $d->tahun_ajaran,
            ];

            // Hitung total kuota laki-laki dan perempuan
            $totalLakiLaki = 0;
            $totalPerempuan = 0;

            // foreach ($d->kuotaIndustri as $kuota) {
            //     $jurusanSingkatan = $kuota->jurusan->singkatan;
            //     $jenisKelamin = $kuota->jenis_kelamin == 'Laki-laki' ? 'L' : 'P';
            //     $formattedKey = "{$jenisKelamin}-{$jurusanSingkatan}";
            //     $row[$formattedKey] = $kuota->kuota;
            // }

            // // Isi semua jurusan dengan kuota, set 0 jika tidak ada kuota
            // foreach ($allJurusan as $jurusanSingkatan) {
            //     $row["L-{$jurusanSingkatan}"] = $row["L-{$jurusanSingkatan}"] ?? 0;
            //     $row["P-{$jurusanSingkatan}"] = $row["P-{$jurusanSingkatan}"] ?? 0;
            // }

            // Tentukan kuota awal untuk semua jurusan (0 jika tidak ada data)
            foreach ($jurusan as $jrs) {
                $row["L-{$jrs->singkatan}"] = 0;
            }

            foreach ($jurusan as $jrs) {
                $row["P-{$jrs->singkatan}"] = 0;
                $row["L-{$jrs->singkatan}"] = 0;
            }

            // Isi kuota berdasarkan data yang ada
            foreach ($d->kuotaIndustri as $kuota) {
                $jurusanSingkatan = $kuota->jurusan->singkatan;
                $jenisKelamin = $kuota->jenis_kelamin == 'Laki-laki' ? 'L' : 'P';
                $formattedKey = "{$jenisKelamin}-{$jurusanSingkatan}";
                $row[$formattedKey] = $kuota->kuota;
            }

            $row['Aksi'] = $d->id;

            $items[] = $row;
        }
    @endphp

    <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
        <div x-data="dataList">
            <div class="invoice-table">
                <table id="myTable" class="whitespace-nowrap">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th class="hidden">Tahun Ajaran</th>
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
                            <th class="hidden"></th>
                            <th colspan="{{ $jurusanLakiLaki->count() }}" class="!text-center border-b border-r">Laki-Laki</th>
                            <th colspan="{{ $jurusanPerempuan->count() }}" class="!text-center border-b">Perempuan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
    </div>

    {{-- =========================== --}}
    {{-- BOTTOM --}}
    {{-- =========================== --}}

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
         * datatable 
         */

        document.addEventListener("alpine:init", () => {
            Alpine.data('dataList', () => ({
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
                    const countArr = generateSequence(3, {{$jurusanLakiLaki->count() + $jurusanPerempuan->count()}});

                    this.datatable = new simpleDatatables.DataTable('#myTable', {
         
                        data: {
                            data: this.dataArr
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [
                            {
                                select: 0,
                                sortable: false,
                                render: function(data, cell, row) {
                                    const select = 3 + {{$jurusanLakiLaki->count() + $jurusanPerempuan->count()}};
                                    const id = row.cells[select].data; 
                                    return `<a href="/kuotaindustri/${id}/edit" class="hover:underline">${ data }</a>`;
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
                                select: 3 + {{$jurusanLakiLaki->count() + $jurusanPerempuan->count()}},
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
                        (d.nama && d.nama.toLowerCase().includes(this.searchText)) ||
                        (d.alamat && d.alamat.toLowerCase().includes(this.searchText)) ||
                        (d.kota && d.kota.toLowerCase().includes(this.searchText)) ||
                        (d.tahun_ajaran && d.tahun_ajaran.toLowerCase().includes(this.searchText))
                    );
                },
            }))
        })
    </script>

</x-layout.default>
