<?php

namespace App\Console\Commands\Notify;

use Illuminate\Console\Command;
use App\Models\LunchSchedule;
use Illuminate\Support\Arr;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendAllSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lunch-master-bot:send-all-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'That command send all schedule to group Telegram';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $allSchedules = LunchSchedule::select([
            'schedule_id',
            'group_id',
            'hour',
            'minute',
            'max_per_round'
        ])
        ->where('active', true)
        ->with('group:group_id,name')
        ->get()
        ->toArray();

        $group_id = config('telegram.default_chat_id');
        
        foreach($allSchedules as $schedule){

            $group = Arr::pull($schedule, 'group');            

            Telegram::sendMessage([
                'chat_id'    => $group_id,
                'parse_mode' => 'HTML',
                'text'       =>
                "📅 <b>Вот сегодняшние расписания:</b>\n" .
                    "🍱 <b>Название ланча:</b> {$group['name']}\n" .
                    "⏰ <b>Начало ланча:</b> {$schedule['hour']}\n" .
                    "⏳ <b>Время на ланч:</b> {$schedule['minute']} мин\n" .
                    "👥 <b>Макс. участников:</b> {$schedule['max_per_round']}\n"    
            ]);
        }

    }
}
