<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// Auth & Profile Controllers
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\GlobalSlotController;

// Doctor Controllers
use App\Http\Controllers\Doctor\DoctorRegisterController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\AvailabilityController;

// Patient Controllers
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\AppointmentController;

// Appointment Controllers (Aliased for clarity)
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;

// ==========================
// Public Routes
// ==========================
Route::get('/', fn () => view('welcome'));
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

Route::get('/doctor/register', [DoctorRegisterController::class, 'create'])->name('doctor.register');
Route::post('/doctor/register', [DoctorRegisterController::class, 'store'])->name('doctor.register.submit');

// ==========================
// Unified Dashboard Redirect
// ==========================
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'doctor' && $user->status !== 'approved') {
        Auth::logout();
        return redirect('/login')->withErrors([
            'email' => 'Your account is pending approval by admin.',
        ]);
    }

    return match ($user->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'doctor'  => redirect()->route('doctor.dashboard'),
        'patient' => redirect()->route('patient.dashboard'),
        default   => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================
// Profile Routes
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================
// Admin Routes
// ==========================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users');
    Route::post('/users/{id}/update-role', [UserManagementController::class, 'updateRole'])->name('users.update-role');

    // Doctor Management
    Route::get('/doctors/pending', [AdminController::class, 'showPendingDoctors'])->name('pending.doctors');
    Route::post('/doctors/approve/{id}', [AdminController::class, 'approveDoctor'])->name('approve.doctor');
    Route::get('/doctors/{id}/view', [AdminController::class, 'viewDoctor'])->name('doctor.view');
    Route::get('/doctors/{id}/edit', [AdminController::class, 'editDoctor'])->name('doctor.edit');
    Route::put('/doctors/{id}', [AdminController::class, 'updateDoctor'])->name('doctor.update');

    // Doctor Slot Management
    Route::get('/doctors/{doctor}/slots', [TimeSlotController::class, 'index'])->name('doctor.slots');

    // Availability Management
    Route::get('/doctors', [TimeSlotController::class, 'doctors'])->name('doctors.list');
    Route::get('/doctors/{doctor}/availabilities', [TimeSlotController::class, 'index'])->name('availabilities.index');
    Route::post('/doctors/{doctor}/availabilities', [TimeSlotController::class, 'store'])->name('availabilities.store');
    Route::delete('/availabilities/{id}', [TimeSlotController::class, 'destroy'])->name('availabilities.destroy');

    // Global Time Slot Settings
    Route::get('/global-slots', [GlobalSlotController::class, 'edit'])->name('global-slots.edit');
    Route::put('/global-slots', [GlobalSlotController::class, 'update'])->name('global-slots.update');
});

// ==========================
// Doctor Routes
// ==========================

Route::middleware(['auth', 'is_doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

    // Availability
    Route::get('/availability', [AvailabilityController::class, 'index'])->name('availability');
    Route::delete('/availability/{id}', [AvailabilityController::class, 'destroy'])->name('availability.delete');

    // Appointment Actions
    Route::post('/appointments/{id}/accept', [DoctorAppointmentController::class, 'accept'])->name('appointments.accept');
    Route::post('/appointments/{id}/reject', [DoctorAppointmentController::class, 'reject'])->name('appointments.reject');
    Route::post('/appointments/{id}/reschedule', [DoctorAppointmentController::class, 'reschedule'])->name('appointments.reschedule');
});

// ==========================
// Patient Routes
// ==========================

Route::middleware(['auth', 'is_patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');

    Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('appointments');
    Route::get('/appointments/create', [PatientAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/book', [PatientAppointmentController::class, 'book'])->name('appointments.book');

    Route::get('/available-slots', [PatientAppointmentController::class, 'showAvailableSlots'])->name('available.slots');
    Route::get('/get-available-slots', [PatientAppointmentController::class, 'getAvailableSlots'])->name('get.available.slots');
});

// ==========================
// Miscellaneous Routes
// ==========================

// Test Email
Route::get('/test-email', function () {
    Mail::raw("Dear Doctor,\n\nYour account has been approved by the administrator.\n\nRegards,\nHospital Appointment System", function ($message) {
        $message->to('bashibashima@gmail.com')->subject('Your Doctor Account Has Been Approved');
    });

    return '✅ Approval email sent to doctor!';
});

require __DIR__.'/auth.php';
