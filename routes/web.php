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

// GP Authentication Routes
Route::get('/gp/login', [App\Http\Controllers\Auth\GPLoginController::class, 'showLoginForm'])->name('gp.login.form');
Route::post('/gp/login', [App\Http\Controllers\Auth\GPLoginController::class, 'login'])->name('gp.login');

// Hospital Authentication Routes
Route::get('/hospital/login', [App\Http\Controllers\Auth\HospitalLoginController::class, 'showLoginForm'])->name('hospital.login.form');
Route::post('/hospital/login', [App\Http\Controllers\Auth\HospitalLoginController::class, 'login'])->name('hospital.login');

// Consultant Authentication Routes
Route::get('/consultant/login', [App\Http\Controllers\Auth\ConsultantLoginController::class, 'showLoginForm'])->name('consultant.login.form');
Route::post('/consultant/login', [App\Http\Controllers\Auth\ConsultantLoginController::class, 'login'])->name('consultant.login');

// Booking Agent Authentication Routes
Route::get('/booking-agent/login', [App\Http\Controllers\Auth\BookingAgentLoginController::class, 'showLoginForm'])->name('booking-agent.login.form');
Route::post('/booking-agent/login', [App\Http\Controllers\Auth\BookingAgentLoginController::class, 'login'])->name('booking-agent.login');

// Default home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('hospitals', App\Http\Controllers\Admin\HospitalController::class)->names('hospitals');
    Route::resource('specialties', App\Http\Controllers\Admin\SpecialtyController::class)->names('specialties');
    Route::resource('consultants', App\Http\Controllers\Admin\ConsultantController::class)->names('consultants');
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class)->names('services');
    Route::resource('clinics', App\Http\Controllers\Admin\ClinicController::class)->names('clinics');
    Route::resource('gps', App\Http\Controllers\Admin\GPController::class)->names('gps');
    Route::resource('companies', App\Http\Controllers\Admin\CompanyController::class)->names('companies');
    Route::resource('booking-agents', App\Http\Controllers\Admin\BookingAgentController::class)->names('booking-agents');
    
    // Referral Management Routes
    Route::resource('referrals', App\Http\Controllers\Admin\ReferralController::class)->names('referrals');
    
    // Referral Status Update Route
    Route::patch('/referrals/{referral}/update-status', [App\Http\Controllers\Admin\ReferralController::class, 'updateStatus'])->name('referrals.update-status');
    
    // Referral Document Upload Route
    Route::post('/referrals/{referral}/upload-documents', [App\Http\Controllers\Admin\ReferralController::class, 'uploadDocuments'])->name('referrals.upload-documents');
    
    // Referral Feedback Route
    Route::post('/referrals/{referral}/send-feedback', [App\Http\Controllers\Admin\ReferralController::class, 'sendFeedback'])->name('referrals.send-feedback');
    
    // Document Management Routes
    Route::get('/documents/{document}/download', [App\Http\Controllers\Admin\DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [App\Http\Controllers\Admin\DocumentController::class, 'destroy'])->name('documents.destroy');
    
    // Loyalty Point Settings Routes
    Route::resource('loyalty-point-settings', App\Http\Controllers\Admin\LoyaltyPointSettingController::class)
        ->only(['index', 'edit', 'update'])
        ->names('loyalty-point-settings');
    
    // GP Loyalty Points Routes
    Route::get('gp-loyalty-points', [App\Http\Controllers\Admin\GPLoyaltyPointController::class, 'index'])
        ->name('gp-loyalty-points.index');
    Route::get('gp-loyalty-points/{id}', [App\Http\Controllers\Admin\GPLoyaltyPointController::class, 'show'])
        ->name('gp-loyalty-points.show');
    
    // Booking Agent Loyalty Points Routes
    Route::get('booking-agent-loyalty-points', [App\Http\Controllers\Admin\BookingAgentLoyaltyPointController::class, 'index'])
        ->name('booking-agent-loyalty-points.index');
    Route::get('booking-agent-loyalty-points/{id}', [App\Http\Controllers\Admin\BookingAgentLoyaltyPointController::class, 'show'])
        ->name('booking-agent-loyalty-points.show');
    
    // GP Referral Program Routes
    Route::resource('gp-referral-programs', App\Http\Controllers\Admin\GPReferralProgramController::class)
        ->names('gp-referral-programs');
    Route::post('gp-referral-programs/{gpReferralProgram}/participation', [App\Http\Controllers\Admin\GPReferralProgramController::class, 'recordParticipation'])
        ->name('gp-referral-programs.participation');
    Route::post('gp-referral-programs/{gpReferralProgram}/attendance', [App\Http\Controllers\Admin\GPReferralProgramController::class, 'recordAttendance'])
        ->name('gp-referral-programs.attendance');
    
    // GP Referral Program Participation Routes
    Route::get('gp-referral-program-participation', [App\Http\Controllers\Admin\GPReferralProgramParticipationController::class, 'index'])
        ->name('gp-referral-program-participation.index');
    Route::get('gp-referral-program-participation/{program}', [App\Http\Controllers\Admin\GPReferralProgramParticipationController::class, 'show'])
        ->name('gp-referral-program-participation.show');
    Route::post('gp-referral-program-participation/{program}/record-participation', [App\Http\Controllers\Admin\GPReferralProgramParticipationController::class, 'recordParticipation'])
        ->name('gp-referral-program-participation.record-participation');
    Route::post('gp-referral-program-participation/{program}/record-attendance', [App\Http\Controllers\Admin\GPReferralProgramParticipationController::class, 'recordAttendance'])
        ->name('gp-referral-program-participation.record-attendance');

    // Add the statistics route to the admin routes
    Route::get('statistics', 'App\Http\Controllers\Admin\StatisticsController@index');
});

