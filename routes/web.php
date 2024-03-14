<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\BotController;
use App\Http\Controllers\PyrusController;

$router->post('/pyrus-webhook', [PyrusController::class, 'webhook']);
$router->get('/integration/auth', [PyrusController::class, 'integrationAuth']);
$router->post('/authorize', [PyrusController::class, 'auth']);

$router->post('/bot-webhook', [BotController::class, 'webhook']);
$router->get('/auth', [BotController::class, 'auth']);
