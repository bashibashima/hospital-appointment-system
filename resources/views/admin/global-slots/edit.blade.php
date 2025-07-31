<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Manage Global Time Slots</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.global-slots.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Start Time:</label>
                <input type="time" name="start_time" value="{{ $slot->start_time ?? '' }}" class="border rounded p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">End Time:</label>
                <input type="time" name="end_time" value="{{ $slot->end_time ?? '' }}" class="border rounded p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Slot Duration (minutes):</label>
                <input type="number" name="slot_duration" value="{{ $slot->slot_duration ?? 15 }}" class="border rounded p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Days:</label>
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <label class="inline-block mr-4">
                        <input type="checkbox" name="days[]" value="{{ $day }}"
                            {{ in_array($day, json_decode($slot->days ?? '[]')) ? 'checked' : '' }}>
                        {{ $day }}
                    </label>
                @endforeach
            </div>

            <x-primary-button>Save Settings</x-primary-button>
        </form>
    </div>
</x-app-layout>
