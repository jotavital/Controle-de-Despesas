<?php

include_once(__DIR__ . "/modalAddConta.php");
include_once(__DIR__ . "/modalAddCategoriaDespesa.php");

?>

<div class="modal fade" id="modalEditDespesa" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEditDespesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditDespesaLabel">Editar despesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAddDespesas" enctype="multipart/form-data">
                        <div class="row col-md">
                            <div class="mb-3 col-8">
                                <label for="descDespesaInput" class="form-label">Descrição da despesa</label>
                                <input type="text" class="form-control" id="descDespesaInput" name="descDespesaInput" aria-describedby="Nome" placeholder="Ex.: Mercado" required>
                            </div>
                            <div class="mb-3 col-4">
                                <label for="valorInput" class="form-label">Valor</label>
                                <input type="text" class="form-control" name="valorInput" id="valorInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" required autocomplete="off">
                            </div>
                        </div>
                        <div class="row col-md">
                            <div class="mb-3 col-6">
                                <label for="dataDespesa" class="form-label">Data da despesa</label>
                                <input type="date" class="form-control" id="dataDespesa" name="dataDespesa" aria-describedby="Data da despesa" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="dataVencimentoDespesa" class="form-label">Data do vencimento</label>
                                <input type="date" class="form-control" id="dataVencimentoDespesa" name="dataVencimentoDespesa" aria-describedby="Data da despesa">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="imgInput" class="form-label">Imagem</label>
                            <input class="form-control" type="file" id="imgInput" name="imgInput" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="contaSelect" class="form-label">Conta</label>
                            <div class="row col-12 d-flex align-items-center">
                                <div class="col-11">
                                    <select name="contaSelect" id="contaSelectEdit">
                                        <?php
                                        $userId = $_SESSION['userId'];
                                        $sql = $conexao->prepare("SELECT * FROM conta WHERE fk_usuario = :userId");
                                        $sql->bindValue(':userId', $userId);
                                        $sql->execute();
                                        $data = $sql->fetchAll();

                                        foreach ($data as $row) {
                                        ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['nome_conta'] . " - " . $functions->formatarReal($row['saldo_atual']) ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <a id="btnAddConta" data-bs-target="#modalAddConta" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-plus-square"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaSelect" class="form-label">Categorias</label>
                            <div class="row col-12 d-flex align-items-center">
                                <div class="col-11">
                                    <select id="categoriasSelectEdit" name="categoriasSelect[]" multiple required>
                                        <?php
                                        $userId = $_SESSION['userId'];
                                        $sql = $conexao->prepare("SELECT * FROM categoria WHERE fk_tipo = 3 AND fk_usuario = :userId OR fk_tipo = 3 AND fk_usuario IS NULL");
                                        $sql->bindValue(':userId', $userId);
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
                                <div class="col-1">
                                    <a id="btnAddConta" data-bs-target="#modalAddCategoriaDespesa" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-plus-square"></i></a>
                                </div>
                            </div>
                        </div>
                        <input name="insertDespesa" class="hide">
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
    $("#categoriasSelect option").filter(function() {
        return $(this).text() == 'Outros';
    }).prop('selected', true);

    $('#formEditDespesas').submit(function() {
        var x = $('#valorInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('valorInput').value = x;
        var dados = new FormData(this);

        $.ajax({
            url: '../classes/Despesa.class.php',
            method: 'POST',
            data: dados,
            processData: false,
            contentType: false,
            success: function(msg) {
                alert("Despesa cadastrada com sucesso!" + msg);
                window.location.reload();
            },
            error: function(msg) {
                alert("Erro ao cadastrar a despesa!");
            }
        });

        return false;
    });

    $('#imgInput').bind('change', function() {
        if (this.files[0].size > 5242880) {
            alert('Escolha uma imagem de até 5 MB');
            $('#imgInput').val('');
        }
    });

    var select = new SlimSelect({
        select: '#categoriasSelectEdit',
        allowDeselect: true,
        searchPlaceholder: 'Pesquise categorias',
        searchText: 'Nada com esse nome :/',
        placeholder: "Selecione",
        deselectLabel: '<span class="white">✖</span>',
        closeOnSelect: false,
        hideSelectedOption: true
    });

    var select2 = new SlimSelect({
        select: '#contaSelectEdit',
        searchPlaceholder: 'Pesquise a conta',
        searchText: 'Não achamos essa conta :/',
        placeholder: "Selecione",
        closeOnSelect: true,
        hideSelectedOption: true
    });
</script>