<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

            $updates = $telegram->useGetUpdatesWithoutDatabase();
            Log::error('updates' . var_export($updates->getLastUpdateId(), true));
            Log::error('updates' . var_export($updates->getBotId(), true));
            Log::error('updates' . var_export($updates->getBotUsername(), true));

        } catch (TelegramException $e) {
            Log::error('telegram error '. $e->getMessage());
        }
    }
}

