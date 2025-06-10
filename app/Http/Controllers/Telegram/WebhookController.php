<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LunchSession;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Operator;

class WebhookController extends Controller
{
    public function handle(Request $request){

        $update = Telegram::getWebhookUpdates();

        Telegram::commandsHandler(true);

        if (! $inlineBtn = $update->getCallbackQuery()) {
            return response('OK', 200);
        }

        [$action, $sessionId] = explode(':', $inlineBtn->getData(), 2);

        if ($action === 'join') {
            $this->handleJoin($inlineBtn, (int)$sessionId);
        }

        return response('OK', 200);
    }

    private function handleJoin($inlineBtn, int $sessionId): void
    {
        $lunchSession = LunchSession::findOrFail($sessionId);

        $telegramId = $inlineBtn->getFrom()->getId();

        $operator = Operator::firstWhere('telegram_id', $telegramId);

        if ($operator && ! $lunchSession->operators()->where('telegram_id', $telegramId)->exists()) {

            $nextPosition = $lunchSession
                ->operators()
                ->withPivot('position')
                ->get()
                ->max('pivot.position') + 1;

            $lunchSession->operators()->attach($operator->operator_id, [
                'position' => $nextPosition,
                'status'   => 'waiting'
            ]);
        }

        Telegram::answerCallbackQuery([
            'callback_query_id' => $inlineBtn->getId(),
            'text'              => 'Вы записаны!',
        ]);

        $inlineBtnMsg  = $inlineBtn->getMessage();
        $inlineBtnText = $inlineBtnMsg->getText();
        $joinsPerson   = $lunchSession->operators()->count();
        $maxPerson     = $lunchSession->schedule->max_per_round;
        $newTxt        = preg_replace('/Записано: \d+ из \d+/', "Записано: {$joinsPerson} из {$maxPerson}", $inlineBtnText);

        Telegram::editMessageText([
            'chat_id'    => $inlineBtnMsg->getChat()->getId(),
            'message_id' => $inlineBtnMsg->getMessageId(),
            'text'       => $newTxt,
            'parse_mode' => 'HTML',
        ]);
    }
}