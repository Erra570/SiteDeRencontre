function confirmPassword(){
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('password_confirm');
    var password_error = document.getElementById('password_error');

    confirmPasswordInput.addEventListener('input', function() {
        if (confirmPasswordInput.value == passwordInput.value) {
            password_error.style.display = 'none';
            document.getElementById("submit").type="submit";
        }
        else {
            password_error.style.display = 'inline';
            document.getElementById("submit").type="button";
        }
    });
}

