<div class="modal fade" id="modalEditConta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEditContaLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditContaLabel">Editar dados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="../../classes/Conta.class.php" id="formEditConta">
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <label for="inputNovoNome" class="form-label">Nome</label>
                                <input value="<?php echo $_GET['nome_conta'];?>" type="text" class="mb-3 form-control" id="inputNovoNome" name="inputNovoNome" aria-describedby="Nome" placeholder="Novo nome da conta" required>
                            </div>
                        </div>
                        <input name="editNomeConta" class="hide">
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