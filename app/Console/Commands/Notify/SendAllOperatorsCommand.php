<?php

namespace App\Console\Commands\Notify;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Operator;
use Illuminate\Support\Arr;

class SendAllOperatorsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lunch-master-bot:send-all-operators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'That command send all operators';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $operators = Operator::pluck('fullname')->toArray();

        $joinedOperators = Arr::join($operators, "\n");
        
        Telegram::sendMessage([
            'chat_id' => config('telegram.default_chat_id'),
            'text' => "Hello, im bot send All Operators:\n<u>{$joinedOperators}</u>",
            'parse_mode' => 'HTML'
        ]);
    }
}
