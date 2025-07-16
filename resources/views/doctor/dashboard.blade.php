@extends('layouts.app')
@section('content')
<div class="p-6 text-center">
    <h1 class="text-2xl font-bold text-blue-700">Welcome, Doctor!</h1>
    <p class="mt-2 text-gray-600">Here you can manage patients, appointments.</p>
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Doctor Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <h2 class="text-xl font-bold mb-4">Your Appointments</h2>

                @if($appointments->isEmpty())
                    <p>No appointments booked yet.</p>
                @else
                    <ul class="list-disc pl-5 space-y-2">
                        @foreach($appointments as $appointment)
                            <li>
                                {{ $appointment->patient->name }} – 
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>







@endsection
