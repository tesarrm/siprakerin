<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidangKeahlianController;
use App\Http\Controllers\CapaianPembelajaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HasilMonitoringController;
use App\Http\Controllers\IndustriController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JadwalMonitoringController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\KuotaIndustriController;
use App\Http\Controllers\Monitoring2Controller;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\NonaktifController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PelanggaranSiswaController;
use App\Http\Controllers\PenempatanIndustriController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PilihanKotaController;
use App\Http\Controllers\PrakerinController;
use App\Http\Controllers\PusatUnduhanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;

// Route::view('/tabel', 'tabel');

// middleware untuk auth

Route::middleware(['authenticated'])->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('user', UserController::class);
    Route::get('user/{id}/delete', [UserController::class, 'destroy']);
    Route::get('biodata', [UserController::class, 'editProfile']);
    Route::post('biodata', [UserController::class, 'updateProfile']);
    Route::post('user/{id}/role', [UserController::class, 'role']);
    Route::get('guruindustri', [UserController::class, 'guruIndustriIndex']);
    Route::post('guruindustri/{id}/industri', [UserController::class, 'storeGuruIndustri']);

    Route::get('pengaturan-akun', [UserController::class, 'editPengaturanAkun']);
    Route::post('pengaturan-akun', [UserController::class, 'updatePengaturanAkun']);
    Route::post('ubah-password', [AuthController::class, 'updateUbahPassword']);

    Route::get('nonaktif', [NonaktifController::class, 'index']);
    Route::post('/tmp-upload', [GuruController::class, 'tmpUpload']);
    Route::delete('/tmp-delete', [GuruController::class, 'tmpDelete']);

    Route::resource('pengaturan', PengaturanController::class);

    Route::resource('guru', GuruController::class);
    Route::get('guru/{id}/delete', [GuruController::class, 'destroy']);
    Route::post('guru/{user_id}/reset', [GuruController::class, 'resetPassword']);
    Route::post('guru/delete-multiple', [GuruController::class, 'deleteMultiple']);
    Route::post('guru/{id}/nonaktif', [GuruController::class, 'nonaktif']);
    Route::post('guru/{id}/aktif', [GuruController::class, 'aktif']);
    Route::get('guru-export', [GuruController::class, 'export']);
    Route::post('guru-import', [GuruController::class, 'import']);
    Route::get('guru-template', [GuruController::class, 'downloadTemplate']);

    Route::resource('bidangkeahlian', BidangKeahlianController::class);
    Route::get('bidangkeahlian/{id}/delete', [BidangKeahlianController::class, 'destroy']);
    Route::post('bidangkeahlian/delete-multiple', [BidangKeahlianController::class, 'deleteMultiple']);

    Route::resource('jurusan', JurusanController::class);
    Route::get('jurusan/{jurusanId}/delete', [JurusanController::class, 'destroy']);
    Route::post('jurusan/delete-multiple', [JurusanController::class, 'deleteMultiple']);

    Route::resource('kelas', KelasController::class);
    Route::get('kelas/{kelas}/edit', [KelasController::class, 'edit']);
    Route::get('kelas/{kelasId}/delete', [KelasController::class, 'destroy']);
    Route::post('kelas/{id}/nonaktif', [KelasController::class, 'nonaktif']);
    Route::post('kelas/{id}/aktif', [KelasController::class, 'aktif']);
    Route::post('kelas/delete-multiple', [KelasController::class, 'deleteMultiple']);

    Route::resource('siswa', SiswaController::class);
    Route::get('siswa/{siswaId}/delete', [SiswaController::class, 'destroy']);
    Route::post('siswa/delete-multiple', [SiswaController::class, 'deleteMultiple']);
    Route::post('siswa/{user_id}/reset', [SiswaController::class, 'resetPassword']);
    Route::post('siswa/{id}/nonaktif', [SiswaController::class, 'nonaktif']);
    Route::post('siswa/{id}/unconfirm', [SiswaController::class, 'unconfirm']);// pilihan kota
    Route::post('siswa/{id}/aktif', [SiswaController::class, 'aktif']);
    Route::get('siswa-pdf', [PdfController::class, 'siswa']);
    Route::get('siswa-export', [SiswaController::class, 'export']);
    Route::post('siswa-import', [SiswaController::class, 'import']);
    Route::get('siswa-template', [SiswaController::class, 'downloadTemplate']);
    Route::post('siswa/filter', [SiswaController::class, 'filter'])->name('siswa.filter');
    Route::post('pilihankota/filter', [PilihanKotaController::class, 'index2'])->name('pilihankota.filter');
    Route::get('siswa-wali', [SiswaController::class, 'indexWali']);

    Route::post('siswa-wali', [SiswaController::class, 'updateWali']);
    Route::post('siswa-wali/{id}/reset', [SiswaController::class, 'resetPasswordWali']);

    Route::resource('karyawan', KaryawanController::class);
    Route::get('karyawan/{id}/delete', [KaryawanController::class, 'destroy']);
    Route::post('karyawan/delete-multiple', [KaryawanController::class, 'deleteMultiple']);
    Route::post('karyawan/{id}/reset', [KaryawanController::class, 'resetPassword']);
    Route::post('karyawan/{id}/nonaktif', [KaryawanController::class, 'nonaktif']);
    Route::post('karyawan/{id}/aktif', [KaryawanController::class, 'aktif']);
    Route::get('karyawan-export', [KaryawanController::class, 'export']);
    Route::post('karyawan-import', [KaryawanController::class, 'import']);
    Route::get('karyawan-template', [KaryawanController::class, 'downloadTemplate']);

    Route::resource('kota', KotaController::class);
    Route::get('kota/{id}/delete', [KotaController::class, 'destroy']);
    Route::post('kota/delete-multiple', [KotaController::class, 'deleteMultiple']);

    Route::resource('industri', IndustriController::class);
    Route::get('industri/{industriId}/delete', [IndustriController::class, 'destroy']);
    Route::post('industri-akun/{id}/reset', [IndustriController::class, 'resetPassword']);
    Route::post('industri/{id}/nonaktif', [IndustriController::class, 'nonaktif']);
    Route::post('industri/{id}/aktif', [IndustriController::class, 'aktif']);
    Route::get('industri-akun', [IndustriController::class, 'indexAkun']);
    Route::post('industri/delete-multiple', [IndustriController::class, 'deleteMultiple']);
    Route::get('industri-export', [IndustriController::class, 'export']);
    Route::post('industri-import', [IndustriController::class, 'import']);
    Route::get('industri-template', [IndustriController::class, 'downloadTemplate']);

    Route::resource('kuotaindustri', KuotaIndustriController::class);
    Route::post('kuota-industri', [KuotaIndustriController::class, 'storeOrUpdate'])->name('kuota-industri.storeOrUpdate');

    Route::resource('pilihankota', PilihanKotaController::class);
    Route::post('pilihankota', [PilihanKotaController::class, 'storeOrUpdate']);
    Route::get('pilihankota-buat', [PilihanKotaController::class, 'buat']);
    Route::post('pilihankota/{id}/membuat', [PilihanKotaController::class, 'membuat']);

    Route::resource('penempatan', PenempatanIndustriController::class);
    Route::post('penempatan', [PenempatanIndustriController::class, 'storeOrUpdate'])->name('penempatan.storeOrUpdate');
    Route::get('penempatan/{id}/siswa', [PenempatanIndustriController::class, 'show2']);

    Route::resource('jurnal', JurnalController::class);
    Route::get('jurnal/{jurnalId}/delete', [JurnalController::class, 'destroy']);
    Route::resource('izin', IzinController::class);
    Route::get('attendance', [KehadiranController::class, 'index']);
    Route::get('attendance-data', [KehadiranController::class, 'getAttendanceData']);
    Route::get('cek', [KehadiranController::class, 'storeCron']);
    Route::post('jurnal/filter', [JurnalController::class, 'filter'])->name('siswa.filterJurnal');
    Route::post('jurnal/filterSiswa', [JurnalController::class, 'filterJurnal'])->name('jurnal.filter');

    Route::resource('pelanggaran', PelanggaranSiswaController::class);
    Route::get('pelanggaran/{id}/delete', [PelanggaranSiswaController::class, 'destroy']);

    Route::resource('pkl', PrakerinController::class);
    Route::post('pkl/{id}/berhenti', [PrakerinController::class, 'berhenti']);
    Route::post('pkl/{id}/lanjut', [PrakerinController::class, 'lanjut']);
    Route::post('pkl/filter', [PrakerinController::class, 'filter'])->name('siswa.filterPkl');

    Route::resource('capaian', CapaianPembelajaranController::class);
    Route::post('capaian', [CapaianPembelajaranController::class, 'storeOrUpdate']);

    Route::resource('jadwalmonitoring', JadwalMonitoringController::class);
    Route::get('jadwalmonitoring/{id}/delete', [JadwalMonitoringController::class, 'destroy']);
    Route::post('jadwalmonitoring/delete-multiple', [JadwalMonitoringController::class, 'deleteMultiple']);

    Route::resource('monitoring2', Monitoring2Controller::class);

    Route::resource('hasilmonitoring', HasilMonitoringController::class);
    Route::post('hasilmonitoring', [HasilMonitoringController::class, 'storeOrUpdate']);

    Route::get('pilihankota-pdf', [PdfController::class, 'pilihankota']);
    Route::get('pernyataan-pdf', [PdfController::class, 'pernyataan']);

    Route::resource('nilai', NilaiController::class);
    Route::post('nilai', [NilaiController::class, 'storeOrUpdate']);
    Route::get('nilai/{id}/show', [NilaiController::class, 'show']);

    Route::get('pusat-unduhan', [DashboardController::class, 'indexPusatUnduhan']);

    Route::resource('pusatunduhan', PusatUnduhanController::class);
    Route::get('pusatunduhan/{id}/delete', [PusatUnduhanController::class, 'destroy']);
    Route::post('pusatunduhan/delete-multiple', [PusatUnduhanController::class, 'deleteMultiple']);
    Route::post('tmp-upload-pusatunduhan', [PusatUnduhanController::class, 'tmpUpload']);
    Route::delete('tmp-delete-pusatunduhan', [PusatUnduhanController::class, 'tmpDelete']);
    Route::post('pusatunduhan/download', [PusatUnduhanController::class, 'download']);
    Route::get('pusatunduhan-view', [PusatUnduhanController::class, 'view']);

    Route::resource('tahunajaran', TahunAjaranController::class);
});