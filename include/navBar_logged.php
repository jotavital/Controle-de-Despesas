<?php

include_once(__DIR__ . "/../classes/Usuario.class.php");

$usuarioObj = new Usuario;
$nomeUsuario = $usuarioObj->selectFromUsuario("nome", "id = " . $_SESSION['userId'])[0]['nome'];

?>

<div id="navBarDashboard" class="col-12 navBar d-flex justify-content-start">
    <div class="menuToggler">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <div class="col-6 headerDashboardTitle">
        <h4 class="ms-3 title"><?php echo $title ?></h4>
    </div>
    <div class="col-5 pe-3 d-flex align-items-center justify-content-end">
        <div class="me-3 notificationIcon">
            <div class="hide">
                <i class="p-white fas fa-bell"></i>
            </div>
            <div>
                <div class="dropdown d-flex justify-content-center" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="p-white far fa-bell"></i>
                </div>
                <ul class="dropdown-menu col-3">
                    <div class="d-flex align-items-center alert alert-success alert-dismissible fade show" role="alert" style="padding:0">
                        <div class="notificationText p-2">
                            <p>joao pedro vital te convidou para uma meta! Clique para ver</p>
                        </div>
                        <div class="d-flex align-items-center alertButtons">
                            <button type="button" class="btn">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="btn" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <div class="goToProfile d-flex align-items-center">
            <div class="divNavBarProfilePicture">
                <img id="navBarProfilePicture" src="../image/assets/no_profile_picture.png" alt="foto de perfil">
            </div>
            <div class="ms-1 nomeUsuarioNavBar">
                <small class="p-white"><?php echo $nomeUsuario ?></small>
            </div>
        </div>
    </div>
</div>

<script>
    $('.dropdown-menu').click(function(event) {
        event.stopPropagation();
    })

    $(".goToProfile").click(function() {
        window.location.href = "../pages/profile.php";
    });
</script>