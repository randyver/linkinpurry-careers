<?php foreach ($jobs as $job): ?>
    <div class="job-card" data-job-id="<?php echo htmlspecialchars($job['job_vacancy_id']); ?>">
        <div class="job-title"><?php echo htmlspecialchars($job['position']); ?></div>

        <div class="job-info">
            <p><img src="../../../public/images/clock-icon.svg" alt="Clock Icon"> <?php echo date('j F Y', strtotime($job['created_at'])); ?></p>
            <p><img src="../../../public/images/location-icon.svg" alt="Location Icon"> <?php echo ucfirst(htmlspecialchars($job['location_type'])); ?></p>
            <p><img src="../../../public/images/type-icon.svg" alt="Type Icon"> <?php echo ucfirst(htmlspecialchars($job['job_type'])); ?></p>
        </div>

        <div class="job-widget">
            <button class="widget-icon-button">
                <img src="../../../public/images/trash-icon.svg" alt="Trash Icon" class="widget-icon">
            </button>

            <a href="/edit-job/<?php echo htmlspecialchars($job['job_vacancy_id']); ?>" class="widget-icon-link">
                <img src="../../../public/images/edit-icon.svg" alt="Edit Icon" class="widget-icon">
            </a>

            <a href="#" class="widget-icon-link" onclick="expandJob(<?php echo htmlspecialchars($job['job_vacancy_id']); ?>)">
                <img src="../../../public/images/expand-icon.svg" alt="Expand Icon" class="widget-icon">
            </a>
        </div>
    </div>
<?php endforeach; ?>