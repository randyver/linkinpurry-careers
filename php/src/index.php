<?php

require_once __DIR__ . '/app/core/Router.php';
require_once __DIR__ . '/app/core/View.php';

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/check-connection', 'DatabaseController@checkConnection');

// register
$router->get('/register', 'RegisterController@register_index');
$router->get('/register-job-seeker', 'RegisterController@register_form_job_seeker');
$router->post('/register-job-seeker', 'RegisterController@register_form_job_seeker');
$router->get('/register-company', 'RegisterController@register_form_company');
$router->post('/register-company', 'RegisterController@register_form_company');

// login
$router->get('/login', 'LoginController@login_index');
$router->post('/login', 'LoginController@login_index');

// logout
$router->post('/logout', 'LoginController@logout');

// dashboard
$router->get('/dashboard', 'DashboardController@index');


// testing db
$router->get('/test-db', 'TestDbController@index');
$router->post('/test-db', 'TestDbController@index');

$router->dispatch($_SERVER['REQUEST_URI']);