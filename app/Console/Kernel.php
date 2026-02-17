<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define your application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ✅ Automatically mark past appointments as completed every day
        $schedule->call(function () {
            \App\Models\Appointment::where('status', 'accepted')
                ->whereDate('appointment_date', '<', now()->toDateString())
                ->update(['status' => 'completed']);
        })->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
