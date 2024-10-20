const fileInput = document.getElementById('job-image-upload');
const fileNameDisplay = document.getElementById('file-name');
const fileLabel = document.querySelector('.file-label');
const submitButton = document.querySelector('.save-btn');

fileInput.addEventListener('change', function() {
    if (this.files && this.files.length > 0) {
        fileNameDisplay.textContent = this.files[0].name;
        fileNameDisplay.classList.add('active');
        fileLabel.classList.add('active');
    } else {
        fileNameDisplay.textContent = "No file chosen";
        fileNameDisplay.classList.remove('active');
        fileLabel.classList.remove('active');
    }
});

submitButton.addEventListener('click', function(event) {
    event.preventDefault();

    const jobName = document.getElementById('job-name').value;
    const location = document.getElementById('job-location').value;
    const jobType = document.getElementById('job-type').value;
    const description = quill.root.innerHTML;
    const file = fileInput.files[0];

    if (jobName && location && jobType && description && file) {
        const formData = new FormData();
        formData.append('job_name', jobName);
        formData.append('location', location);
        formData.append('job_type', jobType);
        formData.append('description', description);
        formData.append('job_image', file);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/add-job/create', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Job posted successfully.');
                    window.location.href = "/home-company";
                } else {
                    alert('Error: ' + response.error);
                }
            } else {
                alert('An error occurred during the submission.');
            }
        };

        xhr.send(formData);
    } else {
        alert('Please fill out all fields and upload an image.');
    }
});