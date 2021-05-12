<div class="modal fade" id="modalAddCategoriaDespesa" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddCategoriaDespesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddCategoriaDespesaLabel">Nova categoria para despesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAddCategoriaDespesa">
                        <div class="row col-md">
                            <div class="mb-3">
                                <label for="nomeCategoriaInput" class="form-label">Nome da categoria</label>
                                <input type="text" class="form-control" id="nomeCategoriaInput" name="nomeCategoriaInput" aria-describedby="Nome" placeholder="Ex.: Restaurante" required>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>