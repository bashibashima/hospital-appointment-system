<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\GlobalSlotController;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Doctor\DoctorRegisterController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\AvailabilityController;

use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\AppointmentController;

// ==========================
// Public Routes
// ==========================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

Route::get('/doctor/register', [DoctorRegisterController::class, 'create'])->name('doctor.register');
Route::post('/doctor/register', [DoctorRegisterController::class, 'store'])->name('doctor.register.submit');

// ==========================
// Redirect After Login
// ==========================
Route::get('/redirect', function () {
    $user = auth()->user();

    if ($user->role === 'doctor' && $user->status !== 'approved') {
        Auth::logout();
        return redirect('/login')->withErrors([
            'email' => 'Your account is pending approval by admin.',
        ]);
    }

    switch ($user->role) {
        case 'admin':
            return redirect('/admin/dashboard');
        case 'doctor':
            return redirect('/doctor/dashboard');
        case 'patient':
            return redirect('/patient/dashboard');
        default:
            abort(403);
    }
})->middleware('auth');

// ==========================
// Authenticated User Profile
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================
// Admin Routes
// ==========================
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');


        Route::get('/admin/doctors', [AdminController::class, 'index'])->name('admin.doctors.index');


        // User Management
        Route::get('/users', [UserManagementController::class, 'index'])->name('users');
        Route::post('/users/{id}/update-role', [UserManagementController::class, 'updateRole'])->name('users.update-role');

        // Doctor Approval
        Route::get('/doctors/pending', [AdminController::class, 'showPendingDoctors'])->name('pending.doctors');
        Route::post('/doctors/approve/{id}', [AdminController::class, 'approveDoctor'])->name('approve.doctor');
        Route::get('/doctors/{id}/view', [AdminController::class, 'viewDoctor'])->name('doctor.view');
        Route::get('/doctors/{doctor}/edit', [AdminController::class, 'editDoctor'])->name('doctor.edit');
        Route::put('/doctors/{doctor}', [AdminController::class, 'updateDoctor'])->name('doctor.update');

//Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Doctor approval
    //Route::post('/admin/approve-doctor/{id}', [AdminController::class, 'approveDoctor'])->name('admin.approve.doctor');

    // Edit doctor permissions
   // Route::get('/admin/doctors/{id}/edit', [AdminController::class, 'editDoctor'])->name('admin.doctor.edit');
   // Route::put('/admin/doctors/{id}', [AdminController::class, 'updateDoctor'])->name('admin.doctor.update');

    // (Optional) Manage doctor slots
    //Route::get('/admin/doctors/{id}/slots', [DoctorSlotController::class, 'index'])->name('admin.doctor.slots');




//doctor permission
        Route::get('/admin/doctors/{id}/edit', [AdminController::class, 'editDoctor'])->name('admin.doctor.edit');
        //updating
Route::put('/admin/doctors/{id}', [AdminController::class, 'updateDoctor'])->name('admin.doctor.update');
//managing time slot
Route::get('/admin/doctors/{id}/slots', [DoctorSlotController::class, 'index'])->name('admin.doctor.slots');


        // Time Slot Management
        Route::get('/doctors', [TimeSlotController::class, 'doctors'])->name('doctors.list');
        Route::get('/doctors/{doctor}/availabilities', [TimeSlotController::class, 'index'])->name('availabilities.index');
        Route::post('/doctors/{doctor}/availabilities', [TimeSlotController::class, 'store'])->name('availabilities.store');
        Route::delete('/availabilities/{id}', [TimeSlotController::class, 'destroy'])->name('availabilities.destroy');

       // Route::get('/doctors/{doctor}/slots', [TimeSlotController::class, 'adminManageSlots'])->name('doctor.slots');

        // Global Time Slot Settings
        Route::get('/global-time-slots', [GlobalSlotController::class, 'edit'])->name('global-slots.edit');
        Route::put('/global-time-slots', [GlobalSlotController::class, 'update'])->name('global-slots.update');
    });

// ==========================
// Doctor Routes
// ==========================
Route::middleware(['auth', 'is_doctor'])->prefix('doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');

    Route::get('/availability', [AvailabilityController::class, 'index'])->name('doctor.availability');
    Route::post('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
    Route::delete('/availability/{id}', [AvailabilityController::class, 'destroy'])->name('availability.delete');

    Route::post('/appointments/{id}/accept', [DoctorController::class, 'acceptAppointment'])->name('doctor.appointments.accept');
    Route::post('/appointments/{id}/reject', [DoctorController::class, 'rejectAppointment'])->name('doctor.appointments.reject');
    Route::post('/appointments/{id}/reschedule', [DoctorController::class, 'rescheduleAppointment'])->name('doctor.appointments.reschedule');
});

// ==========================
// Patient Routes
// ==========================
Route::middleware(['auth', 'is_patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

    Route::get('/available-slots', [AppointmentController::class, 'showAvailableSlots'])->name('available.slots');
    Route::get('/get-available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('get.available.slots');
});

// ==========================
// Miscellaneous
// ==========================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================
// Test Email (optional)
// ==========================
Route::get('/test-email', function () {
    Mail::raw("Dear Doctor,\n\nYour account has been approved by the administrator.\n\nYou can now log in to the Hospital Appointment System and start managing your profile and appointments.\n\nRegards,\nHospital Appointment System", function ($message) {
        $message->to('bashibashima@gmail.com')
                ->subject('Your Doctor Account Has Been Approved');
    });

    return '✅ Approval email sent to doctor!';
});

// ==========================
// Breeze Auth Routes
// ==========================
require __DIR__.'/auth.php';
