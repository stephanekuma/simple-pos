<?php

use App\Http\Controllers\PrinterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(url('admin/'));
});

Route::redirect('/login', '/admin')->name('login');

Route::get('/print/{id}',  PrinterController::class);
