function makeXHRRequest(method, url, onSuccess, onError) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            onSuccess(xhr.responseText);
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

    xhr.send();
}

document.getElementById('check-connection').addEventListener('click', function() {
    makeXHRRequest('GET', '/check-connection', function(response) {
        document.getElementById('response').innerHTML = response;
    }, function(errorMessage) {
        document.getElementById('response').innerHTML = '<div style="color: red;">' + errorMessage + '</div>';
    });
});