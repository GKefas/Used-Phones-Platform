
const deleteButton = document.getElementById("deleteButton");
const blur = document.getElementById("blur");
const alertBox = document.getElementById("alertBox");
const ok = document.getElementById("yes");
const cancel = document.getElementById("no");



deleteButton.addEventListener('mouseover', (event) => {
    if (alertBox.style.pointerEvents != 'auto') {
        deleteButton.classList.add("fa-shake");
    }
    else {
        deleteButton.style.cursor = 'default';
    }

});

deleteButton.addEventListener('mouseleave', (event) => {
    deleteButton.classList.remove("fa-shake");
});



deleteButton.addEventListener('click', (event) => {
    blur.style.filter = 'blur(5px)';
    document.body.style.pointerEvents = 'none';
    document.body.style.userSelect = 'none';
    alertBox.style.opacity = "1";
    alertBox.style.pointerEvents = "auto";

});

no.addEventListener('click', (event) => {
    blur.style.filter = 'blur(0)';
    alertBox.style.opacity = "0";
    alertBox.style.pointerEvents = "none";
    document.body.style.pointerEvents = 'auto';
    document.body.style.userSelect = 'auto';
    deleteButton.style.cursor = 'pointer';
});




