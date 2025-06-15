<?php

namespace App\Domain\Contracts;

use App\Domain\Contracts\ISendMessage;
use Telegram\Bot\Commands\Command;

interface ITelegramGroup extends ISendMessage 
{
    public static function sendMessageInGroup(Command $command, $userChatId): int; 
}