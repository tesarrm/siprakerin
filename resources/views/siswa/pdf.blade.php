@php
    use Carbon\Carbon;
    $today = Carbon::now()->locale('id')->translatedFormat('d F Y');

    $path = public_path('assets/images/pdf/biodata-siswa.jpg');
    $path2 = public_path('assets/images/pdf/biodata-siswa2.jpg');
    // $path3 = public_path("{{ asset('storage/posts/' . $data->siswa->pas_foto) }}");
    $path3 = storage_path('app/public/posts/' . $data->siswa->pas_foto);

    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data1 = file_get_contents($path);
    $data2 = file_get_contents($path2);
    $data3 = file_get_contents($path3);

    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data1);
    $base642 = 'data:image/' . $type . ';base64,' . base64_encode($data2);
    $base643 = 'data:image/' . $type . ';base64,' . base64_encode($data3);
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
  <img style="width: 813.70px; height: 1243.68px; left: 0px; top: 0px; position: absolute" src="{{ $base64 }}" />
  <img style="width: 813.70px; height: 427.68px; left: 0px; top: 837px; position: absolute" src="{{ $base642 }}" />
  <div style="width: 181px; height: 23px; left: 412px; top: 221px; position: absolute; background: white"></div>
  <div style="width: 181px; height: 23px; left: 328px; top: 460px; position: absolute; background: white"></div>
  <div style="width: 169px; height: 19px; left: 102px; top: 830px; position: absolute; background: white"></div>
  <div style="width: 243px; height: 19px; left: 273px; top: 830px; position: absolute; background: white"></div>
  <div style="width: 243px; height: 52px; left: 38px; top: 1122px; position: absolute; background: white"></div>
  <div style="width: 236px; height: 19px; left: 517px; top: 828px; position: absolute; background: white"></div>
  <div style="width: 53px; height: 23px; left: 348px; top: 221px; position: absolute; background: white"></div>
  <div style="width: 268px; height: 49px; left: 328px; top: 240px; position: absolute; background: white"></div>
  <div style="left: 330px; top: 313px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->nama_lengkap }}</div>
  <div style="left: 348px; top: 222px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->kelas->jurusan->singkatan ." ". $data->siswa->kelas->klasifikasi }}</div>
  <div style="left: 420px; top: 222px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $pengaturan->tahun_ajaran }}</div>
  <div style="left: 328px; top: 241px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->kelas->jurusan->nama }}</div>
  <div style="left: 330px; top: 334px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->nis }}</div>
  <div style="left: 330px; top: 355px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->tempat_lahir .", ". $data->siswa->tanggal_lahir }}</div>
  <div style="left: 330px; top: 376px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->agama }}</div>
  <div style="left: 330px; top: 458px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->jenis_kelamin }}</div>
  <div style="left: 330px; top: 477px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->golongan_darah }}</div>
  <div style="left: 473px; top: 477px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tinggi_badan }}</div>
  <div style="left: 330px; top: 397px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->alamat }}</div>
  <div style="left: 272px; top: 543px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tahun_awal_1 }}</div>
  <div style="left: 272px; top: 567px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tahun_awal_2 }}</div>
  <div style="left: 272px; top: 590px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tahun_awal_3 }}</div>
  <div style="left: 330px; top: 620px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->hobi }}</div>
  <div style="left: 330px; top: 641px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->keahlian }}</div>
  <div style="left: 330px; top: 662px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->organisasi}}</div>
  <div style="left: 281px; top: 736px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ayah_nama }}</div>
  <div style="left: 163px; top: 920px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->nama_0 }}</div>
  <div style="left: 163px; top: 938px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->nama_1 }}</div>
  <div style="left: 163px; top: 955px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->nama_2 }}</div>
  <div style="left: 315px; top: 920px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->alamat_0 }}</div>
  <div style="left: 315px; top: 938px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->alamat_1 }}</div>
  <div style="left: 315px; top: 955px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->alamat_2 }}</div>
  <div style="left: 350px; top: 1001px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->penyakit }}</div>
  <div style="left: 582px; top: 1035px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $today }}</div>
  <div style="left: 526px; top: 1155px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->nama_lengkap }}</div>
  <div style="left: 512px; top: 920px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->no_telp_0 }}</div>
  <div style="left: 512px; top: 938px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->no_telp_1 }}</div>
  <div style="left: 512px; top: 955px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->no_telp_2 }}</div>
  <div style="left: 635px; top: 920px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->hub_keluarga_0 }}</div>
  <div style="left: 635px; top: 938px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->hub_keluarga_1 }}</div>
  <div style="left: 635px; top: 955px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->hub_keluarga_2 }}</div>
  <div style="left: 126px; top: 920px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">1</div>
  <div style="left: 126px; top: 938px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">2</div>
  <div style="left: 126px; top: 955px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">3</div>
  <div style="left: 526px; top: 737px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ibu_nama }}</div>
  <div style="left: 281px; top: 756px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ayah_usia }}</div>
  <div style="left: 526px; top: 757px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ibu_usia }}</div>
  <div style="left: 281px; top: 776px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ayah_pendidikan_terakhir }}</div>
  <div style="left: 526px; top: 777px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ibu_pendidikan_terakhir }}</div>
  <div style="left: 281px; top: 854px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ayah_no_telp }}</div>
  <div style="left: 526px; top: 855px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ibu_no_telp }}</div>
  <div style="left: 281px; top: 796px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ayah_pekerjaan }}</div>
  <div style="left: 526px; top: 797px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ibu_pekerjaan }}</div>
  <div style="left: 281px; top: 816px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ayah_alamat }}</div>
  <div style="left: 526px; top: 817px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->ibu_alamat }}</div>
  <div style="left: 356px; top: 543px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tahun_awal_1 }}</div>
  <div style="left: 356px; top: 567px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tahun_awal_2 }}</div>
  <div style="left: 356px; top: 590px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tahun_awal_3 }}</div>
  <div style="left: 425px; top: 546px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tempat_1 }}</div>
  <div style="left: 425px; top: 570px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->tempat_2 }}</div>
  <div style="left: 629px; top: 546px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->berijasah_1 }}</div>
  <div style="left: 629px; top: 570px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->berijasah_2 }}</div>
  <div style="left: 629px; top: 593px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->berijasah_1 }}</div>
  <div style="left: 391px; top: 418px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->kode_pos }}</div>
  <div style="left: 576px; top: 418px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->no_telp }}</div>
  <div style="left: 570px; top: 334px; position: absolute; color: black; font-size: 13px; font-family: Abhaya Libre Medium; font-weight: 400; word-wrap: break-word">{{ $data->siswa->nisn }}</div>
  <img style="width: 111px; height: 148px; left: 637px; top: 170px; position: absolute" src="{{ $base643 }}" />
</div>
</body>
</html>