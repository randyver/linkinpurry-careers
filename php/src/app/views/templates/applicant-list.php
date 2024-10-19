<?php if (!empty($applicants)): ?>
    <?php foreach ($applicants as $applicant): ?>
        <div class="status-row">
            <span class="applicant-name"><?php echo htmlspecialchars($applicant['applicant_name']); ?></span>
            <span class="status <?php echo strtolower(htmlspecialchars($applicant['status'])); ?>">
                <span class="status-label">Status:</span>
                <img src="../../../public/images/<?php echo htmlspecialchars(strtolower($applicant['status'])); ?>-icon.svg" alt="<?php echo htmlspecialchars($applicant['status']); ?> Icon" class="status-icon">
                <?php echo ucfirst(htmlspecialchars($applicant['status'])); ?>
            </span>
            <a href="#" class="details-link">
                <img src="../../../public/images/details-icon.svg" alt="Details Icon" class="details-icon">
                <span>Details</span>
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="status-row">
        <span class="applicant-name">No applicants found for this status.</span>
    </div>
<?php endif; ?>