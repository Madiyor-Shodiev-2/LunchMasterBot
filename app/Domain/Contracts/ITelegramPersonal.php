<?php

namespace App\Domain\Contracts;

use Telegram\Bot\Commands\Command;

interface ITelegramPersonal extends ISendMessage
{
    public static function sendMessageInPersonal(Command $command, $userChatId): int;
}