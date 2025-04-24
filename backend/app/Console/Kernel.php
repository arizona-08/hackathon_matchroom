<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            \App\Models\Negotiation::whereNotIn('status', ['accepted', 'refused'])
                ->where('expires_at', '<', now())
                ->update(['status' => 'refused']);
        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
