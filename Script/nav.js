function change() {
    let menu = document.getElementById("menu");
    if (menu.getAttribute("src") == "images/menu.svg")
        menu.setAttribute("src", "images/x.svg");
    else if (menu.getAttribute("src") == "images/x.svg")
        menu.setAttribute("src", "images/menu.svg");
}