<?php foreach ($jobs as $job): ?>
    <div class="job-card">
        <div class="job-header">
            <div class="company-info">
                <a href="/company-profile/<?php echo htmlspecialchars($job['company_id']); ?>" style="text-decoration: none; color: inherit;">
                    <img src="../../../public/images/company-pic.png" alt="Company Logo" class="company-logo">
                    <div class="company-details">
                        <h3><?php echo htmlspecialchars($job['company_name']); ?></h3>
                        <p><?php echo htmlspecialchars($job['company_location']); ?></p>
                    </div>
                </a>
            </div>
            <div class="job-view">
                <a href="/job/<?php echo $job['job_vacancy_id']; ?>">
                    <button>View</button>
                </a>
            </div>
        </div>

        <div class="job-details">
            <h4><?php echo htmlspecialchars($job['position']); ?></h4>
            <div class="job-meta">
                <p><img src="../../../public/images/calendar-icon.svg" alt="Calendar Icon"> Posted: <?php echo date('jS F Y', strtotime($job['created_at'])); ?></p>
                <p><img src="../../../public/images/location-icon.svg" alt="Location Icon"> Location: <?php echo htmlspecialchars(ucfirst($job['location_type'])); ?></p>
                <p><img src="../../../public/images/type-icon.svg" alt="Type Icon"> Type: <?php echo htmlspecialchars(ucfirst($job['job_type'])); ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
