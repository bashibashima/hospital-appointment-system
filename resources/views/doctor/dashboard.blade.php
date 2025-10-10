
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Doctor Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800 border border-red-300">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


<!-- Stats Summary in Small Square Boxes -->
<div class="flex flex-wrap justify-center gap-4 mb-6">
    <div class="w-32 h-32 bg-blue-100 border border-blue-300 rounded-2xl shadow flex flex-col justify-center items-center">
        <h3 class="text-xs font-semibold text-blue-700 uppercase">Total</h3>
        <p class="text-2xl font-bold text-blue-900 mt-1">{{ $totalAppointments }}</p>
    </div>

    <div class="w-32 h-32 bg-yellow-100 border border-yellow-300 rounded-2xl shadow flex flex-col justify-center items-center">
        <h3 class="text-xs font-semibold text-yellow-700 uppercase">Pending</h3>
        <p class="text-2xl font-bold text-yellow-900 mt-1">{{ $pendingAppointments }}</p>
    </div>

    <div class="w-32 h-32 bg-green-100 border border-green-300 rounded-2xl shadow flex flex-col justify-center items-center">
        <h3 class="text-xs font-semibold text-green-700 uppercase">Accepted</h3>
        <p class="text-2xl font-bold text-green-900 mt-1">{{ $acceptedAppointments }}</p>
    </div>
</div>







            <!-- Today's Appointments -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold mb-3">Today's Appointments</h3>
                <table class="min-w-full bg-white border rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-700">
                            <th class="py-2 px-4 border">Patient</th>
                            <th class="py-2 px-4 border">Time</th>
                            <th class="py-2 px-4 border">Status</th>
                            <th class="py-2 px-4 border text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todaysAppointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border">{{ $appointment->patient->name }}</td>
                                <td class="py-2 px-4 border">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>
                                <td class="py-2 px-4 border capitalize">{{ $appointment->status }}</td>
                                <td class="py-2 px-4 border text-center">
                                    <a href="{{ route('doctor.patient.history', $appointment->patient->id) }}" 
                                       class="text-blue-600 hover:underline">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 px-4 text-center text-gray-500">
                                    No appointments today.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Latest Appointments -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold mb-3">Latest Appointments</h3>
                <table class="min-w-full bg-white border rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-700">
                            <th class="py-2 px-4 border">Patient</th>
                            <th class="py-2 px-4 border">Date</th>
                            <th class="py-2 px-4 border">Time</th>
                            <th class="py-2 px-4 border">Status</th>
                            <th class="py-2 px-4 border text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestAppointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border">{{ $appointment->patient->name }}</td>
                                <td class="py-2 px-4 border">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                                </td>
                                <td class="py-2 px-4 border">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>
                                <td class="py-2 px-4 border capitalize">{{ $appointment->status }}</td>
                                <td class="py-2 px-4 border text-center">
                                    <a href="{{ route('doctor.patient.history', $appointment->patient->id) }}" 
                                       class="text-blue-600 hover:underline">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-3 px-4 text-center text-gray-500">
                                    No recent appointments.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Past Appointments -->
            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-3">Past Appointments</h3>
                <table class="min-w-full bg-white border rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-700">
                            <th class="py-2 px-4 border">Patient</th>
                            <th class="py-2 px-4 border">Date</th>
                            <th class="py-2 px-4 border">Time</th>
                            <th class="py-2 px-4 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pastAppointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border">{{ $appointment->patient->name }}</td>
                                <td class="py-2 px-4 border">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                                </td>
                                <td class="py-2 px-4 border">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>
                                <td class="py-2 px-4 border capitalize">{{ $appointment->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 px-4 text-center text-gray-500">
                                    No past appointments.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
