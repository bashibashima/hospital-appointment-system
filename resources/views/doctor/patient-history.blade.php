<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Patient History - {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="p-6">
        @if($appointments->isEmpty())
            <p>No history found for this patient.</p>
        @else
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Date</th>
                        <th class="border p-2">Doctor</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Symptoms</th>
                        <th class="border p-2">Prescriptions</th>
                        <th class="border p-2">Patient Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td class="border p-2">{{ $appointment->appointment_date }} {{ $appointment->appointment_time }}</td>
                            <td class="border p-2">{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                            <td class="border p-2">{{ ucfirst($appointment->status) }}</td>
                            <td class="border p-2">{{ $appointment->doctor_symptoms ?? '-' }}</td>
                            <td class="border p-2">{{ $appointment->prescriptions ?? '-' }}</td>
                            <td class="border p-2">{{ $appointment->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
