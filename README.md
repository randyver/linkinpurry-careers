# Tugas Besar IF3110 2024/2025

<a id="readme-top"></a>
<br />
<div align="center">
    <img src="php/src/public/images/logo-dark.png" alt="LinkinPurry Logo">
    <h3>LinkinPurry – Your Bridge to Opportunity</h3>
</div>

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#results">Results</a></li>
    <li><a href="#contributors">Contributors</a></li>
    <li><a href="#tasks-allocation">Tasks Allocation</a></li>
  </ol>
</details>

## About The Project

LinkinPurry is a platform designed to connect job seekers with the right job opportunities and empower companies to upload and manage job listings effortlessly. Inspired by Purry the Platypus and the challenges faced by the agents of O.W.C.A., LinkinPurry serves as a solution to bridge the gap between those seeking employment and organizations offering exciting career prospects.

At LinkinPurry, we are dedicated to making the job search and recruitment experience smooth, efficient, and successful for both individuals and businesses. Our platform offers key features such as job search filtering, easy job listing management, and a user-friendly interface, ensuring an optimal experience for all users.

Whether you’re a job seeker looking for the perfect role or a company seeking top talent, LinkinPurry is here to support you every step of the way.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Getting Started

To access this web locally on your device, there are some prerequisites and installation steps you need to follow.

### Prerequisites

1. Docker: Install Docker Desktop on your device
<br>Refer to Docker's official installation guide for your operating system.</br>

### Installation

1. Clone this repository
<br>Begin by cloning the project repository from GitHub:</br>
   ```sh
   git clone https://github.com/Labpro-21/if3110-tubes-2024-k02-19
   ```
2. Launch Docker Desktop
<br>Ensure that Docker Desktop is installed and running on your machine.</br>
3. Establish connection to the database
<br>Use the following command to build and run the Docker containers, which include the application and database</br>
   ```sh
   docker compose up --build
   ```
4. Access the Application
<br>Once the Docker containers are running, open your web browser and navigate to:</br>
    ```sh
    localhost:8080
    ```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Results
1. Home - Not Logged in
<img src="image/landing-page.png">
<img src="image/landing-page-lighthouse.png">
2. Log In
<img src="image/login.png">
<img src="image/login-lighthouse.png">
3. Sign In
<img src="image/signup1.png">
<img src="image/signup1-lighthouse.png">
<img src="image/signup2.png">
<img src="image/signup2-lighthouse.png">
4. Home - Jobseeker
<img src="image/home-jobseeker.png">
<img src="image/home-jobseeker-lighthouse.png">
5. Job Detail - Jobseeker
<img src="image/job-detail-jobseeker.png">
<img src="image/job-detail-job-seekerlighthouse.png">
6. Applications Page
<img src="image/apply.png">
<img src="image/apply-lighthouse.png">
7. Application History
<img src="image/history.png">
<img src="image/history-lighthouse.png">
8. Profile - Job Seeker
<img src="image/profile-jobseeker.png">
<img src="image/profile-jobseeker-lighthouse.png">
9. Edit Profile - Job Seeker
<img src="image/edit-profile-jobseeker.png">
<img src="image/edit-profile-jobseeker-lighthouse.png">
10. Company Profile - Job Seeker
<img src="image/company-profile-jobseeker.png">
<img src="image/company-profile-jobseeker-lighthouse.png">
11. Home - Company
<img src="image/home-company.png">
<img src="image/home-company-lighthouse.png">
12. Add Job
<img src="image/add-job.png">
<img src="image/add-job-lighthouse.png">
13. Job Detail - Company
<img src="image/job-detail-company.png">
<img src="image/job-detail-company-lighthouse.png">
14. Edit Job
<img src="image/edit-job.png">
<img src="image/edit-job-lighthouse.png">
15. Application Detail
<img src="image/application-detail.png">
<img src="image/application-detail-lighthouse.png">
16. Profile - Company
<img src="image/profile-company.png">
<img src="image/profile-company-lighthouse.png">
17. Edit Profile - Company
<img src="image/edit-profile-company.png">
<img src="image/edit-profile-company-lighthouse.png">
18. About
<img src="image/about.png">
<img src="image/about-lighthouse.png">

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<table>
  <tr>
    <td style="text-align: center;">
      <img src="php/src/public/images/salsa-pic.png" alt="Salsabiila's Picture" width="150" height="150" style="border-radius: 50%;">
      <p>Salsabiila</p>
      <p>13522062</p>
    </td>
    <td style="text-align: center;">
      <img src="php/src/public/images/randy-pic.png" alt="Randy Verdian's Picture" width="150" height="150" style="border-radius: 50%;">
      <p>Randy Verdian</p>
      <p>13522067</p>
    </td>
    <td style="text-align: center;">
      <img src="php/src/public/images/juan-pic.png" alt="Juan Alfred Widjaya's Picture" width="150" height="150" style="border-radius: 50%;">
      <p>Juan Alfred Widjaya</p>
      <p>13522073</p>
    </td>
  </tr>
</table>

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Tasks Allocation
1. **Server-side**  
   - Login: 13522067  
   - Register: 13522067  
   - Navbar: 13522073  
   - Footer: 13522067  
   - About: 13522062  

    Company 
   - Home: 13522073  
   - Add Job: 13522073  
   - Job Detail: 13522073  
   - Edit Job: 13522073  
   - Application Detail: 13522073  
   - Profile: 13522062  
   - Edit Profile: 13522062  

    Job Seeker 
   - Home: 13522073  
   - Job Detail: 13522067  
   - Company Profile: 13522062  
   - Application Page: 13522067  
   - Application History: 13522067  
   - Profile: 13522062  
   - Edit Profile: 13522062

2. **Client-side**
   - Login: 13522067  
   - Register: 13522067  
   - Navbar: 13522073  
   - Footer: 13522067  
   - About: 13522062  

    Company  
   - Home: 13522073  
   - Add Job: 13522073  
   - Job Detail: 13522073  
   - Edit Job: 13522073  
   - Application Detail: 13522073  
   - Profile: 13522062  
   - Edit Profile: 13522062  

    Job Seeker  
   - Home: 13522073  
   - Job Detail: 13522067  
   - Company Profile: 13522062  
   - Application Page: 13522067  
   - Application History: 13522067  
   - Profile: 13522062  
   - Edit Profile: 13522062

<p align="right">(<a href="#readme-top">back to top</a>)</p>