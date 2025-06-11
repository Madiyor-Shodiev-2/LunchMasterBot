<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;

class TelegramMessageAction
{
    public static function sendMessageSituation(Command $command, $userChatId)
    {
        switch ($userChatId) {
            case config('lunch.telegram_chat'):
                Log::info("Телеграм группа: {$userChatId}", ['sendMessageSituation']);
                $command->replyWithMessage([
                    "chat_id" => $userChatId,
                    "text"    => "Привет! Я LunchMasterBot. Я помогу тебе встать в очередь на обед"
                ]);
                break;
            default:
                Log::info("Телеграм личка:  {$userChatId} ", ['sendMessageSituation']);
                $command->replyWithMessage([
                    "chat_id" => $userChatId,
                    "text"    => "Привет! Я LunchMasterBot. Я помогу тебе встать в очередь на обед:\n" .
                        "/lunch — записаться в очередь\n" .
                        "/queue — посмотреть очередь"
                ]);
        }
    }
}