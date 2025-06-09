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
        $chatId = $command->getUpdate()->getMessage()->getChat()->getId();

        try {

            $message = $command->getUpdate()->getMessage();
            $from    = $message->getFrom();

            $attributes = [
                'telegram_id' => $from->getId(),
            ];

            $values = [
                'username'    => $from->getUsername() ?? 'not username',
                'fullname'    => (($from->getFirstName() ?? '') . ' ' . ($from->getLastName() ?? '')) ?? 'no name'
            ];

            $user = Operator::updateOrCreate(
                $attributes,
                $values
            );

        } catch (\Exception $exception) {
            $command->replyWithMessage([
                "chat_id" => $chatId,
                "text"    => "Произошло внутренняя ошибка, пожалуйста повторите попытку позже"
            ]);
        } finally {
            $command->replyWithMessage([
                "chat_id" => $chatId,
                "text"    => "Привет {$user->fullname}!. Вы успешно зарегистрировались на ланч, введите команду /lunch чтобы присоединиться к доступным ланчам!"
            ]);
        }
    } 

    public static function joinToQueue(Command $command, $chatId){
        try {
            $today = Carbon::today('Asia/Tashkent')->toDateString();

            $sessions = LunchSession::with('schedule', 'operators')
                ->where('date', $today)
                ->get();

            if ($sessions->isEmpty()) {
                $command->replyWithMessage([
                    'chat_id' => $chatId,
                    'text'    => 'На сегодня нет доступных ланч-сессий.',
                ]);
                return;
            }
            foreach ($sessions as $session) {

                $sched = $session->schedule;
                $taken = $session->operators->count();
                $max   = $sched->max_per_round;
                $time  = gmdate('H:i', $sched->hour);

                $text = "🕒 <b>{$sched->name}</b>\n"
                    . "Время: {$time}\n"
                    . "Записано: {$taken} из {$max}";


                $kb = Keyboard::make();  // возвращает экземпляр Keyboard

                $button = $kb
                    ->inline()                        // ставим клавиатуру в inline-режим
                    ->row([
                        $kb->inlineButton([          // обёрнуто в массив!
                            'text'          => '✅ Присоединиться',
                            'callback_data' => "join:{$session->session_id}",
                        ]),
                    ]);

                $command->replyWithMessage([
                    "chat_id"      => $chatId,
                    "text"         => $text,
                    "parse_mode"   => 'HTML',
                    'reply_markup' => $button
                ]);
            }
        } catch (\Exception $exception) {
            $command->replyWithMessage([
                "chat_id"      => $chatId,
                "text"         => "Произошло внутреняя ошибка!",
            ]);
        }
    }
}