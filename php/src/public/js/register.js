function makeXHRRequest(method, url, params, onSuccess, onError) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            onSuccess(JSON.parse(xhr.responseText));
        } else {
            if (onError) {
                onError('Error: Unexpected status code ' + xhr.status);
            }
        }
    };

    xhr.onerror = function() {
        if (onError) {
            onError('Request error. Please try again.');
        }
    };

    xhr.send(params);
}

// Event listener untuk form registrasi
document.getElementById('register-job-seeker').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    // Validasi password
    if (password !== confirmPassword) {
        showMessage('Passwords do not match.', 'error');
        return;
    }

    // Jika validasi berhasil, kirim data registrasi menggunakan makeXHRRequest
    const params = `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&confirm_password=${encodeURIComponent(confirmPassword)}`;

    makeXHRRequest('POST', '/register_form_job_seeker', params, function(response) {
        if (response.success) {
            showMessage('Registration successful!', 'success');
            document.getElementById('register-job-seeker').reset();
        } else {
            showMessage(response.error, 'error');
        }
    }, function(errorMessage) {
        showMessage(errorMessage, 'error');
    });
});


// Function untuk menampilkan pesan
function showMessage(message, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.style.display = 'block';
    messageDiv.style.color = type === 'success' ? 'green' : 'red';
    messageDiv.textContent = message;
}
