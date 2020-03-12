"use strict";

function openNavBar() {
    document.getElementById("sidenav").style.width = "15%";
    document.getElementById("main").style.marginLeft = "15%";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNavBar() {
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
    document.body.style.backgroundColor = "white";
}