<?php 
namespace App\Http\Controllers\Doctor;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\Doctor;
use Carbon\Carbon;

class AvailabilityController extends Controller
{


     public function index()
    {
       $userId = Auth::id();
       $doctor = Doctor::where('user_id', $userId)->firstOrFail();
       $availabilities = Availability::where('doctor_id', $doctor->id)->get();

        $daysOfWeek = [
              'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
         ];
        return view('doctor.availability.index', compact('doctor', 'availabilities', 'daysOfWeek'));
    }
    






    public function store(Request $request, $doctorId)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $start = Carbon::createFromFormat('H:i', $request->start_time);
        $end = Carbon::createFromFormat('H:i', $request->end_time);

        // Prevent overlapping slots
        $overlap = Availability::where('doctor_id', $doctorId)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start_time', '<', $end->format('H:i:s'))
                      ->where('end_time', '>', $start->format('H:i:s'));
                });
            })->exists();

        if ($overlap) {
            return redirect()->back()->withErrors(['overlap' => 'This time slot overlaps with an existing availability.']);
        }

        Availability::create([
            'doctor_id'   => $doctorId,
            'day_of_week' => $request->day_of_week,
            'start_time'  => $start->format('H:i:s'),
            'end_time'    => $end->format('H:i:s'),
        ]);

        return redirect()->back()->with('message', 'Availability added successfully.');
    }

    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);
        $availability->delete();

        return redirect()->back()->with('message', 'Availability deleted.');
    }
}
