function placeNavBar() {
    place("navbar", "/fragments/navbar.html")
}

function place(name, location) {
    element = document.getElementById(name);
    pageTitle = document.title;
    pageURL = window.location.pathname;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            element.innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", location, true);
    xhttp.send();
}

function jsCheck() {
    document.getElementById("jsCheck").remove();
}

function onLoad() {
    placeNavBar();
    jsCheck();
}