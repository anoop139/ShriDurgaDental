const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('confirm_password');
const messageBox = document.getElementById('password-message');

function clearSignupFields() {
    const usernameInput = document.getElementById('username');
    if (usernameInput) {
        usernameInput.value = '';
    }

    if (passwordInput) {
        passwordInput.value = '';
    }

    if (confirmInput) {
        confirmInput.value = '';
    }
}

document.addEventListener('DOMContentLoaded', clearSignupFields);

function validatePasswordMatch() {
    if (!passwordInput || !confirmInput || !messageBox) {
        return;
    }

    if (!confirmInput.value) {
        messageBox.textContent = '';
        return;
    }

    if (passwordInput.value.length < 6) {
        messageBox.textContent = 'Password should be at least 6 characters.';
    } else if (passwordInput.value !== confirmInput.value) {
        messageBox.textContent = 'Passwords do not match.';
    } else {
        messageBox.textContent = 'Passwords match.';
    }
}

if (passwordInput) {
    passwordInput.addEventListener('input', validatePasswordMatch);
}

if (confirmInput) {
    confirmInput.addEventListener('input', validatePasswordMatch);
}