<div class="modal fade" id="modalAddParticipantesMeta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddParticipantesMetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddParticipantesMetaLabel">Compartilhe essa meta com alguém!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAddParticipanteMeta" class="need-validation">
                        <div class="row col-md">
                            <div class="mb-3">
                                <label for="emailInput" class="form-label">E-mail do participante:</label>
                                <input type="email" class="form-control" id="emailInput" name="emailInput" placeholder="Ex.: joao@gmail.com" onkeyup="verificaEmail(this.value);" required autocomplete="nope" >
                                <small>
                                    <p id="invalid-feedback" style="text-align:center;" class="p-danger hide">Não encontramos um usuário com este e-mail!</p>
                                </small>
                                <small>
                                    <p id="valid-feedback" style="text-align:center;" class="p-success hide">Encontramos um usuário com este e-mail!</p>
                                </small>
                            </div>
                        </div>
                        <input name="idMeta" class="hide" value="<?= $_POST['idMeta'] ?>">
                        <input name="insertParticipanteMeta" class="hide">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-success">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function verificaEmail(valor) {
        if (valor.length > 2) {

            $.post('../classes/Usuario.class.php', {
                verificaEmail: 1,
                email: valor
            }, function(response) {
                if (response == 1) {
                    $('#emailInput').removeClass("is-invalid");
                    $('#formAddParticipanteMeta').removeClass("need-validation");
                    $('#formAddParticipanteMeta').addClass("was-validated");
                    $('#emailInput').addClass("is-valid");
                    $('#invalid-feedback').addClass("hide");
                    $('#valid-feedback').removeClass("hide");
                } else {
                    $('#formAddParticipanteMeta').removeClass("was-validated");
                    $('#formAddParticipanteMeta').addClass("need-validation");
                    $('#valid-feedback').addClass("hide");
                    $('#emailInput').removeClass("is-valid");
                    $('#emailInput').addClass("is-invalid");
                    $('#invalid-feedback').removeClass("hide");
                }
            });
        }
    }

    $('#formAddParticipanteMeta').submit(function(e) {
        if ($('#formAddParticipanteMeta').hasClass("need-validation")) {
            e.preventDefault();
        } else {
            var dados = new FormData(this);

            $.ajax({
                url: '../classes/Meta.class.php',
                method: 'POST',
                data: dados,
                processData: false,
                contentType: false,
                success: function(msg) {
                    alert("O usuário foi convidado para essa meta! " + msg);
                    window.location.reload();
                },
                error: function(msg) {
                    alert("Erro ao convidar o usuário!" + msg);
                }
            });

            return false;
        }
    });
</script>