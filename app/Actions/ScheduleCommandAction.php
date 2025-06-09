<?php

namespace App\Actions;

use App\Models\LunchSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ScheduleCommandAction
{
    public static function scheduleStore(Command $command){
        
        $lunchName = $command->ask('Введите имя расписании');

        do {
            $lunchTime = $command->ask('Введите время ланча пример: (12:45)');

            try {

                $lunchTime = Carbon::createFromFormat('H:i', $lunchTime);
                $errors    = Carbon::getLastErrors();

                if ($errors['warning_count'] > 0 || $errors['error_count'] > 0) {
                    $command->error("Неверное время: {$lunchTime}. Попробуйте снова.");
                    $valid = false;
                } else {
                    $lunchTime = (string) $lunchTime->secondsSinceMidnight();
                    $valid = true;
                }
            } catch (\Exception $exception) {
                $command->error('Неверный формат времени. Попробуйте снова.');
                $valid = false;
            }
        } while (! $valid);

        $lunchMinute = (int) $command->ask('Введите время для обеда');

        $lunchPerson = (int) $command->ask('Сколько людей сходить на обед?');

        $data = [
            'name'          => $lunchName,
            'hour'          => $lunchTime,
            'minute'        => $lunchMinute,
            'max_per_round' => $lunchPerson
        ];

        $validator = Validator::make($data, [
            'max_per_round' => 'required|integer|max:5',
            'name'          => 'required|string|max:32',
            'hour'          => 'required|string',
            'minute'        => 'required|integer|max:60',
        ]);

        if ($validator->fails()) {
            $command->error($validator->getMessageBag());
        } else {
            LunchSchedule::create($data);
        }

    }

    // public static function scheduleUpdate(Command $command);
}