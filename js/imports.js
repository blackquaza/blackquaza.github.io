function place(name, location, extras) {
    element = document.getElementById(name);
    pageTitle = document.title;
    pageURL = window.location.pathname;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            element.innerHTML = this.responseText;
            extras()
        }
    }
    xhttp.open("GET", location, true);
    xhttp.send();
}

function placeNavBar() {
    extras = function() {
        active = document.getElementById(document.title.replaceAll(" ", ""));
        active.classList.add("active");
    }
    place("navbar", "/fragments/navbar.html", extras)
}

function jsCheck() {
    document.getElementById("jsCheck").remove();
}

function onLoad() {
    placeNavBar();
    jsCheck();
}