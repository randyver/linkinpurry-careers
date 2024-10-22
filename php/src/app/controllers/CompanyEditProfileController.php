<?php

class CompanyEditProfileController 
{
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $companyDescription = $this->getCompanyDescription();
        $companyLocation = $this->getCompanyLocation();
        View::render('company-edit-profile/index', [
            'companyDescription' => $companyDescription,
            'companyLocation' => $companyLocation
        ]);
    }

    public function getCompanyDescription() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['isValid' => false]);
            return;
        }

        $userId = $_SESSION['user_id'];
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT about FROM CompanyDetail WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $companyDescription = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$companyDescription) {
            throw new Exception('No company description found.');
        }

        return $companyDescription['about'];
    }

    public function getCompanyLocation() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['isValid' => false]);
            return;
        }

        $userId = $_SESSION['user_id'];
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT location FROM CompanyDetail WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $companyLocation = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$companyLocation) {
            throw new Exception('No company location found.');
        }

        return $companyLocation['location'];
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
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $companyName = $_POST['company_name'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $companyLocation = $_POST['company_location'];
        $companyDescription = $_POST['company_description'];

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
                $statement->execute(['new_password' => $newPasswordHashed, 'user_id' => $userId]);
            }
        }

        $query = 'UPDATE CompanyDetail SET name = :company_name, location = :company_location, about = :company_description WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute([
            'company_name' => $companyName,
            'company_location' => $companyLocation,
            'company_description' => $companyDescription,
            'user_id' => $userId
        ]);

        header('Location: /company-profile');
        exit;
    }
}