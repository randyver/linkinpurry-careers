<?php

class HomeController {
    public function index() {
        // $data = [
        //     'title' => 'Home Page',
        //     'message' => 'Welcome to the Home Page!',
        // ];

        View::render('jobseeker/home');
    }
}