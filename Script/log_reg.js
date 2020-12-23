let loginHead = document.getElementById("loginHead");
let createHead = document.getElementById("createHead");

let username = document.getElementById("username")
let username_inp = document.getElementById("username-inp")

let passwd = document.getElementById("passwd")
let submit = document.getElementById("submit");

let log_form = document.getElementById("log-form");
let reg_form = document.getElementById("reg-form");

let lr_status = document.getElementById("lr-status");

function loginClicked() {
    if (!loginHead.classList.contains("cc-lc-active"))
        loginHead.classList.add("cc-lc-active");
    if (createHead.classList.contains("cc-lc-active"))
        createHead.classList.remove("cc-lc-active");

    if (log_form.classList.contains("d-none"))
        log_form.classList.remove("d-none");
    if (!reg_form.classList.contains("d-none"))
        reg_form.classList.add("d-none");

    // passwd.setAttribute("placeholder","Password")
    // username_inp.removeAttribute("required");


}

function registerClicked() {
    if (loginHead.classList.contains("cc-lc-active"))
        loginHead.classList.remove("cc-lc-active");
    if (!createHead.classList.contains("cc-lc-active"))
        createHead.classList.add("cc-lc-active");

    if (!log_form.classList.contains("d-none"))
        log_form.classList.add("d-none");
    if (reg_form.classList.contains("d-none"))
        reg_form.classList.remove("d-none");

    // if (username.classList.contains("cc-dnone"))
    //     username.classList.remove("cc-dnone");

}

function redirect() {
    // if (lr_status.textContent === "Logged in Successfully") {
    //     // alert("Login Succesful");
    // }
    window.location = "/index.php";
}