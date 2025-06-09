<?php 

namespace App\Actions;

use App\Models\LunchSession;
use App\Models\LunchSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SessionCommandAction
{
    public static function sessionStore(Command $command){
        $allSchedule = LunchSchedule::all(['schedule_id','name', 'hour'])->toArray();

        $selectSchedule = [];

        foreach ($allSchedule as $schedule){
            $selectSchedule[$schedule['schedule_id']] = $schedule['name'] . '  ---  ' . gmdate('H:i', $schedule['hour']);
        }

        $selectedSchedule = $command->choice(
            'Выберите расписания на сегоднешную сессию', 
            $selectSchedule,
        );

        $selectedScheduleId = (int) array_search($selectedSchedule, $selectSchedule, true);

        $date = (string) Carbon::today()->format('Y-m-d');

        $data = [
            'date'        => (string) Carbon::today()->format('Y-m-d'),
            'schedule_id' => $selectedScheduleId,
        ];

        LunchSession::create($data);
    }
}