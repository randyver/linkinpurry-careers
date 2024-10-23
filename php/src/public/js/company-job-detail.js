function deleteJob(jobId) {
    if (confirm('Are you sure you want to delete this job?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/delete-job', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
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

document.addEventListener("DOMContentLoaded", function () {
    const openCloseButton = document.querySelector("#toggle-job-status-btn");

    openCloseButton.addEventListener("click", function () {
        const jobId = this.getAttribute("data-job-id");
        const isOpen = this.getAttribute("data-is-open") === "true";

        const xhr = new XMLHttpRequest();
        const url = isOpen ? "/close-job" : "/open-job";
        const method = "POST";

        xhr.open(method, url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    alert(response.message);

                    if (isOpen) {
                        openCloseButton.textContent = "Open Job";
                        openCloseButton.classList.remove("close-job-btn");
                        openCloseButton.classList.add("open-job-btn");
                        openCloseButton.setAttribute("data-is-open", "false");
                    } else {
                        openCloseButton.textContent = "Close Job";
                        openCloseButton.classList.remove("open-job-btn");
                        openCloseButton.classList.add("close-job-btn");
                        openCloseButton.setAttribute("data-is-open", "true");
                    }
                } else {
                    const response = JSON.parse(xhr.responseText);
                    alert(response.error || "An error occurred");
                }
            }
        };

        xhr.send("job_id=" + jobId);
    });
});
