<div class="modal fade" id="modalAddDespesa" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddDespesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddDespesaLabel">Adicione uma despesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAddDespesas">
                        <div class="row col-md">
                            <div class="mb-3 col-8">
                                <label for="nomeDespesaInput" class="form-label">Descrição da despesa</label>
                                <input type="text" class="form-control" id="nomeDespesaInput" name="nomeDespesa" aria-describedby="Nome" placeholder="Ex.: Mercado" required>
                            </div>
                            <div class="mb-3 col-4">
                                <label for="saldoInput" class="form-label">Valor</label>
                                <input type="text" class="form-control" name="saldoDespesa" id="saldoInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" required>
                            </div>
                        </div>
                        <div class="row col-md">
                            <div class="mb-3 col-6">
                                <label for="dataDespesa" class="form-label">Data da despesa</label>
                                <input type="date" class="form-control" id="dataDespesa" name="dataDespesa" aria-describedby="Data da despesa" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="dataVencimentoDespesa" class="form-label">Data do vencimento</label>
                                <input type="date" class="form-control" id="dataVencimentoDespesa" name="dataVencimentoDespesa" aria-describedby="Data da despesa" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contaSelect" class="form-label">Conta</label>
                            <select class="form-select" name="contaSelect" id="contaSelect">
                                <?php
                                $sql = $conn->prepare("SELECT * FROM categoria WHERE fk_tipo = 5");
                                $sql->execute();
                                $data = $sql->fetchAll();

                                foreach ($data as $row) {
                                ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['nome_categoria'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="imgInput" class="form-label">Imagem</label>
                            <input class="form-control" type="file" id="imgInput" name="imgInput" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="categoriaSelect" class="form-label">Categorias</label>
                            <br>
                            aqui estarão as categorias
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