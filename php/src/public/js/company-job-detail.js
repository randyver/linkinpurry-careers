function deleteJob(jobId) {
    if (confirm('Are you sure you want to delete this job?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/delete-job', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert('Job deleted successfully');
                window.location.href = '/home-company';
            } else if (xhr.status === 403) {
                alert('You are not authorized to delete this job.');
            } else {
                alert('Failed to delete job. Please try again.');
            }
        };
        xhr.send(`job_id=${jobId}`);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('.delete-job-icon');
        if (deleteButton) {
            const jobId = deleteButton.closest('.job-card').dataset.jobId;
            deleteJob(jobId);
        }
    });
});

function fetchApplicants(jobId, status) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `/get-applicants?job_id=${jobId}&status=${status}`, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const statusRowsContainer = document.querySelector('.status-rows');
            statusRowsContainer.innerHTML = xhr.responseText;
        } else {
            alert('Failed to fetch applicants. Please try again.');
        }
    };
    xhr.send();
}

document.addEventListener('DOMContentLoaded', function () {
    const filterSelect = document.querySelector('.filter-options select');
    const jobId = document.querySelector('.job-card').dataset.jobId;

    filterSelect.addEventListener('change', function () {
        const selectedStatus = filterSelect.value;
        fetchApplicants(jobId, selectedStatus);
    });

    fetchApplicants(jobId, 'all');
});