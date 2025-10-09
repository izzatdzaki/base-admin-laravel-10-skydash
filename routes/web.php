<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

    Route::get('master-data/tarif', function () {
        return view('master-data.tarif.index');
    });

    Route::get('master-data/kelompok-tindakan', function () {
        return view('master-data.kelompok-tindakan.index');
    });

    Route::get('master-data/unit', function () {
        return view('master-data.unit.index');
    });

    Route::get('master-data/paramedis', function () {
        return view('master-data.paramedis.index');
    });

    Route::get('master-data/paramedis-pendamping', function () {
        return view('master-data.paramedis-pendamping.index');
    });

    Route::get('master-data/porsi-jp', function () {
        return view('master-data.porsi-jp.index');
    });

    Route::get('master-data/porsi-jp-tmo', function () {
        return view('master-data.porsi-jp-tmo.index');
    });

    Route::get('master-data/porsi-cbgs', function () {
        return view('master-data.porsi-cbgs.index');
    });

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
