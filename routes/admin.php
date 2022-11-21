<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware('auth', 'role')->group(function(){
    Route::get('/admin', [AdminController::class, 'adminIndex'])->name('admin.index');
});