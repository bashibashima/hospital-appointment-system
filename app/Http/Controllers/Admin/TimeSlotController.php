<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Availability;
use App\Models\Doctor;


class TimeSlotController extends Controller
{


    public function doctors()
    {
        // Assuming you have a relation from doctor → user
        $doctors = Doctor::with('user')->get();

        return view('admin.availabilities.doctor-list', compact('doctors'));
    }




    
    
    // Show all time slots for a specific doctor
    public function index(User $doctor)

{
    $availabilities = Availability::where('doctor_id', $doctor->doctor->id)->get();
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    return view('admin.availabilities.index', compact('doctor', 'availabilities', 'daysOfWeek'));
}
    

    // Add a new time slot for the doctor
    public function store(Request $request, Doctor $doctor)
    {
       $request->validate([
    'day_of_week' => 'required|in:Monday,Tuesday,...',
    'start_time' => 'required|date_format:H:i',
    'end_time' => 'required|date_format:H:i|after:start_time',
    'slot_duration' => 'required|integer|min:5|max:60',
]);

Availability::create([
    'doctor_id' => $doctorId,
    'day_of_week' => $request->day_of_week,
    'start_time' => $request->start_time,
    'end_time' => $request->end_time,
    'slot_duration' => $request->slot_duration,
]);


        return back()->with('success', 'Time slot added successfully.');
    }

    // Delete a time slot
    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);
        $availability->delete();

        return back()->with('success', 'Time slot removed successfully.');
    }
}
