var iconMenu = document.querySelector(".menuToggler");
var sideBar = document.querySelector(".sideBarMenu");

window.onload = function(){
    iconMenu.addEventListener("click", function () {
        sideBar.classList.toggle("hide");
    });
};

