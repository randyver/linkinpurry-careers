<?php
require_once 'db.php';

header('Content-Type: text/html');

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "<div style='color: green;'>Connected to the PostgreSQL database successfully!</div>";
} catch (PDOException $e) {
    echo "<div style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>