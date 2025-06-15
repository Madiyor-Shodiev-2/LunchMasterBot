<?php

namespace App\Domain\Models;

use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\Log;
use App\Domain\Contracts\ITelegramPersonal;
use Exception;

class TelegramPersonal implements ITelegramPersonal
{
    public function sendMessage():string
    {
        return "Hello, i'm send message to personal user";
    }

    public static function sendMessageInPersonal(Command $command, $userChatId):int{

        try{
            self::log_replyWithMessage_access($userChatId);
    
            $command->replyWithMessage([
                "chat_id" => $userChatId,
                "text"    => "Привет! Я LunchMasterBot. Я помогу тебе встать в очередь на обед:\n" .
                    "/lunch — записаться в очередь\n" .
                    "/queue — посмотреть очередь"
            ]);

            return 1;

        } catch (Exception $e){
            
            self::log_replyWithMessage_fail();

            return 0;
        }
    }

    private static function log_replyWithMessage_access($userChatId)
    {
        Log::info("Успешно отправлено сообщения в личку пользователя", [
            'class'   => 'TelegramPersonal',
            'method'  => 'replyWithMessage',
            'user_id' => $userChatId
        ]);
    }

    private static function log_replyWithMessage_fail()
    {
        Log::channel('errors')
        ->error("Произошло какая-то ошибка ((",
        [
            'class' => 'TelegramPersonal',
            'method' => 'replyWithMessage'
        ]);
    }
}