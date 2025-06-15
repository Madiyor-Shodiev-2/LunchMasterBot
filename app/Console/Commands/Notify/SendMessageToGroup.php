<?php

namespace App\Console\Commands\Notify;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendMessageToGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lunch-master-bot:notify-group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message every five minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Telegram::sendMessage([
            'chat_id' => config('telegram.default_chat_id'),
            'text' => "👋 Привет, команда!\nДанное время: " . now()->format('H:i') . "\nЖмите на кнопку ниже или введите /join, чтобы присоединиться 🥗"
        ]);

        $this->info('✉️ Сообщение отправлено — можно расслабиться! 🛋️');
    }
}
