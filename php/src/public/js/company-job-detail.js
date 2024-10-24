const generalModal = document.getElementById("generalModal");
const modalMessage = document.getElementById("modalMessage");
const closeModalButtons = document.querySelectorAll(".close-modal");
const confirmButton = document.getElementById('confirmButton');
const cancelButton = document.getElementById('cancelButton');
let currentJobId = null; // variable to store the jobId to be deleted

// Function to hide the modal
function closeModal() {
    generalModal.classList.remove('show');
    generalModal.classList.add('hidden');
    currentJobId = null; // reset jobId
}

// Close modal when the close button or No button is clicked
closeModalButtons.forEach(button => {
    button.addEventListener('click', closeModal);
});
cancelButton.addEventListener('click', closeModal);

// Function to show modal and confirm deletion
function deleteJob(jobId) {
    modalMessage.textContent = 'Are you sure you want to delete this job?';
    generalModal.classList.remove('hidden');
    generalModal.classList.add('show');
    currentJobId = jobId; // store jobId
}

// Function to confirm the job deletion
confirmButton.addEventListener('click', function() {
    if (currentJobId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/delete-job', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const jobCard = document.querySelector(`.job-card[data-job-id='${currentJobId}']`);
                if (jobCard) {
                    jobCard.remove(); // remove job card from the DOM
                }
                closeModal(); // hide modal after job is deleted
            } else if (xhr.status === 403) {
                modalMessage.textContent = 'You are not authorized to delete this job.';
                generalModal.classList.remove('hidden');
                generalModal.classList.add('show');
            } else {
                modalMessage.textContent = 'Failed to delete job. Please try again.';
                generalModal.classList.remove('hidden');
                generalModal.classList.add('show');
            }
        };
        xhr.send(`job_id=${currentJobId}`);
    }
});

// Event listener for the delete button click on job cards
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('.delete-job-icon');
        if (deleteButton) {
            const jobId = deleteButton.closest('.job-card').dataset.jobId;
            deleteJob(jobId); // open the confirmation modal
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
            showModal('Failed to fetch applicants. Please try again.');
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
                    showModal(response.message);

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
                    showModal(response.message);
                }
            }
        };

        xhr.send("job_id=" + jobId);
    });
});
