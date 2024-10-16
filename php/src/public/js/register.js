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

