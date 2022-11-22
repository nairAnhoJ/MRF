<?php

use App\Http\Controllers\GoogleSheetsController;
use App\Http\Controllers\MrfController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    $mrfs = DB::table('mrf')->get();
    return view('dashboard', compact('mrfs'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/create-mrf/for-rental-unit', [MrfController::class, 'rentalIndex'])->name('rental.index');

    Route::get('/googlesheets', [GoogleSheetsController::class, 'sheetOperation']);
});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
