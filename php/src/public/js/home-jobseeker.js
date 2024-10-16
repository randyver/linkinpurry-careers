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
  const filters = document.querySelectorAll('.filter select, .filter input[type="checkbox"]');
  const sortSelect = document.querySelector('.sort-options select');
  const jobListingsContainer = document.querySelector('.job-listings-response');
  const searchInput = document.querySelector('.search-input');
  let debounceTimeout;
  let page = 1;
  let isFetching = false;

  function updateFiltersAndFetchJobs(resetPage = false) {
      let params = new URLSearchParams(window.location.search);

      // Add the search term
      const searchTerm = searchInput.value.trim();
      if (searchTerm) {
          params.set('search', searchTerm);
      } else {
          params.delete('search');
      }

      // Handle posted month
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

      // Handle location filters
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

      // Handle job type filters
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

      // Handle sorting
      const sort = sortSelect.value;
      if (sort) {
          params.set('sort', sort);
      } else {
          params.delete('sort');
      }

      // Reset page to 1 if filters or sorting is updated
      if (resetPage) {
          page = 1;
          jobListingsContainer.innerHTML = ''; // Clear existing listings
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

  // Add event listener to search input with debounce
  searchInput.addEventListener('input', function () {
      clearTimeout(debounceTimeout);
      debounceTimeout = setTimeout(() => {
          updateFiltersAndFetchJobs(true); // Reset page and fetch new results
      }, 500); // 500ms debounce delay
  });

  // Event listener for filters and sort options
  filters.forEach(filter => {
      filter.addEventListener('change', function () {
          updateFiltersAndFetchJobs(true);  // Reset page when filter changes
      });
  });

  sortSelect.addEventListener('change', function () {
      updateFiltersAndFetchJobs(true);  // Reset page when sorting changes
  });

  // Infinite scroll implementation
  window.addEventListener('scroll', function () {
      if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500 && !isFetching) {
          // Near the bottom of the page, load the next page
          page++;
          updateFiltersAndFetchJobs();
      }
  });

  // Initial fetch of job listings
  updateFiltersAndFetchJobs();
});