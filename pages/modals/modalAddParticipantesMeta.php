<div class="modal fade" id="modalAddParticipantesMeta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddParticipantesMetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddParticipantesMetaLabel">Compartilhe essa meta com alguém!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAddParticipanteMeta">
                        <div class="row col-md">
                            <div class="mb-3">
                                <label for="nomeCategoriaInput" class="form-label">E-mail do participante</label>
                                <input type="text" class="form-control" id="nomeCategoriaInput" name="nomeCategoriaInput" aria-describedby="Nome" placeholder="Ex.: joao@gmail.com" required>
                            </div>
                        </div>
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
    $('#formAddParticipanteMeta').submit(function() {
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
    });
</script>