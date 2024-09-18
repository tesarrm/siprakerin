<?php

use App\Http\Controllers\BidangKeahlianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HasilMonitoringController;
use App\Http\Controllers\IndustriController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\KuotaIndustriController;
use App\Http\Controllers\Monitoring2Controller;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PenempatanIndustriController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PilihanKotaController;
use App\Http\Controllers\SiswaController;
use App\Models\Jurnal;
use App\Models\PilihanKota;

Route::view('/', 'index');
Route::view('/tabel', 'tabel');

Route::resource('guru', GuruController::class);
Route::get('guru/{guruId}/delete', [GuruController::class, 'destroy']);
Route::post('/guru/delete-multiple', [GuruController::class, 'deleteMultiple']);
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

Route::resource('siswa', SiswaController::class);
Route::get('siswa/{siswaId}/delete', [SiswaController::class, 'destroy']);
Route::post('/siswa/delete-multiple', [SiswaController::class, 'deleteMultiple']);

Route::resource('industri', IndustriController::class);
Route::get('industri/{industriId}/delete', [IndustriController::class, 'destroy']);

Route::resource('kuotaindustri', KuotaIndustriController::class);
Route::post('/kuota-industri', [KuotaIndustriController::class, 'storeOrUpdate'])->name('kuota-industri.storeOrUpdate');

Route::resource('kota', KotaController::class);

Route::resource('pilihankota', PilihanKotaController::class);
Route::post('/pilihankota', [PilihanKotaController::class, 'storeOrUpdate']);

Route::resource('penempatan', PenempatanIndustriController::class);
Route::post('/penempatan', [PenempatanIndustriController::class, 'storeOrUpdate'])->name('penempatan.storeOrUpdate');

Route::resource('jurnal', JurnalController::class);
Route::get('jurnal/{jurnalId}/delete', [JurnalController::class, 'destroy']);

Route::resource('monitoring', MonitoringController::class);
Route::get('monitoring/{id}/delete', [MonitoringController::class, 'destroy']);

Route::resource('monitoring2', Monitoring2Controller::class);

Route::resource('hasilmonitoring', HasilMonitoringController::class);