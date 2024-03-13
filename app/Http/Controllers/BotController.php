<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request as RequestTelegram;
use Longman\TelegramBot\Telegram;

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
        $bot_api_key = '817087292:AAGCA9jQpZaFGkTedtpM50m9yBjXs-F4hQw';
        $bot_username = 'InionBot';

        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);

            // Handle telegram webhook request

            $telegram->setUpdateFilter(function (Update $update, Telegram $telegram, &$reason = 'Update denied by update_filter') {
                Log::error('update filter');

                $chat_id = $update->getMessage()->getChat()->getId();
                $user_id = $update->getMessage()->getFrom()->getId();

                // todo check if task exists

                Log::error('chat_id' . $chat_id);
                Log::error('user_id' . $user_id);

                RequestTelegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "Your chat id {$chat_id}, your telegram user id {$user_id}",
                ]);

                return true;
            });

            $telegram->handle();

//            $updates = $telegram->useGetUpdatesWithoutDatabase();
//            Log::error('updates' . var_export($updates->getLastUpdateId(), true));
//            Log::error('updates' . var_export($updates->getBotId(), true));
//            Log::error('updates' . var_export($updates->getBotUsername(), true));
//            Log::error('updates' . var_export($updates->get(), true));

        } catch (TelegramException $e) {
            Log::error('telegram error ' . $e->getMessage());
        }
    }

    public function auth()
    {
        // auth
        $response = Http::post('https://accounts.pyrus.com/api/v4/auth', [
            'login' => 'bot@76e8eb9a-5b57-4040-b6cb-5b014123c357',
            'security_key' => '-GlbXSHyTa2zLiuq2-67fq1AFOwWxvyIWlOS5dWEn9nkU4HejzYHUbfsck7isb6IJGGLxgI4LQsyq0oI8YbBtSSeJkLTj4kc',
        ]);
        $jsonResponse = json_decode($response->body(), true, 5, JSON_PRETTY_PRINT);

        echo '<pre>';
        var_export($jsonResponse);

        $response = Http::withToken($jsonResponse['access_token'])->get($jsonResponse['api_url'] . 'forms');
        var_export($response->clientError());
        var_export($response->status());
        var_export($response->body());

        $jsonResponse = json_decode($response->body(), true, 5, JSON_PRETTY_PRINT);
        var_export($jsonResponse);
    }
}

