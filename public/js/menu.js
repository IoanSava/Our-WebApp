"use strict";

function openNavBar() {
    var screenWidth = window.innerWidth;

    // adapt navigation bar width
    if (screenWidth < 620) {
        document.getElementById("sidenav").style.width = "100%";
    } else if (screenWidth < 960) {
        document.getElementById("sidenav").style.width = "35%";
        document.getElementById("mainid").style.marginLeft = "35%";
    } else {
        document.getElementById("sidenav").style.width = "15%";
        document.getElementById("mainid").style.marginLeft = "15%";
    }
    document.body.style.backgroundColor = "#a7e9af";
}

function closeNavBar() {
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("mainid").style.marginLeft = "0";
    document.body.style.backgroundColor = "#eef9bf";
}