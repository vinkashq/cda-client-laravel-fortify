<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::namespace('Vinkas\Cda\Client\Http\Controllers')
    ->prefix(Config::get('cda.path'))
    ->group(function (Router $router) {
        $router->get('/auth', 'CdaController@auth')->name('cda.auth');
        $router->get('/callback', 'CdaController@callback');
    });
