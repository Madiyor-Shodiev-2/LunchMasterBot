<?php

namespace App\Bot\Commands;

use Telegram\Bot\Commands\Command;
use App\Actions\TelegramCommandAction;

class StatusCommand extends Command
{
    protected string $name        = "status";
    protected string $description = "Статус пользователя на сегоднящный день";

    public function handle()
    {
        $userChatId = $this->getUpdate()->getMessage()->getChat()->getId();

        TelegramCommandAction::operatorDayStatus($this, $userChatId);
    }
}