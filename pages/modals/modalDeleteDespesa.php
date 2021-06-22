<?php

include_once(__DIR__ . "/../../classes/Despesa.class.php");
include_once(__DIR__ . "/../../classes/Conta.class.php");

if(isset($_POST['idDespesa'])){
    $despesaObj = new Despesa;
    $despesa = $despesaObj->selectFromDespesa('', 'id = ' . $_POST['idDespesa']);
    $despesa = $despesa[0];
    
    $contaObj = new Conta;
    $conta = $contaObj->selectFromConta('', 'id = ' . $despesa['fk_conta']);
    $conta = $conta[0];
}

?>

<div class="modal fade" id="modalDeleteDespesa" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDespesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalDespesaLabel">Excluir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Confirme a exclusão desta despesa:</p>
                <?php echo "<p>" . $despesa['descricao_despesa'] . " da conta " . $conta['nome_conta'] . " com valor de <span class='p-danger'><strong>" . $despesa['valor'] . "</strong></span></p>"; ?>
                <p class="p-warning"><strong>ATENÇÃO! A exclusão desta despesa irá refletir no saldo atual da conta à qual ela pertence!</strong></p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="../../classes/Despesa.class.php">
                    <input type="text" name="idDespesa" value="<?php echo $despesa['id'] ?>" class="hide">
                    <input type="text" name="idConta" value="<?php echo $despesa['fk_conta'] ?>" class="hide">
                    <input type="text" name="valorDespesa" value="<?php echo $despesa['valor'] ?>" class="hide">
                    <input type="text" name="deleteDespesa" class="hide">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>