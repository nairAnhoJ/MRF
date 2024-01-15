<?php

use App\Http\Controllers\ApproverController;
use App\Http\Controllers\ChargeableRequestController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NonChargeableRequestController;
use App\Http\Controllers\UserController;
use App\Models\ChargeableRequest;
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
            return redirect()->route('dashboard');
            // return redirect()->route('nchargeable');
        }
    }
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/change-password', [LoginController::class, 'changePassword'])->name('change.password');
    Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('update.password');

    // NON-CHARGEABLE
        Route::get('/non-chargeable', [NonChargeableRequestController::class, 'index'])->name('nchargeable');

        Route::get('/non-chargeable/add', [NonChargeableRequestController::class, 'add'])->name('nchargeable.add');
        Route::post('/non-chargeable/add/get-models', [NonChargeableRequestController::class, 'getModels'])->name('nchargeable.add.getModels');
        Route::post('/non-chargeable/add/get-parts', [NonChargeableRequestController::class, 'getParts'])->name('nchargeable.add.getParts');
        Route::post('/non-chargeable/add/update-selected-parts', [NonChargeableRequestController::class, 'updateSelected'])->name('nchargeable.add.updateSelected');
        Route::post('/non-chargeable/store', [NonChargeableRequestController::class, 'store'])->name('nchargeable.store');
        
        Route::get('/non-chargeable/edit/{request_number}', [NonChargeableRequestController::class, 'edit'])->name('nchargeable.edit');
        Route::post('/non-chargeable/update', [NonChargeableRequestController::class, 'update'])->name('nchargeable.update');

        Route::post('/non-chargeable/view', [NonChargeableRequestController::class, 'view'])->name('nchargeable.view');
        Route::post('/non-chargeable/view-history', [NonChargeableRequestController::class, 'viewHistory'])->name('nchargeable.viewHistory');
        Route::post('/non-chargeable/view-history-parts', [NonChargeableRequestController::class, 'viewHistoryParts'])->name('nchargeable.viewHistoryParts');
        Route::post('/non-chargeable/view-fsrr', [NonChargeableRequestController::class, 'viewFSRR'])->name('nchargeable.viewFSRR');
        Route::post('/non-chargeable/validate-request', [NonChargeableRequestController::class, 'validateRequest'])->name('nchargeable.validateRequest');
        Route::post('/non-chargeable/verify-request', [NonChargeableRequestController::class, 'verifyRequest'])->name('nchargeable.verifyRequest');
        Route::post('/non-chargeable/edoc-parts', [NonChargeableRequestController::class, 'edocParts'])->name('nchargeable.edocParts');
        Route::post('/non-chargeable/mri-number', [NonChargeableRequestController::class, 'mriNumber'])->name('nchargeable.mriNumber');
        Route::post('/non-chargeable/approve-request', [NonChargeableRequestController::class, 'approveRequest'])->name('nchargeable.approveRequest');

        Route::post('/non-chargeable/return-parts', [NonChargeableRequestController::class, 'returnParts'])->name('nchargeable.returnParts');
        Route::post('/non-chargeable/return-request', [NonChargeableRequestController::class, 'returnRequest'])->name('nchargeable.returnRequest');
        Route::post('/non-chargeable/view-return-parts', [NonChargeableRequestController::class, 'viewReturnParts'])->name('nchargeable.viewReturnParts');
        Route::post('/non-chargeable/view-edoc-parts', [NonChargeableRequestController::class, 'viewEdocParts'])->name('nchargeable.viewEdocParts');
        Route::post('/non-chargeable/view-serial-numbers', [NonChargeableRequestController::class, 'viewSerialNumbers'])->name('nchargeable.viewSerialNumbers');
    // NON-CHARGEABLE







    

    // CHARGEABLE
        Route::get('/chargeable', [ChargeableRequestController::class, 'index'])->name('chargeable');//

        Route::get('/chargeable/add', [ChargeableRequestController::class, 'add'])->name('chargeable.add');//
        Route::post('/chargeable/add/get-models', [ChargeableRequestController::class, 'getModels'])->name('chargeable.add.getModels');//
        Route::post('/chargeable/add/get-parts', [ChargeableRequestController::class, 'getParts'])->name('chargeable.add.getParts');//
        Route::post('/chargeable/add/update-selected-parts', [ChargeableRequestController::class, 'updateSelected'])->name('chargeable.add.updateSelected');//
        Route::post('/chargeable/store', [ChargeableRequestController::class, 'store'])->name('chargeable.store');//
        
        Route::get('/chargeable/edit/{request_number}', [ChargeableRequestController::class, 'edit'])->name('chargeable.edit');
        Route::post('/chargeable/update', [ChargeableRequestController::class, 'update'])->name('chargeable.update');

        Route::post('/chargeable/view', [ChargeableRequestController::class, 'view'])->name('chargeable.view'); 
        Route::post('/chargeable/view-history', [ChargeableRequestController::class, 'viewHistory'])->name('chargeable.viewHistory');
        Route::post('/chargeable/view-history-parts', [ChargeableRequestController::class, 'viewHistoryParts'])->name('chargeable.viewHistoryParts');
        Route::post('/chargeable/view-fsrr', [ChargeableRequestController::class, 'viewFSRR'])->name('chargeable.viewFSRR');
        
        Route::post('/chargeable/validate-request', [ChargeableRequestController::class, 'validateRequest'])->name('chargeable.validateRequest');
        Route::post('/chargeable/verify-request', [ChargeableRequestController::class, 'verifyRequest'])->name('chargeable.verifyRequest');
        Route::post('/chargeable/approve-request', [ChargeableRequestController::class, 'approveRequest'])->name('chargeable.approveRequest');

        Route::post('/chargeable/return-parts', [ChargeableRequestController::class, 'returnParts'])->name('chargeable.returnParts');
        Route::post('/chargeable/return-request', [ChargeableRequestController::class, 'returnRequest'])->name('chargeable.returnRequest');
        Route::post('/chargeable/view-return-parts', [ChargeableRequestController::class, 'viewReturnParts'])->name('chargeable.viewReturnParts');
        Route::post('/chargeable/view-serial-numbers', [ChargeableRequestController::class, 'viewSerialNumbers'])->name('chargeable.viewSerialNumbers');
    // CHARGEABLE






    // SYSTEM MANAGEMENT
        // USERS
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/add', [UserController::class, 'add'])->name('users.add');
            Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
            Route::get('/user/edit/{key}', [UserController::class, 'edit'])->name('users.edit');
            Route::post('/user/update/{key}', [UserController::class, 'update'])->name('users.update');
            Route::get('/user/delete/{key}', [UserController::class, 'delete'])->name('users.delete');
            Route::get('/user/reset/{key}', [UserController::class, 'reset'])->name('users.reset');
        // USERS

        // APPROVERS
            Route::get('/approvers', [ApproverController::class, 'index'])->name('approvers.index');
            Route::get('/approvers/add', [ApproverController::class, 'add'])->name('approvers.add');
            Route::post('/approvers/store', [ApproverController::class, 'store'])->name('approvers.store');
            Route::get('/approver/edit/{id}', [ApproverController::class, 'edit'])->name('approvers.edit');
            Route::post('/approver/update/{id}', [ApproverController::class, 'update'])->name('approvers.update');
            Route::get('/approver/delete/{id}', [ApproverController::class, 'delete'])->name('approvers.delete');
        // APPROVERS
    
    // SYSTEM MANAGEMENT











    Route::get('/logout', function () {
        if (Auth::user()) {
            Auth::logout();
            return redirect('/');
        }
    })->name('logout');
});








