document.getElementById('editJobForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const jobId = this.getAttribute('action').split('/').pop();

    const descriptionContent = quill.root.innerHTML;
    formData.append('description', descriptionContent);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/edit-job/${jobId}/update`, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                window.location.href = '/home-company';
            } else {
                alert(response.error || 'Failed to update the job');
            }
        } else {
            alert('An error occurred while processing the request');
        }
    };

    xhr.onerror = function () {
        alert('An error occurred during the request.');
    };

    xhr.send(formData);
});


const fileInput = document.getElementById('job-image-upload');
const fileNameDisplay = document.getElementById('file-name');
const fileLabel = document.querySelector('.file-label');

fileInput.addEventListener('change', function () {
    if (this.files && this.files.length > 0) {
        fileNameDisplay.textContent = this.files[0].name;
        fileNameDisplay.classList.add('active');
        fileLabel.classList.add('active');
    } else {
        fileNameDisplay.textContent = 'No file chosen';
        fileNameDisplay.classList.remove('active');
        fileLabel.classList.remove('active');
    }
});