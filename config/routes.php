<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});

Router::get('/get', 'App\Controller\RouteController::get');
//Router::get('/get', 'App\Controller\TestController@get');
//Router::get('/get', [App\Controller\IndexController::class, 'get']);

Router::post('/hello', [App\Controller\IndexController::class, 'hello']);
Router::get('/hello', [App\Controller\IndexController::class, 'hello']);