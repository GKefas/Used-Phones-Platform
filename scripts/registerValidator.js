const password = document.getElementById('password');
const confPassword = document.getElementById('confirmPassword');
const passwordMatchErrorDisplay = document.getElementById('confirmPasswordError');

const passwordErrorDisplay = document.getElementById('passwordErrorDisplay');

const email = document.getElementById('email');
const emailErrorDisplay = document.getElementById('emailErrorDisplay');

let regExPass = /^[a-z0-9!@_-]+$/;
let regExEmail = /^[a-zΑ-Ζ0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;


confPassword.addEventListener('input', event => {
    
    if (password.value != confPassword.value) {
        passwordMatchErrorDisplay.textContent = 'password doesnt match';
    } else {
        passwordMatchErrorDisplay.textContent = '';
    }
});

password.addEventListener('input', event => {

    if (password.value != confPassword.value) {
        passwordMatchErrorDisplay.textContent = 'password doesnt match';
    } else {
        passwordMatchErrorDisplay.textContent = '';
    }

    if (confPassword.value == '') {
        passwordMatchErrorDisplay.textContent = '';
    }
});



password.addEventListener('blur', event => {
    if (event.target.value.length < 8 && event.target.value.length != '') {
        passwordErrorDisplay.textContent = "Password length must be at least 8 characters";
    } else {

        if (regExPass.test(event.target.value) || event.target.value.length == '') {
            passwordErrorDisplay.textContent = '';
        } else {
            passwordErrorDisplay.textContent = "Use only lowercase Latin letters, numerical digits, and the symbols !, -, _,@";

        }
    }
});

email.addEventListener('blur', event => {

    if (regExEmail.test(event.target.value) || event.target.value.length == '') {
        emailErrorDisplay.textContent = '';
    } else {
        emailErrorDisplay.textContent = 'The email you entered is not valid';
    }

});







