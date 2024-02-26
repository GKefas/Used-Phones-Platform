//CLIENT VALIDATOR TOP SIDE INPUTS


function message(msg, label) {


    label.textContent = msg;
}

function hasNumber(str) {
    return /\d/.test(str);
}

const brand = document.getElementById('brand');
const model = document.getElementById('model');
const color = document.getElementById('color');
const ram = document.getElementById('ramSize');
const cores = document.getElementById('cores');
const size = document.getElementById('storageSize');
const os = document.getElementById('osVersion');
const price = document.getElementById('price');

brand.addEventListener('input', (event) => {

    let regex = /^[a-zA-Z\s]*$/;
    let label = document.getElementById('invalidBrand');

    if (regex.test(event.target.value)) {
        message('', label);
    } else {

        message("Brand has only letters!", label);
    }
});


model.addEventListener('input', (event) => {

    let regex = /^[a-zA-Z0-9\s]*$/;
    let label = document.getElementById('invalidModel');

    if (regex.test(event.target.value)) {
        message('', label);
    } else {
        message('Model has only letters or numbers!', label);
    }
});


color.addEventListener('input', (event) => {

    let regex = /^[a-zA-Z\s]*$/;
    let label = document.getElementById('invalidcolor');

    if (regex.test(event.target.value)) {
        message('', label);
    } else {
        message('Color has only letters!', label);
    }
});

ram.addEventListener('input', (event) => {

    let regex = /^[0-9]*$/;
    let label = document.getElementById('invalidRamSize');

    if (regex.test(event.target.value)) {
        message('', label);
    } else {
        message('RamSize is a number!', label);
    }
});

cores.addEventListener('input', (event) => {

    let regex = /^[0-9]*$/;
    let label = document.getElementById('invalidCores');

    if (regex.test(event.target.value)) {
        message('', label);
    } else {
        message('Cores is a numbers!', label);
    }
});

size.addEventListener('input', (event) => {

    let regex = /^[0-9]*$/;
    let label = document.getElementById('invalidStorageSize');

    if (regex.test(event.target.value)) {
        message('', label);
    } else {
        message('Storage size is a numbers!', label);
    }
});

os.addEventListener('input', (event) => {

    let regex = /^[a-zA-Z0-9.\s]*$/;
    let label = document.getElementById('invalidOsVersion');

    if (regex.test(event.target.value)) {
        message('', label);
    } else {
        message('Os Version has only letters or numbers!', label);
    }
});


price.addEventListener('input', (event) => {

    let regex = /^[0-9]*$/;
    let label = document.getElementById('invalidPrice');

    if (regex.test(event.target.value)) {
        message('', label);
    } else {
        message('Price is a numbers!', label);
    }
});




//FILE AND DESCREPTION CHECK



const descreption = document.getElementById("Descreption");
const letterCounter = document.getElementById('starting_counter');
const fileInput = document.getElementById('imageUpload');
const fileNameOutput = document.getElementById('imageName');
const invalidFile = document.getElementById('invalidFile');


descreption.addEventListener('input', (event) => {
    const target = event.target;
    const currentLetters = target.value.length;
    letterCounter.textContent = currentLetters;
});

fileInput.addEventListener('change', (event) => {
    if (fileInput.files.length > 0) {
        var file = fileInput.files[0];
    }

    if (file.type === 'image/jpeg' || file.type === 'image/jpg') {
        if (file.size <= 400 * 1024) {
            fileNameOutput.textContent = file.name;
            invalidFile.textContent = '';
        } else {
            invalidFile.textContent = 'Error:Image has to be lower than 400 KB';
            file.fileNameOutput.textContent = '';

        }
    } else {
        fileNameOutput.textContent = '';
        invalidFile.textContent = 'Error: Choose only images files';
    }

});



