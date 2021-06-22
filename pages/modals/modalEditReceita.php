<?php

include_once(__DIR__ . "/modalAddConta.php");
include_once(__DIR__ . "/modalAddCategoriaReceita.php");
include_once(__DIR__ . "/../../classes/Categoria.class.php");
include_once(__DIR__ . "/../../classes/Receita.class.php");
include_once(__DIR__ . "/../../classes/Categoria_Receita.class.php");

$categoriaObj = new Categoria;
$categorias = $categoriaObj->selectAllFromCategoria("fk_tipo = 4");
$categoriaReceitaObj = new Categoria_Receita;

if (isset($_POST['idReceita'])) {
    $receitaObj = new Receita;
    $receita = $receitaObj->selectFromReceita('', 'id = ' . $_POST['idReceita']);
    $receita = $receita[0];
    $categoriasReceita = $categoriaReceitaObj->selectAllCategoriaReceitaByReceitaId($receita['id']);
}

$functions = new Functions;

?>

<div class="modal fade" id="modalEditReceita" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEditReceitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditReceitaLabel">Editar receita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" id="formEditReceitas">
                        <div class="row col-md">
                            <div class="mb-3">
                                <label for="descReceitaInput" class="form-label">Descrição da receita</label>
                                <input type="text" class="form-control" id="descReceitaInput" name="descReceitaInput" aria-describedby="Descrição despesa" placeholder="Ex.: Salário de maio" value="<?php echo $receita['descricao_receita'] ?>" required>
                            </div>
                        </div>
                        <div class="row col-md">
                            <div class="mb-3 col-6">
                                <label for="dataReceita" class="form-label">Data da receita</label>
                                <input type="date" class="form-control" id="dataReceita" name="dataReceita" aria-describedby="Data da receita" value="<?php echo $receita['data_receita'] ?>" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="novoValorReceitaInput" class="form-label">Valor</label>
                                <input type="text" class="form-control" name="valorInput" id="novoValorReceitaInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" value="<?php echo $functions->formatarRealSemCifrao($receita['valor']) ?>" required autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contaSelectEdit" class="form-label">Conta</label>
                            <div class="row col-12 d-flex align-items-center">
                                <div class="col-11">
                                    <select name="contaSelect" id="contaSelectEditReceita">
                                        <?php
                                        $userId = $_SESSION['userId'];
                                        $sql = $conexao->prepare("SELECT * FROM conta WHERE fk_usuario = :userId");
                                        $sql->bindValue(':userId', $userId);
                                        $sql->execute();
                                        $data = $sql->fetchAll();



                                        foreach ($data as $row) {
                                        ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo ($receita['fk_conta'] == $row['id']) ? ("selected") : (""); ?>> <?php echo $row['nome_conta'] . " - " . $functions->formatarReal($row['saldo_atual']) ?></option>
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
                        <label for="categoriasSelectEdit" class="form-label">Categorias</label>
                            <div class="row col-12 d-flex align-items-center">
                                <div class="col-11">
                                    <select id="categoriasSelectEditReceita" name="categoriasSelect[]" multiple required>
                                        <?php

                                        foreach ($categorias as $row) {
                                            foreach ($categoriasReceita as $categoria) {
                                                if ($categoria[0] == $row['id']) {
                                                    $selected = 1;
                                                    break;
                                                } else {
                                                    $selected = 0;
                                                }
                                            }
                                        ?>
                                            <option value="<?php echo $row['id'] ?>" <?php echo ($selected == 1) ? ("selected") : (""); ?>><?php echo $row['nome_categoria'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <a id="btnAddCategoria" data-bs-target="#modalAddCategoriaReceita" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-plus-square"></i></a>
                                </div>
                            </div>
                        </div>
                        <input name="editReceita" class="hide">
                        <input name="idReceita" class="hide" value="<?php echo $receita['id'] ?>">
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

    $('#formEditReceitas').submit(function() {

        var x = $('#novoValorReceitaInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('novoValorReceitaInput').value = x;

        var dados = new FormData(this);

        $.ajax({
            url: "../classes/Receita.class.php",
            method: "POST",
            data: dados,
            processData: false,
            contentType: false,
            success: function(msg) {
                alert("Receita editada com sucesso!");
                window.history.pushState(null, null, window.location.pathname);
                window.location.reload();
            },
            error: function(msg) {
                alert("Erro ao editar a receita!");
            }
        });

        return false;

    });

    new SlimSelect({
        select: '#categoriasSelectEditReceita',
        allowDeselect: true,
        searchPlaceholder: 'Pesquise categorias',
        searchText: 'Nada com esse nome :/',
        placeholder: "Selecione",
        deselectLabel: '<span class="white">✖</span>',
        closeOnSelect: false,
        hideSelectedOption: true
    });

    new SlimSelect({
        select: '#contaSelectEditReceita',
        searchPlaceholder: 'Pesquise a conta',
        searchText: 'Não achamos essa conta :/',
        placeholder: "Selecione",
        closeOnSelect: true,
        hideSelectedOption: true
    });
</script>