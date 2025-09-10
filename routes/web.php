<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExcelUploadController;

Route::get('/excel-upload', [ExcelUploadController::class, 'uploadForm'])->name('excel.form');
Route::post('/excel-upload', [ExcelUploadController::class, 'upload'])->name('excel.upload');
