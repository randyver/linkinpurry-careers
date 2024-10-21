document.querySelector('.save-btn')?.addEventListener('click', function () {
    var reasonContent = quill.root.innerHTML;
    var status = document.getElementById('status-select').value;
    const applicationId = document.querySelector('.applicant-section').dataset.applicationId;

    if (status === 'waiting') {
        alert("You cannot save while the status is 'waiting'.");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/manage-applicant/update", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.reload();
        } else {
            alert("Failed to update application");
        }
    };

    xhr.send("application_id=" + encodeURIComponent(applicationId) + "&status=" + encodeURIComponent(status) + "&reason=" + encodeURIComponent(reasonContent));
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