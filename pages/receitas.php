<?php

include_once("../connections/loginVerify.php");

include_once("../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Receitas";
include_once("../include/header.php");
include_once("../pages/modals/modalAddReceita.php");
include_once("../pages/modals/modalDeleteReceita.php");
setTitulo($title);

?>

<body>
    <div id="containerDashboard">

        <?php
        include_once("../include/sideBar.php");
        ?>

        <main>

            <?php
            include_once("../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddReceita">Nova receita</button>
                </div>

                <?php
                $userId = $_SESSION['userId'];
                $sql = $conexao->prepare("SELECT r.*, c.nome_conta, c.id as id_conta FROM receita as r, conta as c WHERE r.fk_usuario = :userId AND r.fk_conta = c.id GROUP BY r.id");
                $sql->bindValue(":userId", $userId);

                try {
                    $sql->execute();
                    $data = $sql->fetchAll();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>

                <!-- tabela do dataTables -->
                <div class="d-flex justify-content-center">
                    <div class="col-12 tableReceitas" id="tableReceitasContainer">
                        <table id="tableReceitas" class="tabela display">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Data</th>
                                    <th>Valor</th>
                                    <th>Conta</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($data as $row) {
                                    $valor = $row['valor'];
                                    $data_receita_formatada = date('d/m/Y', strtotime($row['data_receita']));
                                ?>

                                    <tr>
                                        <td><?php echo $row['descricao_receita'] ?></td>
                                        <td><?php echo $data_receita_formatada ?></td>
                                        <td><?php echo "<span class='p-success'><strong>" . ($formatter->formatCurrency($valor, 'BRL')) . "</strong></span>"; ?></td>
                                        <td><?php echo $row['nome_conta'] ?></td>
                                        <td>
                                            <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-edit"></i>
                                                <?php echo '<a href="../pages/receitas.php?delete=true&type=receita&id=' . $row['id'] . '&desc_receita=' . $row['descricao_receita'] . '&nome_conta=' . $row['nome_conta'] . "&id_conta=" . $row['id_conta'] . "&valor=" . sprintf("%.2f", $row['valor']) . '"' . 'id="btnExcluirReceita"><i class="fas fa-trash-alt"></i></a>' ?>
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

        </main>
    </div>
</body>

<?php
include_once("../include/footer.php");

if (@$_GET['delete'] != null && @$_GET['delete'] == "true") {
    echo    "<script>$(document).ready(function(){
                $('#modalDeleteReceita').modal('show');
            });</script>";
}

?>

<script>
    $(document).ready(function() {

        $('#modalDeleteReceita').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>