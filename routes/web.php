<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

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
    return view('home', [
        'title' => 'Home',
        'active' => 'home'
    ]);
});

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout']);

Route::post('/api/login', [LoginController::class, 'authenticate']);
Route::post('/api/logout', [LoginController::class, 'logout']);

// Route::get('/dashboard', function () {
//     return view('dashboard.index');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('check.token');
Route::resource('/category', CategoryController::class)->middleware('check.token');

Route::get('/property', [PropertyController::class, 'index'])->name('property.index')->middleware('check.token');
Route::post('/property', [PropertyController::class, 'storeProperty'])->name('property.store')->middleware('check.token');
Route::get('/property/{id}', [PropertyController::class, 'showProperty'])->name('property.show')->middleware('check.token');
Route::get('/property/{id}/edit', [PropertyController::class, 'editProperty'])->name('property.edit')->middleware('check.token');
Route::get('/unit', [PropertyController::class, 'getUnit'])->name('property.unit');
