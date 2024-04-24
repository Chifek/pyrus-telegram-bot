<?php

namespace App\Services;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class TelegramService extends Telegram
{
    private string $botApiKey = '817087292:AAGCA9jQpZaFGkTedtpM50m9yBjXs-F4hQw'; // todo move to .env
    private string $botUsername = 'InionBot'; // todo move to .env

    /**
     * @throws TelegramException
     */
    public function __construct()
    {
        parent::__construct($this->botApiKey, $this->botUsername);
    }
}
