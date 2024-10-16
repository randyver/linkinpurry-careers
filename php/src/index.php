<?php

require_once __DIR__ . '/app/core/Router.php';
require_once __DIR__ . '/app/core/View.php';

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/check-connection', 'DatabaseController@checkConnection');
$router->post('/register', 'RegisterController@register_form');
$router->get('/register', 'RegisterController@register_page');
// $router->get('/user/login', 'UserController@login');
// $router->post('/user/login', 'UserController@authenticate');

$router->get('/test-db', 'TestDbController@index');
$router->post('/test-db', 'TestDbController@index');

$router->dispatch($_SERVER['REQUEST_URI']);