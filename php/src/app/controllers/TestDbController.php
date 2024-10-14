<?php

class TestDbController {
    public function index() {
        require_once __DIR__ . '/../config/db.php';
        $results = [];
        $query = '';
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = trim($_POST['query']);

            try {
                $pdo = Database::getConnection();
                $stmt = $pdo->query($query);
                $results = $stmt->fetchAll();

            } catch (PDOException $e) {
                $error = "Error: " . htmlspecialchars($e->getMessage());
            } catch (Exception $e) {
                $error = "General Error: " . htmlspecialchars($e->getMessage());
            }
        }

        View::render('test-db/db_query', [
            'results' => $results,
            'query' => $query,
            'error' => $error,
        ]);
    }
}