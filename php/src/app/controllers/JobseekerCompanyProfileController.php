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

        // Get request parameters
        $postedMonth = $_GET['posted-month'] ?? null;
        $postedYear = $_GET['posted-year'] ?? null;
        $locations = isset($_GET['location']) ? explode(',', $_GET['location']) : [];
        $types = isset($_GET['type']) ? explode(',', $_GET['type']) : [];
        $sort = $_GET['sort'] ?? 'recent';

        // Retrieve the company info and job listings
        $companyName = $this->getCompanyName($companyId);
        $companyDescription = $this->getCompanyDescription($companyId);
        $companyLocation = $this->getCompanyLocation($companyId);
        
        // Fetch jobs with the dynamic and request parameters
        $jobs = $this->getCompanyJobListings(
            $companyId, 
            $postedMonth, 
            $postedYear, 
            $locations, 
            $types, 
            $sort
        );

        // Render the view
        View::render('jobseeker-company-profile/index', [
            'companyName' => $companyName,
            'companyDescription' => $companyDescription,
            'companyLocation' => $companyLocation,
            'jobs' => $jobs
        ]);
    }

    public function getCompanyJobListings($companyId = null, $postedMonth = null, $postedYear = null, $locations = [], $types = [], $sort = 'recent')
    {
        if (!$companyId) {
            header('HTTP/1.1 400 Bad Request');
            echo 'Company ID is required.';
            exit;
        }

        $jobs = $this->getCompanyJobListingsData($companyId, $postedMonth, $postedYear, $locations, $types, $sort);

        return $jobs ? $jobs : [];
    }

    private function getCompanyJobListingsData($companyId, $postedMonth, $postedYear, $locations, $types, $sort)
    {
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT * FROM JobVacancy WHERE company_id = :company_id';
        $params = ['company_id' => $companyId];

        if ($postedMonth) {
            $query .= ' AND MONTH(created_at) = :posted_month';
            $params['posted_month'] = $postedMonth;
        }

        if ($postedYear) {
            $query .= ' AND YEAR(created_at) = :posted_year';
            $params['posted_year'] = $postedYear;
        }

        if (!empty($locations)) {
            $query .= ' AND location_type IN (' . implode(',', array_fill(0, count($locations), '?')) . ')';
            $params = array_merge($params, $locations);
        }

        if (!empty($types)) {
            $query .= ' AND job_type IN (' . implode(',', array_fill(0, count($types), '?')) . ')';
            $params = array_merge($params, $types);
        }

        if ($sort === 'recent') {
            $query .= ' ORDER BY created_at DESC';
        } else if ($sort === 'oldest') {
            $query .= ' ORDER BY created_at ASC';
        }

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