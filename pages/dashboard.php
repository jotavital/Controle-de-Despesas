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
            <div id="headerDashboard">
                <a href="#">Abrir menu</a>
            </div>
            <div id="contentDashboard">
                <div class="row cardsContainer">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex justify-content-center">Carteiras</h5>
                                <p class="card-text d-flex justify-content-center">Adicione suas carteiras</p>
                                <div class="row col-sm d-flex justify-content-center">
                                    <a href="#" class="btn btn-success col-sm me-3">Adicionar</a>
                                    <a href="#" class="btn btn-primary col-sm">Ver tudo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex justify-content-center">Despesas</h5>
                                <p class="card-text d-flex justify-content-center">Adicione seus gastos</p>
                                <div class="row col-sm d-flex justify-content-center">
                                    <a href="#" class="btn btn-success col-sm me-3">Adicionar</a>
                                    <a href="#" class="btn btn-primary col-sm">Ver tudo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex justify-content-center">Economias</h5>
                                <p class="card-text d-flex justify-content-center">Adicione suas economias</p>
                                <div class="row col-sm d-flex justify-content-center">
                                    <a href="#" class="btn btn-success col-sm me-3">Adicionar</a>
                                    <a href="#" class="btn btn-primary col-sm">Ver tudo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>  
    </div>
    
</body>

<?php
    include("../include/footer.php");
?>