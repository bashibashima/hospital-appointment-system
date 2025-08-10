<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Doctor Availability
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($availabilities->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded mb-4">
                    No availability set by admin for you yet.
                </div>
            @else
                <!-- Top Slot Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-800">
                        <div>
                            <span class="font-semibold">Day:</span>
                            {{ \Carbon\Carbon::parse($availabilities->first()->day_of_week)->format('l') }}
                        </div>
                        <div>
                            <span class="font-semibold">Time Slot:</span>
                            {{ $availabilities->first()->time_slot }}
                        </div>
                        <div>
                            <span class="font-semibold">Duration:</span>
                            {{ $availabilities->first()->duration ?? '15 minutes' }}
                        </div>
                    </div>
                </div>

                <!-- Availability Table -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-4">Remaining Slots</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 border">#</th>
                                        <th class="px-4 py-2 border">Day</th>
                                        <th class="px-4 py-2 border">Time Slot</th>
                                        <th class="px-4 py-2 border">Duration</th>
                                        <th class="px-4 py-2 border">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm text-gray-800">
                                    @foreach ($availabilities as $index => $slot)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($slot->day_of_week)->format('l') }}</td>
                                            <td class="px-4 py-2 border">{{ $slot->time_slot }}</td>
                                            <td class="px-4 py-2 border">{{ $slot->duration ?? '15 minutes' }}</td>
                                            <td class="px-4 py-2 border">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Available
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
