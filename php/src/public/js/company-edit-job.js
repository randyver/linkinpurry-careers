const fileInput = document.getElementById("job-image-upload");
const fileList = document.getElementById("file-list");
let selectedFiles = [];

fileInput.addEventListener("change", function () {
  const newFiles = Array.from(fileInput.files);
  selectedFiles.push(...newFiles);

  updateFileList();
});

function updateFileList() {
  fileList.innerHTML = "";

  selectedFiles.forEach((file, index) => {
    const listItem = document.createElement("li");
    listItem.textContent = file.name;

    const removeButton = document.createElement("button");
    removeButton.textContent = "Remove";
    removeButton.classList.add("remove-btn");
    removeButton.addEventListener("click", function () {
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

const currentAttachmentsList = document.getElementById(
  "current-attachments-list"
);
let filesToRemove = [];

if (currentAttachmentsList) {
  currentAttachmentsList.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-existing-attachment")) {
      const filePath = e.target.getAttribute("data-file-path");
      filesToRemove.push(filePath);
      e.target.closest("li").remove();
    }
  });
}

const generalModal = document.getElementById("generalModal");
const modalMessage = document.getElementById("modalMessage");
const closeModalButtons = document.querySelectorAll(".close-modal");

closeModalButtons.forEach(button => {
  button.addEventListener('click', function() {
    if (modalMessage.textContent === 'Job updated successfully.') {
        window.location.href = '/home-company';
    } else {
        generalModal.classList.remove('show');
        generalModal.classList.add('hidden');
    }
  });
});

document.getElementById("editJobForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const jobName = document.getElementById("job-name").value;
  const location = document.getElementById("job-location").value;
  const jobType = document.getElementById("job-type").value;
  const description = quill.root.innerHTML;

  const formData = new FormData();
  formData.append("job_name", jobName);
  formData.append("job_location", location);
  formData.append("job_type", jobType);
  formData.append("description", description);

  const jobId = this.getAttribute("action").split("/").pop();

  filesToRemove.forEach((filePath) =>
    formData.append("filesToRemove[]", filePath)
  );

  selectedFiles.forEach((file) => {
    formData.append("job_images[]", file);
  });

  const xhr = new XMLHttpRequest();
  xhr.open("POST", `/edit-job/${jobId}/update`, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        // show success message
        modalMessage.textContent = 'Job updated successfully.';
      } else {
        // show failure message
        modalMessage.textContent = 'Failed to update the job.';
      }
    } else {
      // show error message
      modalMessage.textContent = 'An error occurred while processing the request.';
    }
    // display modal
    generalModal.classList.remove('hidden');
    generalModal.classList.add('show');
  };

  xhr.onerror = function () {
    // show network error message
    modalMessage.textContent = 'An error occurred during the request.';
    // display modal
    generalModal.classList.remove('hidden');
    generalModal.classList.add('show');
  };

  xhr.send(formData);
});
