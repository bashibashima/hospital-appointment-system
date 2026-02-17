<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Auth & Profile Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;

/*
|--------------------------------------------------------------------------
| Doctor Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Doctor\DoctorRegisterController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;

/*
|--------------------------------------------------------------------------
| Patient Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

/*
|--------------------------------------------------------------------------
| Doctor Registration (Public)
|--------------------------------------------------------------------------
*/
Route::get('/doctor/register', [DoctorRegisterController::class, 'create'])->name('doctor.register');
Route::post('/doctor/register', [DoctorRegisterController::class, 'store'])->name('doctor.register.submit');

/*
|--------------------------------------------------------------------------
| Unified Dashboard Redirect
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // User & Doctor Management
        Route::get('/users', [UserManagementController::class, 'index'])->name('users');
        Route::post('/users/{id}/update-role', [UserManagementController::class, 'updateRole'])
            ->name('users.update-role');

        Route::get('/doctors/pending', [AdminController::class, 'showPendingDoctors'])
            ->name('pending.doctors');
        Route::post('/doctors/approve/{id}', [AdminController::class, 'approveDoctor'])
            ->name('approve.doctor');

        // Admin can only VIEW appointments (no slot management)
        Route::get('/appointments', [AdminAppointmentController::class, 'index'])
            ->name('appointments');
    });

/*
|--------------------------------------------------------------------------
| Doctor Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_doctor'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {

        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])
            ->name('dashboard');

        // Appointment actions
        Route::post('/appointments/{id}/accept',
            [DoctorAppointmentController::class, 'accept']
        )->name('appointments.accept');

        Route::post('/appointments/{id}/reject',
            [DoctorAppointmentController::class, 'reject']
        )->name('appointments.reject');

        Route::post('/appointments/{id}/reschedule',
            [DoctorAppointmentController::class, 'reschedule']
        )->name('appointments.reschedule');

        Route::post('/appointments/{id}/update',
            [DoctorAppointmentController::class, 'updateDoctorData']
        )->name('appointments.update');

        // Patient history
        Route::get('/patient/{id}/history',
            [DoctorDashboardController::class, 'patientHistory']
        )->name('patient.history');
    });

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_patient'])
    ->prefix('patient')
    ->name('patient.')
    ->group(function () {

        Route::get('/dashboard', [PatientDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/appointments', [PatientAppointmentController::class, 'index'])
            ->name('appointments');

        Route::get('/appointments/create', [PatientAppointmentController::class, 'create'])
            ->name('appointments.create');

        Route::post('/appointments/book', [PatientAppointmentController::class, 'book'])
            ->name('appointments.book');

        // Automatic slot fetch (NO availability table)
        Route::get('/available-slots',
            [PatientAppointmentController::class, 'getAvailableSlots']
        )->name('get.available.slots');
    });

/*
|--------------------------------------------------------------------------
| Test Email
|--------------------------------------------------------------------------
*/
Route::get('/test-email', function () {
    Mail::raw(
        "Dear Doctor,\n\nYour account has been approved by admin.\n\nRegards,\nHospital Appointment System",
        function ($message) {
            $message->to('bashibashima@gmail.com')
                    ->subject('Doctor Account Approved');
        }
    );

    return '✅ Test email sent';
});

require __DIR__ . '/auth.php';
