<?php

class View
{
    public static function render($view, $data = [])
    {
        // Extract data array into variables so they can be accessed in the view
        extract($data);

        // Include the view file from the views directory
        require __DIR__ . '/../views/' . $view . '.php';
    }
}