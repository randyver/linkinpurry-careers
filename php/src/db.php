<?php

$host = getenv('POSTGRES_HOST') ?: 'localhost';
$db = getenv('POSTGRES_DB') ?: 'app_database';
$user = getenv('POSTGRES_USER') ?: 'my_user';
$pass = getenv('POSTGRES_PASSWORD') ?: 'my_password';

$dsn = "pgsql:host=$host;port=5432;dbname=$db;";
?>