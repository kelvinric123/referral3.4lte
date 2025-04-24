<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Hospital\DashboardController as HospitalDashboardController;
use App\Http\Controllers\Consultant\DashboardController as ConsultantDashboardController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Booking\DashboardController as BookingDashboardController;

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

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Auth::routes();

// Default home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Hospital Admin Routes
Route::prefix('hospital')->group(function () {
    Route::get('/dashboard', [HospitalDashboardController::class, 'index'])->name('hospital.dashboard');
});

// Consultant Routes
Route::prefix('consultant')->group(function () {
    Route::get('/dashboard', [ConsultantDashboardController::class, 'index'])->name('consultant.dashboard');
});

// GP Doctor Routes
Route::prefix('doctor')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
});

// Booking Agent Routes
Route::prefix('booking')->group(function () {
    Route::get('/dashboard', [BookingDashboardController::class, 'index'])->name('booking.dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
