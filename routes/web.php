<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;

Route::view('/', 'index');

Route::resource('guru', GuruController::class);
Route::get('guru/{guruId}/delete', [GuruController::class, 'destroy']);
Route::post('/guru/delete-multiple', [GuruController::class, 'deleteMultiple']);
Route::get('/guru-export', [GuruController::class, 'export']);
Route::post('/guru-import', [GuruController::class, 'import']);


Route::post('/tmp-upload', [GuruController::class, 'tmpUpload']);
Route::delete('/tmp-delete', [GuruController::class, 'tmpDelete']);