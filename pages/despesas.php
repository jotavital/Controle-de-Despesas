<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Despesas";
include_once(__DIR__ . "/../include/header.php");
include_once(__DIR__ . "/modals/modalAddDespesa.php");
include_once(__DIR__ . "/modals/modalDeleteDespesa.php");
setTitulo($title);

?>

<body>
    <div id="containerDashboard">

        <?php
        include_once(__DIR__ . "/../include/sideBar.php");
        ?>

        <main>

            <?php
            include_once(__DIR__ . "/../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddDespesa">Nova despesa</button>
                </div>
                <div class="row col-12 cardsContainer" id="containerCardsDespesas">

                    <?php
                    $userId = $_SESSION['userId'];
                    $stm = $conexao->prepare("SELECT d.*, c.nome_conta FROM despesa as d, conta as c WHERE d.fk_usuario = :userId AND d.fk_conta = c.id GROUP BY d.id");
                    $stm->bindValue(":userId", $userId);

                    try {
                        $stm->execute();
                        $data = $stm->fetchAll();
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }

                    ?>

                    <!-- tabela do dataTables -->
                    <div class="d-flex justify-content-center">
                        <div class="col-12 tableDespesas" id="tableDespesasContainer">
                            <table id="tableDespesas" class="tabela display">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Data</th>
                                        <th>Vencimento</th>
                                        <th>Valor</th>
                                        <th>Conta</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($data as $row) {
                                        $valor = $row['valor'];
                                        $data_despesa_formatada = date('d/m/Y', strtotime($row['data_despesa']));
                                        $data_vencimento_formatada = date('d/m/Y', strtotime($row['data_vencimento']));
                                    ?>

                                        <tr>
                                            <td><?php echo $row['descricao_despesa'] ?></td>
                                            <td><?php echo $data_despesa_formatada ?></td>
                                            <td><?php echo $data_vencimento_formatada ?></td>
                                            <td><?php echo "<span class='p-danger'><strong>" . ($formatter->formatCurrency($valor, 'BRL')) . "</strong></span>"; ?></td>
                                            <td><?php echo $row['nome_conta'] ?></td>
                                            <td>
                                                <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-edit"></i>
                                                    <?php echo '<a href="../pages/despesas.php?delete=true&type=despesa&id=' . $row['id'] . '&desc_despesa=' . $row['descricao_despesa'] . '&id_conta=' . $row['fk_conta'] . '&nome_conta=' . $row['nome_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirDespesa"><i class="fas fa-trash-alt"></i></a>' ?>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>

<?php
include_once(__DIR__ . "/../include/footer.php");
?>

<?php

if (@$_GET['delete'] != null && @$_GET['delete'] == "true") {
    echo    "<script>$(document).ready(function(){
                $('#modalDeleteDespesa').modal('show');
            });</script>";
}

?>

<script>
    $(document).ready(function() {

        $('#modalDeleteDespesa').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>