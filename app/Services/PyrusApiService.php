<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PyrusApiService
{
    private string $clientId = 'ext@44a2e482-9b57-4a32-8f7b-c3dfab25409c';
    private string $secret = 'Y96eCzDttuRXE7DLMBQxeGkKxmQi1ipbphZelIM4yw9-4lxB8zHSN1fdMVoI-flyWEuCD3Cm9fQQjFvMLLX64nYyfy~UwmWs';
    private string $baseUrlExt = 'https://extensions.pyrus.com/v1';
    private string $baseUrlApi = 'https://api.pyrus.com/v4';
    private ?string $token = null;

    public function __construct()
    {
        //ClientID: ext@44a2e482-9b57-4a32-8f7b-c3dfab25409c
        //Secret: Cz1jkMwhYnGjJIgaoDkNiwJh-JgBxPJDvWqwimeBXnL6Z5pjRBCkEsd2~eiQhL6aNUD2iLDp9PsJOHSaUUwKcMaYwdmV2BIC
    }

    /**
     * @link https://pyrus.com/ru/help/integration-development/api#post-token
     *
     * @return string
     */
    public function token(): string
    {
        Log::debug('Request token');
        $token = Cache::get('token');
        if ($token) {
            Log::debug('Return saved token', ['token' => $token]);
            return $token;
        }

        $response = Http::post($this->baseUrlExt . '/token', [
            'client_id' => $this->clientId,
            'secret' => $this->secret,
        ]);

        Log::debug('Return new token, response ', [$response->json()]);
        $token = $response->json('access_token');
        Log::debug('Return new token', [$token]);
        Cache::set('token', $token);

        return $token;
    }

    /**
     * @link https://pyrus.com/ru/help/integration-development/api#post-getmessage
     *
     * @return void
     */
    public function getMessage(): void
    {
        $token = $this->token;
        // todo send POST /getmessage
    }

    public function call(): void
    {

    }

    public function attachcallrecord(): void
    {

    }

    public function task(int $telegramId, string $text, string $username): ?array
    {
        // $client - telegram user
        try {
            $client = Client::firstOrCreate([
                'telegram_id' => $telegramId
            ], [
                'chat_id' => $telegramId,
                'user_id' => $telegramId,
            ]);
        } catch (\Exception $e) {
            Log::debug('Create client exception: ' . $e->getMessage());
        }

        Log::debug('Call Pyrus task', [
            'telegramId' => $telegramId,
            'text' => $text,
            'username' => $username,
            'client_id' => $client->id
        ]);

        $data = [
//            'account_id' => (string)$telegramId,
            'account_id' => env('APP_ACCOUNT_ID'),
            'text' => $text,
            'mappings' => [
                [
                    'code' => 'SenderName',
                    'value' => $username,
                ],
                [
                    'code' => 'Subject',
                    'value' => $text
                ],
                [
                    'code' => 'Message',
                    'value' => $text
                ],
                [
                    'code' => 'TelegramId',
                    'value' => (string)$telegramId
                ],
                [
                    'code' => 'telegram_id',
                    'value' => (string)$telegramId
                ]
            ]
        ];
        Log::debug('Call Pyrus task data', $data);

        $token = $this->token();
        Log::debug('response /task, use token ', [$token]);

        if ($client->task_id) {
            $response = Http::withToken($token)->post($this->baseUrlApi . "/integrations/addcomment", [
                'account_id' => env('APP_ACCOUNT_ID'),
                'task_id' => $client->id,
                'comment_text' => $text,
                'mappings' => $data['mappings']
            ]);

            Log::debug("response /comments status", [
                'url' => $this->baseUrlApi . "/integrations/addcomment",
                'status' => $response->status(),
                'body' => $response->body()
            ]);

        } else {
            $response = Http::withToken($token)->post($this->baseUrlExt . '/task', $data);

            Log::debug('task_id saved for client ', ['client_id' => $client->id, 'task_id' => $response->json('task_ids.0')]);
            try {
                $client->task_id = $response->json('task_ids.0');
                $client->save();
            } catch (\Exception $e) {
                Log::debug('Create client exception: ' . $e->getMessage());
            }
        }

        Log::debug('response /task status ', ['status' => $response->status()]);
        Log::debug('response /task json ', ['json' => $response->json()]);
        if ($response->json('error')) {
            Log::debug('Removed token');
            Cache::delete('token');
        }

        return $response->json();
    }
}
