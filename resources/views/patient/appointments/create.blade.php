<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Book Appointment
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                @if (session('success'))
                    <div class="mb-4 text-green-600 font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('patient.appointments.store') }}">
                    @csrf

                    <!-- Doctor -->
                    <div class="mb-4">
                        <x-input-label for="doctor_id" :value="'Select Doctor'" />
                        <select id="doctor_id" name="doctor_id" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Choose Doctor --</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Appointment Date -->
                    <div class="mb-4">
                        <x-input-label for="appointment_date" :value="'Appointment Date'" />
                        <x-text-input type="date" name="appointment_date" id="appointment_date" required class="block mt-1 w-full" />
                    </div>

                    <!-- Appointment Time -->
                    <div class="mb-4">
                        <x-input-label for="appointment_time" :value="'Appointment Time'" />
                        <x-text-input type="time" name="appointment_time" id="appointment_time" required class="block mt-1 w-full" />
                    </div>

                    <!-- Notes -->
                    <div class="mb-4">
                        <x-input-label for="notes" :value="'Notes (Optional)'" />
                        <textarea name="notes" id="notes" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                    </div>

                    <x-primary-button class="mt-4">
                        Book Appointment
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
