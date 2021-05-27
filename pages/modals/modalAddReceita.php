<?php

include("../pages/modals/modalAddConta.php");
include("modalAddCategoriaReceita.php");

?>

<div class="modal fade" id="modalAddReceita" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAddReceitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddReceitaLabel">Adicione uma receita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formAddReceitas">
                        <div class="row col-md">
                            <div class="mb-3">
                                <label for="descReceitaInput" class="form-label">Descrição da receita</label>
                                <input type="text" class="form-control" id="descReceitaInput" name="descReceitaInput" aria-describedby="Descrição despesa" placeholder="Ex.: Salário de maio" required>
                            </div>
                        </div>
                        <div class="row col-md">
                            <div class="mb-3 col-6">
                                <label for="dataReceita" class="form-label">Data da receita</label>
                                <input type="date" class="form-control" id="dataReceita" name="dataReceita" aria-describedby="Data da receita" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="valorInput" class="form-label">Valor</label>
                                <input type="text" class="form-control" name="valorInput" id="valorInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" required autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contaSelect" class="form-label">Conta</label>
                            <div class="row col-12 d-flex align-items-center">
                                <div class="col-11">
                                    <select name="contaSelect" id="contaReceitaSelect">
                                        <?php
                                        $userId = $_SESSION['userId'];
                                        $sql = $conn->prepare("SELECT * FROM conta WHERE fk_usuario = :userId");
                                        $sql->bindValue(':userId', $userId);
                                        $sql->execute();
                                        $data = $sql->fetchAll();
                                        $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);


                                        foreach ($data as $row) {
                                        ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['nome_conta'] . " - " . $formatter->formatCurrency($row['saldo_atual'], 'BRL') ?></option>
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
                                    <select id="categoriasReceitaSelect" name="categoriasSelect[]" multiple required>
                                        <?php

                                        $userId = $_SESSION['userId'];
                                        $sql = $conn->prepare("SELECT * FROM categoria WHERE fk_tipo = 4 AND fk_usuario = :userId");
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
                                    <a id="btnAddConta" data-bs-target="#modalAddCategoriaReceita" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-plus-square"></i></a>
                                </div>
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

<script>
    $('#formAddReceitas').submit(function() {

        var x = $('#valorInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('valorInput').value = x;

        var dados = new FormData(this);

        $.ajax({
            url: "../connections/inserts/insertReceita.php",
            method: "POST",
            data: dados,
            processData: false,
            contentType: false,
            success: function(msg) {
                alert("Receita cadastrada com sucesso!");
                window.location.href = "../pages/receitas.php";
            },
            error: function(msg) {
                alert("Erro ao cadastrar a receita!");
            }
        });

        return false;

    });

    new SlimSelect({
        select: '#categoriasReceitaSelect',
        allowDeselect: true,
        searchPlaceholder: 'Pesquise categorias',
        searchText: 'Nada com esse nome :/',
        placeholder: "Selecione",
        deselectLabel: '<span class="white">✖</span>',
        closeOnSelect: false,
        hideSelectedOption: true
    });

    new SlimSelect({
        select: '#contaReceitaSelect',
        searchPlaceholder: 'Pesquise a conta',
        searchText: 'Não achamos essa conta :/',
        placeholder: "Selecione",
        closeOnSelect: true,
        hideSelectedOption: true
    });
</script>