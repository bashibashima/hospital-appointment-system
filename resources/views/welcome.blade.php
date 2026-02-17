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
    
        <header class="bg-blue-100 shadow p-4">

        <div class="container mx-auto flex justify-between items-center">
            
                

               <h1 class="text-xl font-extrabold text-blue-900 flex items-center gap-2">
    <span>🏥</span> Hospital Appointment System
</h1>

            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
                <a href="{{ route('doctor.register') }}" class="text-blue-600 hover:underline">Doctor Sign Up</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">

        <!-- Hero Section -->
    
  
<section
  class="relative min-h-screen bg-no-repeat bg-cover bg-center flex items-center"
  style="background-image: url('{{ url('images/online_book.jpg') }}');"
>

    <!-- Overlay -->
    
<div class="absolute inset-0 bg-white/70"></div>

    <!-- Content -->
    <div class="relative container mx-auto px-6 py-24 grid grid-cols-1 md:grid-cols-2 items-center">

        <!-- Text -->
        <div>
            <h2 class="text-4xl md:text-5xl font-bold text-blue-800 mb-6">
                Book Your Appointment Easily
            </h2>

            <p class="text-gray-700 mb-8 text-lg">
                Conveniently book appointments online for a hassle-free experience.
                Patients can book appointments, doctors can manage schedules,
                and admins can monitor everything smoothly.
            </p>

            <a href="{{ route('register') }}"
               class="inline-block bg-blue-600 text-white px-8 py-4 rounded-lg hover:bg-blue-700 transition">
                Get Started
            </a>
        </div>

    </div>
</section>

        <!-- Features Section -->
        <section class="bg-blue-50 py-14">
            <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-4xl mb-4">🧑‍⚕️</div>
                    <h4 class="text-xl font-semibold text-blue-700 mb-2">
                        Expert Doctors
                    </h4>
                    <p class="text-gray-600">
                        Connect with verified doctors across multiple specialties.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-4xl mb-4">📅</div>
                    <h4 class="text-xl font-semibold text-blue-700 mb-2">
                        Easy Scheduling
                    </h4>
                    <p class="text-gray-600">
                        Book and manage appointments in just a few clicks.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <div class="text-4xl mb-4">🛡️</div>
                    <h4 class="text-xl font-semibold text-blue-700 mb-2">
                        Admin Control
                    </h4>
                    <p class="text-gray-600">
                        Full control over doctors, patients, and schedules.
                    </p>
                </div>

            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-sm text-gray-500 py-6">
        © {{ date('Y') }} Hospital Appointment System. All rights reserved.
    </footer>

</body>

</html>