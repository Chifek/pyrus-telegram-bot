<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PyrusApiService
{
    private string $clientId = 'ext@44a2e482-9b57-4a32-8f7b-c3dfab25409c';
    private string $secret = 'Cz1jkMwhYnGjJIgaoDkNiwJh-JgBxPJDvWqwimeBXnL6Z5pjRBCkEsd2~eiQhL6aNUD2iLDp9PsJOHSaUUwKcMaYwdmV2BIC';
    private string $baseUrl = 'https://extensions.pyrus.com/v1';
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
        if ($this->token) {
            Log::debug('Return saved token', ['token' => $this->token]);
            return $this->token;
        }

        $response = Http::post($this->baseUrl . '/token', [
            'client_id' => $this->clientId,
            'secret' => $this->secret,
        ]);

        $this->token = $response->json('access_token');
        Log::debug('Return new token', ['token' => $this->token]);

        return $this->token;
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
        Log::debug('Call Pyrus task', [
            'telegramId' => $telegramId,
            'text' => $text,
            'username' => $username,
        ]);
        $response = Http::withToken($this->token())->post($this->baseUrl . '/task', [
//            'account_id' => (string)$telegramId,
            'account_id' => 'uniqueID12345',
            'text' => $text,
            'mappings' => [
                [
                    'code' => 'SenderName',
                    'value' => $username,
                ],
                [
                    'code' => 'Message',
                    'value' => $text
                ]
            ]
        ]);

        Log::debug('response /task status ', ['status' => $response->status()]);
        Log::debug('response /task json ', ['json' => $response->json()]);

        return $response->json();
    }
}
