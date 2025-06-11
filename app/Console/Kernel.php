<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\LunchSchedule;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule){

        LunchSchedule::where('active', 'collecting')->get()->each(function ($cfg) use ($schedule) {
            $time = '18:00';

            $schedule
                ->command("collect:lunch {$cfg->schedule_id}")
                ->dailyAt($time)
                ->timezone('Asia/Tashkent');
        });

    }
}
