<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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
        if ($this->token) {
            return $this->token;
        }

        $response = Http::post($this->baseUrl . '/token', [
            'client_id' => $this->clientId,
            'secret' => $this->secret,
        ]);

        $this->token = $response->json('access_token');

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

    public function task(int $telegramId, string $text): ?array
    {
        return Http::withToken($this->token())->post($this->baseUrl . '/task', [
            'account_id' => $telegramId,
            'text' => $text,
        ])->json();
    }
}
