const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('confirm_password');
const messageBox = document.getElementById('password-message');
const confirmMessageBox = document.getElementById('confirm-password-message');

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

function updatePasswordMessage(message, type, targetBox) {
    if (!targetBox) {
        return;
    }

    targetBox.textContent = message;
    targetBox.classList.remove('success', 'error');

    if (type === 'success') {
        targetBox.classList.add('success');
    } else if (type === 'error') {
        targetBox.classList.add('error');
    }
}

function validatePasswordMatch() {
    if (!passwordInput || !confirmInput || !messageBox || !confirmMessageBox) {
        return;
    }

    const passwordValue = passwordInput.value;
    const confirmValue = confirmInput.value;

    if (!passwordValue) {
        updatePasswordMessage('', '', messageBox);
        updatePasswordMessage('', '', confirmMessageBox);
        return;
    }

    if (passwordValue.length < 6) {
        const remaining = 6 - passwordValue.length;
        updatePasswordMessage(`Need ${remaining} more character${remaining === 1 ? '' : 's'}`, 'error', messageBox);
        updatePasswordMessage('', '', confirmMessageBox);
        return;
    }

    const hasSpecialChar = /[^A-Za-z0-9]/.test(passwordValue);

    if (!hasSpecialChar) {
        updatePasswordMessage('Include at least one special character', 'error', messageBox);
        updatePasswordMessage('', '', confirmMessageBox);
        return;
    }

    updatePasswordMessage('Strong password', 'success', messageBox);

    if (!confirmValue) {
        updatePasswordMessage('Type the same password below to confirm.', 'error', confirmMessageBox);
    } else if (passwordValue === confirmValue) {
        updatePasswordMessage('Passwords match.', 'success', confirmMessageBox);
    } else {
        updatePasswordMessage('Passwords do not match.', 'error', confirmMessageBox);
    }
}

if (passwordInput) {
    passwordInput.addEventListener('input', validatePasswordMatch);
}

if (confirmInput) {
    confirmInput.addEventListener('input', validatePasswordMatch);
}


