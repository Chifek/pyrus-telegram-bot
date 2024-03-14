<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Lumen\Http\Redirector;
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
        $telegram = new Telegram($bot_api_key, $bot_username);

        $chat_id = 1; // todo need to found chat_id from database using user_id from POST

        $result = TelegramRequest::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Your utf8 text 😜 ...',
        ]);
        // todo send message to telegram bot
        // $request->post('event');
        // $request->post('access_token');
        // $request->post('task_id');
        // $request->post('user_id');
        // $request->post('task');
    }

    public function pulse(): Response
    {
        return response();
    }

    public function integrationAuth(Request $request): RedirectResponse|Redirector
    {
        $state = $request->get('state');
        $token = '123';

        Log::error('integration authorize' . $state);

        return redirect("https://pyrus.com/integrations/oauthorization?state={$state}&code={$token}");
    }

    public function auth(Request $request): JsonResponse
    {
        Log::error('authorize' . var_export($_POST, true));
        Log::error('authorize _ auth_code: ' . $request->post('authorization_code'));
        Log::error('authorize _ grant_type: ' . $request->post('grant_type'));
        return response()->json([
            "account_id" => "uniqueID12345",
            "account_name" => "Test account",
            "access_token" => "123",
            "refresh_token" => "321"
        ]);
    }
}
