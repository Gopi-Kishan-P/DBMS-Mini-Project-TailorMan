let loginHead = document.getElementById("loginHead");
let createHead = document.getElementById("createHead");



function loginClicked() {
    if(!loginHead.classList.contains("cc-lc-active"))
        loginHead.classList.add("cc-lc-active");
    if(createHead.classList.contains("cc-lc-active"))
        createHead.classList.remove("cc-lc-active");
}

function createClicked() {
    if(loginHead.classList.contains("cc-lc-active"))
        loginHead.classList.remove("cc-lc-active");
    if(!createHead.classList.contains("cc-lc-active"))
        createHead.classList.add("cc-lc-active");
}