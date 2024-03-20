<?php

namespace App\Services;

class PyrusApiService
{

    public function __construct()
    {
        //ClientID: ext@44a2e482-9b57-4a32-8f7b-c3dfab25409c
        //Secret: Cz1jkMwhYnGjJIgaoDkNiwJh-JgBxPJDvWqwimeBXnL6Z5pjRBCkEsd2~eiQhL6aNUD2iLDp9PsJOHSaUUwKcMaYwdmV2BIC
    }

    /**
     * @link https://pyrus.com/ru/help/integration-development/api#post-token
     *
     * @return void
     */
    public function token()
    {
        // take client_id, secret
        // todo send POST /token
    }

    /**
     * @link https://pyrus.com/ru/help/integration-development/api#post-getmessage
     *
     * @return void
     */
    public function getMessage()
    {
        // todo send POST /token
    }

    public function call()
    {

    }

    public function attachcallrecord()
    {

    }
}
