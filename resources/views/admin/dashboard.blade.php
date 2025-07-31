<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <x-dashboard-card title="Users" :count="$totalUsers" />
            <x-dashboard-card title="Doctors" :count="$totalDoctors" />
            <x-dashboard-card title="Patients" :count="$totalPatients" />
            <x-dashboard-card title="Appointments" :count="$totalAppointments" />
        </div>

        {{-- Pending Doctor Approvals --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Pending Doctor Approvals</h3>
            @if($pendingDoctors->isEmpty())
                <p class="text-gray-600">No pending approvals.</p>
            @else
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-2">Name</th>
                            <th class="text-left p-2">Email</th>
                            <th class="text-left p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingDoctors as $doctor)
                            <tr class="border-t">
                                <td class="p-2">{{ $doctor->name }}</td>
                                <td class="p-2">{{ $doctor->email }}</td>
                                <td class="p-2">
                                    <form method="POST" action="{{ route('admin.approve.doctor', $doctor->id) }}">
                                        @csrf
                                        <x-primary-button>Approve</x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Doctor Availability: Manage Time Slots --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Doctor Availability</h3>
            @if($doctors->isEmpty())
                <p class="text-gray-600">No approved doctors available.</p>
            @else
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-2">Name</th>
                            <th class="text-left p-2">Email</th>
                            <th class="text-left p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doc)
                            <tr class="border-t">
                                <td class="p-2">{{ $doc->user->name }}</td>
                                <td class="p-2">{{ $doc->user->email }}</td>
                                <td class="p-2">
                                    <a href="{{ route('admin.doctor.edit', $doc->id) }}"
                                       class="text-blue-600 hover:underline">Edit Permission</a>
                                    @if($doc->can_manage_slots)
                                        <span class="mx-2">|</span>
                                        <a href="{{ route('admin.doctor.slots', $doc->id) }}"
                                           class="text-green-600 hover:underline">Manage Time Slots</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Pending Appointments --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4">Pending Appointments</h3>
            @if($pendingAppointments->isEmpty())
                <p class="text-gray-600">No pending appointments.</p>
            @else
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left p-2">Patient</th>
                            <th class="text-left p-2">Doctor</th>
                            <th class="text-left p-2">Date</th>
                            <th class="text-left p-2">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingAppointments as $appointment)
                            <tr class="border-t">
                                <td class="p-2">{{ $appointment->patient->name }}</td>
                                <td class="p-2">{{ $appointment->doctor->name }}</td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
