<?php 

namespace App\Actions;

use App\Models\LunchSession;
use App\Models\LunchSchedule;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SessionCommandAction
{
    public static function sessionStore(Command $command){
        
        $allSchedule = LunchSchedule::select('schedule_id', 'group_id', 'hour')
            ->with(['group' => function ($q) {
                $q->select('group_id', 'name');   // грузим только id и name группы
            }])
            ->get()
            ->map(function ($item) {
                return [
                    'schedule_id' => $item->schedule_id,
                    'hour'        => $item->hour,
                    'group_id'    => $item->group->group_id,
                    'group_name'  => $item->group->name
                ];
            })
            ->toArray();

        Log::info($allSchedule, ['sessionStore']);

        $selectSchedule = [];

        foreach ($allSchedule as $schedule){
            $selectSchedule[$schedule['schedule_id']] = $schedule['group_name'] . '  ---  ' . $schedule['hour'];
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