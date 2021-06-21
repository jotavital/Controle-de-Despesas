<?php

if (isset($_POST['newRow'])) {
    $newRow = unserialize(base64_decode($_POST['newRow']));
}

$functions = new Functions;

?>

<div class="modal fade" id="modalDeleteMeta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDeleteMetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalDeleteMetaLabel">Excluir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form method="POST" action="../../classes/Meta.class.php">
                <div class="modal-body">
                    <p>Confirme a exclusão desta meta:</p>
                    <p><strong class='p-primary'><?php echo $newRow['nome_meta'] . ": " . $newRow['descricao_meta'] ?></strong></p>
                    <hr>
                    <div class="mb-3 col-12 d-flex justify-content-center form-check form-switch">
                        <input class="me-2 form-check-input" type="checkbox" name="apagarParaTodos" id="apagarParaTodos" style="width:40px;" checked>
                        <label class="form-check-label" for="apagarParaTodos">Apagar para todos os participantes</label>
                    </div>
                    <small>
                        <p class="p-warning" style="text-align:center;"><strong>ATENÇÃO! Não será possível recuperar essa meta se apagar para todos os participantes!</strong></p>
                    </small>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <input type="text" name="idMeta" value="<?php echo $newRow['id'] ?>" class="hide">
                    <input type="text" name="deleteMeta" class="hide">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>