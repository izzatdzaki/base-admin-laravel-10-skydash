<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\KelompokTindakanController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PorsiCbgsController;
use App\Http\Controllers\PorsiJpController;
use App\Http\Controllers\PorsiJpTmoController;
use App\Http\Controllers\ParamedisController;
use App\Http\Controllers\ParamedisPendampingController;

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

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to dashboard if authenticated, otherwise to login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    });

    Route::get('/forms', function () {
        return view('pages.forms.index');
    });

    Route::get('/buttons', function () {
        return view('pages.ui-features.buttons.index');
    });

    Route::get('/dropdowns', function () {
        return view('pages.ui-features.dropdowns.index');
    });

    Route::get('/typography', function () {
        return view('pages.ui-features.typography.index');
    });

    Route::get('/chart', function () {
        return view('pages.chart.index');
    });

    Route::get('/table', function () {
        return view('pages.table.index');
    });

    Route::get('/icons', function () {
        return view('pages.icons.index');
    });

    // Master Data Routes
    Route::get('master-data/tarif', [TarifController::class, 'index'])->name('tarif.index');
    Route::post('master-data/tarif', [TarifController::class, 'store'])->name('tarif.store');
    Route::get('master-data/tarif/{id}/edit', [TarifController::class, 'edit'])->name('tarif.edit');
    Route::put('master-data/tarif/{id}', [TarifController::class, 'update'])->name('tarif.update');
    Route::delete('master-data/tarif/{id}', [TarifController::class, 'destroy'])->name('tarif.destroy');

    // master data kelompok tindakan
    Route::get('master-data/kelompok-tindakan', [KelompokTindakanController::class, 'index'])->name('kelompok-tindakan.index');
    Route::post('master-data/kelompok-tindakan', [KelompokTindakanController::class, 'store'])->name('kelompok-tindakan.store');
    Route::get('master-data/kelompok-tindakan/{id}/edit', [KelompokTindakanController::class, 'edit'])->name('kelompok-tindakan.edit');
    Route::put('master-data/kelompok-tindakan/{id}', [KelompokTindakanController::class, 'update'])->name('kelompok-tindakan.update');
    Route::delete('master-data/kelompok-tindakan/{id}', [KelompokTindakanController::class, 'destroy'])->name('kelompok-tindakan.destroy');

    // master data unit
    Route::resource('master-data/unit', UnitController::class);

    // master data porsi cbgs
    Route::resource('master-data/porsi-cbgs', PorsiCbgsController::class);

    // master data porsi jp
    Route::resource('master-data/porsi-jp', PorsiJpController::class);

    // master data porsi jp tmo
    Route::resource('master-data/porsi-jp-tmo', PorsiJpTmoController::class);

    // master data paramedis
    Route::resource('master-data/paramedis', ParamedisController::class);

    // master data paramedis pendamping
    Route::resource('master-data/paramedis-pendamping', ParamedisPendampingController::class);

});

// Public Routes (accessible without authentication)
Route::get('/register', function () {
    return view('pages.user-pages.register.index');
});

Route::get('/erro404', function () {
    return view('pages.error-pages.404.index');
});

Route::get('/erro500', function () {
    return view('pages.error-pages.500.index');
});
