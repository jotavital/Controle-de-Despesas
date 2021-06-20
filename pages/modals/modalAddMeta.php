<div class="modal fade" id="modalAddMeta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddMetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddMetaLabel">Adicione uma meta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="metainer-fluid">
                    <form method="POST" id="formAddMetas">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="nomeMetaInput" class="form-label">Nome da meta</label>
                                <input type="text" class="form-control" id="nomeMetaInput" name="nomeMetaInput" aria-describedby="Nome" placeholder="Ex.: Bateria Eletrônica" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="prazoMeta" class="form-label">Prazo</label>
                                <input type="date" class="form-control" id="prazoMeta" name="prazoMeta" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="valorMetaInput" class="form-label">Valor total</label>
                                <input type="text" autocomplete="off" class="form-control" name="valorMetaInput" id="valorMetaInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="valorAtingidoInput" class="form-label">Valor atingido</label>
                                <input type="text" autocomplete="off" class="form-control" name="valorAtingidoInput" id="valorAtingidoInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});">
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="descricaoMetaInput" class="form-label">Descrição da meta</label>
                            <textarea style="resize:none;" class="form-control" id="descricaoMetaInput" name="descricaoMetaInput" aria-describedby="Descrição" placeholder="Ex.: Minha tão sonhada bateria eletrônica"></textarea>
                        </div>
                        <input name="insertMeta" class="hide">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#formAddMetas').submit(function() {
        var valorMetaInput = $('#valorMetaInput').val();
        valorMetaInput = valorMetaInput.replace(/[.]/gim, "");
        valorMetaInput = valorMetaInput.replace(/[,]/gim, ".");
        document.getElementById('valorMetaInput').value = valorMetaInput;

        var valorAtingidoInput = $('#valorAtingidoInput').val();
        valorAtingidoInput = valorAtingidoInput.replace(/[.]/gim, "");
        valorAtingidoInput = valorAtingidoInput.replace(/[,]/gim, ".");
        document.getElementById('valorAtingidoInput').value = valorAtingidoInput;

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