<div class="modal fade" id="modalEditConta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEditContaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditContaLabel">Editar dados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="../../classes/Usuario.class.php" id="formEditConta">
                        <div class="row col-md-12">
                            <div class="col-md-6">
                                <label for="inputNovoNome" class="form-label">Nome</label>
                                <input value="<?php echo $_GET['nome'];?>" type="text" class="form-control" id="inputNovoNome" name="inputNovoNome" aria-describedby="Nome" placeholder="Seu novo nome" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="inputNovoSobrenome" class="form-label">Sobrenome</label>
                                <input value="<?php echo $_GET['sobrenome'];?>" type="text" class="form-control" id="inputNovoSobrenome" name="inputNovoSobrenome" aria-describedby="Nome" placeholder="Seu novo sobrenome" required>
                            </div>

                        </div>
                        <input name="editConta" class="hide">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>