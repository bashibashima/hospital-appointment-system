<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\SmsService; // ✅ import SmsService

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, SmsService $smsService): RedirectResponse
    {
        // 1️⃣ Validate input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'regex:/^(\+?\d{10,15})$/'], // +91 or international format
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2️⃣ Format phone (convert ordinary number to +91 format)
        $phone = ltrim($request->phone, '0'); // remove leading zero
        if (!str_starts_with($phone, '+')) {
            $phone = '+91' . $phone; // assume Indian number
        }

        // 3️⃣ Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $phone,
            'password' => Hash::make($request->password),
            'role'     => 'patient', // optional if using roles
        ]);

        // 4️⃣ Fire registered event
        event(new Registered($user));

        // 5️⃣ Send SMS
        try {
            $smsService->sendSms(
                $user->phone,
                "Hello {$user->name}, your account has been successfully created in Hospital Appointment System!"
            );
        } catch (\Exception $e) {
            \Log::error("Twilio SMS failed for user {$user->id}: " . $e->getMessage());
        }

        // 6️⃣ Login user
        Auth::login($user);

        // 7️⃣ Redirect to patient dashboard (or home)
        return redirect()->route('patient.dashboard')->with('success', 'Registration successful and SMS sent!');
    }
}
