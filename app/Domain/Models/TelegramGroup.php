<?php 

namespace App\Domain\Models;

use Illuminate\Support\Facades\Log;
use App\Domain\Contracts\ITelegramGroup;
use Telegram\Bot\Commands\Command;

class TelegramGroup implements ITelegramGroup
{
    public function sendMessage(): string
    {
        return "I send message in Group";
    }

    public static function sendMessageInGroup(Command $command, $userChatId): int
    {
        Log::info("Отправлено в тг личку:  {$userChatId} ", ['sendMessageSituation']);

        $command->replyWithMessage([
            "chat_id" => $userChatId,
            "text"    => "Привет! Я LunchMasterBot. Я помогу тебе встать в очередь на обед"
        ]);

        return 1;
    }
}