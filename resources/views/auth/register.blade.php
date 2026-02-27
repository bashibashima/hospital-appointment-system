<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">

        <!-- Header -->
        <div class="text-center mb-6">
            
<div class="flex justify-center mb-3">
    <svg xmlns="http://www.w3.org/2000/svg"
        class="w-14 h-14 text-blue-600"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M12 4v16m8-8H4m2-6h4v4H6V6zm8 0h4v4h-4V6zM6 14h4v4H6v-4zm8 0h4v4h-4v-4z" />
    </svg>
</div


            <h2 class="text-2xl font-bold text-blue-700">Patient Registration</h2>
            <p class="text-sm text-gray-500">
                Create your account to book appointments
            </p>
        </div>

        <!-- Form -->
        <form>
            <!-- Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Full Name
                </label>
                <input type="text"
                    placeholder="Enter your full name"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Email Address
                </label>
                <input type="email"
                    placeholder="example@email.com"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Phone Number
                </label>
                <input type="text"
                    placeholder="Enter phone number"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input type="password"
                    placeholder="Create a password"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">
                    Confirm Password
                </label>
                <input type="password"
                    placeholder="Confirm your password"
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Register Button -->
            <button
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                Register
            </button>
        </form>

        <!-- Footer -->
        <p class="text-sm text-center text-gray-600 mt-4">
            Already registered?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                Login here
            </a>
        </p>

        <div class="mt-6 text-xs text-center text-gray-400">
            Secure • Trusted Hospital Appointment System
        </div>

    </div>

</body>
</html>