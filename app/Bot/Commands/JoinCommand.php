<?php

namespace App\Bot\Commands;

use Telegram\Bot\Commands\Command;
use App\Actions\TelegramCommandAction;
class JoinCommand extends Command
{
    protected string $name        = "join";
    protected string $description = "Присоединиться к приложению";

    public function handle()
    {
        TelegramCommandAction::operatorStore($this);
    }

}