<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Http\Redirector;
use Longman\TelegramBot\Exception\TelegramException;
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

    public function webhook(Request $request): void
    {
        $bot_api_key = '817087292:AAGCA9jQpZaFGkTedtpM50m9yBjXs-F4hQw';
        $bot_username = '@InionBot';
        try {
            $telegram = new Telegram($bot_api_key, $bot_username);
            $chat_id = 1; // todo need to found chat_id from database using user_id from POST

            $result = TelegramRequest::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Your utf8 text 😜 ...',
            ]);
        } catch (TelegramException $e) {
        }


        // todo send message to telegram bot
        // $request->post('event');
        // $request->post('access_token');
        // $request->post('task_id');
        // $request->post('user_id');
        // $request->post('task');
    }

    public function integrationAuth(Request $request): RedirectResponse|Redirector
    {
        $state = $request->get('state');
        $token = Crypt::encrypt(Crypt::generateKey('AES-128-CBC') . $state);

        Log::error('integration authorize ' . $state);
        Log::error('integration authorize token ' . $token);

        // todo save token

        return redirect("https://pyrus.com/integrations/oauthorization?state={$state}&code={$token}");
    }

    // callback pyrus methods:
    // GET pulse
    public function pulse(): Response
    {
        Log::debug('Called GET pulse');
        return new Response();
    }

    // POST authorize
    public function authorizeConfirm(Request $request): JsonResponse
    {
        Log::debug('Called POST authorize', $request->post());

        // todo get token

        return response()->json([
            "account_id" => "uniqueID12345",
            "account_name" => "Test account",
            "access_token" => "123123",
            "refresh_token" => "321321"
        ]);
    }

    // GET getavailablenumbers
    public function getAvailableNumbers(Request $request)
    {
        Log::debug('Called GET getavailablenumbers', $request->all());
    }

    // POST sendmessage
    public function sendMessage(Request $request)
    {
        Log::debug('Called GET sendmessage', $request->post());
    }

    // POST toggle
    public function toggle(Request $request)
    {
        Log::debug('Called GET toggle', $request->post());
    }

    // POST event
    public function event(Request $request)
    {
        Log::debug('Called GET event', $request->post());
    }

}
