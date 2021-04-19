<?php
    include("../connections/loginVerify.php");
    $title = "Dashboard";
    include("../include/header.php");
    setTitulo($title);
    // include("../include/navBar_dashboard.php");
?>

<body>
    <div id="containerDashboard">
        <sidebar>
            <?php
                include("../include/sideNav.php");
            ?>
        </sidebar>
          
        <main>
            <div id="contentDashboard">
                <div id="headerDashboard">
                    <a href="#">Abrir menu</a>
                </div>
            </div>
        </main>  
    </div>
    
</body>

<?php
    include("../include/footer.php");
?>