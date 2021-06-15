<div class="modal fade" id="modalEditConta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEditContaLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditContaLabel">Editar dados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" action="../../classes/Conta.class.php" id="formEditConta">
                        <div class="col-sm-12">
                            <label for="inputNovoNome" class="form-label">Nome</label>
                            <input value="<?php echo $_GET['nome_conta']; ?>" type="text" class="mb-3 form-control" id="inputNovoNome" name="inputNovoNome" aria-describedby="Nome" placeholder="Novo nome da conta" required>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="categoriaSelect" class="form-label">Categoria</label>
                            <select class="form-select" name="categoriaSelect" id="categoriaSelect">

                                <?php
                                $sql = $conexao->prepare("SELECT * FROM categoria WHERE fk_tipo = 5");
                                $sql->execute();
                                $data = $sql->fetchAll();

                                foreach ($data as $row) {
                                ?>
                                    <option value="<?php echo $row['id'] ?>" <?php echo ($_GET['idCategoria'] == $row['id']) ? ("selected") : (""); ?> ><?php echo $row['nome_categoria'] ?></option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>
                        <input name="editNomeConta" class="hide">
                        <input name="editCategoriaConta" class="hide">
                        <input name="idConta" class="hide" value="<?php echo $_GET['id'] ?>">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" id="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>