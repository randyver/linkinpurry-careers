<?php

class JobSeekerProfileController
{
    public function index() {
        $jobSeekerEmail = $this->getJobseekerEmail();
        $jobsAppliedNum = $this->getJobsAppliedNum();
        View::render('jobseeker-profile/index', [
            'email' => $jobSeekerEmail,
            'jobsAppliedNum' => $jobsAppliedNum
        ]);
    }

    public function getJobseekerEmail() {
        $userId = $_SESSION['user_id'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT email FROM Users WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $jobseekerEmail = $statement->fetch(PDO::FETCH_ASSOC);

        return $jobseekerEmail['email'];
    }

    public function getJobsAppliedNum() {
        $userId = $_SESSION['user_id'];

        require_once __DIR__ . '/../config/db.php';
        $pdo = Database::getConnection();

        $query = 'SELECT COUNT(job_vacancy_id) AS applied_count FROM Application WHERE user_id = :user_id';
        $statement = $pdo->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $jobsAppliedNum = $statement->fetch(PDO::FETCH_ASSOC);

        return $jobsAppliedNum['applied_count'];
    }
}