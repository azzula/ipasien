<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Daerahs;
use App\Http\Livewire\Pasiens;

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
    if (Auth::check()) {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('daerah');
        } elseif (Auth::user()->hasRole('operator')) {
            return redirect()->route('pasien');
        }
    } else {
        return redirect()->route('login');
    }
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('daerah');
        } elseif (Auth::user()->hasRole('operator')) {
            return redirect()->route('pasien');
        }
    })->name('welcome');

    Route::get('dashboard', function () {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('daerah');
        } elseif (Auth::user()->hasRole('operator')) {
            return redirect()->route('pasien');
        }
    })->name('dashboard');

    Route::get('daerah', Daerahs::class)->middleware('role:admin')->name('daerah');
    Route::get('pasien', Pasiens::class)->middleware('role:operator')->name('pasien');
    Route::get('/{value}', [Pasiens::class, 'cetak'])->middleware('role:operator')->name('biopasien.cetak');
});
