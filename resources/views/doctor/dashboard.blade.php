<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Doctor Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Row -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <h3 class="text-lg font-bold">Total Appointments</h3>
                    <p class="text-2xl">{{ $totalAppointments }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <h3 class="text-lg font-bold">Pending</h3>
                    <p class="text-2xl">{{ $pendingAppointments }}</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <h3 class="text-lg font-bold">Accepted</h3>
                    <p class="text-2xl">{{ $acceptedAppointments }}</p>
                </div>
            </div>

            <!-- Today's Slots -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold mb-2">Today's Slots</h3>
                @if($todaysSlots->count() > 0)
                    <ul>
                        @foreach($todaysSlots as $slot)
                            <li>{{ $slot->time_slot }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No slots available today.</p>
                @endif
            </div>

            <!-- Today's Appointments -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold mb-2">Today's Appointments</h3>
                <table class="min-w-full bg-white border rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Patient</th>
                            <th class="py-2 px-4 border">Time</th>
                            <th class="py-2 px-4 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todaysAppointments as $appointment)
                            <tr>
                                <td class="py-2 px-4 border">{{ $appointment->patient->name }}</td>
                                <td class="py-2 px-4 border">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                </td>
                                <td class="py-2 px-4 border capitalize">{{ $appointment->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-2 px-4 text-center text-gray-500">No appointments today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Latest Appointments -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold mb-2">Latest Appointments</h3>
                <table class="min-w-full bg-white border rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Patient</th>
                            <th class="py-2 px-4 border">Date</th>
                            <th class="py-2 px-4 border">Time</th>
                            <th class="py-2 px-4 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestAppointments as $appointment)
                            <tr>
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
                                <td colspan="4" class="py-2 px-4 text-center text-gray-500">No appointments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Past Appointments -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold mb-2">Past Appointments</h3>
                <table class="min-w-full bg-white border rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Patient</th>
                            <th class="py-2 px-4 border">Date</th>
                            <th class="py-2 px-4 border">Time</th>
                            <th class="py-2 px-4 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pastAppointments as $appointment)
                            <tr>
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
                                <td colspan="4" class="py-2 px-4 text-center text-gray-500">No past appointments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
