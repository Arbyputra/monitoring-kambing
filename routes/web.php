<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Data_kambingController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/data-kambing', [Data_kambingController::class, 'index'])->name('data_kambing.index')->middleware('auth');

Route::get('/data-kambing/create', [Data_kambingController::class, 'create'])->name('data_kambing.create')->middleware('auth');
Route::post('/data-kambing', [Data_kambingController::class, 'store'])->name('data_kambing.store')->middleware('auth');
Route::get('/data-kambing/{id}/edit', [Data_kambingController::class, 'edit'])->name('data_kambing.edit')->middleware('auth');
Route::put('/data-kambing/{id}', [Data_kambingController::class, 'update'])->name('data_kambing.update')->middleware('auth');
Route::get('/data-kambing/{id}', [Data_kambingController::class, 'show'])->name('data_kambing.show')->middleware('auth');
Route::delete('/data-kambing/{id}', [Data_kambingController::class, 'destroy'])->name('data_kambing.destroy')->middleware('auth');
