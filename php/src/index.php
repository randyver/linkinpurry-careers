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

// job seeker profile
$router->get('/jobseeker-profile', 'JobSeekerProfileController@index');

// job seeker edit profile
$router->get('/jobseeker-edit-profile', 'JobseekerEditProfileController@index');
$router->post('/check-current-password', 'JobseekerEditProfileController@checkCurrentPassword');
$router->post('/jobseeker-update-profile', 'JobseekerEditProfileController@updateProfile');

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

// company detail job
$router->get('/company-job/{id}', 'CompanyJobController@index');
$router->get('/get-applicants', 'CompanyJobController@getApplicantsByStatus');

// company application
$router->get('/manage-applicant/{application_id}', 'CompanyApplicationController@index');
$router->post('/manage-applicant/update', 'CompanyApplicationController@update');

// company add job
$router->get('/add-job', 'CompanyAddJobController@index');
$router->post('/add-job/create', 'CompanyAddJobController@addJob');

// company edit job
$router->get('/edit-job/{id}', 'CompanyEditJobController@index');
$router->post('/edit-job/{id}/update', 'CompanyEditJobController@editJob');

// company profile
$router->get('/company-profile', 'CompanyProfileController@index');

// company edit profile
$router->get('/company-edit-profile', 'CompanyEditProfileController@index');
$router->post('/check-current-password', 'CompanyEditProfileController@checkCurrentPassword');
$router->post('/company-update-profile', 'CompanyEditProfileController@updateProfile');

// not found
$router->get('/404', 'NotFoundController@index');

// testing db
$router->get('/test-db', 'TestDbController@index');
$router->post('/test-db', 'TestDbController@index');

$router->dispatch($_SERVER['REQUEST_URI']);