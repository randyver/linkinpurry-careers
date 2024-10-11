<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path == '/check_connection.php') {
    include 'check_connection.php';
} else {
    readfile(__DIR__ . '/public/index.html');
}
?>