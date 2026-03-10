<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
Book Appointment
</h2>
</x-slot>

<script>
function fetchAvailableSlots(){

const doctorId=document.getElementById('doctor_id').value;
const date=document.getElementById('appointment_date').value;

if(!doctorId || !date) return;

fetch(`/patient/available-slots?doctor_id=${doctorId}&date=${date}`)
.then(res=>res.json())
.then(data=>{

const timeSelect=document.getElementById('appointment_time');
timeSelect.innerHTML='<option value="">Select time slot</option>';

if(!data.status || data.slots.length===0){

timeSelect.innerHTML='<option disabled>No available slots</option>';
return;

}

data.slots.forEach(slot=>{

if(isPastSlot(date,slot)) return;

const option=document.createElement('option');
option.value=slot;
option.text=formatTime(slot);

timeSelect.appendChild(option);

});

if(timeSelect.options.length===1){

timeSelect.innerHTML='<option disabled>No available slots</option>';

}

});

}

function formatTime(time){

const parts=time.split(':');
let hour=parseInt(parts[0]);
const minute=parts[1];

const ampm=hour>=12?'PM':'AM';
hour=hour%12 || 12;

return `${hour}:${minute} ${ampm}`;

}

function isPastSlot(date,time){

const now=new Date();

const parts=time.split(':');

const slotDateTime=new Date(date);
slotDateTime.setHours(parts[0],parts[1],0,0);

return slotDateTime<=now;

}
</script>

<div class="p-6">

<form method="POST"
action="{{ route('patient.appointments.book') }}"
class="max-w-lg mx-auto bg-white p-6 rounded shadow">

@csrf

<div class="mb-4">
<label class="block font-medium">Doctor</label>

<select name="doctor_id"
id="doctor_id"
onchange="fetchAvailableSlots()"
class="w-full border rounded p-2"
required>

<option value="">Select Doctor</option>

@foreach($doctors as $doctor)

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

<input type="date"
name="appointment_date"
id="appointment_date"
min="{{ date('Y-m-d') }}"
onchange="fetchAvailableSlots()"
class="w-full border rounded p-2"
required>

</div>

<div class="mb-4">

<label class="block font-medium">Time Slot</label>

<select name="appointment_time"
id="appointment_time"
class="w-full border rounded p-2"
required>

<option value="">Select time slot</option>

</select>

</div>

<div class="mb-4">

<label class="block font-medium">Notes</label>

<textarea name="notes"
class="w-full border rounded p-2"></textarea>

</div>

<button type="submit"
class="bg-blue-600 text-white px-4 py-2 rounded">

Book Appointment

</button>

</form>

</div>

</x-app-layout>