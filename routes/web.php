<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::namespace('Vinkas\Cda\Client\Http\Controllers')
    ->prefix(config('cda.path'))
    ->group(function (Router $router) {
        $router->get('/auth', 'CdaController@auth');
        $router->get('/callback', 'CdaController@callback');
    });
