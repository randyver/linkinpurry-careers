const dropdownArrow = document.getElementById("dropdown-arrow");
const dropdownMenu = document.getElementById("dropdown-menu");

dropdownArrow.addEventListener("click", () => {
  dropdownMenu.style.display =
    dropdownMenu.style.display === "none" || dropdownMenu.style.display === ""
      ? "block"
      : "none";
});

window.addEventListener("click", (e) => {
  if (!dropdownArrow.contains(e.target) && !dropdownMenu.contains(e.target)) {
    dropdownMenu.style.display = "none";
  }
});

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