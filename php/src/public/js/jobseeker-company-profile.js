document.addEventListener('DOMContentLoaded', function () {
    const filters = document.querySelectorAll('.filter select, .filter input[type="checkbox"]');
    const sortSelect = document.getElementById('sort-by');
    const jobListingsContainer = document.getElementById('job-listings-response');
    let page = 1;
    let isFetching = false;

    function updateFiltersAndFetchJobs(resetPage = false) {
        let params = new URLSearchParams();
    
        const postedMonth = document.getElementById('posted-month').value;
        if (postedMonth && postedMonth !== "Select month") {
            params.set('posted-month', postedMonth);
        }
    
        const postedYear = document.getElementById('posted-year').value;
        if (postedYear && postedYear !== "Select year") {
            params.set('posted-year', postedYear);
        }
    
        const locations = [];
        document.querySelectorAll('.filter-group input[id^="filter-location"]:checked').forEach(checkbox => {
            locations.push(checkbox.value);
        });
        if (locations.length > 0) {
            params.set('location', locations.join(','));
        }
    
        const types = [];
        document.querySelectorAll('.filter-group input[id^="filter-jobtype"]:checked').forEach(checkbox => {
            types.push(checkbox.value);
        });
        if (types.length > 0) {
            params.set('type', types.join(','));
        }
    
        const sortBy = sortSelect.value;
        if (sortBy && sortBy !== "Select sorting") {
            params.set('sort', sortBy);
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
        xhr.open('GET', `/company-profile-jobs?${queryString}`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                const jobs = JSON.parse(xhr.responseText); 
                const newJobListings = document.createElement('div');
                
                jobs.forEach(job => {
                    let jobElement = document.createElement('div');
                    jobElement.innerHTML = `<h3>${job.title}</h3><p>${job.description}</p>`;
                    newJobListings.appendChild(jobElement);
                });
                
                jobListingsContainer.appendChild(newJobListings);
                isFetching = false;
            }
        };
        xhr.send();
    }

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