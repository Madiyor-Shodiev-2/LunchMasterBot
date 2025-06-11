<?php

namespace App\Bot\Commands;

use App\Actions\TelegramCommandAction;
use App\Actions\TelegramMessageAction;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name        = "start";
    protected string $description = "Приветствие при старте бота";

    public function handle()
    {
        $chatId = $this->getUpdate()->getMessage()->getChat()->getId();

        TelegramMessageAction::sendMessageSituation($this, $chatId);
    }
}
