<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request as TelegramRequest;
use Longman\TelegramBot\TelegramLog;

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
        Log::error('Test 1: '. var_export($_POST, true));
        Log::error('Test 2: '. var_export(file_get_contents('php://input'), true));

        $bot_api_key  = '817087292:AAGCA9jQpZaFGkTedtpM50m9yBjXs-F4hQw';
        $bot_username = 'InionBot';

        try {
            $telegram = new Telegram($bot_api_key, $bot_username);

            // Handle telegram webhook request
            $telegram->handle();

            /*$update = new Update(file_get_contents('php://input'));
            $message = $update->getMessage();

            // Reply to the message
            $text = $message->getText();
            $chat_id = $message->getChat()->getId();
            TelegramRequest::sendMessage(['chat_id' => $chat_id, 'text' => $text]);*/

            // todo search task id for client and send comment to task
        } catch (TelegramException $e) {
            // Silence is golden!
            // log telegram errors
             echo $e->getMessage();
        }

        // $request->post('event');
        // $request->post('access_token');
        // $request->post('task_id');
        // $request->post('user_id');
        // $request->post('task');
    }
    //
}
