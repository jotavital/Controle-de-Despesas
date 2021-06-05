<div class="modal fade" id="modalAddConta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddContaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddContaLabel">Adicione uma conta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAddContas">
                        <div class="col-sm-12 mb-3">
                            <label for="nomeContaInput" class="form-label">Nome da conta</label>
                            <input type="text" class="form-control" id="nomeContaInput" name="nomeConta" aria-describedby="Nome" placeholder="Ex.: Minha Poupança" required>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="saldoInput" class="form-label">Saldo atual</label>
                            <input type="text" class="form-control" name="saldoConta" id="saldoInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" required>
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
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['nome_categoria'] ?></option>
                                <?php
                                }
                                ?>

                            </select>
                        </div>
                        <input name="insertConta" class="hide">
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
    $('#formAddContas').submit(function() {
        var x = $('#saldoInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('saldoInput').value = x;
        var dados = jQuery(this).serialize();

        $.ajax({
            url: '../connections/crud/Conta.class.php',
            method: 'POST',
            data: dados,
            success: function(msg) {
                alert("Conta cadastrada com sucesso!");
                location.reload();
            },
            error: function(msg) {
                alert("Erro ao cadastrar a conta!");
            }
        });

        return false;
    });
</script>