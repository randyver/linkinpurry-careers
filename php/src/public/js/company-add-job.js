const fileInput = document.getElementById('job-image-upload');
const fileList = document.getElementById('file-list');
let selectedFiles = [];

fileInput.addEventListener('change', function() {
    const newFiles = Array.from(fileInput.files);
    selectedFiles.push(...newFiles);

    updateFileList();
});

function updateFileList() {
    fileList.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const listItem = document.createElement('li');
        listItem.textContent = file.name;

        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.classList.add('remove-btn');
        removeButton.addEventListener('click', function() {
            removeFile(index);
        });

        listItem.appendChild(removeButton);
        fileList.appendChild(listItem);
    });
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateFileList();
}

const submitButton = document.querySelector('.save-btn');
const responseModal = document.getElementById('responseModal');
const closeModalButtons = document.querySelectorAll('.close-modal');
const modalMessage = document.getElementById('modalMessage');

closeModalButtons.forEach(button => {
    button.addEventListener('click', function() {
        if (modalMessage.textContent === 'Job posted successfully.') {
            window.location.href = '/home-company';
        } else {
            responseModal.classList.remove('show');
            responseModal.classList.add('hidden');
        }
    });
});

submitButton.addEventListener('click', function(event) {
    event.preventDefault();

    const jobName = document.getElementById('job-name').value;
    const location = document.getElementById('job-location').value;
    const jobType = document.getElementById('job-type').value;
    const description = quill.root.innerHTML;

    if (jobName && location && jobType && description) {
        const formData = new FormData();
        formData.append('job_name', jobName);
        formData.append('location', location);
        formData.append('job_type', jobType);
        formData.append('description', description);

        selectedFiles.forEach(file => {
            formData.append('job_images[]', file);
        });

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/add-job/create', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    modalMessage.textContent = 'Job posted successfully.';
                } else {
                    modalMessage.textContent = 'Error: ' + response.error;
                }
            } else {
                modalMessage.textContent = 'An error occurred during the submission.';
            }

            // Show modal after setting the message
            responseModal.classList.remove('hidden');
            responseModal.classList.add('show');
        };

        xhr.send(formData);
    } else {
        modalMessage.textContent = 'Please fill out all fields.';
        responseModal.classList.remove('hidden');
        responseModal.classList.add('show');
    }
});