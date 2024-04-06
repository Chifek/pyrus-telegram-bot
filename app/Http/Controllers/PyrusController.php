<?php

namespace App\Http\Controllers;

use App\Models\Integration;
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

    public function integrationAuth(Request $request)
    {
        Log::debug('Called integrationAuth', [$request->get('state')]);

        $state = $request->input('state');
        $stateJson = json_decode($state, true);
        Log::debug('Called integrationAuth state', [$stateJson]);
        Log::debug('Called integrationAuth state.formId', [$stateJson['formId']]);
        $formId = $stateJson['formId'] ?? null;
        if ($formId) {
            $integration = Integration::where('form_id', $formId)->firstOr(function () use ($formId) {
                return Integration::create([
                    'form_id' => $formId,
                    'token' => Integration::generateNewToken($formId)
                ]);
            });

            return redirect("https://pyrus.com/integrations/oauthorization?state={$state}&code={$integration->token}");
        }
        abort(403);
    }

    // callback pyrus methods:
    // GET pulse
    public function pulse(): Response
    {
        Log::debug('Called GET pulse');
        return new Response();
    }

    // POST authorize
    public function authorizeConfirm(Request $request)
    {
        Log::debug('Called POST authorize', $request->post());
        $token = $request->post('authorization_code');

        $integration = Integration::where('token', $token)->firstOrFail();
        if ($integration) {
            $client_id = $request->post('client_id');
            $client_secret = $request->post('client_secret');
            if (env('APP_CLIENT_ID') === $client_id && env('APP_SECRET') === $client_secret) {
                return response()->json([
                    "account_id" => $integration->id,
                    "account_name" => env('APP_NAME'),
                    "access_token" => $token,
                    "refresh_token" => $token // todo return refresh token
                ]);
            }
        }
        abort(403);
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
