<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Doctor Permissions
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.doctor.update', $doctor->id) }}" class="bg-white shadow p-6 rounded">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Name</label>
                <input type="text" value="{{ $doctor->user->name }}" disabled class="w-full px-3 py-2 border rounded bg-gray-100" />
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Email</label>
                <input type="email" value="{{ $doctor->user->email }}" disabled class="w-full px-3 py-2 border rounded bg-gray-100" />
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="can_manage_slots" value="1"
                        {{ $doctor->can_manage_slots ? 'checked' : '' }} class="mr-2">
                    Allow this doctor to manage their own time slots
                </label>
            </div>

            <x-primary-button>Update</x-primary-button>
        </form>
    </div>
</x-app-layout>
