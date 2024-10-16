<?php if (!empty($jobs)): ?>
    <?php foreach ($jobs as $job): ?>
        <a href="#" class="recommendation-item-link">
            <div class="recommendation-item">
                <div class="recommendation-details">
                    <strong><?php echo htmlspecialchars($job['position']); ?></strong>
                    <p><?php echo htmlspecialchars($job['company_name']); ?></p>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
<?php else: ?>
    <p>No job recommendations available at the moment.</p>
<?php endif; ?>