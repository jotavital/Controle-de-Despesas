<?php

if (isset($_POST['newRow'])) {
    $newRow = unserialize(base64_decode($_POST['newRow']));
}

$functions = new Functions;

?>

<div class="modal fade" id="modalDepositoMeta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDepositoMetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDepositoMetaLabel">Depositar na meta: <?php echo $newRow['nome_meta']?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <p>Total atingido: <?php echo $functions->formatarReal($newRow['valor_atingido'])?></p>
                    <form method="POST" action="../../classes/Meta.class.php" id="formDepositoMeta">
                        <div class="col-sm-12 mb-3">
                            <label for="valorInput" class="form-label">Valor a depositar</label>
                            <input type="text" class="form-control" name="valorInput" id="valorInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" required>
                        </div>
                        <input name="depositoMeta" class="hide">
                        <input type="hidden" name="idMeta" value="<?php echo $newRow['id']?>">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-primary">Depositar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#formDepositoMeta').submit(function() {
        var x = $('#valorInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('valorInput').value = x;
    });
</script>