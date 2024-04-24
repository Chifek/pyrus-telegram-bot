<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PyrusController extends Controller
{
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
        return new Response('', 403);
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


                // setwebhook

                return response()->json([
                    "account_id" => env('APP_ACCOUNT_ID'),
                    "account_name" => env('APP_NAME'),
                    "access_token" => $token,
                    "refresh_token" => $token // todo return refresh token
                ]);
            }
        }
        return new Response('', 403);
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

        $account_id = $request->post('account_id');
        $access_token = $request->post('access_token');

        Integration::where('id', $account_id)
            ->where('token', $access_token)
            ->update(['enabled' => $request->post('enabled', false)]);
    }

    // POST event
    public function event(Request $request)
    {
        Log::debug('Called GET event', $request->post());
    }

}
