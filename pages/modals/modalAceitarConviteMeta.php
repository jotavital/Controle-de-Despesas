<div class="modal fade" id="modalAceitarConviteMeta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAceitarConviteMetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAceitarConviteMetaLabel">Adicione uma meta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAceitarConviteMeta">
                        <input name="aceitarConviteMeta" class="hide">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-success">Aceitar</button>
                            <button type="button" class="btn btn-danger">Recusar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modalAceitarConviteMetaLabel').submit(function() {

        var dados = jQuery(this).serialize();

        $.ajax({
            url: '../classes/Meta.class.php',
            method: 'POST',
            data: dados,
            success: function(msg) {
                alert("Meta cadastrada com sucesso!");
                location.reload();
            },
            error: function(msg) {
                alert("Erro ao cadastrar a meta! " + msg);
            }
        });

        return false;
    });
</script>