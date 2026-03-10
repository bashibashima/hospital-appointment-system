<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Patient Dashboard</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        {{-- Greeting --}}
        <h2 class="text-lg font-semibold mb-4">Welcome, {{ $user->name }} 👋</h2>

        {{-- Upcoming Appointments --}}
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <h3 class="text-md font-bold mb-2">📅 Upcoming Appointments</h3>

            @if($appointments->count())
                <ul class="divide-y divide-gray-200">
                    @foreach($appointments as $appt)
                        <li class="py-2 flex justify-between items-center">
                            <div>
                                {{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}
                                at {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A')}}
                                with Dr. {{ $appt->doctor?->name ?? 'Unknown' }}
                            </div>
                            <span class="text-sm px-2 py-1 bg-green-100 text-green-800 rounded">
                                {{ ucfirst($appt->status) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">
                    No upcoming appointments.
                    <a href="{{ route('patient.appointments.create') }}" class="text-blue-600 underline">Book one now</a>.
                </p>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="mb-6 flex flex-wrap gap-4">
            <a href=""
               class="bg-blue-100 hover:bg-blue-200 text-black px-5 py-2 rounded-md text-sm shadow font-medium">
                📋 View All Appointments
            </a>

            <a href="{{ route('patient.appointments.create') }}"
               class="bg-green-100 hover:bg-green-200 text-black px-5 py-2 rounded-md text-sm shadow font-medium">
                ➕ Book New Appointment
            </a>
        </div>

        {{-- Booked Doctors --}}
        <div class="bg-white shadow rounded-lg p-4">
            <h3 class="text-md font-bold mb-2">🩺 Your Booked Doctors</h3>

            @if($appointments->isEmpty())
                <p class="text-gray-600">You have not booked any doctors yet.</p>
            @else
                <ul class="list-disc list-inside space-y-1">
                    @foreach($appointments as $appointment)
                        <li>
                            Dr. {{ $appointment->doctor?->name ?? 'Unknown' }}
                            @if($appointment->appointment_date)
                                – on {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
