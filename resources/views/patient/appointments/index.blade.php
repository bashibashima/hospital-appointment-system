<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Appointments
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($appointments->isEmpty())
                    <p class="text-gray-600">You have no appointments yet.</p>
                @else
                    <table class="table-auto w-full text-left">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Doctor</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Time</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                       <tbody>
@foreach ($appointments as $appointment)
    <tr>
        <td class="border px-4 py-2">
            {{ $appointment->doctor->name ?? 'N/A' }}
        </td>

        <td class="border px-4 py-2">
            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
        </td>

        <td class="border px-4 py-2">
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $appointment->appointment_time)->format('h:i A') }}
        </td>

        <td class="border px-4 py-2 capitalize">
            {{ $appointment->status }}
        </td>
    </tr>
@endforeach
</tbody>

                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
