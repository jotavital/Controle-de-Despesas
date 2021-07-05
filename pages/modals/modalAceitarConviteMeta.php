<?php

include_once(__DIR__ . "/../../classes/Meta.class.php");
include_once(__DIR__ . "/../../classes/Usuario.class.php");
include_once(__DIR__ . "/../../classes/Meta_Usuario.class.php");
include_once(__DIR__ . "/../../classes/Notificacao.class.php");

if (isset($_POST['idMeta'])) {
    $idMeta = $_POST['idMeta'];

    $metaObj = new Meta;
    $dadosMeta = $metaObj->selectFromMeta('', 'id = ' . $idMeta)[0];

    $idRemetente = $_POST['idRemetente'];

    $usuarioObj = new Usuario;
    $dadosRemetente = $usuarioObj->selectFromUsuario('nome, sobrenome', 'id = ' . $idRemetente)[0];

    $notificacaoObj = new Notificacao;
    $notificacaoObj->marcarNotificacaoLida($_POST['idNotificacao']);
}


?>

<div class="modal fade" id="modalAceitarConviteMeta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAceitarConviteMetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAceitarConviteMetaLabel">Convite para meta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <p style="text-align: center;"><strong class="p-warning"><?= $dadosRemetente['nome'] . " " . $dadosRemetente['sobrenome'] ?></strong> convidou você para participar da sua meta <strong class="p-warning">"<?= $dadosMeta['nome_meta'] ?>"</strong></p>
                    <form method="POST" id="formAceitarConviteMeta">
                        <input name="aceitarConviteMeta" class="hide">
                        <input name="idMeta" class="hide" value="<?= $idMeta ?>">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-success">Aceitar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Recusar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#formAceitarConviteMeta').submit(function() {

        var dados = jQuery(this).serialize();

        $.ajax({
            url: '../classes/Meta_Usuario.class.php',
            method: 'POST',
            data: dados,
            success: function(msg) {
                alert("Você aceitou o convite para participar desta meta!");
                window.history.pushState(null, null, window.location.pathname);
                window.location.reload();
            },
            error: function(msg) {
                alert("Ocorreu um erro ao tentar aceitar este convite, por favor tente novamente.");
                window.history.pushState(null, null, window.location.pathname);
                window.location.reload();
            }
        });

        return false;
    });
</script>