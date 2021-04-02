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

$teste = 'a';

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(
    [
        'middleware'    => 'auth.transfer',
        'prefix'        => 'api'
    ],
    function () use ($router) {
        $router->post(
            '/transfer-values',
            function () {
                return ['hello' => 'world'];
            }
        );

        $router->post(
            '/detail-transfers',
            function () {
                return ['hello' => 'world'];
            }
        );
    }
);
