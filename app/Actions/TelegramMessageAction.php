<?php

namespace App\Actions;

use Telegram\Bot\Commands\Command;
use App\Domain\Models\TelegramGroup;
use App\Domain\Models\TelegramPersonal;

class TelegramMessageAction
{
    public static function sendMessageSituation(Command $command, $userChatId)
    {
        switch ($userChatId) {
            case config('lunch.telegram_chat'):
                TelegramGroup::sendMessageInGroup($command, $userChatId);
                break;
            default:
                TelegramPersonal::sendMessageInPersonal($command, $userChatId);
        }
    }
}