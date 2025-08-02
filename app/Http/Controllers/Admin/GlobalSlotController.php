<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalTimeSlot;

class GlobalSlotController extends Controller
{
    public function edit()
    {
        $slot = GlobalTimeSlot::first(); // Only one row
        return view('admin.global-slots.edit', compact('slot'));
    }

    public function update(Request $request)
    { 
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'slot_duration' => 'required|integer|min:5',
            'days' => 'required|array',
        ]);


        GlobalTimeSlot::updateOrCreate([], [
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'slot_duration' => $request->slot_duration,
            'days' => json_encode($request->days),
        ]);

        return back()->with('success', 'Global slot settings updated.');
    }
}
