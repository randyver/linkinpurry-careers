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
  fetchRecentJobs();

  function fetchRecentJobs() {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', '/get-recommendation-jobs', true);
      xhr.onload = function () {
          if (xhr.status === 200) {
              const recommendationsContainer = document.getElementById('recommendation-response');
              recommendationsContainer.innerHTML = xhr.responseText;
          }
      };
      xhr.send();
  }
});


document.addEventListener('DOMContentLoaded', function () {
  const filters = document.querySelectorAll('.filter select, .filter input[type="checkbox"]');
  const sortSelect = document.querySelector('.sort-options select');
  const jobListingsContainer = document.getElementById('job-listings-response');
  const searchInput = document.querySelector('.search-input');
  let debounceTimeout;
  let page = 1;
  let isFetching = false;

  function updateFiltersAndFetchJobs(resetPage = false) {
      let params = new URLSearchParams(window.location.search);

      const searchTerm = searchInput.value.trim();
      if (searchTerm) {
          params.set('search', searchTerm);
      } else {
          params.delete('search');
      }

      const postedMonth = document.getElementById('posted-month').value;
      if (postedMonth && postedMonth !== "Select month") {
          params.set('posted-month', postedMonth);
      } else {
          params.delete('posted-month');
      }

      const postedYear = document.getElementById('posted-year').value;
      if (postedYear && postedYear !== "Select year") {
          params.set('posted-year', postedYear);
      } else {
          params.delete('posted-year');
      }

      const locations = [];
      document.querySelectorAll('.filter-group input[id="filter-location"]').forEach(checkbox => {
          if (checkbox.checked) {
              locations.push(checkbox.value);
          }
      });
      if (locations.length > 0) {
          params.set('location', locations.join(','));
      } else {
          params.delete('location');
      }

      const types = [];
      document.querySelectorAll('.filter-group input[id="filter-jobtype"]').forEach(checkbox => {
          if (checkbox.checked) {
              types.push(checkbox.value);
          }
      });
      if (types.length > 0) {
          params.set('type', types.join(','));
      } else {
          params.delete('type');
      }

      const sort = sortSelect.value;
      if (sort) {
          params.set('sort', sort);
      } else {
          params.delete('sort');
      }

      if (resetPage) {
          page = 1;
          jobListingsContainer.innerHTML = '';
      }

      params.set('page', page);
      fetchJobListings(params.toString());
  }

  function fetchJobListings(queryString) {
      if (isFetching) return;
      isFetching = true;

      const xhr = new XMLHttpRequest();
      xhr.open('GET', `/get-job-listings?${queryString}`, true);
      xhr.onload = function () {
          if (xhr.status === 200) {
              const newJobListings = document.createElement('div');
              newJobListings.innerHTML = xhr.responseText;
              jobListingsContainer.appendChild(newJobListings);
              isFetching = false;
          }
      };
      xhr.send();
  }

  searchInput.addEventListener('input', function () {
      clearTimeout(debounceTimeout);
      debounceTimeout = setTimeout(() => {
          updateFiltersAndFetchJobs(true);
      }, 500);
  });

  filters.forEach(filter => {
      filter.addEventListener('change', function () {
          updateFiltersAndFetchJobs(true);
      });
  });

  sortSelect.addEventListener('change', function () {
      updateFiltersAndFetchJobs(true);
  });

  window.addEventListener('scroll', function () {
      if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500 && !isFetching) {
          page++;
          updateFiltersAndFetchJobs();
      }
  });

  updateFiltersAndFetchJobs();
});