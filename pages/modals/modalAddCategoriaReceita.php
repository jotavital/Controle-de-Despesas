<div class="modal fade" id="modalAddCategoriaReceita" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddCategoriaReceitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddCategoriaReceitaLabel">Nova categoria para receitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAddCategoriaReceita">
                        <div class="row col-md">
                            <div class="mb-3">
                                <label for="nomeCategoriaInput" class="form-label">Nome da categoria</label>
                                <input type="text" class="form-control" id="nomeCategoriaInput" name="nomeCategoriaInput" aria-describedby="Nome" placeholder="Ex.: Salário" required>
                            </div>
                        </div>
                        <input name="insertCategoriaReceita" class="hide">
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
    
    $('#formAddCategoriaReceita').submit(function() {
        var dados = new FormData(this);

        $.ajax({
            url: '../classes/Receita.class.php',
            method: 'POST',
            data: dados,
            processData: false,
            contentType: false,
            success: function(msg) {
                alert("Categoria cadastrada com sucesso! " + msg);
                window.location.reload();
            },
            error: function(msg) {
                alert("Erro ao cadastrar a categoria!" + msg);
            }
        });

        return false;
    });

</script>
