<?php

namespace App\Console\Commands\Notify;

use App\Models\LunchSession;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Arr;

class SendAllSessionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lunch-master-bot:send-all-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thats send all Session to Telegram-group';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sessions = LunchSession::select(['session_id', 'schedule_id','date', 'status'])
        ->with(['schedule' => function ($selectRow){
            $selectRow->select([
                'schedule_id',
                'group_id',
                'hour',
                'minute',
                'max_per_round'
            ]);
        },
        'schedule.group' => function ($selectRaw) {
            $selectRaw->select([
                'group_id',
                'name'
            ]);
        }])
        ->get()
        ->toArray();

        $chat_id = config('telegram.default_chat_id');

        foreach($sessions as $session){

            $schedule = Arr::pull($session, 'schedule');
            $group    = Arr::pull($schedule, 'group');
    
            // dd($session);
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text'    =>
                "<b>🍱 Название сессии:</b> {$group['name']}\n" .
                    "⏰ <b>Начало сессии:</b> {$schedule['hour']}\n" .
                    "⏳ <b>Время на ланч:</b> {$schedule['minute']} мин\n" .
                    "👥 <b>Макс. участников:</b> {$schedule['max_per_round']}\n" .
                    "📅 <b>Дата создания:</b> {$session['date']}\n" .
                    "✅ <b>Статус:</b> " . ($session['status'] === 'collecting' ? 'Открыта' : 'Закрыта'),
                'parse_mode' => 'HTML'
            ]);
            // dump($session, $schedule);
        }
        
    }
}
