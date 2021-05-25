<div class="modal fade" id="modalDeleteDespesa" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDeleteDespesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalDeleteDespesaLabel">Excluir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Confirme a exclusão desta despesa:</p>
                <?php echo "<p>" . $_GET['desc_despesa'] . " com valor de " . $_GET['valor'] . "</p>"; ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="../../connections/delete/deleteDespesa.php">
                    <input type="text" name="idDespesa" value="<?php echo $_GET['id'] ?>" class="hide">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>