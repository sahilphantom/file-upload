<?php

use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/file-upload', [FileUploadController::class, 'index'])->name('file-upload.index');
Route::post('/file-upload', [FileUploadController::class, 'store'])->name('file-upload.store');