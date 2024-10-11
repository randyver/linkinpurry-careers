document.getElementById('check-connection').addEventListener('click', function() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/check_connection.php', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('response').innerHTML = xhr.responseText;
        } else {
            document.getElementById('response').innerHTML = '<div style="color: red;">Error: Unexpected status code.</div>';
        }
    };

    xhr.onerror = function() {
        document.getElementById('response').innerHTML = '<div style="color: red;">Request error. Please try again.</div>';
    };

    xhr.send();
});