// Hospital Admin Routes
Route::prefix('hospital')->name('hospital.')->middleware(['auth', 'role:hospital-admin'])->group(function () {
    Route::get('/dashboard', [HospitalDashboardController::class, 'index'])->name('dashboard');
    
    // Hospital Statistics
    Route::get('/statistics', 'App\Http\Controllers\Hospital\StatisticsController@index');
    
    // Hospital Management
    Route::get('/hospital', [App\Http\Controllers\Hospital\HospitalController::class, 'show'])->name('my-hospital');
    Route::get('/hospital/edit', [App\Http\Controllers\Hospital\HospitalController::class, 'edit'])->name('my-hospital.edit');
    Route::put('/hospital/update', [App\Http\Controllers\Hospital\HospitalController::class, 'update'])->name('my-hospital.update');
    
    // Specialty Management
    Route::resource('specialties', App\Http\Controllers\Hospital\SpecialtyController::class)->names('specialties');
    
    // Consultant Management
    Route::resource('consultants', App\Http\Controllers\Hospital\ConsultantController::class)->names('consultants');
    
    // Service Management
    Route::resource('services', App\Http\Controllers\Hospital\ServiceController::class)->names('services');
    
    // Clinic Management
    Route::resource('clinics', App\Http\Controllers\Hospital\ClinicController::class)->names('clinics');
    
    // GP Management
    Route::resource('gps', App\Http\Controllers\Hospital\GPController::class)->names('gps');
    
    // Document Management Routes
    Route::get('/documents/{document}/download', [App\Http\Controllers\Hospital\DocumentController::class, 'download'])->name('documents.download');
    
    // Referral Management
    Route::resource('referrals', App\Http\Controllers\Hospital\ReferralController::class)->names('referrals');
    
    // Add referral status update route
    Route::patch('/referrals/{referral}/update-status', [App\Http\Controllers\Hospital\ReferralController::class, 'updateStatus'])->name('referrals.update-status');
    
    // Loyalty Points Routes
    Route::get('/loyalty-points', [App\Http\Controllers\Hospital\LoyaltyPointController::class, 'index'])->name('loyalty-points.index');
    
    // GP Loyalty Points Routes
    Route::get('/gp-loyalty-points', [App\Http\Controllers\Hospital\GPLoyaltyPointController::class, 'index'])->name('gp-loyalty-points.index');
    Route::get('/gp-loyalty-points/{id}', [App\Http\Controllers\Hospital\GPLoyaltyPointController::class, 'show'])->name('gp-loyalty-points.show');
    
    // Booking Agent Loyalty Points Routes
    Route::get('/booking-agent-loyalty-points', [App\Http\Controllers\Hospital\BookingAgentLoyaltyPointController::class, 'index'])->name('booking-agent-loyalty-points.index');
    Route::get('/booking-agent-loyalty-points/{id}', [App\Http\Controllers\Hospital\BookingAgentLoyaltyPointController::class, 'show'])->name('booking-agent-loyalty-points.show');
});

