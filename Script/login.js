let loginHead = document.getElementById("loginHead");
let createHead = document.getElementById("createHead");

let username = document.getElementById("username")
let username_inp = document.getElementById("username-inp")

let passwd = document.getElementById("passwd")
let submit = document.getElementById("submit");



function loginClicked() {
    if (!loginHead.classList.contains("cc-lc-active"))
        loginHead.classList.add("cc-lc-active");
    if (createHead.classList.contains("cc-lc-active"))
        createHead.classList.remove("cc-lc-active");

    if (!username.classList.contains("cc-dnone"))
        username.classList.add("cc-dnone");
    submit.innerText = "Login";

    passwd.setAttribute("placeholder","Password")
    username_inp.removeAttribute("required");


}

function createClicked() {
    if (loginHead.classList.contains("cc-lc-active"))
        loginHead.classList.remove("cc-lc-active");
    if (!createHead.classList.contains("cc-lc-active"))
        createHead.classList.add("cc-lc-active");

    if (username.classList.contains("cc-dnone"))
        username.classList.remove("cc-dnone");

    submit.innerText = "Register";
    passwd.setAttribute("placeholder","New Password")

    username_inp.setAttributeNode(document.createAttribute("required"));
}