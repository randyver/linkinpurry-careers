<?php

class JobseekerEditProfileController 
{
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $jobseekerName = $this->getJobseekerName();
        View::render('jobseeker-edit-profile/index', [
            'jobseekerName' => $jobseekerName
        ]);
    }

    public function getJobseekerName() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['isValid' => false]);
            return;
        }
        
        $userId = $_SESSION['user_id'];
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT name FROM Users WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $companyName = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$companyName) {
            throw new Exception('No such name found.');
        }

        return $companyName['name'];
    }

    public function checkCurrentPassword()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['isValid' => false]);
            return;
        }

        $userId = $_SESSION['user_id'];
        $currentPassword = $_POST['current_password'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT password FROM Users WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            echo json_encode(['isValid' => true]);
        } else {
            echo json_encode(['isValid' => false]);
        }
    }

    public function updateProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $jobseekerName = $_POST['jobseeker_name'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        if (!empty($currentPassword)) {
            $query = 'SELECT password FROM Users WHERE user_id = :user_id';
            $statement = $pdo->prepare($query);
            $statement->execute(['user_id' => $userId]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($currentPassword, $user['password'])) {
                echo 'Incorrect password.';
                return;
            }

            if (!empty($newPassword)) {
                $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
                $query = 'UPDATE Users SET password = :new_password WHERE user_id = :user_id';
                $statement = $pdo->prepare($query);
                if (!$statement->execute(['new_password' => $newPasswordHashed, 'user_id' => $userId])) {
                    echo 'Failed to update password.';
                    return;
                }
            }
        }

        $query = 'UPDATE Users SET name = :jobseeker_name WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        if (!$statement->execute(['jobseeker_name' => $jobseekerName, 'user_id' => $userId])) {
            echo 'Failed to update name.';
            return;
        }

        $_SESSION['name'] = $jobseekerName;

        header('Location: /jobseeker-profile');
        exit;
    }
}