<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
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
            $telegram->handle();

            $telegram->setUpdateFilter(function (Update $update, Telegram $telegram, &$reason = 'Update denied by update_filter') {
                $user_id = $update->getMessage()->getFrom()->getId();
                RequestTelegram::sendMessage([
                    'chat_id' => $user_id,
                    'text'    => 'Your utf8 text 😜 ...',
                ]);
            });

//            $updates = $telegram->useGetUpdatesWithoutDatabase();
//            Log::error('updates' . var_export($updates->getLastUpdateId(), true));
//            Log::error('updates' . var_export($updates->getBotId(), true));
//            Log::error('updates' . var_export($updates->getBotUsername(), true));
//            Log::error('updates' . var_export($updates->get(), true));

        } catch (TelegramException $e) {
            Log::error('telegram error '. $e->getMessage());
        }
    }
}

