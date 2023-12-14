<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NonChargeableRequestController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (!Auth::user()) {
        return redirect()->route('login');
    } else {
        if (Auth::user()->first_time_login == 1) {
            return redirect()->route('change.password');
        } else {
            // return redirect()->route('dashboard');
            return redirect()->route('nchargeable');
        }
    }
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');


Route::middleware(['auth'])->group(function () {

    Route::get('/change-password', [LoginController::class, 'changePassword'])->name('change.password');
    Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('update.password');

    // NON-CHARGEABLE
    Route::get('/non-chargeable', [NonChargeableRequestController::class, 'index'])->name('nchargeable');

    Route::get('/non-chargeable/add', [NonChargeableRequestController::class, 'add'])->name('nchargeable.add');
    Route::post('/non-chargeable/add/get-models', [NonChargeableRequestController::class, 'getModels'])->name('nchargeable.add.getModels');
    Route::post('/non-chargeable/add/get-parts', [NonChargeableRequestController::class, 'getParts'])->name('nchargeable.add.getParts');
    Route::post('/non-chargeable/store', [NonChargeableRequestController::class, 'store'])->name('nchargeable.store');

    Route::post('/non-chargeable/view', [NonChargeableRequestController::class, 'view'])->name('nchargeable.view');
    Route::post('/non-chargeable/view-history', [NonChargeableRequestController::class, 'viewHistory'])->name('nchargeable.viewHistory');
    Route::post('/non-chargeable/view-history-parts', [NonChargeableRequestController::class, 'viewHistoryParts'])->name('nchargeable.viewHistoryParts');
    Route::post('/non-chargeable/view-fsrr', [NonChargeableRequestController::class, 'viewFSRR'])->name('nchargeable.viewFSRR');
    Route::post('/non-chargeable/validate-request', [NonChargeableRequestController::class, 'validateRequest'])->name('nchargeable.validateRequest');
    Route::post('/non-chargeable/verify-request', [NonChargeableRequestController::class, 'verifyRequest'])->name('nchargeable.verifyRequest');
    Route::post('/non-chargeable/approve-request', [NonChargeableRequestController::class, 'approveRequest'])->name('nchargeable.approveRequest');

    Route::post('/non-chargeable/return-parts', [NonChargeableRequestController::class, 'returnParts'])->name('nchargeable.returnParts');
    Route::post('/non-chargeable/return-request', [NonChargeableRequestController::class, 'returnRequest'])->name('nchargeable.returnRequest');
    Route::post('/non-chargeable/view-return-parts', [NonChargeableRequestController::class, 'viewReturnParts'])->name('nchargeable.viewReturnParts');
    Route::post('/non-chargeable/view-serial-numbers', [NonChargeableRequestController::class, 'viewSerialNumbers'])->name('nchargeable.viewSerialNumbers');












    Route::get('/logout', function () {
        if (Auth::user()) {
            Auth::logout();
            return redirect('/');
        }
    })->name('logout');
});








