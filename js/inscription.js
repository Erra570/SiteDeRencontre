var passwordInput = document.getElementById('password');
var confirmPasswordInput = document.getElementById('password_confirm');
var password_error = document.getElementById('passwordError');

confirmPasswordInput.addEventListener('input', function() {
    if (confirmPasswordInput.value === passwordInput.value) {
        password_error.style.display = 'none';
    } else {
        password_error.style.display = 'inline';
    }
});
