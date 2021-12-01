const inputs = document.querySelectorAll('.user-detail-field input');
const showPasswordEyes = document.querySelectorAll('.show-password-eye');
const passwordInputs = document.querySelectorAll('.user-password');

inputs.forEach((value, index) => {
    value.addEventListener('focus', () => {
        value.parentElement.classList.add('focus');
    });

    value.addEventListener('blur', () => {
        if (value.value == "") {
            value.parentElement.classList.remove('focus');
        }
    });    
});

showPasswordEyes.forEach((eye, i) => {
    eye.addEventListener('mousedown', () => {
        eye.style.color = '#000000';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
        let node = eye.previousElementSibling;
        if (node.classList.contains('user-password')) {
            node.type = 'text';
        }
    });

    eye.addEventListener('mouseup', () => {
        eye.style.color = '#999999';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
        let node = eye.previousElementSibling;
        if (node.classList.contains('user-password')) {
            node.type = 'password';
        }
    });

    eye.addEventListener('mouseleave', () => {
        eye.style.color = '#999999';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
        let node = eye.previousElementSibling;
        if (node.classList.contains('user-password')) {
            node.type = 'password';
        }
    });
});
