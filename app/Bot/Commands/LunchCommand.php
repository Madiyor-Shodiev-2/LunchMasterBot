<?php

namespace App\Bot\Commands;

use Telegram\Bot\Commands\Command;
use App\Actions\TelegramCommandAction;

class LunchCommand extends Command
{
    protected string $name        = "lunch";
    protected string $description = "Записатся на обед";

    public function handle(): void
    {
        $userChatId = $this->getUpdate()->getMessage()->getChat()->getId();

        TelegramCommandAction::joinToQueue($this, $userChatId);   
    }
}
