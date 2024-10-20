<?php

class CompanyEditJobController
{
    public function index($jobId)
    {
        try {
            require_once __DIR__ . '/../config/db.php';
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("
                SELECT jv.*, jva.file_path 
                FROM JobVacancy jv 
                LEFT JOIN JobVacancyAttachment jva ON jv.job_vacancy_id = jva.job_vacancy_id
                WHERE jv.job_vacancy_id = :jobId AND jv.company_id = :companyId
            ");
            $stmt->execute([
                ':jobId' => $jobId,
                ':companyId' => $_SESSION['user_id']
            ]);

            // Fetch the job data
            $job = $stmt->fetch(PDO::FETCH_ASSOC);

            // If no job found, throw an exception
            if (!$job) {
                throw new Exception('Job not found or you are not authorized to edit this job.');
            }

            // Render the view and pass the job data
            View::render("company-edit-job/index", [
                'job' => $job
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
                $jobName = $_POST['job_name'];
                $location = $_POST['job_location'];
                $jobType = $_POST['job_type'];
                $description = $_POST['description'];

                // Validate form data
                if (empty($jobName) || empty($location) || empty($jobType) || empty($description)) {
                    echo json_encode(['error' => 'All fields are required.']);
                    return;
                }

                // Check if a new file is uploaded
                if (isset($_FILES['job_image']) && $_FILES['job_image']['error'] === UPLOAD_ERR_OK) {
                    $stmt = $pdo->prepare("SELECT file_path FROM JobVacancyAttachment WHERE job_vacancy_id = :jobId");
                    $stmt->execute([':jobId' => $jobId]);
                    $oldAttachment = $stmt->fetch(PDO::FETCH_ASSOC);

                    $uploadDirectory = __DIR__ . '/../../public/uploads/attachments/';

                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0755, true);
                    }

                    $fileTmpPath = $_FILES['job_image']['tmp_name'];
                    $fileName = $_FILES['job_image']['name'];
                    $fileType = $_FILES['job_image']['type'];

                    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($fileType, $allowedFileTypes)) {
                        echo json_encode(['error' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
                        return;
                    }

                    $newFileName = time() . "_" . basename($fileName);
                    $destPath = $uploadDirectory . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        if (!empty($oldAttachment['file_path'])) {
                            $oldFilePath = $uploadDirectory . $oldAttachment['file_path'];
                            if (file_exists($oldFilePath)) {
                                unlink($oldFilePath);
                            }
                        }

                        $stmt = $pdo->prepare("UPDATE JobVacancyAttachment SET file_path = :file_path WHERE job_vacancy_id = :jobId");
                        $stmt->execute([
                            ':file_path' => $newFileName,
                            ':jobId' => $jobId
                        ]);
                    } else {
                        echo json_encode(['error' => 'There was an error uploading the file.']);
                        return;
                    }
                }

                // Update the job vacancy data
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
