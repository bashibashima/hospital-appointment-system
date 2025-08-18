<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Book Appointment
        </h2>
    </x-slot>

    <script>
    function fetchAvailableSlots() {
        const doctorId = document.getElementById('doctor_id').value;
        const date = document.getElementById('appointment_date').value;

        if (doctorId && date) {
            fetch(`{{ route('patient.get.available.slots') }}?doctor_id=${doctorId}&appointment_date=${date}`)
                .then(res => res.json())
                .then(data => {
                    const timeSelect = document.getElementById('appointment_time');
                    timeSelect.innerHTML = '';

                
                    if (!data.slots || data.slots.length === 0) {
    timeSelect.innerHTML = '<option value="" disabled selected>No available slots</option>';
    return;
}



                    data.slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot.start; // Stored in DB
                        option.text = `${slot.start_display} - ${slot.end_display}`;
                        timeSelect.appendChild(option);
                    });
                })
                .catch(err => {
                    console.error("Error fetching slots:", err);
                });
        }
    }
    </script>

    <div class="p-6">
        <form method="POST" action="{{ route('patient.appointments.book') }}" class="max-w-lg mx-auto bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="block font-medium">Doctor</label>
                <select name="doctor_id" id="doctor_id" onchange="fetchAvailableSlots()" class="w-full border rounded p-2" required>
                    <option value="">-- Select Doctor --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">
                            {{ $doctor->name }}
                            @if($doctor->doctor && $doctor->doctor->specialization)
                                - {{ $doctor->doctor->specialization->name }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Date</label>
                <input type="date" name="appointment_date" id="appointment_date" onchange="fetchAvailableSlots()" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Time Slot</label>
                <select name="appointment_time" id="appointment_time" class="w-full border rounded p-2" required>
                    <option value="">Select time slot</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Notes</label>
                <textarea name="notes" class="w-full border rounded p-2"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Book Appointment</button>
        </form>
    </div>
</x-app-layout>
