<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExcelUploadController;
use App\Http\Controllers\LaporanController;

Route::get('/', [ExcelUploadController::class, 'uploadForm'])->name('index');
Route::post('/', [ExcelUploadController::class, 'upload'])->name('index');
Route::get('/formlaporan', [LaporanController::class, 'index'])->name('formlaporan');
Route::delete('/clear-data', [ExcelUploadController::class, 'clear'])->name('clear-data');
Route::get('/kegiatan-utama/{id}/sub-kegiatan', [LaporanController::class, 'getSubKegiatan']);

