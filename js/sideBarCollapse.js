var menuIconDashboard = document.getElementById("navBarDashboard").querySelector(".menuToggler");
var menuIconSideBar = document.getElementById("sidebarHeader").querySelector(".menuToggler");
var sideBar = document.querySelector(".sideBarMenu");
var title = document.getElementById("navBarDashboard").querySelector(".headerDashboardTitle");

window.onload = function () {

    if (!sideBar.classList.contains("hide")) { //sidebar esta aberta
        menuIconDashboard.classList.add("hide");
    }

    menuIconDashboard.addEventListener("click", function () { //abriu a sidebar
        sideBar.classList.toggle("hide");
        menuIconDashboard.classList.add("hide");
    });

    menuIconSideBar.addEventListener("click", function () { //fechou a sidebar
        sideBar.classList.toggle("hide");
        menuIconDashboard.classList.remove("hide");
    });

    if (window.matchMedia("(max-width: 700px)").matches) {
        sideBar.classList.add("hide");
        menuIconDashboard.classList.remove("hide");
    } else {
        sideBar.classList.remove("hide");
    }

    window.addEventListener('resize', function (event) {
        if (window.matchMedia("(max-width: 700px)").matches) {
            sideBar.classList.add("hide");
            menuIconDashboard.classList.remove("hide");
        } else {
            sideBar.classList.remove("hide");
            menuIconDashboard.classList.add("hide");
        }
    }, true);

};

