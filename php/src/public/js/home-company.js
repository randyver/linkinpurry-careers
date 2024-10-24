document.getElementById("posted-month").addEventListener("change", function () {
  if (this.value === "clear") {
    this.selectedIndex = 0;
  }
});

document.getElementById("posted-year").addEventListener("change", function () {
  if (this.value === "clear") {
    this.selectedIndex = 0;
  }
});

const generalModal = document.getElementById("generalModal");
const modalMessage = document.getElementById("modalMessage");
const closeModalButtons = document.querySelectorAll(".close-modal");

closeModalButtons.forEach(button => {
  button.addEventListener('click', function() {
      generalModal.classList.remove('show');
      generalModal.classList.add('hidden');
  });
});

function deleteJob(jobId) {
    if (confirm('Are you sure you want to delete this job?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/delete-job', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const jobCard = document.querySelector(`.job-card[data-job-id='${jobId}']`);
                if (jobCard) {
                    jobCard.remove();
                }
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
        xhr.send(`job_id=${jobId}`);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        const deleteButton = e.target.closest('.widget-icon-button');
        if (deleteButton) {
            const jobId = deleteButton.closest('.job-card').dataset.jobId;
            deleteJob(jobId);
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const companyDescriptionContainer = document.getElementById('company-description');
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/get-company-description', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            companyDescriptionContainer.innerHTML = `<p>${xhr.responseText}</p>`;
        } else {
            companyDescriptionContainer.innerHTML = '<p>Failed to load company description.</p>';
        }
    };
    xhr.send();
});

document.addEventListener('DOMContentLoaded', function () {
    let page = 1;
    const limit = 20;
    let isLoading = false;
    const jobListingsContainer = document.getElementById('job-listings-response');
    const filters = document.querySelectorAll('.filter select, .filter input[type="checkbox"]');
    const sortSelect = document.querySelector('.sort-options select');
    const searchInput = document.querySelector('.search-input');
    let debounceTimeout;

    function fetchJobListings(reset = false) {
        if (isLoading) return;
        isLoading = true;

        const params = new URLSearchParams();

        const postedMonth = document.getElementById('posted-month').value;
        const postedYear = document.getElementById('posted-year').value;

        if (postedMonth && postedMonth !== "Select month") {
            params.set('posted-month', postedMonth);
        }

        if (postedYear && postedYear !== "Select year") {
            params.set('posted-year', postedYear);
        }

        const locations = [];
        document.querySelectorAll('.filter-group input[id="filter-location"]:checked').forEach(checkbox => {
            locations.push(checkbox.value);
        });
        if (locations.length > 0) {
            params.set('location', locations.join(','));
        }

        const types = [];
        document.querySelectorAll('.filter-group input[id="filter-jobtype"]:checked').forEach(checkbox => {
            types.push(checkbox.value);
        });
        if (types.length > 0) {
            params.set('type', types.join(','));
        }

        const sort = sortSelect.value;
        params.set('sort', sort);

        const searchTerm = searchInput.value.trim();
        if (searchTerm) {
            params.set('search', searchTerm);
        }

        params.set('page', page);
        params.set('limit', limit);

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `/get-company-job-listings?${params.toString()}`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                if (reset) {
                    jobListingsContainer.innerHTML = xhr.responseText;
                } else {
                    const newJobListings = document.createElement('div');
                    newJobListings.innerHTML = xhr.responseText;
                    jobListingsContainer.appendChild(newJobListings);
                }
                page++;
            }
            isLoading = false;
        };
        xhr.send();
    }

    filters.forEach(filter => {
        filter.addEventListener('change', function () {
            page = 1;
            fetchJobListings(true);
        });
    });

    sortSelect.addEventListener('change', function () {
        page = 1;
        fetchJobListings(true);
    });

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            page = 1;
            fetchJobListings(true);
        }, 300);
    });

    window.addEventListener('scroll', function () {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500 && !isLoading) {
            fetchJobListings();
        }
    });

    fetchJobListings();
});