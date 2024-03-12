<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Longman\TelegramBot\Request as TelegramRequest;
use Longman\TelegramBot\Telegram;

class PyrusController extends Controller
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

    public function webhook(Request $request)
    {
        $bot_api_key  = '817087292:AAGCA9jQpZaFGkTedtpM50m9yBjXs-F4hQw';
        $bot_username = '@InionBot';
        $telegram = new Telegram($bot_api_key, $bot_username);

        $chat_id = 1; // todo need to found chat_id from database using user_id from POST

        $result = TelegramRequest::sendMessage([
            'chat_id' => $chat_id,
            'text'    => 'Your utf8 text 😜 ...',
        ]);
        // todo send message to telegram bot
        // $request->post('event');
        // $request->post('access_token');
        // $request->post('task_id');
        // $request->post('user_id');
        // $request->post('task');
    }
    //
}
