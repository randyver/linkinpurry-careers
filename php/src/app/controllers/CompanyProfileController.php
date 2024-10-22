<?php

class CompanyProfileController
{
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $companyDescription = $this->getCompanyDescription();
        $companyLocation = $this->getCompanyLocation();
        View::render('company-profile/index', [
            'companyDescription' => $companyDescription,
            'companyLocation' => $companyLocation
        ]);
    }

    public function getCompanyDescription() {
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
}
