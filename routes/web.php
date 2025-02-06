<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('/categories', CategoryController::class);
