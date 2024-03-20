<?php

namespace Tests;

use App\Services\PyrusApiService;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base_endpoint_returns_a_successful_response()
    {
        $pyrusApiService = new PyrusApiService();

        $token = $pyrusApiService->token();

        $this->assertGreaterThan(500, $token);
    }
}