// Consultant Routes
Route::prefix('consultant')->name('consultant.')->middleware(['auth', 'role:consultant,super-admin'])->group(function () {
    Route::get('/dashboard', [ConsultantDashboardController::class, 'index'])->name('dashboard');
    
    // Consultant Statistics
    Route::get('/statistics', 'App\Http\Controllers\Consultant\StatisticsController@index')->name('statistics');
    
    // Referral Management
    Route::get('/referrals', [App\Http\Controllers\Consultant\ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/referrals/{referral}', [App\Http\Controllers\Consultant\ReferralController::class, 'show'])->name('referrals.show');
});

// GP Doctor Routes
Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:gp-doctor'])->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    
    // GP Statistics
    Route::get('/statistics', 'App\Http\Controllers\Doctor\StatisticsController@index');
    
    // Referrals
    Route::get('/referrals', [App\Http\Controllers\Doctor\ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/referrals/create', [App\Http\Controllers\Doctor\ReferralController::class, 'create'])->name('referrals.create');
    Route::post('/referrals', [App\Http\Controllers\Doctor\ReferralController::class, 'store'])->name('referrals.store');
    Route::get('/referrals/{referral}', [App\Http\Controllers\Doctor\ReferralController::class, 'show'])->name('referrals.show');
    Route::post('/referrals/{referral}/send-feedback', [App\Http\Controllers\Doctor\ReferralController::class, 'sendFeedback'])->name('referrals.send-feedback');
    
    // Loyalty Points
    Route::get('/loyalty-points', [App\Http\Controllers\Doctor\LoyaltyPointController::class, 'index'])->name('loyalty-points.index');
    
    // Profile Routes
    Route::get('/profile/hospital', [App\Http\Controllers\Doctor\ProfileController::class, 'hospital'])->name('profile.hospital');
    Route::get('/profile/specialty', [App\Http\Controllers\Doctor\ProfileController::class, 'specialty'])->name('profile.specialty');
    Route::get('/profile/consultant', [App\Http\Controllers\Doctor\ProfileController::class, 'consultant'])->name('profile.consultant');
    
    // GP Referral Programs
    Route::get('/gp-referral-programs', [App\Http\Controllers\Doctor\GPReferralProgramController::class, 'index'])->name('gp-referral-programs.index');
    Route::get('/gp-referral-programs/{gpReferralProgram}', [App\Http\Controllers\Doctor\GPReferralProgramController::class, 'show'])->name('gp-referral-programs.show');
    Route::post('/gp-referral-programs/{gpReferralProgram}/participate', [App\Http\Controllers\Doctor\GPReferralProgramController::class, 'participate'])->name('gp-referral-programs.participate');
    Route::post('/gp-referral-programs/{gpReferralProgram}/attend', [App\Http\Controllers\Doctor\GPReferralProgramController::class, 'attend'])->name('gp-referral-programs.attend');
});

// Booking Agent Routes
Route::prefix('booking')->name('booking.')->middleware(['auth', 'role:booking-agent'])->group(function () {
    Route::get('/dashboard', [BookingDashboardController::class, 'index'])->name('dashboard');
    
    // Referrals
    Route::get('/referrals', [App\Http\Controllers\Booking\ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/referrals/create', [App\Http\Controllers\Booking\ReferralController::class, 'create'])->name('referrals.create');
    Route::post('/referrals', [App\Http\Controllers\Booking\ReferralController::class, 'store'])->name('referrals.store');
    Route::get('/referrals/{referral}', [App\Http\Controllers\Booking\ReferralController::class, 'show'])->name('referrals.show');
    Route::get('/referrals/{referral}/edit', [App\Http\Controllers\Booking\ReferralController::class, 'edit'])->name('referrals.edit');
    Route::put('/referrals/{referral}', [App\Http\Controllers\Booking\ReferralController::class, 'update'])->name('referrals.update');
    Route::patch('/referrals/{referral}/cancel', [App\Http\Controllers\Booking\ReferralController::class, 'cancel'])->name('referrals.cancel');
    
    // Loyalty Points
    Route::get('/loyalty-points', [App\Http\Controllers\Booking\LoyaltyPointController::class, 'index'])->name('loyalty-points.index');
    
    // Profile Routes
    Route::get('/profile/hospital', [App\Http\Controllers\Booking\ProfileController::class, 'hospital'])->name('profile.hospital');
    Route::get('/profile/specialty', [App\Http\Controllers\Booking\ProfileController::class, 'specialty'])->name('profile.specialty');
    Route::get('/profile/consultant', [App\Http\Controllers\Booking\ProfileController::class, 'consultant'])->name('profile.consultant');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
