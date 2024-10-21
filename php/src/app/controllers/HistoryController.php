<?php

class HistoryController {
    public function index() {
        require_once __DIR__ . '/../config/db.php';

        try {
            // Redirect jika belum login
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }

            $pdo = Database::getConnection();

            // Ambil data lamaran pekerjaan
            $stmt = $pdo->prepare("
                SELECT jv.*, c.name AS company_name, cd.location AS company_location, a.status
                FROM Application a
                JOIN JobVacancy jv ON a.job_vacancy_id = jv.job_vacancy_id
                JOIN Users c ON jv.company_id = c.user_id
                JOIN CompanyDetail cd ON c.user_id = cd.user_id
                WHERE a.user_id = :userId
            ");
            $stmt->execute([':userId' => $_SESSION['user_id']]);
            $appliedJobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Render view history
            View::render('history/index', [
                'appliedJobs' => $appliedJobs,
            ]);

        } catch (PDOException $e) {
            echo "Database Error: " . htmlspecialchars($e->getMessage());
        } catch (Exception $e) {
            echo "General Error: " . htmlspecialchars($e->getMessage());
        }
    }
}