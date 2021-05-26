var menuIconDashboard = document.getElementById("headerDashboard").querySelector(".menuToggler");
var menuIconSideBar = document.getElementById("sidebarHeader").querySelector(".menuToggler");
var sideBar = document.querySelector(".sideBarMenu");

window.onload = function(){

    if(!sideBar.classList.contains("hide")){
        menuIconDashboard.classList.add("hide");
    }

    menuIconDashboard.addEventListener("click", function () {
        sideBar.classList.toggle("hide");
        menuIconDashboard.classList.add("hide");
    });

    menuIconSideBar.addEventListener("click", function(){
        sideBar.classList.toggle("hide");
        menuIconDashboard.classList.remove("hide");
    });
};

