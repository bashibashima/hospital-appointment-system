<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Doctors
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Specialization</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $doctor->user->name }}</td>
                            <td class="px-4 py-2">{{ $doctor->user->email }}</td>
                            <td class="px-4 py-2">{{ $doctor->specialization->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.doctor.edit', $doctor->id) }}"
                                   class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                    Edit
                                </a>
                                <a href="{{ route('admin.doctors.slots', $doctor->id) }}"
                                   class="inline-block bg-black text-white px-3 py-1 rounded hover:bg-gray-800 text-sm">
                                    Manage Time Slots
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">No doctors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
