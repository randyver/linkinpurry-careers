<?php

require_once __DIR__ . '/app/core/Router.php';
require_once __DIR__ . '/app/core/View.php';

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/check-connection', 'DatabaseController@checkConnection');
// $router->get('/user/login', 'UserController@login');
// $router->post('/user/login', 'UserController@authenticate');

$router->dispatch($_SERVER['REQUEST_URI']);