<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Manage Time Slots for Dr. {{ $doctor->user->name }}</h2>
    </x-slot>

    <div class="p-4">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <!-- Add Slot Form -->
        <form method="POST" action="{{ route('admin.availabilities.store', $doctor->id) }}" class="mb-6">
            @csrf
            <div class="flex gap-4 items-center">
                <div>
                    <label>Day of Week:</label>
                    <select name="day_of_week" class="border rounded p-1">
                        @foreach ($daysOfWeek as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Time Slot:</label>
                    <input type="text" name="time_slot" placeholder="e.g., 10:00 AM - 11:00 AM" class="border rounded p-1" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Add</button>
            </div>
        </form>

        <!-- Slot List -->
        <h3 class="font-semibold mb-2">Existing Slots</h3>
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Day</th>
                    <th class="border px-4 py-2">Time Slot</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($availabilities as $availability)
                    <tr>
                        <td class="border px-4 py-2">{{ $availability->day_of_week }}</td>
                        <td class="border px-4 py-2">{{ $availability->time_slot }}</td>
                        <td class="border px-4 py-2">
                            <form method="POST" action="{{ route('admin.availabilities.destroy', $availability->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-2">No time slots found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
