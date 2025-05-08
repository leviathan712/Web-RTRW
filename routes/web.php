<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DownloadSuratController;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/surat/download/{record}', [DownloadSuratController::class, 'downloadSurat'])
    ->name('surat.download');

