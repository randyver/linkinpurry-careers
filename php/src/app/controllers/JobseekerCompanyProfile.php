<?php

class JobseekerCompanyProfileController
{
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'company') {
            header('HTTP/1.1 403 Forbidden');
            echo 'Unauthorized access.';
            exit;
        }

        $companyName = $this->getCompanyName();
        $companyDescription = $this->getCompanyDescription();
        $companyLocation = $this->getCompanyLocation();
        View::render('company-profile/index', [
            'companyName' => $companyName,
            'companyDescription' => $companyDescription,
            'companyLocation' => $companyLocation
        ]);
    }

    public function getCompanyDescription() {
        
    }

    public function getCompanyLocation() {
        
    }

    public function getCompanyName() {
        
    }
}
