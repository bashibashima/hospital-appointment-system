{{-- resources/views/admin/availabilities/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Manage Availability for Dr. {{ $doctor->user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash messages --}}
            @if (session('message'))
                <div class="mb-4 text-green-600">
                    {{ session('message') }}
                </div>
            @endif

            {{-- Existing availabilities --}}
            <div class="mb-6">
                <h3 class="text-lg font-bold mb-2">Existing Availabilities</h3>
                <ul class="space-y-2">
                    @forelse ($availabilities as $slot)
                        <li class="flex justify-between items-center bg-white p-4 rounded shadow">
                            <div>
                                <strong>{{ $slot->day_of_week }}</strong>:
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                                to
<!-- {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
({{ \Carbon\Carbon::parse($slot->end_time)->diffInMinutes(\Carbon\Carbon::parse($slot->start_time)) }} mins) -->

                                {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                <span class="text-sm text-gray-600">({{ $slot->slot_duration }} mins)</span>
                            </div>

@if ($errors->has('slot_exists'))
    <div class="alert alert-warning">
        {{ $errors->first('slot_exists') }}
    </div>
@endif

                            
                            <form action="{{ route('admin.availabilities.destroy', $slot->id) }}" method="POST" onsubmit="return confirm('Delete this availability?')">
                                @csrf
                                @method('DELETE')
                                <x-primary-button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                    Delete
                                </x-primary-button>
                            </form>
                        </li>
                    @empty
                        <p class="text-gray-500">No availability set yet.</p>
                    @endforelse
                </ul>
            </div>

            {{-- Add new availability --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-bold mb-4">Add New Availability</h3>
                <form method="POST" action="{{ route('admin.availabilities.store', $doctor->id) }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Day of Week</label>
                            <select name="day_of_week" class="form-select w-full mt-1 rounded" required>
                                @foreach ($daysOfWeek as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input type="time" name="start_time" class="form-input w-full mt-1 rounded" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="time" name="end_time" class="form-input w-full mt-1 rounded" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Slot Duration (minutes)</label>
                            <input type="number" name="slot_duration" class="form-input w-full mt-1 rounded" min="5" step="5" required>
                        </div>
                    </div>

                    <x-primary-button class="mt-3">Add Availability</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
