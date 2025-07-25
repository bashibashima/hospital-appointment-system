<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Appointment System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-700">🏥 Hospital Appointment System</h1>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
                <a href="{{ route('doctor.register') }}" class="text-blue-600 hover:underline">Doctor Sign Up</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-grow flex items-center justify-center text-center px-4">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-xl w-full">
            <h2 class="text-3xl font-bold text-blue-800 mb-4">Book Your Appointment Easily</h2>
            <p class="text-gray-600 mb-6">
                Welcome! Patients can book appointments, doctors can manage schedules, and admins can monitor everything smoothly.
            </p>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Get Started</a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-sm text-gray-500 p-4">
        © {{ date('Y') }} Hospital Appointment System. All rights reserved.
    </footer>

</body>
</html>
