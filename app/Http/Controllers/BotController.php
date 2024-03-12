<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Request as RequestTelegram;

class BotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function webhook(Request $request): void
    {
        $bot_api_key  = '817087292:AAGCA9jQpZaFGkTedtpM50m9yBjXs-F4hQw';
        $bot_username = 'InionBot';

        $json = json_encode(file_get_contents('php://input'), true);

        $result = RequestTelegram::sendMessage([
            'chat_id' => $json['message']['chat_id'],
            'text'    => 'Your utf8 text 😜 ...',
        ]);
    }
    //
}

