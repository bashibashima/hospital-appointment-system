<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Doctor Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Upcoming Appointments</h3>

                @if ($appointments->isEmpty())
                    <p class="text-gray-600">No appointments scheduled yet.</p>
                @else
                    <table class="table-auto w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">Patient</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Time</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $appointment->patient->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}</td>
                                    
<td class="px-4 py-2">
    {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}


                                    <td class="px-4 py-2 capitalize">{{ $appointment->status }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex flex-wrap gap-2">
                                            @if($appointment->status === 'pending')
                                
                                                <form action="{{ route('doctor.appointments.reject', $appointment->id) }}" method="POST">
                                                    @csrf
                                                    <button class="text-red-600 hover:underline">Reject</button>
                                                </form>
                                            @endif

                                            <form action="{{ route('doctor.appointments.reschedule', $appointment->id) }}" method="POST" class="flex gap-2">
                                                @csrf
                                                <input type="date" name="date" required class="border rounded px-1 py-0.5 text-sm">
                                                <input type="time" name="time" required class="border rounded px-1 py-0.5 text-sm">
                                                <button class="text-blue-600 hover:underline">Reschedule</button>
                                            </form>
                                        </div>
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
