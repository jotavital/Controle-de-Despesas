var iconMenu = document.querySelector(".menuToggler");
var sideNav = document.querySelector(".sideNavMenu");

window.onload = function(){
    iconMenu.addEventListener("click", function () {
        sideNav.classList.toggle("hide");
    });
};

