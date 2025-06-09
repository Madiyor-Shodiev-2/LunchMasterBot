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

        if (! $cq = $update->getCallbackQuery()) {
            return response('OK', 200);
        }

        [$action, $sessionId] = explode(':', $cq->getData(), 2);

        if ($action === 'join') {
            $this->handleJoin($cq, (int)$sessionId);
        }

        return response('OK', 200);
    }

    private function handleJoin($cq, int $sessionId): void
    {
        $session = LunchSession::findOrFail($sessionId);

        $telegramId = $cq->getFrom()->getId();

        $operator = Operator::firstWhere('telegram_id', $telegramId);

        if ($operator && ! $session->operators()->where('telegram_id', $telegramId)->exists()) {

            $nextPosition = $session
                ->operators()
                ->withPivot('position')
                ->get()
                ->max('pivot.position') + 1;

            $session->operators()->attach($operator->operator_id, [
                'position' => $nextPosition,
                'status'   => 'waiting'
            ]);
        }

        Telegram::answerCallbackQuery([
            'callback_query_id' => $cq->getId(),
            'text'              => 'Вы записаны!',
        ]);

        $msg    = $cq->getMessage();
        $text   = $msg->getText();
        $taken  = $session->operators()->count();
        $max    = $session->schedule->max_per_round;
        $newTxt = preg_replace('/Записано: \d+ из \d+/', "Записано: {$taken} из {$max}", $text);

        Telegram::editMessageText([
            'chat_id'    => $msg->getChat()->getId(),
            'message_id' => $msg->getMessageId(),
            'text'       => $newTxt,
            'parse_mode' => 'HTML',
        ]);
    }
}