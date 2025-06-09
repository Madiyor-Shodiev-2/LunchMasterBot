<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;

class WebhookController extends Controller
{
    public function handle(Request $request){
        $update = Telegram::getWebhookUpdates();
        
        Telegram::commandsHandler(true);
        return response('OK', 200);

    }
}