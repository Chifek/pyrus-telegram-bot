<?php

namespace App\Http\Controllers;

use App\Services\PyrusApiService;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request as RequestTelegram;
use Longman\TelegramBot\Telegram;

class BotController extends Controller
{
    private PyrusApiService $pyrusApiService;
    private TelegramService $telegramService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PyrusApiService $pyrusApiService, TelegramService $telegramService)
    {
        $this->pyrusApiService = $pyrusApiService;
        $this->telegramService = $telegramService;
    }

    public function webhook(): void
    {
        try {

            $this->telegramService->setUpdateFilter(function (Update $update, Telegram $telegram, &$reason = 'Update denied by update_filter') {
                $user = $update->getMessage()->getFrom();
                $name = $user->getFirstName() . ' ' . $user->getLastName();
                $chatId = $user->getId();
                $text = $update->getMessage()->getText();
                $phone = '';

                // todo check if the opened task already exist
                $id = $this->pyrusApiService->task($chatId, $text, $name, $phone);

                Log::debug('Telegram Webhook: ' . $chatId . ' / '. $text);

                RequestTelegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Ваш запрос принят, номер задачи: {$id}. Ожидайте ответа",
                ]);

                return true;
            });

            $this->telegramService->handle();
        } catch (TelegramException $e) {
            Log::error('telegram error ' . $e->getMessage());
        }
    }

    public function auth(): void
    {
        // auth
        /*
        $response = Http::post('https://accounts.pyrus.com/api/v4/auth', [
            'login' => 'bot@76e8eb9a-5b57-4040-b6cb-5b014123c357',
            'security_key' => '-GlbXSHyTa2zLiuq2-67fq1AFOwWxvyIWlOS5dWEn9nkU4HejzYHUbfsck7isb6IJGGLxgI4LQsyq0oI8YbBtSSeJkLTj4kc',
        ]);
        $jsonResponse = json_decode($response->body(), true, 5, JSON_PRETTY_PRINT);
        $token = $jsonResponse['access_token'];
        $apiUrl = $jsonResponse['api_url'];

        echo '<pre>';
        var_export($jsonResponse);

        $response = Http::withToken($token)->get($apiUrl . 'forms');
        var_export($response->clientError());
        var_export($response->status());
        var_export($response->body());

        $jsonResponse = json_decode($response->body(), true, 10, JSON_PRETTY_PRINT);
        var_export($jsonResponse);*/

        /*
        $token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6ImF0K2p3dCJ9.eyJuYmYiOjE3MTAzODcwNzksImV4cCI6MTcxMDQ3MzQ3OSwiaXNzIjoiaHR0cDovL2lkZW50aXR5LnB5cnVzLmNvbSIsImF1ZCI6InB1YmxpY2FwaSIsImNsaWVudF9pZCI6IjExRkYyODk3LUQzRTEtNEIwMC1CQkY2LTQxQjM4QzNBMDA3MiIsInN1YiI6IjEwMDQyNzgiLCJhdXRoX3RpbWUiOjE3MTAzODcwNzksImlkcCI6ImxvY2FsIiwic2VjcmV0IjoiN2M2MzI5NGEzNmIxNjI4MWJkOTRmYzI1ZjFiYzQzMzJhMDgwMzY3MDk4YzUwYzMwZmI2YjExMGNkNGQ0NDE1NyIsInRpbWVzdGFtcCI6IjE3MTA0NzM0NzkiLCJzY29wZSI6WyJwdWJsaWNhcGkiXSwiYW1yIjpbInB3ZCJdfQ.LK6VPfE3gOW9s5Tbk0v4V8XrJchZE1D9pWrrYqfJIaBQgbkVdxBOr7PmLE6jjkJbLIsyUU4233D23J8Yzotqvt79sj1Kh5zrUnkgLN_LEWS2w7AyRWKeAZA8gtOSVyH16SctCrySMY2-cJ3ctAaF-Bv3o11tc4DUCYFy77GPDkIfEk7WeE3hQyjOaqToD_3SnNMLIAEM428Z545vBKQiwPHXsaKpdQK9HqTy6Ah3lKfrXQZ3R-ZaB8Eq3eLYmWQG9avRFSPIr3_yAU0SPJl_kZyWiXRPtdWbT8PPa3S_rL36geCG8pZ6DKMonTad0HrGkaTZRWViElUrfiGjoTQKig';
        $apiUrl = 'https://api.pyrus.com/v4/';

        $telegramNickname = 'Art';
        $telegramId = 128513547;

        // create task
        $response = Http::withToken($token)->post($apiUrl . 'tasks', [
            'form_id' => 1418269, // from get /forms
            'fields' => [
                [
                    'id' => 3,
                    'value' => 'Test problem'
                ],
                [
                    'id' => 6,
                    'value' => $telegramNickname
                ],
                [
                    'id' => 15,
                    'value' => $telegramId
                ]
            ]
        ]);
        var_export($response->clientError());
        var_export($response->status());
        var_export($response->body());*/

    }
}

