<?php 

namespace App\Actions;

use Telegram\Bot\Commands\Command;
use App\Models\Operator;
use Telegram\Bot\Keyboard\Keyboard;
use Carbon\Carbon;
use App\Models\LunchSession;
use Illuminate\Support\Facades\Log;

class TelegramCommandAction
{ 
    public static function operatorStore(Command $command)
    {
        $personChatId = $command->getUpdate()->getMessage()->getChat()->getId();

        try {

            $message  = $command->getUpdate()->getMessage();
            $from     = $message->getFrom();
            
            $userName     = $from->getUsername() ?? 'not username';
            $userFullName = (($from->getFirstName() ?? '') . ' ' . ($from->getLastName() ?? '')) ?? 'no name';

            $attributes = [
                'telegram_id' => $from->getId(),
            ];

            $values = [
                'username' => $userName,
                'fullname' => $userFullName
            ];

            Operator::updateOrCreate(
                $attributes,
                $values
            );

        } catch (\Exception $exception) {
            $command->replyWithMessage([
                "chat_id" => $personChatId,
                "text"    => "Произошло внутренняя ошибка, пожалуйста повторите попытку позже"
            ]);
        } finally {
            $command->replyWithMessage([
                "chat_id" => $personChatId,
                "text"    => "Привет {$userFullName}!. Вы успешно зарегистрировались на ланч, введите команду /lunch чтобы присоединиться к доступным сессии!"
            ]);
        }
    } 

    public static function joinToQueue(Command $command, $userChatId){
        try {
            $sessionToday = Carbon::today('Asia/Tashkent')->toDateString();

            $lunchSessions = LunchSession::with('schedule', 'operators')
                ->where('date', $sessionToday)
                ->get();

            if ($lunchSessions->isEmpty()) {
                $command->replyWithMessage([
                    'chat_id' => $userChatId,
                    'text'    => 'На сегодня нет доступных ланч-сессий.',
                ]);
                return;
            }
            foreach ($lunchSessions as $lunchSession) {

                $sessionSchedule = $lunchSession->schedule;
                $joinsPerson     = $lunchSession->operators->count();
                $maxPerson       = $sessionSchedule->max_per_round;
                $sessionTime     = gmdate('H:i', $sessionSchedule->hour);

                $text = "🕒 <b>{$sessionSchedule->name}</b>\n"
                    . "Время: {$sessionTime}\n"
                    . "Записано: {$joinsPerson} из {$maxPerson}";


                $keyboard = Keyboard::make();  // возвращает экземпляр Keyboard

                $joinButton = $keyboard
                    ->inline()                        // ставим клавиатуру в inline-режим
                    ->row([
                        $keyboard->inlineButton([          // обёрнуто в массив!
                            'text'          => '✅ Присоединиться',
                            'callback_data' => "join:{$lunchSession->session_id}",
                        ]),
                    ]);

                $command->replyWithMessage([
                    "chat_id"      => $userChatId,
                    "text"         => $text,
                    "parse_mode"   => 'HTML',
                    'reply_markup' => $joinButton
                ]);
                
            }
        } catch (\Exception $exception) {
            $command->replyWithMessage([
                "chat_id"      => $userChatId,
                "text"         => "Произошло внутреняя ошибка!",
            ]);
        }
    }
}