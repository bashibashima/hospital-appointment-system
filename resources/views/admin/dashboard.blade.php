<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Users</h3>
                    <p class="text-2xl">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Doctors</h3>
                    <p class="text-2xl">{{ $totalDoctors }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Patients</h3>
                    <p class="text-2xl">{{ $totalPatients }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Appointments</h3>
                    <p class="text-2xl">{{ $totalAppointments }}</p>
                </div>
            </div>

            <!-- Pending Doctor Approvals -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Pending Doctor Approvals</h3>
                @if($pendingDoctors->count())
                    <ul class="divide-y divide-gray-200">
                        @foreach($pendingDoctors as $doctor)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $doctor->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $doctor->email }}</p>
                                </div>
                                <form action="{{ route('admin.approve.doctor', $doctor->id) }}" method="POST">
                                    @csrf
                                    <x-primary-button>Approve</x-primary-button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">No pending doctors.</p>
                @endif
            </div>

            <!-- Pending Appointments -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Pending Appointments</h3>
                @if($pendingAppointments->count())
                    <ul class="divide-y divide-gray-200">
                        @foreach($pendingAppointments as $appt)
                            <li class="py-3">
                                <p>
                                    <strong>Patient:</strong> {{ $appt->patient->name ?? 'Unknown' }} <br>
                                    <strong>Doctor:</strong> {{ $appt->doctor->name ?? 'Unknown' }} <br>
                                    <strong>Date:</strong> {{ $appt->appointment_date }} {{ $appt->appointment_time }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">No pending appointments.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
