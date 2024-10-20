document.querySelector('.save-btn')?.addEventListener('click', function() {
    var reasonContent = quill.root.innerHTML;
    var status = document.getElementById('status-select').value;
    const applicationId = document.querySelector('.applicant-section').dataset.applicationId;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/manage-applicant/update", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            alert("Application updated successfully");
            window.location.reload();
        } else {
            alert("Failed to update application");
        }
    };

    xhr.send("application_id=" + encodeURIComponent(applicationId) + "&status=" + encodeURIComponent(status) + "&reason=" + encodeURIComponent(reasonContent));
});