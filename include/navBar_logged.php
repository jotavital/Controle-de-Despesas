<?php

include_once(__DIR__ . "/../classes/Usuario.class.php");
include_once(__DIR__ . "/../classes/Notificacao.class.php");

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

        <!-- notificacoes -->
        <div class="me-3 notificationIcon">
            <div class="hide">
                <i class="p-white fas fa-bell"></i>
            </div>
            <div>
                <div class="dropdown d-flex justify-content-center" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="p-white far fa-bell"></i>
                </div>
                <ul class="dropdown-menu col-3">
                    <?php

                    $notificacaoObj = new Notificacao;
                    $todasNotificacoes = $notificacaoObj->pegarTodasNotificacoesUsuario($_SESSION['userId']);

                    if($todasNotificacoes == null){
                        ?>

                        <div class="d-flex justify-content-center">
                            Sem novas notificações
                        </div>

                        <?php
                    }

                    foreach ($todasNotificacoes as $notificacao) {

                        $nomeCompletoRemetente = $usuarioObj->selectFromUsuario("nome, sobrenome", "id = " . $notificacao['fk_usuario_remetente']);

                        if ($notificao['fk_tipo_notificacao'] = 1) {
                            $textoNotificacao = "<strong>" . $nomeCompletoRemetente[0]['nome'] . " " . $nomeCompletoRemetente[0]['sobrenome'] . "</strong> te convidou para participar de uma meta. Clique para ver";
                        }

                        if ($notificacao['foi_lida'] == 0) {
                    ?>

                            <div class="mb-1 d-flex align-items-center alert alert-warning alert-dismissible fade show" role="alert" style="padding:0;">
                                <div class="notificationText p-2">
                                    <p style="font-size:.9rem; margin-bottom:0;"><?= $textoNotificacao ?></p>
                                </div>
                                <div class="d-flex align-items-center alertButtons">
                                    <form id="formLida" action="" method="POST">
                                        <input type="hidden" name="notificacaoLida">
                                        <input type="hidden" name="idNotificacao" value="<?= $notificacao['id'] ?>">
                                        <button class="iconButton" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar como lida"><i class="fas fa-check"></i></button>
                                    </form>
                                    <form id="formExcluirNotificacao" action="" method="POST">
                                        <input type="hidden" name="notificacaoExcluida">
                                        <input type="hidden" name="idNotificacao" value="<?= $notificacao['id'] ?>">
                                        <button type="submit" class="iconButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="fas fa-times"></i></button>
                                    </form>
                                </div>
                            </div>

                        <?php
                        } else if ($notificacao['foi_lida'] == 1) {
                        ?>

                            <div class="mb-1 d-flex align-items-center alert alert-secondary alert-dismissible fade show" role="alert" style="padding:0">
                                <div class="notificationText p-2">
                                    <p style="font-size:.9rem; margin-bottom:0;"><?= $textoNotificacao ?></p>
                                </div>
                                <div class="d-flex align-items-center alertButtons">
                                    <form id="formExcluirNotificacao" action="" method="POST">
                                        <input type="hidden" name="notificacaoExcluida">
                                        <input type="hidden" name="idNotificacao" value="<?= $notificacao['id'] ?>">
                                        <button type="submit" class="iconButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="fas fa-times"></i></button>
                                    </form>
                                </div>
                            </div>

                    <?php
                        }
                    }

                    ?>
                </ul>
            </div>
        </div>
        <!--  -->

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

    $('#formLida').on('submit', function(event) {
        event.preventDefault();

        var dados = new FormData(this);

        $.ajax({
            url: "../classes/Notificacao.class.php",
            method: "POST",
            data: dados,
            processData: false,
            contentType: false,
            success: function(msg) {
                <?= $todasNotificacoes = $notificacaoObj->pegarTodasNotificacoesUsuario($_SESSION['userId']); ?>
            },
            error: function(msg) {
                alert("Um erro ocorreu ao tentar marcar essa notificação como lida.");
            }
        });
    })

    $('#formExcluirNotificacao').submit(function(event) {
        event.preventDefault();

        var dados = new FormData(this);

        $.ajax({
            url: "../classes/Notificacao.class.php",
            method: "POST",
            data: dados,
            processData: false,
            contentType: false,
            success: function(msg) {
                <?= $todasNotificacoes = $notificacaoObj->pegarTodasNotificacoesUsuario($_SESSION['userId']); ?>
            },
            error: function(msg) {
                alert("Um erro ocorreu ao tentar excluir essa notificação.");
            }
        });
    })
</script>