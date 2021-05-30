<div class="modal fade" id="modalReceita" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalReceitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalReceitaLabel">Excluir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Confirme a exclusão desta receita:</p>
                <?php echo "<p>" . $_GET['desc_receita'] . " com valor de " . $_GET['valor'] . "</p>"; ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="../../connections/delete/Receita.class.php">
                    <input type="text" name="idReceita" value="<?php echo $_GET['id'] ?>" class="hide">
                    <input type="text" name="deleteReceita" class="hide">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>