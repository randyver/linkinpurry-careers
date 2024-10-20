<?php

class CompanyApplicationController
{
    public function index($application_id)
    {
        require_once __DIR__ . '/../config/db.php';

        try {
            $pdo = Database::getConnection();
            $user_id = $_SESSION['user_id'];

            // Fetch application data and validate company ownership based on application_id
            $stmt = $pdo->prepare("
                SELECT a.*, u.name, j.position, u.name as applicant_name, u.email as applicant_email, j.company_id
                FROM Application a
                JOIN Users u ON a.user_id = u.user_id
                JOIN JobVacancy j ON a.job_vacancy_id = j.job_vacancy_id
                WHERE a.application_id = :application_id
            ");
            $stmt->execute(['application_id' => $application_id]);
            $application = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$application) {
                throw new Exception('Application not found');
            }

            // Check if the logged-in user is the owner of the job vacancy
            if ($application['company_id'] != $user_id) {
                throw new Exception('Unauthorized access: You do not own this job vacancy');
            }

            // Render the view and pass application data
            View::render("company-application/index", ['application' => $application]);
        } catch (PDOException $e) {
            echo "Database Error: " . htmlspecialchars($e->getMessage());
        } catch (Exception $e) {
            echo "General Error: " . htmlspecialchars($e->getMessage());
        }
    }

    public function update()
    {
        require_once __DIR__ . '/../config/db.php';

        try {
            if (!isset($_POST['application_id'], $_POST['status'], $_POST['reason'])) {
                throw new Exception('Invalid input');
            }

            $application_id = $_POST['application_id'];
            $status = $_POST['status'];
            $reason = $_POST['reason'];
            $user_id = $_SESSION['user_id'];

            $pdo = Database::getConnection();

            // Fetch application data and validate company ownership before updating
            $stmt = $pdo->prepare("
                SELECT j.company_id
                FROM Application a
                JOIN JobVacancy j ON a.job_vacancy_id = j.job_vacancy_id
                WHERE a.application_id = :application_id
            ");
            $stmt->execute(['application_id' => $application_id]);
            $application = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$application) {
                throw new Exception('Application not found');
            }

            // Check if the logged-in user is the owner of the job vacancy
            if ($application['company_id'] != $user_id) {
                throw new Exception('Unauthorized access: You do not own this job vacancy');
            }

            // Update the application
            $stmt = $pdo->prepare("UPDATE Application SET status = :status, status_reason = :reason WHERE application_id = :application_id");
            $stmt->execute([
                ':status' => $status,
                ':reason' => $reason,
                ':application_id' => $application_id
            ]);

            // Send success response
            echo json_encode(['message' => 'Application updated successfully']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => 'General Error: ' . $e->getMessage()]);
        }
    }
}