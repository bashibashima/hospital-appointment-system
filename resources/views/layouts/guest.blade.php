<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Hospital Appointment System') }}</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-gray-100">

<div class="min-h-screen flex flex-col items-center justify-center">

    <!-- Login Card -->
    <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-lg rounded-lg">

        <!-- Patient Icon -->
        <div class="flex justify-center mb-4">
            <i class="fa-solid fa-user-injured text-blue-600 text-4xl"></i>
        </div>

        <!-- Title -->
        <h2 class="text-center text-xl font-semibold text-gray-700">
            Patient Login
        </h2>

        <p class="text-center text-sm text-gray-500 mb-6">
            Access your appointments and records
        </p>

        <!-- Breeze Form Slot -->
        {{ $slot }}

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 mt-6">
            Secure • Trusted Hospital Appointment System
        </p>

    </div>

</div>

</body>
</html>