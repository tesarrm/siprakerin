<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidangKeahlianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HasilMonitoringController;
use App\Http\Controllers\IndustriController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\KuotaIndustriController;
use App\Http\Controllers\Monitoring2Controller;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\NonaktifController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PelanggaranSiswaController;
use App\Http\Controllers\PenempatanIndustriController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PilihanKotaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Models\HasilMonitoring;
use App\Models\PelanggaranSiswa;

Route::view('/', 'index');
Route::view('/tabel', 'tabel');

// middleware untuk auth

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::resource('user', UserController::class);
Route::get('user/{id}/delete', [UserController::class, 'destroy']);
Route::get('profile', [UserController::class, 'editProfile']);
Route::post('profile', [UserController::class, 'updateProfile']);

Route::get('nonaktif', [NonaktifController::class, 'index']);

Route::resource('guru', GuruController::class);
Route::get('guru/{id}/delete', [GuruController::class, 'destroy']);
Route::post('guru/{user_id}/reset', [GuruController::class, 'resetPassword']);
Route::post('/guru/delete-multiple', [GuruController::class, 'deleteMultiple']);
Route::post('guru/{id}/nonaktif', [GuruController::class, 'nonaktif']);
Route::post('guru/{id}/aktif', [GuruController::class, 'aktif']);
Route::get('/guru-export', [GuruController::class, 'export']);
Route::post('/guru-import', [GuruController::class, 'import']);

Route::post('/tmp-upload', [GuruController::class, 'tmpUpload']);
Route::delete('/tmp-delete', [GuruController::class, 'tmpDelete']);

Route::resource('pengaturan', PengaturanController::class);

Route::resource('bidang-keahlian', BidangKeahlianController::class);
Route::get('bidang_keahlian/{bidangKeahlianId}/delete', [BidangKeahlianController::class, 'destroy']);

Route::resource('jurusan', JurusanController::class);
Route::get('jurusan/{jurusanId}/delete', [JurusanController::class, 'destroy']);

Route::resource('kelas', KelasController::class);
Route::get('/kelas/{kelas}/edit', [KelasController::class, 'edit']);
Route::get('kelas/{kelasId}/delete', [KelasController::class, 'destroy']);
Route::post('kelas/{id}/nonaktif', [KelasController::class, 'nonaktif']);
Route::post('kelas/{id}/aktif', [KelasController::class, 'aktif']);

Route::resource('siswa', SiswaController::class);
Route::get('siswa/{siswaId}/delete', [SiswaController::class, 'destroy']);
Route::post('/siswa/delete-multiple', [SiswaController::class, 'deleteMultiple']);
Route::post('siswa/{user_id}/reset', [SiswaController::class, 'resetPassword']);
Route::post('siswa/{id}/nonaktif', [SiswaController::class, 'nonaktif']);
Route::post('siswa/{id}/aktif', [SiswaController::class, 'aktif']);
Route::get('siswa-pdf', [PdfController::class, 'siswa']);

Route::resource('industri', IndustriController::class);
Route::get('industri/{industriId}/delete', [IndustriController::class, 'destroy']);
Route::post('industri/{id}/nonaktif', [IndustriController::class, 'nonaktif']);
Route::post('industri/{id}/aktif', [IndustriController::class, 'aktif']);

Route::resource('kuotaindustri', KuotaIndustriController::class);
Route::post('/kuota-industri', [KuotaIndustriController::class, 'storeOrUpdate'])->name('kuota-industri.storeOrUpdate');

Route::resource('kota', KotaController::class);

Route::resource('pilihankota', PilihanKotaController::class);
Route::post('/pilihankota', [PilihanKotaController::class, 'storeOrUpdate']);
Route::get('pilihankota-buat', [PilihanKotaController::class, 'buat']);
Route::post('/pilihankota/{id}/membuat', [PilihanKotaController::class, 'membuat']);

Route::resource('penempatan', PenempatanIndustriController::class);
Route::post('/penempatan', [PenempatanIndustriController::class, 'storeOrUpdate'])->name('penempatan.storeOrUpdate');
Route::get('penempatan/{id}/siswa', [PenempatanIndustriController::class, 'show2']);

Route::resource('jurnal', JurnalController::class);
Route::get('jurnal/{jurnalId}/delete', [JurnalController::class, 'destroy']);
Route::get('jurnal/{id}/izin', [JurnalController::class, 'show2']);

Route::resource('monitoring', MonitoringController::class);
Route::get('monitoring/{id}/delete', [MonitoringController::class, 'destroy']);

Route::resource('monitoring2', Monitoring2Controller::class);

Route::resource('hasilmonitoring', HasilMonitoringController::class);
Route::post('hasilmonitoring', [HasilMonitoringController::class, 'storeOrUpdate']);

Route::get('pilihankota-pdf', [PdfController::class, 'pilihankota']);
Route::get('pernyataan-pdf', [PdfController::class, 'pernyataan']);

Route::resource('izin', IzinController::class);

Route::get('/attendance', [AttendanceController::class, 'index']);
Route::get('/attendance-data', [AttendanceController::class, 'getAttendanceData']);
Route::get('/cek', [AttendanceController::class, 'storeCron']);

Route::resource('pelanggaran', PelanggaranSiswaController::class);
Route::get('pelanggaran/{id}/delete', [PelanggaranSiswaController::class, 'destroy']);