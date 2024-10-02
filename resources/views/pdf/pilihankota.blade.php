@php
    use Carbon\Carbon;
    $today = Carbon::now()->locale('id')->translatedFormat('d F Y');

    $path = public_path('assets/images/pdf/pilihankota.jpg');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data1 = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data1);

@endphp

<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        .container-table {
            width: 670px;
            position: absolute;
            top: 261px;
            left: 75px;
        }
        table {
            background: #fff;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
            padding: 3px; 
        }
        th {
            background-color: #fff;
        }
        /* Lebar kolom diatur sesuai kebutuhan */
        .col-no { width: 5%; }
        .col-kota { width: 30%; }
        .col-biaya { width: 17%; }
        .col-pilihan1 { width: 9%; }
        .col-pilihan2 { width: 9%; }
        .col-pilihan3 { width: 9%; }
        .col-keterangan { width: 21%; }

    </style>
</head>
<body>
<div style="width: 813.70px; height: 1247.40px; position: relative; background: white">
  <img style="width: 811.83px; height: 1243.68px; left: 0px; top: 0px; position: absolute" src="{{ $base64 }}" />
  <div style="width: 269px; left: 139px; top: 236px; position: absolute; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">{{ $siswa->nama_lengkap }}</div>
  <div style="width: 269px; left: 533px; top: 236px; position: absolute; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">{{ $siswa->kelas->jurusan->singkatan . " " . $siswa->kelas->klasifikasi }}</div>
  <div class="container-table">
    <table style="text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-kota">Kota Tempat PKL</th>
                <th class="col-biaya">Perkiraan Biaya Hidup</th>
                <th class="col-pilihan1">Pilihan 1</th>
                <th class="col-pilihan2">Pilihan 2</th>
                <th class="col-pilihan3">Pilihan 3</th>
                <th class="col-keterangan">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kota as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: start;">{{ $item->nama }}</td>
                <td>{{ $item->biaya }}</td>
                <td>
                    @if(isset($pilihan) && $item->id === $pilihan->kota1->id)
                       <b>V</b> 
                    @endif
                </td>
                <td>
                    @if(isset($pilihan) && $item->id === $pilihan->kota2->id)
                       <b>V</b> 
                    @endif
                </td>
                <td>
                    @if(isset($pilihan) && $item->id === $pilihan->kota3->id)
                       <b>V</b> 
                    @endif
                </td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 12px; margin-bottom: 5px; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
        Alasan memilih tempat PKL:
    </div>
    <div style="text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
        In publishing and graphic design, Lorem ipsum is a  placeholder text commonly used to demonstrate the visual form of a  document or a typeface without relying on meaningful conte
        In publishing and graphic design, Lorem ipsum is a  placeholder text commonly used to demonstrate the visual form of a  document or a typeface without relying on meaningful conte
    </div>
    <div style="margin-top: 12px; margin-bottom: 5px; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
        Keterangan:
    </div>
    <div style="text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
        <ol style="margin: 0">
            <li>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, perspiciatis.
            </li>
            <li>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae ipsum velit, veritatis ducimus fugiat voluptates ullam similique nihil enim voluptatem suscipit, dolor natus consequatur harum quibusdam aliquid adipisci corrupti nostrum tempore distinctio sint explicabo odit. Modi amet suscipit harum optio, necessitatibus debitis cum, dolorem praesentium ipsam expedita sequi quod itaque.
            </li>
            <li>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, perspiciatis.
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, perspiciatis.
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, perspiciatis.
            </li>
            <li>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, perspiciatis.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae ipsum velit, veritatis ducimus fugiat voluptates ullam similique nihil enim voluptatem suscipit, dolor natus consequatur harum quibusdam aliquid adipisci corrupti nostrum tempore distinctio sint explicabo odit. Modi amet suscipit harum optio, necessitatibus debitis cum, dolorem praesentium ipsam expedita sequi quod itaque.
            </li>
            <li>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, perspiciatis.
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, perspiciatis.
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa, perspiciatis.
            </li>
        </ol>
    </div>
    <div style="margin-top: 12px; margin-bottom: 5px; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
        <table style="width: 100%; border: none !important;">
            <tr>
                <td style="text-align: left; vertical-align: top;border: none !important;">
                    Mengetahui/Menyetujui<br>
                    Orang Tua/Wali Siswa, 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    (…………………………….)
                </td>
                <td style="text-align: right; vertical-align: top; border: none !important;">
                    Malang, {{ $today }}</br>
                    Siswa, 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    ( {{ $siswa->nama_lengkap }} )
                </td>
            </tr>
        </table>
    </div>

    {{-- <div style="display: flex; justify-content: space-between;">
        <div>
            <div style="margin-top: 12px; margin-bottom: 12px; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
                Mengetahui/Menyetujui<br>
                Orang Tua/Wali Siswa, 
            </div>
            <br>
            <br>
            <br>
            <br>
            <div style="margin-top: 12px; margin-bottom: 5px; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
                (…………………………….)
            </div>
        </div>
        <div>
            <div style="margin-top: 12px; margin-bottom: 8px; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
                Malang, {{ $today }}</br>
                Siswa, 
            </div>
            <br>
            <br>
            <br>
            <br>
            <div style="margin-top: 12px; margin-bottom: 5px; text-align: justify; color: black; font-size: 16px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">
                ( {{ $siswa->nama_lengkap }} )
            </div>
        </div>
    </div> --}}
  </div>
</div>
</body>