<?php

include_once(__DIR__ . "/../../classes/Despesa.class.php");
include_once(__DIR__ . "/modalAddConta.php");
include_once(__DIR__ . "/modalAddCategoriaDespesa.php");
include_once(__DIR__ . "/../../classes/Categoria.class.php");
include_once(__DIR__ . "/../../classes/Categoria_Despesa.class.php");

$categoriaObj = new Categoria;
$categorias = $categoriaObj->selectAllFromCategoria("fk_tipo = 3");
$categoriaDespesaObj = new Categoria_Despesa;

$functions = new Functions;

if (isset($_POST['idDespesa'])) {
    $despesaObj = new Despesa;
    $despesa = $despesaObj->selectFromDespesa('', 'id = ' . $_POST['idDespesa']);
    $despesa = $despesa[0];
    $categoriasDespesa = $categoriaDespesaObj->selectAllCategoriaDespesaByDespesaId($_POST['idDespesa']);
}

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
                    <form method="POST" id="formEditDespesas" enctype="multipart/form-data">
                        <div class="row col-md">
                            <div class="mb-3 col-8">
                                <label for="descDespesaInput" class="form-label">Descrição da despesa</label>
                                <input type="text" class="form-control" id="descDespesaInput" name="descDespesaInput" aria-describedby="Nome" placeholder="Ex.: Mercado" value="<?php echo $despesa['descricao_despesa'] ?>" required>
                            </div>
                            <div class="mb-3 col-4">
                                <label for="novoValorInput" class="form-label">Valor</label>
                                <input type="text" class="form-control" name="valorInput" id="novoValorInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" value="<?php echo $functions->formatarRealSemCifrao($despesa['valor']) ?>" required autocomplete="off">
                            </div>
                        </div>
                        <div class="row col-md">
                            <div class="mb-3 col-6">
                                <label for="dataDespesa" class="form-label">Data da despesa</label>
                                <input type="date" class="form-control" id="dataDespesa" name="dataDespesa" aria-describedby="Data da despesa" value="<?php echo $despesa['data_despesa'] ?>" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="dataVencimentoDespesa" class="form-label">Data do vencimento</label>
                                <input type="date" class="form-control" id="dataVencimentoDespesa" name="dataVencimentoDespesa" aria-describedby="Data da despesa" value="<?php echo $despesa['data_vencimento'] ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="imgInput" class="form-label">Imagem</label>
                            <input class="form-control" type="file" id="imgInput" name="imgInput" accept="image/*">
                            <div class="d-flex justify-content-center">
                                <p class="p-warning mb-0">A nova imagem irá substituir a imagem atual!</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contaSelectEdit" class="form-label">Conta</label>
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
                                            <option value="<?php echo $row['id'] ?>" <?php echo ($despesa['fk_conta'] == $row['id']) ? ("selected") : (""); ?>><?php echo $row['nome_conta'] . " - " . $functions->formatarReal($row['saldo_atual']) ?></option>
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
                                    <select id="categoriasSelectEdit" name="categoriasSelect[]" multiple required>
                                        <?php

                                        foreach ($categorias as $row) {
                                            foreach ($categoriasDespesa as $categoria) {
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
                                    <a id="btnAddCategoria" data-bs-target="#modalAddCategoriaDespesa" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-plus-square"></i></a>
                                </div>
                            </div>
                        </div>
                        <input name="editDespesa" class="hide">
                        <input name="idDespesa" class="hide" value="<?php echo $despesa['id'] ?>">
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
    $('#formEditDespesas').submit(function() {

        var x = $('#novoValorInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('novoValorInput').value = x;

        var dados = new FormData(this);

        $.ajax({
            url: '../classes/Despesa.class.php',
            method: 'POST',
            data: dados,
            processData: false,
            contentType: false,
            success: function(msg) {
                alert("Despesa editada com sucesso!" + msg);
                window.history.pushState(null, null, window.location.pathname);
                window.location.reload();
            },
            error: function(msg) {
                alert("Erro ao editada a despesa!");
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