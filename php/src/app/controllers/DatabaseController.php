<?php

class DatabaseController {
    public function checkConnection() {
        require_once __DIR__ . '/../config/db.php';
        
        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            $message = "Connected to the PostgreSQL database successfully!";
            $messageType = "success";
        } catch (PDOException $e) {
            $message = "Error: " . htmlspecialchars($e->getMessage());
            $messageType = "error";
        }

        View::render('db/check_connection', ['message' => $message, 'messageType' => $messageType]);
    }
}