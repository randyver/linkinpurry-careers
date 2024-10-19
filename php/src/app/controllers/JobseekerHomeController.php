<?php

class JobseekerHomeController
{
    public function index()
    {
        View::render('jobseeker/home');
    }

    public function getRecommendationJobs()
    {
        require_once __DIR__ . '/../config/db.php';

        $pdo = Database::getConnection();
        $queryParams = [];

        // Base query: Most recent open jobs with the highest number of applicants
        $query = "
            SELECT jv.job_vacancy_id, jv.position, u.name AS company_name, jv.created_at, COUNT(a.application_id) AS applicant_count
            FROM JobVacancy jv
            JOIN Users u ON jv.company_id = u.user_id
            LEFT JOIN Application a ON jv.job_vacancy_id = a.job_vacancy_id
            WHERE jv.is_open = TRUE
        ";

        // If user is logged in, exclude jobs they've applied for
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $query .= " AND jv.job_vacancy_id NOT IN (
                SELECT job_vacancy_id FROM Application WHERE user_id = :userId
            )";
            $queryParams[':userId'] = $userId;
        }

        $query .= "
            GROUP BY jv.job_vacancy_id, u.name, jv.position, jv.created_at
            ORDER BY applicant_count DESC, jv.created_at DESC
            LIMIT 5
        ";

        // Prepare and execute the statement
        $statement = $pdo->prepare($query);
        $statement->execute($queryParams);
        $jobs = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Render the job recommendations view
        ob_start();
        include __DIR__ . '/../views/templates/recommendation-jobs-template.php';
        $htmlResponse = ob_get_clean();

        // Send the response
        header('Content-Type: text/html');
        echo $htmlResponse;
        exit;
    }


    public function getJobListings()
    {
        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        // Base query
        $query = 'SELECT jv.job_vacancy_id, jv.position, jv.description, jv.job_type, jv.location_type, jv.created_at, jv.updated_at, 
                         c.name AS company_name, cd.location AS company_location
                  FROM JobVacancy jv
                  JOIN Users c ON jv.company_id = c.user_id
                  JOIN CompanyDetail cd ON jv.company_id = cd.user_id
                  WHERE jv.is_open = TRUE';

        $params = [];

        // Handle search by job name (case-insensitive and partial match)
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = '%' . $_GET['search'] . '%';
            $query .= ' AND jv.position ILIKE :search';
            $params[':search'] = $searchTerm;
        }

        // Handle filter by posted month
        if (isset($_GET['posted-month']) && !empty($_GET['posted-month'])) {
            $postedMonth = $_GET['posted-month'];
            $query .= ' AND EXTRACT(MONTH FROM jv.created_at) = :postedMonth';
            $params[':postedMonth'] = $postedMonth;
        }

        // Handle filter by posted year
        if (isset($_GET['posted-year']) && !empty($_GET['posted-year'])) {
            $postedYear = $_GET['posted-year'];
            $query .= ' AND EXTRACT(YEAR FROM jv.created_at) = :postedYear';
            $params[':postedYear'] = $postedYear;
        }

        // Handle filter by location
        if (isset($_GET['location']) && !empty($_GET['location'])) {
            $locations = explode(',', $_GET['location']);
            $locationPlaceholders = [];
            foreach ($locations as $index => $location) {
                $placeholder = ":location$index";
                $locationPlaceholders[] = $placeholder;
                $params[$placeholder] = $location;
            }
            $query .= ' AND jv.location_type IN (' . implode(', ', $locationPlaceholders) . ')';
        }

        // Handle filter by job type
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $types = explode(',', $_GET['type']);
            $typePlaceholders = [];
            foreach ($types as $index => $type) {
                $placeholder = ":type$index";
                $typePlaceholders[] = $placeholder;
                $params[$placeholder] = $type;
            }
            $query .= ' AND jv.job_type IN (' . implode(', ', $typePlaceholders) . ')';
        }

        // Handle sorting
        if (isset($_GET['sort']) && $_GET['sort'] === 'oldest') {
            $query .= ' ORDER BY jv.created_at ASC';
        } else {
            $query .= ' ORDER BY jv.created_at DESC';
        }

        // Pagination
        $limit = 5;
        $page = isset($_GET['page']) && !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $query .= ' LIMIT :limit OFFSET :offset';
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        // Execute query
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $jobs = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Render using template
        ob_start();
        if ($page === 1 && empty($jobs)) {
            echo '<div>No job listings found.</div>';
        } else {
            include __DIR__ . '/../views/templates/job-listings-template.php';
        }
        $jobListingsHTML = ob_get_clean();

        echo $jobListingsHTML;
        exit;
    }
}
