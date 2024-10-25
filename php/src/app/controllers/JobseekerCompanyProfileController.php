<?php

class JobseekerCompanyProfileController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SESSION['role'] !== 'jobseeker') {
            header('Location: /404');
            exit();
        }
    }

    public function index($companyId)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if ($_SESSION['role'] !== 'jobseeker') {
            header('HTTP/1.1 403 Forbidden');
            echo 'Unauthorized access.';
            exit;
        }

        // Retrieve the company info and job listings
        $companyName = $this->getCompanyName($companyId);
        $companyDescription = $this->getCompanyDescription($companyId);
        $companyLocation = $this->getCompanyLocation($companyId);
        $jobs = $this->getCompanyJobListings($companyId);

        // Render the view
        View::render('jobseeker-company-profile/index', [
            'companyName' => $companyName,
            'companyDescription' => $companyDescription,
            'companyLocation' => $companyLocation,
            'jobs' => $jobs
        ]);
    }

    private function getCompanyJobListings($companyId)
    {
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT * FROM JobVacancy WHERE company_id = :company_id';
        $params = ['company_id' => $companyId];

        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $jobs = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $jobs ? $jobs : [];
    }

    public function getCompanyName($companyId) {
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT name FROM Users WHERE user_id = :company_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['company_id' => $companyId]);
        $company = $statement->fetch(PDO::FETCH_ASSOC);

        return $company ? $company['name'] : null;
    }

    public function getCompanyDescription($companyId) {
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT about FROM CompanyDetail WHERE user_id = :company_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['company_id' => $companyId]);
        $company = $statement->fetch(PDO::FETCH_ASSOC);

        return $company ? $company['about'] : null;
    }

    public function getCompanyLocation($companyId) {
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT location FROM CompanyDetail WHERE user_id = :company_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['company_id' => $companyId]);
        $company = $statement->fetch(PDO::FETCH_ASSOC);

        return $company ? $company['location'] : null;
    }
}