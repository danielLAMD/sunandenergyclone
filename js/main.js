/*
* MOON - Absolute Coming Soon Template
* Release Date: June 2017
* Last Update: June 2017
* Author: Madeon08
* Copyright (C) 2017 Madeon08
* This is a premium product available exclusively here : http://themeforest.net/user/Madeon08/portfolio
*/

/*  TABLE OF CONTENTS
    ---------------------------
    1. Loading / Opening
    2. Contact form functions
    3. Fullpage
    4. Newsletter
*/

/* ------------------------------------- */
/* 1. Loading / Opening ................ */
/* ------------------------------------- */

$(window).load(function() {
    "use strict";
    setTimeout(function() {
        $("#loading").addClass("loaded");
    }, 1000);

    setTimeout(function() {
        $("#loading").remove();
    }, 2210);
});

/* ------------------------------------- */
/* 2. Basic functions .................. */
/* ------------------------------------- */

function selectedfield() {
    var a = document.getElementById("reason");
    "placeholder" !== a.options[a.selectedIndex].value && $("#reason").removeClass("no-selection");
}

$(".form-control").on("focusin focusout", function() {
    $(this).siblings(".icon-fields").toggleClass("active");
});

$(document).ready(function() {
    "use strict";

    /* ------------------------------------- */
    /* 3. Fullpage ......................... */
    /* ------------------------------------- */

    $("#fullpage").fullpage({
        anchors: "123".split(""),
        navigationTooltips: "Home About Contact".split(" "),
        showActiveTooltip: !1,
        menu: "#menu",
        css3: !0,
        scrollingSpeed: 800,
        responsiveWidth: 992
    });

    /* ------------------------------------- */
    /* 7. Newsletter ....................... */
    /* ------------------------------------- */

    $("#notifyMe").notifyMe();
});