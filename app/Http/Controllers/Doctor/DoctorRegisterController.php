<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorRegisterController extends Controller
{
    public function create()
    {
        return view('auth.doctor-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // ✅ Create doctor with correct role and pending status
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
            'status' => 'pending', // to be approved by admin
        ]);

        // ✅ Redirect with flash message
        return redirect()->route('login')->with('message', 'Doctor registration successful. Please wait for admin approval.');
    }
}
