<sidebar class="sideBarMenu">
    <div id="sidebarHeader" class="col-12 d-flex align-items-center justify-content-end">
        <div class="menuToggler me-3">
            <i class="fas fa-bars fa-2x"></i>
        </div>
    </div>
    <div id="sidebarItems">
        <div id="logoSideBar" class="col-12 mt-3 mb-3 d-flex justify-content-center logoSidebar">
            <img src="../image/favicon.ico" style="width:40px;">
        </div>
        <ul>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../pages/dashboard.php">Dashboard</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../pages/contas.php">Contas</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../pages/despesas.php">Despesas</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../pages/receitas.php">Receitas</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../pages/transacoes.php">Transações</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../pages/estatisticas.php">Estatísticas</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../pages/metas.php">Metas</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../pages/profile.php">Perfil</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="mb-2 sideBarItem d-flex align-items-center">
                    <div class="sideBarIcon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="sideBarLink">
                        <a href="../classes/Usuario.class.php?logout">Sair</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <script src="../js/sideBarCollapse.js"></script>
</sidebar>

<script>

    $('#logoSideBar').on('click', function () {
        window.location.href = "../pages/dashboard.php";
    })

</script>