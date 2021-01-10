function place(name, location, extras) {
    element = document.getElementById(name);
    pageTitle = document.title;
    pageURL = window.location.pathname;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            element.innerHTML = this.responseText;
            extras();
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
    place("navbar", "/fragments/navbar.html", extras);
}

function fixEmail() {
    // I purposefully put a copyright symbol in the email address to fool low-quality
    // scrapers (which don't run JavaScript). This code removes it once loaded.
    span = document.getElementById("emailSpan");
    email = span.innerHTML.replaceAll("©", "@");
    span.innerHTML = '<a href="mailto:' + email + '">' + email + '</a>';
}

function jsCheck() {
    document.getElementById("jsCheck").remove();
    document.getElementById("main").style.display = "block";
}

function onLoad() {
    placeNavBar();
    jsCheck();
}

function onLoadContact() {
    onLoad()
    fixEmail()
}