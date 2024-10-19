<?php

require_once __DIR__ . '/app/core/Router.php';
require_once __DIR__ . '/app/core/View.php';

if (!session_id()) {
    session_start();
}

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');

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

// home job seeker
$router->get('/home-jobseeker', 'JobseekerHomeController@index');
$router->get('/get-job-listings', 'JobseekerHomeController@getJobListings');
$router->get('/get-recommendation-jobs', 'JobseekerHomeController@getRecommendationJobs');

// detail job
$router->get('/job/{id}', 'JobController@show');

// company
$router->get('/home-company', 'CompanyHomeController@index');
$router->get('/get-company-description', 'CompanyHomeController@getCompanyDescription');
$router->get('/get-company-job-listings', 'CompanyHomeController@getJobListings');
$router->post('/delete-job', 'CompanyJobController@deleteJob');

// application
$router->get('/job/{id}/application', 'ApplicationController@submitApplication');
$router->post('/job/{id}/application', 'ApplicationController@submitApplication');

// history
$router->get('/application-history', 'HistoryController@index');

// testing db
$router->get('/test-db', 'TestDbController@index');
$router->post('/test-db', 'TestDbController@index');

$router->dispatch($_SERVER['REQUEST_URI']);