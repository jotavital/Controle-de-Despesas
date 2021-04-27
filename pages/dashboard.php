<?php
    include("../connections/loginVerify.php");
    $title = "Dashboard";
    include("../include/header.php");
    setTitulo($title);
?>

<body>
    <div id="containerDashboard">
        <?php
            include("../include/sideNav.php");
        ?>
        <main>
            <?php
                include("../include/navBar_logged.php");
            ?>
            
            <div id="contentDashboard">
                <div class="row cardsContainer">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body p-4">
                                <h5 class="card-title d-flex justify-content-center">Contas</h5>
                                <p class="card-text d-flex justify-content-center">Adicione suas contas</p>
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

    <script src="../js/sidenavCollapse.js"></script>
    
</body>

<?php
    include("../include/footer.php");
?>