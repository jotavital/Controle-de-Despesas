<div class="modal fade" id="modalDeleteReceita" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDeleteReceitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalDeleteReceitaLabel">Excluir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Confirme a exclusão desta receita:</p>
                <?php echo "<p>" . $_GET['desc_receita'] . " com valor de " . "<span style='color:green'>" . $formatter->formatCurrency($_GET['valor'], 'BRL') . "</span></p>"; ?>
                <p class="p-warning"><strong>ATENÇÃO! A exclusão desta receita irá refletir no saldo atual da conta à qual ela pertence!</strong></p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="../../connections/crud/Receita.class.php">
                    <input type="text" name="idReceita" value="<?php echo $_GET['id'] ?>" class="hide">
                    <input type="text" name="valorReceita" value="<?php echo $_GET['valor'] ?>" class="hide">
                    <input type="text" name="idConta" value="<?php echo $_GET['id_conta'] ?>" class="hide">
                    <input type="text" name="deleteReceita" class="hide">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>