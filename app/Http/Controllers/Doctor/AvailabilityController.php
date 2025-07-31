<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->doctor->can_manage_slots) {
                abort(403, 'You are not allowed to manage time slots.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $availabilities = Availability::where('doctor_id', Auth::user()->doctor->id)->get();
        return view('doctor.availability.index', compact('availabilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $doctorId = auth()->user()->doctor->id;

        // Check for overlapping time slots
        $overlap = Availability::where('doctor_id', $doctorId)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start_time', '<', $request->start_time)
                                ->where('end_time', '>', $request->end_time);
                      });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->withErrors(['overlap' => 'This time slot overlaps with an existing availability.']);
        }

        Availability::create([
            'doctor_id' => $doctorId,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('message', 'Availability added successfully.');
    }

    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);

        if ($availability->doctor_id !== auth()->user()->doctor->id) {
            abort(403, 'Unauthorized action.');
        }

        $availability->delete();

        return redirect()->back()->with('message', 'Availability deleted successfully.');
    }

    public function edit($id)
    {
        $availability = Availability::findOrFail($id);
        return view('doctor.availability.edit', compact('availability'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'day_of_week' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $doctorId = auth()->user()->doctor->id;

        $overlap = Availability::where('doctor_id', $doctorId)
            ->where('day_of_week', $request->day_of_week)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start_time', '<', $request->start_time)
                                ->where('end_time', '>', $request->end_time);
                      });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->withErrors(['overlap' => 'This time slot overlaps with an existing availability.']);
        }

        $availability = Availability::findOrFail($id);
        $availability->update($request->only(['day_of_week', 'start_time', 'end_time']));

        return redirect()->route('doctor.availability')->with('message', 'Availability updated.');
    }
}
