<?php

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
    return redirect()->route('dashboard');
});

Route::group(['prefix' => 'control', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/dashboard', function() { return view('dashboard'); })->name('dashboard');

    Route::get('/users', \App\Http\Livewire\UserManagement::class)->name('users');
    Route::get('/organizations', \App\Http\Livewire\OrganizationManagement::class)->name('organizations');
});
