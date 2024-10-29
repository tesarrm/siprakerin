@php
    use Carbon\Carbon;
    $today = Carbon::now()->locale('id')->translatedFormat('d F Y');

    $path = public_path('assets/images/pdf/pernyataan.jpg');
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
    </style>
</head>
<body>
<div style="width: 813.70px; height: 1247.40px; position: relative; background: white">
  <img style="width: 811.83px; height: 1240.82px; left: 0px; top: 0px; position: absolute" src="{{ $base64 }}" />
  <div style="width: 47px; height: 30px; left: 685px; top: 936px; position: absolute; background: white"></div>
  <div style="left: 322px; top: 218px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">{{ $siswa->user->name }}</div>
  <div style="left: 322px; top: 239px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">{{ $siswa->nis }}</div>
  <div style="left: 322px; top: 260px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">{{ $siswa->kelas->nama . ' ' . $siswa->kelas->jurusan->singkatan . ' ' . $siswa->kelas->klasifikasi }}</div>
  <div style="left: 322px; top: 281px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word"></div>
  <div style="left: 323px; top: 302px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word"></div>
  <div style="left: 323px; top: 323px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word"></div>
  <div style="left: 323px; top: 344px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word"></div>
  <div style="left: 556px; top: 942px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">{{ $today }}</div>
  <div style="left: 515px; top: 1060px; position: absolute; text-align: justify; color: black; font-size: 13px; font-family: Source Serif Pro; font-weight: 400; word-wrap: break-word">{{ $siswa->user->name }}</div>
</div>
<body>