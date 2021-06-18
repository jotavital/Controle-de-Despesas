<?php

if (isset($_POST['newRow'])) {
    $newRow = unserialize(base64_decode($_POST['newRow']));
}

$functions = new Functions;

?>

<div class="modal fade" id="modalDeleteConta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDeleteContaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalDeleteContaLabel">Excluir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Confirme a exclusão desta conta:</p>
                <?php echo "<p><strong class='p-primary'>" . $newRow['nome_conta'] . "</strong> com saldo total de <strong class='p-primary'>" . $functions->formatarReal($newRow['saldo_atual']) . "</strong></p>";?>
                <hr>
                <small><p class="p-warning" style="text-align:center;"><strong>ATENÇÃO! Todas as receitas e despesas vinculadas a esta conta serão permanentemente excluídas!</strong></p></small>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="../../classes/Conta.class.php">
                    <input type="text" name="idConta" value="<?php echo $newRow['id']?>" class="hide">
                    <input type="text" name="deleteConta" class="hide">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>