<?php

class CompanyEditJobController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SESSION['role'] !== 'company') {
            header('Location: /404');
            exit();
        }
    }
    public function index($jobId)
    {
        try {
            require_once __DIR__ . '/../config/db.php';
            $pdo = Database::getConnection();

            // Fetch job details and its attachments
            $stmt = $pdo->prepare("
                SELECT jv.*, c.name AS company_name 
                FROM JobVacancy jv
                JOIN Users c ON jv.company_id = c.user_id
                WHERE jv.job_vacancy_id = :jobId AND jv.company_id = :companyId
            ");
            $stmt->execute([
                ':jobId' => $jobId,
                ':companyId' => $_SESSION['user_id']
            ]);

            $job = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the job belongs to the logged-in company
            if (!$job) {
                throw new Exception('Job not found or you are not authorized to edit this job.');
            }

            // Fetch all attachments
            $attachmentStmt = $pdo->prepare("SELECT file_path FROM JobVacancyAttachment WHERE job_vacancy_id = :jobId");
            $attachmentStmt->execute([':jobId' => $jobId]);
            $attachments = $attachmentStmt->fetchAll(PDO::FETCH_ASSOC);

            // Pass the job and attachments to the view
            View::render("company-edit-job/index", [
                'job' => $job,
                'attachments' => $attachments
            ]);
        } catch (PDOException $e) {
            echo "Database Error: " . htmlspecialchars($e->getMessage());
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    }

    public function editJob($jobId)
    {
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $stmt = $pdo->prepare("SELECT company_id FROM JobVacancy WHERE job_vacancy_id = :jobId");
                $stmt->execute([':jobId' => $jobId]);
                $job = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$job || $job['company_id'] != $_SESSION['user_id']) {
                    echo json_encode(['error' => 'You are not authorized to edit this job.']);
                    return;
                }

                $jobName = $_POST['job_name'];
                $location = $_POST['job_location'];
                $jobType = $_POST['job_type'];
                $description = $_POST['description'];
                $filesToRemove = $_POST['filesToRemove'] ?? [];

                if (empty($jobName) || empty($location) || empty($jobType) || empty($description)) {
                    echo json_encode(['error' => 'All fields are required.']);
                    return;
                }

                if (!empty($filesToRemove)) {
                    $uploadDirectory = __DIR__ . '/../../public/uploads/attachments/';
                    foreach ($filesToRemove as $filePath) {
                        $fullPath = $uploadDirectory . $filePath;
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }

                        $deleteStmt = $pdo->prepare("DELETE FROM JobVacancyAttachment WHERE file_path = :file_path AND job_vacancy_id = :jobId");
                        $deleteStmt->execute([
                            ':file_path' => $filePath,
                            ':jobId' => $jobId
                        ]);
                    }
                }

                if (isset($_FILES['job_images']) && count($_FILES['job_images']['name']) > 0) {
                    $uploadDirectory = __DIR__ . '/../../public/uploads/attachments/';
                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0755, true);
                    }

                    $fileCount = count($_FILES['job_images']['name']);
                    for ($i = 0; $i < $fileCount; $i++) {
                        $fileTmpPath = $_FILES['job_images']['tmp_name'][$i];
                        $fileName = $_FILES['job_images']['name'][$i];
                        $fileType = $_FILES['job_images']['type'][$i];

                        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!in_array($fileType, $allowedFileTypes)) {
                            echo json_encode(['error' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
                            return;
                        }

                        $newFileName = time() . "_" . basename($fileName);
                        $destPath = $uploadDirectory . $newFileName;

                        if (move_uploaded_file($fileTmpPath, $destPath)) {
                            $stmt = $pdo->prepare("
                                INSERT INTO JobVacancyAttachment (job_vacancy_id, file_path) 
                                VALUES (:job_vacancy_id, :file_path)
                            ");
                            $stmt->execute([
                                ':job_vacancy_id' => $jobId,
                                ':file_path' => $newFileName
                            ]);
                        } else {
                            echo json_encode(['error' => 'There was an error uploading the file.']);
                            return;
                        }
                    }
                }

                $stmt = $pdo->prepare("
                    UPDATE JobVacancy 
                    SET position = :job_name, location_type = :location, job_type = :job_type, description = :description 
                    WHERE job_vacancy_id = :jobId AND company_id = :company_id
                ");
                $stmt->execute([
                    ':job_name' => $jobName,
                    ':location' => $location,
                    ':job_type' => $jobType,
                    ':description' => $description,
                    ':jobId' => $jobId,
                    ':company_id' => $_SESSION['user_id']
                ]);

                echo json_encode(['success' => true, 'message' => 'Job updated successfully.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
        }
    }
}