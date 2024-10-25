<div class="job-card">
    <div class="job-title">
        <h2><?php echo htmlspecialchars($jobTitle); ?></h2>
    </div>
    <div class="job-details">
        <p>Location: <?php echo htmlspecialchars($jobLocation); ?></p>
        <p>Type: <?php echo htmlspecialchars($jobType); ?></p>
    </div>
    <div class="view-button">
        <a href="/job/<?php echo htmlspecialchars($jobId); ?>" class="button-view">View</a>
    </div>
</div>