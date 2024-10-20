<?php

class CompanyAddJobController
{
    public function index()
    {
        View::render("company-add-job/index");
    }

    public function addJob()
    {
        require_once __DIR__ . '/../config/db.php';

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $jobName = $_POST['job_name'];
                $location = $_POST['location'];
                $jobType = $_POST['job_type'];
                $description = $_POST['description'];
                $companyId = $_SESSION['user_id'];

                // Validate the form data
                if (empty($jobName) || empty($location) || empty($jobType) || empty($description)) {
                    echo json_encode(['error' => 'All fields are required.']);
                    return;
                }

                // Start a transaction
                $pdo = Database::getConnection();
                $pdo->beginTransaction();

                $stmt = $pdo->prepare("
                    INSERT INTO JobVacancy (company_id, position, location_type, job_type, description) 
                    VALUES (:company_id, :position, :location, :job_type, :description)
                ");
                $stmt->execute([
                    ':company_id' => $companyId,
                    ':position' => $jobName,
                    ':location' => $location,
                    ':job_type' => $jobType,
                    ':description' => $description
                ]);

                $jobVacancyId = $pdo->lastInsertId();

                if (isset($_FILES['job_image']) && $_FILES['job_image']['error'] === UPLOAD_ERR_OK) {
                    
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
                        $stmt = $pdo->prepare("
                            INSERT INTO JobVacancyAttachment (job_vacancy_id, file_path) 
                            VALUES (:job_vacancy_id, :file_path)
                        ");
                        $stmt->execute([
                            ':job_vacancy_id' => $jobVacancyId,
                            ':file_path' => $newFileName
                        ]);
                    } else {
                        echo json_encode(['error' => 'There was an error uploading the file.']);
                        $pdo->rollBack();
                        return;
                    }
                }

                $pdo->commit();
                echo json_encode(['success' => true, 'message' => 'Job posted successfully']);
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
        }
    }
}
