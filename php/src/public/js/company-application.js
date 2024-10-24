const responseModal = document.getElementById('responseModal');
const closeModalButtons = document.querySelectorAll('.close-modal-box');
const modalMessage = document.getElementById('modalMessage');

closeModalButtons.forEach(button => {
    button.addEventListener('click', function () {
        responseModal.classList.remove('show');
        responseModal.classList.add('hidden');
    });
});

document.querySelector('.save-btn')?.addEventListener('click', function () {
    const reasonContent = quill.root.innerHTML;
    const status = document.getElementById('status-select').value;
    const applicationId = document.querySelector('.applicant-section').dataset.applicationId;

    if (status === 'waiting') {
        // Tampilkan pesan waiting
        modalMessage.textContent = "You cannot save while the status is 'waiting'.";
        responseModal.classList.remove('hidden');
        responseModal.classList.add('show');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/manage-applicant/update", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.reload();
        } else {
            // Tampilkan pesan error
            modalMessage.textContent = "Failed to update application.";
            responseModal.classList.remove('hidden');
            responseModal.classList.add('show');
        }
    };

    xhr.send(
        "application_id=" + encodeURIComponent(applicationId) +
        "&status=" + encodeURIComponent(status) +
        "&reason=" + encodeURIComponent(reasonContent)
    );
});

var pdfModal = document.getElementById("pdfModal");
var viewCvBtn = document.getElementById("viewCvBtn");
var closeCvModal = pdfModal.getElementsByClassName("close")[0];

viewCvBtn.onclick = function () {
    var cvPath = viewCvBtn.getAttribute('data-cv-path');
    pdfModal.style.display = "block";
    document.getElementById("cvPdfViewer").src = cvPath;
};

closeCvModal.onclick = function () {
    pdfModal.style.display = "none";
};

window.onclick = function (event) {
    if (event.target == pdfModal) {
        pdfModal.style.display = "none";
    }
};

var videoModal = document.getElementById("videoModal");
var viewVideoBtn = document.getElementById("viewVideoBtn");
var closeVideoModal = videoModal.getElementsByClassName("close")[0];

viewVideoBtn.onclick = function () {
    var videoPath = viewVideoBtn.getAttribute('data-video-path');
    videoModal.style.display = "block";
    document.getElementById("videoPlayer").src = videoPath;
};

closeVideoModal.onclick = function () {
    videoModal.style.display = "none";
};

window.onclick = function (event) {
    if (event.target == videoModal) {
        videoModal.style.display = "none";
    }
};