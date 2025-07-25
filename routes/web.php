<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;

use App\Http\Controllers\Admin\UserManagementController;

use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Doctor\DoctorRegisterController;
use App\Http\Controllers\Patient\PatientDashboardController;


//Home Page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::get('/doctor/register', [DoctorRegisterController::class, 'create'])->name('doctor.register');

//Common redirect route after login




// Only check status if user is a doctor
Route::get('/redirect', function () {
    $user = auth()->user();

    if ($user->role === 'doctor' && $user->status !== 'approved') {
        Auth::logout();
        return redirect('/login')->withErrors([
            'email' => 'Your account is pending approval by admin.',
        ]);
    }

    return match($user->role) {
        'admin' => redirect('/admin/dashboard'),
        'doctor' => redirect('/doctor/dashboard'),
        'patient' => redirect('/patient/dashboard'),
        default => abort(403)
    };
})->middleware('auth');



//Authenticated user's profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Laravel Breeze auth routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
     Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::post('/users/{id}/update-role', [UserManagementController::class, 'updateRole'])->name('admin.users.update-role');
});







// ====================================
// Admin Routes
// ====================================


Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // User management
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::post('/users/{id}/update-role', [UserManagementController::class, 'updateRole'])->name('admin.users.update-role');

    // Doctor approval
    Route::get('/doctors/pending', [AdminCocntroller::class, 'showPendingDoctors'])->name('admin.pending.doctors');
    Route::post('/doctors/approve/{id}', [AdminController::class, 'approveDoctor'])->name('admin.approve.doctor');
    
    Route::get('/admin/doctors/{id}', [AdminController::class, 'viewDoctor'])->name('admin.doctor.view');

});




// ==========================
// 👨‍⚕️ Doctor Routes
// ==========================

Route::middleware(['auth', 'isdoctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
});


Route::get('/doctor/register', [DoctorRegisterController::class, 'create'])->name('doctor.register');
Route::post('/doctor/register', [DoctorRegisterController::class, 'store'])->name('doctor.register.submit');



Route::middleware(['auth', 'is_doctor'])->prefix('doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');

Route::post('/appointments/{id}/accept', [DoctorController::class, 'acceptAppointment'])->name('doctor.appointments.accept');
Route::post('/appointments/{id}/reject', [DoctorController::class, 'rejectAppointment'])->name('doctor.appointments.reject');
Route::post('/appointments/{id}/reschedule', [DoctorController::class, 'rescheduleAppointment'])->name('doctor.appointments.reschedule');

   



    // Add doctor-specific routes here
});

Route::get('/test-email', function () {
    Mail::raw("Dear Doctor,\n\nYour account has been approved by the administrator.\n\nYou can now log in to the Hospital Appointment System and start managing your profile and appointments.\n\nRegards,\nHospital Appointment System", function ($message) {
        $message->to('bashibashima@gmail.com')
                ->subject('Your Doctor Account Has Been Approved');
    });

    return '✅ Approval email sent to doctor!';
});

// ==========================
// 🧑‍⚕️ Patient Routes
// ==========================
Route::middleware(['auth', 'is_patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('patient.appointments');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('patient.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('patient.appointments.store');
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); // ✅ name is 'dashboard'

require __DIR__.'/auth.php';

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');


Route::middleware(['auth', 'is_patient'])->prefix('patient')->group(function () {
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('patient.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('patient.appointments.store');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('patient.appointments');
});




// Route::middleware(['auth'])->group(function () {

//     Route::middleware('is_admin')->group(function () {
//         Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
//     });

//     Route::middleware('is_doctor')->group(function () {
//         Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor.dashboard');
//     });

//     Route::middleware('is_patient')->group(function () {
//         Route::get('/patient', [PatientController::class, 'index'])->name('patient.dashboard');
//     });

// });



// Route::middleware(['auth', 'role:patient'])->group(function () {

//     Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
//     Route::get('/patient/appointments', [AppointmentController::class, 'index'])->name('patient.appointments');
//     Route::get('/patient/appointments/create', [AppointmentController::class, 'create'])->name('patient.appointments.create');
//     Route::post('/patient/appointments', [AppointmentController::class, 'store'])->name('patient.appointments.store');
// });




// used for doctor approvel by admin
// Route::middleware(['auth', 'is_admin'])->group(function () {
//     Route::get('/admin/doctors/pending', [AdminController::class, 'showPendingDoctors'])->name('admin.pending.doctors');
//     Route::post('/admin/doctors/approve/{id}', [AdminController::class, 'approveDoctor'])->name('admin.approve.doctor');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
