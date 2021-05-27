var menuIconDashboard = document.getElementById("navBarDashboard").querySelector(".menuToggler");
var menuIconSideBar = document.getElementById("sidebarHeader").querySelector(".menuToggler");
var sideBar = document.querySelector(".sideBarMenu");
var title = document.getElementById("navBarDashboard").querySelector(".headerDashboardTitle");

window.onload = function(){

    if(!sideBar.classList.contains("hide")){ //sidebar esta aberta
        menuIconDashboard.classList.add("hide");
    }

    menuIconDashboard.addEventListener("click", function () { //abriu a sidebar
        sideBar.classList.toggle("hide");
        menuIconDashboard.classList.add("hide");
        title.classList.replace("col-11", "col-12");
    });

    menuIconSideBar.addEventListener("click", function(){ //fechou a sidebar
        sideBar.classList.toggle("hide");
        menuIconDashboard.classList.remove("hide");
        title.classList.replace("col-12", "col-11");
    });
};

