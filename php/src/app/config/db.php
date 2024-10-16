<?php

class Database {
    public static function getConnection() {
        $host = getenv('POSTGRES_HOST') ?: 'localhost';
        $db = getenv('POSTGRES_DB') ?: 'app_database';
        $user = getenv('POSTGRES_USER') ?: 'my_user';
        $pass = getenv('POSTGRES_PASSWORD') ?: 'my_password';

        $dsn = "pgsql:host=$host;port=5432;dbname=$db;";

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            return $pdo;
        } catch (PDOException $e) {
            throw new Exception('Connection failed: ' . $e->getMessage());
        }
    }
}