@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">My Appointments</h1>

    @if($appointments->isEmpty())
        <p class="text-gray-600">You have no appointments yet.</p>
    @else
        <table class="w-full bg-white rounded shadow">
            <thead class="bg-blue-100">
                <tr>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Time</th>
                    <th class="p-3 text-left">Doctor</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr class="border-b">
                    <td class="p-3">{{ $appointment->date }}</td>
                    <td class="p-3">{{ $appointment->time }}</td>
                    <td class="p-3">{{ $appointment->doctor->name ?? 'N/A' }}</td>
                    <td class="p-3">{{ ucfirst($appointment->status) }}</td>
                    <td class="p-3">{{ $appointment->notes }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
