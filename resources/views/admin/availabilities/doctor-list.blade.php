<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Approved Doctors
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @foreach ($doctors as $doctor)
                <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $doctor->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $doctor->email }}</p>
                        </div>
                        <a href="{{ route('admin.availabilities.index', $doctor->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent 
                                  rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                                  hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                  focus:ring-offset-2 transition ease-in-out duration-150">
                            Manage Time Slots
                        </a>
                        <a href="{{ route('admin.doctor.edit', $doctor->id) }}" class="text-blue-600 hover:underline">
    Edit Permissions
</a>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
