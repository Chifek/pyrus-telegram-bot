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

$router->post('/pyrus-webhook', 'PyrusController@webhook');
$router->get('/pulse', 'PyrusController@pulse');
$router->get('/integration/auth', 'PyrusController@integrationAuth');
$router->post('/authorize', 'PyrusController@authorizeConfirm');
$router->post('/getavailablenumbers', 'PyrusController@getAvailableNumbers');
$router->post('/sendmessage', 'PyrusController@sendMessage');
$router->post('/toggle', 'PyrusController@toggle');
$router->post('/event', 'PyrusController@event');

$router->post('/bot-webhook', 'BotController@webhook');
$router->get('/auth', 'BotController@auth');
