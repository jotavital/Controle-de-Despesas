<div class="modal fade" id="modalDeleteUsuario" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalDeleteUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalDeleteUsuarioLabel">Excluir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o seu usuário?</p>
                <p class="p-warning"><strong>ATENÇÃO! A exclusão do seu usuário não pode ser desfeita. Todas os seus registros serão permanentemente apagados!</strong></p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" id="formDeleteUsuario">
                    <input type="text" name="deleteUsuario" class="hide">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#formDeleteUsuario').submit(function() {
        var dados = new FormData(this);

        $.ajax({
            url: '../connections/classes/Usuario.class.php',
            method: 'POST',
            data: dados,
            processData: false,
            contentType: false,
            success: function(msg) {
                window.location.replace("../pages/register.php");
            },
            error: function(msg) {
                alert(msg);
            }
        });

        return false;
    });
</script>