<?php

include("../connections/loginVerify.php");
$title = "Receitas";
include("../include/header.php");
include("../pages/modals/modalAddReceita.php");
include("../pages/modals/modalDeleteReceita.php");
setTitulo($title);

?>

<body>
    <div id="containerDashboard">

        <?php
        include("../include/sideNav.php");
        ?>

        <main>

            <?php
            include("../include/navBar_logged.php");
            ?>

            <div id="contentDashboard">
                <div class="row">
                    <h3 class="mb-4 d-flex justify-content-center">Receitas</h3>
                </div>
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddReceita">Nova receita</button>
                </div>

                <?php
                $userId = $_SESSION['userId'];
                $sql = $conn->prepare("SELECT r.*, c.nome_conta FROM receita as r, conta as c WHERE r.fk_usuario = :userId AND r.fk_conta = c.id GROUP BY r.id");
                $sql->bindValue(":userId", $userId);
                $sql->execute();
                $data = $sql->fetchAll();
                ?>

                <!-- tabela do dataTables -->
                <div class="d-flex justify-content-center">
                    <div class="col-12 tableReceitas" id="tableReceitasContainer">
                        <table id="tableReceitas" class="display">
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
                                    $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
                                ?>

                                    <tr>
                                        <td><?php echo $row['descricao_receita'] ?></td>
                                        <td><?php echo $row['data_receita'] ?></td>
                                        <td><?php echo ($formatter->formatCurrency($valor, 'BRL')); ?></td>
                                        <td><?php echo $row['nome_conta'] ?></td>
                                        <td>
                                            <div class="col-12 d-flex justify-content-center">
                                                <i class="fas fa-edit"></i>
                                                <i class="fas fa-trash-alt"></i>
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
include("../include/footer.php");

if (@$_GET['delete'] != null && @$_GET['delete'] == "true") {
    echo    "<script>$(document).ready(function(){
                $('#modalDeleteReceita').modal('show');
            });</script>";
}

?>

<script>
    $(document).ready(function() {
        $('#tableReceitas').DataTable();
    });
</script>