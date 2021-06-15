<div class="modal fade" id="modalReajusteSaldo" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalReajusteSaldoLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReajusteSaldoLabel">Reajustar saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="alert alert-warning" role="alert">
                        Atenção, será criada uma transação para reajustar o seu saldo.
                    </div>
                    <p>Saldo atual: <?php echo $_GET['saldoAtual'] ?></p>
                    <form method="POST" action="../../classes/Conta.class.php" id="formReajusteSaldo">
                        <div class="col-sm-12 mb-3">
                            <label for="novoSaldoInput" class="form-label">Novo saldo</label>
                            <input type="text" class="form-control" name="novoSaldoInput" id="novoSaldoInput" value="<?php echo $_GET['saldoAtual'] ?>" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" required>
                        </div>
                        <input name="reajusteSaldo" class="hide">
                        <input name="idConta" class="hide" value="<?php echo $_GET['id'] ?>">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#formReajusteSaldo').submit(function() {
        var x = $('#novoSaldoInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('novoSaldoInput').value = x;
    });
</script>