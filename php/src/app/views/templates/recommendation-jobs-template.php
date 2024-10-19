<?php if (!empty($jobs)): ?>
    <?php foreach ($jobs as $job): ?>
        <a href="/job/<?php echo htmlspecialchars($job['job_vacancy_id']); ?>" class="recommendation-item-link">
            <div class="recommendation-item">
                <div class="recommendation-details">
                    <strong><?php echo htmlspecialchars($job['position']); ?></strong>
                    <p><?php echo htmlspecialchars($job['company_name']); ?></p>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
<?php else: ?>
    <div class="recommendation-item">
        <div class="recommendation-details">
            <strong>Sorry!</strong>
            <p>No job recommendations available at the moment.</p>
        </div>
    </div>
<?php endif; ?>