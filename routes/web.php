<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/', function () {
//     return view('home', [
//         'title' => 'Home',
//         'active' => 'home'
//     ]);
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/update-theme', [HomeController::class, 'setTheme'])->name('theme.update');

Route::get('/properties/{slug}', [HomeController::class, 'showProperties']);

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/login/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/lupa-password', [LoginController::class, 'v_resetpassword']);
Route::get('/register', [LoginController::class, 'register']);
Route::post('/register', [LoginController::class, 'storeRegister'])->name('register.storeRegister');

Route::get('/reset-password', [LoginController::class, 'getTokenEmail']);
Route::post('/reset-password', [LoginController::class, 'sendEmail'])->name('reset.sendEmail');

Route::post('/resetpw', [LoginController::class, 'resetPassword'])->name('pw.resetPassword');

Route::post('/api/login', [LoginController::class, 'authenticate']);
Route::post('/api/logout', [LoginController::class, 'logout']);

// Route::get('/dashboard', function () {
//     return view('dashboard.index');
// });

Route::get('/test', [DashboardController::class, 'test'])->name('test');
Route::post('/test', [DashboardController::class, 'storeTest']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('check.token');
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('check.token');
Route::put('/updateProfile', [ProfileController::class, 'updateProfile'])->name('updateProfile')->middleware('check.token');
Route::resource('/category', CategoryController::class)->middleware('check.token');

Route::get('/property', [PropertyController::class, 'index'])->name('property.index')->middleware('check.token');
Route::get('/property/{slug}', [PropertyController::class, 'showProperty'])->name('property.show')->middleware('check.token');
Route::post('/property', [PropertyController::class, 'storeProperty'])->name('property.store')->middleware('check.token');
Route::get('/property/{id}/edit', [PropertyController::class, 'editProperty'])->name('property.edit')->middleware('check.token');
Route::put('/property/{id}', [PropertyController::class, 'updateProperty'])->name('property.update')->middleware('check.token');
Route::delete('/property/{id}', [PropertyController::class, 'destroy'])->name('property.destroy')->middleware('check.token');

Route::get('/unit', [PropertyController::class, 'getUnit'])->name('property.unit')->middleware('check.token');
Route::get('/unit/{id}', [PropertyController::class, 'getUnit'])->name('unit.show')->middleware('check.token');
Route::get('/units/create', [PropertyController::class, 'TambahUnit'])->middleware('check.token');
Route::post('/unit', [PropertyController::class, 'StoreUnit'])->name('unit.store')->middleware('check.token');
Route::get('/unit/{id}/edit', [PropertyController::class, 'editUnit'])->name('unit.edit')->middleware('check.token');
Route::put('/unit/{id}', [PropertyController::class, 'updateUnit'])->name('unit.update')->middleware('check.token');
Route::delete('/unit/{id}', [PropertyController::class, 'destroyUnit'])->name('unit.destroy')->middleware('check.token');


Route::post('/booking', [OrderController::class, 'storeBooking']);
Route::get('/booking/{kode_pemesanan}', [OrderController::class, 'get_data_booking'])
    ->name('booking.detail');

Route::get('/invoice/{kode_pemesanan}', [OrderController::class, 'get_invoice'])
    ->name('invoice.detail');
