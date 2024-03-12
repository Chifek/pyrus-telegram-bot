<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request as TelegramRequest;

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

    public function webhook(Request $request)
    {
        $bot_api_key  = '817087292:AAGCA9jQpZaFGkTedtpM50m9yBjXs-F4hQw';
        $bot_username = '@InionBot';
        $chat_id = $request->post('chat_id');

        try {
            $telegram = new Telegram($bot_api_key, $bot_username);

            // Handle telegram webhook request
            $telegram->handle();

            // todo search task id for client and send comment to task
            $result = TelegramRequest::sendMessage([
                'chat_id' => $chat_id,
                'text'    => 'Your utf8 text 😜 ...',
            ]);
        } catch (TelegramException $e) {
            // Silence is golden!
            // log telegram errors
            // echo $e->getMessage();
        }

        // $request->post('event');
        // $request->post('access_token');
        // $request->post('task_id');
        // $request->post('user_id');
        // $request->post('task');
    }
    //
}
