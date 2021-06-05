<div class="modal fade" id="modalEditSenha" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEditSenhaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditSenhaLabel">Editar dados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formEditSenha">
                        <div class="col-md-12">
                            <div class="col-md-12 mb-3">
                                <label for="inputSenhaAtual" class="form-label">Senha atual</label>
                                <input type="password" class="form-control" id="inputSenhaAtual" name="inputSenhaAtual" placeholder="Sua senha atual" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputNovaSenha" class="form-label">Nova senha</label>
                                <input type="password" class="form-control" id="inputNovaSenha" name="inputNovaSenha" placeholder="Sua nova senha" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inputConfirmSenha" class="form-label">Confirme senha</label>
                                <input type="password" class="form-control" id="inputConfirmSenha" name="inputConfirmSenha" placeholder="Confirme sua nova senha" required>
                            </div>
                        </div>
                        <input name="editSenha" class="hide">
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
    $(document).ready(function() {

        $('#formEditSenha').submit(function() {
            var dados = new FormData(this);

            if (!($('#inputNovaSenha').val() == $('#inputConfirmSenha').val())) {

                alert("A confirmação de senha está diferente da nova senha!");
                e.preventDefault();

            } else {

                $.ajax({
                    url: '../connections/classes/Usuario.class.php',
                    method: 'POST',
                    data: dados,
                    processData: false,
                    contentType: false,
                    success: function(msg) {
                        alert(msg);
                        window.location.reload();
                    },
                    error: function(msg) {
                        alert(msg);
                    }
                });

            }
            return false;
        });

    });
</script>