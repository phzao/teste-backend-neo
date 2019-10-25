<?php

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

$router->group(['prefix'=>'api/v1'], function () use ($router) {
    $router->get('/documents', 'DocumentController@index');
    $router->get('/documents/{id}', 'DocumentController@show');
    $router->get('/documents/{cpf}/cpf', 'DocumentController@showByCPF');
    $router->get('/documents/{cnpj}/cnpj', 'DocumentController@showByCNPJ');
    $router->post('/documents', 'DocumentController@store');
    $router->put('/documents/{id}', 'DocumentController@store');
});
