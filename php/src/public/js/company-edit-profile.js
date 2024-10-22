document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editProfileForm');
    const currentPasswordInput = document.getElementById('current-password');
    const backLink = document.querySelector('.back-link');
    let isFormChanged = false;

    form.addEventListener('input', function () {
        isFormChanged = true;
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (currentPasswordInput.value.trim() !== "") {
            checkCurrentPassword(currentPasswordInput.value)
                .then((isValid) => {
                    if (isValid) {
                        submitForm();
                    } else {
                        alert('Your current password is incorrect. Please try again.');
                    }
                })
                .catch((error) => {
                    console.error('Error checking password:', error);
                });
        } else {
            submitForm();
        }
    });

    function submitForm() {
        const hiddenDescriptionInput = document.getElementById('company-description-hidden');
        hiddenDescriptionInput.value = quillEditor.root.innerHTML;

        isFormChanged = false;
        form.submit();
    }

    async function checkCurrentPassword(currentPassword) {
        const response = await fetch('/check-current-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `current_password=${encodeURIComponent(currentPassword)}`
        });

        if (response.ok) {
            const result = await response.json();
            return result.isValid;
        } else {
            throw new Error('Failed to validate password');
        }
    }

    window.addEventListener('beforeunload', function (e) {
        if (isFormChanged) {
            const message = 'You have unsaved changes. Are you sure you want to leave this page?';
            e.returnValue = message;
            return message;
        }
    });

    form.addEventListener('submit', function () {
        const hiddenDescriptionInput = document.getElementById('company-description-hidden');
        hiddenDescriptionInput.value = quillEditor.root.innerHTML;
    });
});
