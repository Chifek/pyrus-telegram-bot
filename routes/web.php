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

$router->post('/', function () use ($router) {
    file_put_contents('test.txt', $_POST);
    return $router->app->version();
});

$router->post('/pyrus-webhook', 'PyrusController@webhook');

$router->post('/bot-webhook', 'BotController@webhook');

$router->get('/auth', 'BotController@auth');
