var iconMenu = document.querySelector(".menuToggler");
var sideNav = document.querySelector(".sideNavMenu");

iconMenu.addEventListener("click", function(){
    sideNav.classList.toggle("hide");
});