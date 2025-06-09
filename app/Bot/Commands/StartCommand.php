<?php

namespace App\Bot\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name        = "start";
    protected string $description = "Приветствие при старте бота";

    public function handle()
    {
        $chatId = $this->getUpdate()->getMessage()->getChat()->getId();

        $this->replyWithMessage([
            "chat_id" => $chatId,
            "text"    => "Привет! Я LunchMasterBot. Я помогу тебе встать в очередь на обед:\n" .
                "/lunch — записаться в очередь\n" .
                "/queue — посмотреть очередь"
        ]);
    }
}
