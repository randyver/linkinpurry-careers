<?php

class CompanyHomeController
{
    public function index()
    {
        View::render('company/home');
    }

    public function getCompanyDescription() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company') {
            header('HTTP/1.1 403 Forbidden');
            echo 'Unauthorized access.';
            exit;
        }

        $userId = $_SESSION['user_id'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT about FROM CompanyDetail WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $company = $statement->fetch(PDO::FETCH_ASSOC);

        if ($company) {
            echo htmlspecialchars($company['about']);
        } else {
            echo 'No description available.';
        }
        exit;
    }

    public function getJobListings()
    {
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $userId = $_SESSION['user_id'];

        // Base query
        $query = 'SELECT job_vacancy_id, position, created_at, location_type, job_type 
                  FROM JobVacancy 
                  WHERE company_id = :company_id';
        $params = ['company_id' => $userId];

        // Handle filters
        if (!empty($_GET['posted-month'])) {
            $query .= ' AND EXTRACT(MONTH FROM created_at) = :postedMonth';
            $params['postedMonth'] = $_GET['posted-month'];
        }

        if (!empty($_GET['posted-year'])) {
            $query .= ' AND EXTRACT(YEAR FROM created_at) = :postedYear';
            $params['postedYear'] = $_GET['posted-year'];
        }

        // Handle search by job title
        if (!empty($_GET['search'])) {
            $query .= ' AND LOWER(position) LIKE :searchTerm';
            $params['searchTerm'] = '%' . strtolower($_GET['search']) . '%';
        }

        // Handle location filter
        if (!empty($_GET['location'])) {
            $locations = explode(',', $_GET['location']);
            $locationPlaceholders = [];
            foreach ($locations as $index => $location) {
                $placeholder = ":location$index";
                $locationPlaceholders[] = $placeholder;
                $params[$placeholder] = $location;
            }
            $query .= ' AND location_type IN (' . implode(', ', $locationPlaceholders) . ')';
        }

        // Handle job type filter
        if (!empty($_GET['type'])) {
            $types = explode(',', $_GET['type']);
            $typePlaceholders = [];
            foreach ($types as $index => $type) {
                $placeholder = ":type$index";
                $typePlaceholders[] = $placeholder;
                $params[$placeholder] = $type;
            }
            $query .= ' AND job_type IN (' . implode(', ', $typePlaceholders) . ')';
        }

        // Handle sorting
        if (isset($_GET['sort']) && $_GET['sort'] === 'oldest') {
            $query .= ' ORDER BY created_at ASC';
        } else {
            $query .= ' ORDER BY created_at DESC';
        }

        // Handle pagination
        $limit = !empty($_GET['limit']) ? (int)$_GET['limit'] : 20;
        $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $query .= ' LIMIT :limit OFFSET :offset';
        $params['limit'] = $limit;
        $params['offset'] = $offset;

        // Execute the query
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $jobs = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Render job listings
        ob_start();
        if ($page === 1 && empty($jobs)) {
            echo '<div class="job-card no-jobs">
                    <div class="job-details">
                        <h4>No jobs found</h4>
                        <p>There are currently no available job listings. Please check back later!</p>
                    </div>
                </div>';
        } else {
            include __DIR__ . '/../views/templates/company-job-listings-template.php';
        }
        $jobListingsHTML = ob_get_clean();

        echo $jobListingsHTML;
        exit;
    }
}
