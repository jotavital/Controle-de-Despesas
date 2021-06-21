<?php

if (isset($_POST['newRow'])) {
    $newRow = unserialize(base64_decode($_POST['newRow']));
}

$categoriaObj = new Categoria;
$data = $categoriaObj->selectAllFromCategoria("fk_tipo = 2");

$functions = new Functions;

?>

<div class="modal fade" id="modalEditMeta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEditMetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditMetaLabel">Editar dados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="metainer-fluid">
                    <form method="POST" id="formEditMetas">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="nomeMetaInput" class="form-label">Nome da meta</label>
                                <input type="text" value="<?php echo $newRow['nome_meta'] ?>" class="form-control" id="nomeMetaInput" name="nomeMetaInput" aria-describedby="Nome" placeholder="Ex.: Bateria Eletrônica" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="prazoMeta" class="form-label">Prazo</label>
                                <input type="date" value="<?php echo $newRow['prazo_meta'] ?>" class="form-control" id="prazoMeta" name="prazoMeta" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="valorMetaInput" class="form-label">Valor total</label>
                                <input type="text" value="<?php echo $functions->formatarRealSemCifrao($newRow['valor_total']) ?>" autocomplete="off" class="form-control" name="valorMetaInput" id="valorMetaInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="valorAtingidoInput" class="form-label">Valor atingido</label>
                                <input type="text" value="<?php echo $functions->formatarRealSemCifrao($newRow['valor_atingido']) ?>" autocomplete="off" class="form-control" name="valorAtingidoInput" id="valorAtingidoInput" onkeypress="$(this).mask('000.000.000,00', {reverse: true});">
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="descricaoMetaInput" class="form-label">Descrição da meta</label>
                            <textarea style="resize:none;" class="form-control" id="descricaoMetaInput" name="descricaoMetaInput" aria-describedby="Descrição" placeholder="Ex.: Minha tão sonhada bateria eletrônica"><?php echo $newRow['descricao_meta']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaSelect" class="form-label">Categoria</label>
                            <div class="row col-12 d-flex align-items-center">
                                <div class="col-11">
                                    <select id="categoriaSelect" name="categoriaSelect" class="form-select" required>
                                        <?php

                                        foreach ($data as $row) {

                                        ?>

                                            <option value="<?php echo $row['id'] ?>" <?php echo ($newRow['fk_categoria'] == $row['id']) ? ("selected") : (""); ?>><?php echo $row['nome_categoria'] ?></option>

                                        <?php

                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <a id="btnAddCategoria" data-bs-target="#modalAddCategoriaMeta" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-plus-square"></i></a>
                                </div>
                            </div>
                        </div>
                        <input name="editMeta" class="hide">
                        <input name="idMeta" value="<?php echo $newRow['id'] ?>" class="hide">
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

    $('#formEditMetas').submit(function() {
        var valorMetaInput = $('#valorMetaInput').val();
        console.log(valorMetaInput);
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
                alert("Meta atualizada com sucesso!");
                window.history.pushState(null, null, window.location.pathname);
                window.location.reload();
            },
            error: function(msg) {
                alert("Erro ao atualizar a meta! " + msg);
            }
        });

        return false;
    });
</script>