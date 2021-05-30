<div class="modal fade" id="modalDeleteConta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDeleteContaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalDeleteContaLabel">Excluir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Confirme a exclusão desta conta:</p>
                <?php echo "<p>" . $_GET['nome_conta'] . " com saldo total de " . $_GET['saldo_atual'] . "</p>";?>
                <p class="p-warning"><strong>ATENÇÃO! Todas as receitas e despesas vinculadas a esta conta serão permanentemente excluídas!</strong></p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="../../connections/crud/Conta.class.php">
                    <input type="text" name="idConta" value="<?php echo $_GET['id']?>" class="hide">
                    <input type="text" name="deleteConta" class="hide">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>