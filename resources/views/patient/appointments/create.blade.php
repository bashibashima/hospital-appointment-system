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
            fetch(`/patient/get-available-slots?doctor_id=${doctorId}&appointment_date=${date}`)
                .then(res => res.json())
                .then(data => {
                    const timeSelect = document.getElementById('appointment_time');
                    timeSelect.innerHTML = '';

                    if (data.length === 0) {
                        timeSelect.innerHTML = '<option>No available slots</option>';
                        return;
                    }

                    data.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot.start;
                        option.text = `${slot.start} - ${slot.end}`;
                        timeSelect.appendChild(option);
                    });
                });
        }
    }
</script>

<form method="POST" action="{{ route('appointments.book') }}">
    @csrf

    <div class="mb-4">
        <label>Doctor</label>
        <select name="doctor_id" id="doctor_id" onchange="fetchAvailableSlots()" class="w-full border rounded p-2" required>
            <option value="">-- Select Doctor --</option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Date</label>
        <input type="date" name="appointment_date" id="appointment_date" onchange="fetchAvailableSlots()" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4">
        <label>Time Slot</label>
        <select name="appointment_time" id="appointment_time" class="w-full border rounded p-2" required>
            <option value="">Select date and doctor first</option>
        </select>
    </div>

    <div class="mb-4">
        <label>Notes</label>
        <textarea name="notes" class="w-full border rounded p-2"></textarea>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Book Appointment</button>
</form>
