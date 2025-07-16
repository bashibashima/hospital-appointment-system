<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Patient Dashboard</h2>
    </x-slot>

    <div class="container">
        <h2>Welcome, {{ $user->name }} 👋</h2>

        <div class="card my-3">
            <div class="card-header">Upcoming Appointments</div>
            <div class="card-body">
                @if($appointments->count())
                    <ul class="list-group">
                        @foreach($appointments as $appt)
                            <li class="list-group-item d-flex justify-content-between">
                                {{ $appt->appointment_date }} at {{ $appt->appointment_time }}
                                with Dr. {{ $appt->doctor->name }}
                                <span class="badge bg-success">{{ $appt->status }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No upcoming appointments. <a href="{{ route('patient.appointments.create') }}">Book one now</a>.</p>
                @endif
            </div>
        </div>

        <div class="my-3">
            <a href="{{ route('patient.appointments') }}" class="btn btn-primary">View All Appointments</a>
            <a href="{{ route('patient.appointments.create') }}" class="btn btn-success">Book New Appointment</a>
        </div>

        <h2 class="text-xl font-bold mb-4">Your Booked Doctors</h2>

        @if($appointments->isEmpty())
            <p>You have not booked any doctors yet.</p>
        @else
            <ul class="list-disc pl-5 space-y-2">
                @foreach($appointments as $appointment)
                    <li>
                        Dr. {{ $appointment->doctor->name }}
                        @if($appointment->appointment_date)
                            – on {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
