<?php

include_once(__DIR__ . "/../connections/loginVerify.php");

include_once(__DIR__ . "/../connections/Connection.class.php");
$conn = new Connection;
$conexao = $conn->conectar();

$title = "Transações";
include_once(__DIR__ . "/../include/header.php");
include_once(__DIR__ . "/modals/modalDeleteDespesa.php");
include_once(__DIR__ . "/modals/modalDeleteReceita.php");
include_once(__DIR__ . "/modals/modalEditDespesa.php");
include_once(__DIR__ . "/modals/modalEditReceita.php");
setTitulo($title);

include_once(__DIR__ . "/../classes/Transacao.class.php");
$transacaoObj = new Transacao;

$result = $transacaoObj->selectTodasTransacoesUsuario();

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
                <div class="row col-md">

                    <div class="cardTabela">
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="card br-25 col-10 overflow-auto">
                                <div class="card-header bg-light-blue text-white">
                                    <h3 class="col-12 d-flex justify-content-center">Histórico de Transações</h3>
                                </div>
                                <div class="card-body p-1">
                                    <div class="d-flex justify-content-center">
                                        <div class="col-12 tableTransacoes" id="tableDespesasContainer">
                                            <table id="tableTransacoes" class="tabela table hover order-column row-border table-hover table-bordered table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="d-flex justify-content-center">
                                                                Tipo
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="d-flex justify-content-center">
                                                                Descrição
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="d-flex justify-content-center">
                                                                Data
                                                                <div class="ms-2 iconOrdenacao">
                                                                    <i class="p-warning fas fa-sort-amount-down"></i>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="d-flex justify-content-center">
                                                                Vencimento
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="d-flex justify-content-center">
                                                                Valor
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="d-flex justify-content-center">
                                                                Conta
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="d-flex justify-content-center">
                                                                Ações
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    foreach ($result as $row) {
                                                        $valor = $row['valor'];

                                                        if ($row['tipo'] == 'despesa') {
                                                            $data_despesa_formatada = date('d/m/Y', strtotime($row['data_transacao']));
                                                            $data_vencimento_formatada = date('d/m/Y', strtotime($row['data_vencimento']));
                                                    ?>

                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        <i class="p-danger fas fa-arrow-circle-down"></i>
                                                                    </div>
                                                                </td>
                                                                <td><?php echo $row['descricao'] ?></td>
                                                                <td><?php echo $data_despesa_formatada ?></td>
                                                                <td><?php echo $data_vencimento_formatada == "30/11/-0001" ? "-" : $data_vencimento_formatada ?></td>
                                                                <td><?php echo "<span class='p-danger'><strong>" . $functions->formatarReal($valor) . "</strong></span>"; ?></td>
                                                                <td><?php echo $row['nome_conta'] ?></td>
                                                                <td>
                                                                    <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                                        <form action="?edit=true&type=despesa" method="post" id="triggerEdit">
                                                                            <input type="hidden" name="idDespesa" value="<?php echo $row['id']; ?>">
                                                                            <button type="submit" class="iconButton">
                                                                                <?php echo "<i class='fas fa-edit p-primary'></i>" ?>
                                                                            </button>
                                                                        </form>
                                                                        <form action="?delete=true&type=despesa" method="post">
                                                                            <input type="hidden" name="idDespesa" value="<?php echo $row['id']; ?>">
                                                                            <button type="submit" class="iconButton">
                                                                                <?php echo "<i class='fas fas fa-trash p-danger'></i>" ?>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        <?php
                                                        } elseif ($row['tipo'] == 'receita') {
                                                            $data_receita_formatada = date('d/m/Y', strtotime($row['data_transacao']));
                                                        ?>

                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        <i class="p-success fas fa-arrow-circle-up"></i>
                                                                    </div>
                                                                </td>
                                                                <td><?php echo $row['descricao'] ?></td>
                                                                <td><?php echo $data_receita_formatada ?></td>
                                                                <td> - </td>
                                                                <td><?php echo "<span class='p-success'><strong>" . $functions->formatarReal($valor) . "</strong></span>"; ?></td>
                                                                <td><?php echo $row['nome_conta'] ?></td>
                                                                <td>
                                                                    <div class="actionIcons col-12 d-flex align-items-center justify-content-center">
                                                                        <form action="?edit=true&type=receita" method="post" id="triggerEdit">
                                                                            <input type="hidden" name="idReceita" value="<?php echo $row['id']; ?>">
                                                                            <button type="submit" class="iconButton">
                                                                                <?php echo "<i class='fas fa-edit p-primary'></i>" ?>
                                                                            </button>
                                                                        </form>
                                                                        <form action="?delete=true&type=receita" method="post" id="triggerEdit">
                                                                            <input type="hidden" name="idReceita" value="<?php echo $row['id']; ?>">
                                                                            <button type="submit" class="iconButton">
                                                                                <?php echo "<i class='fas fas fa-trash p-danger'></i>" ?>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

if (isset($_GET['delete'])) {
    if ($_GET['delete'] != null && $_GET['delete'] == "true") {

        if ($_GET['type'] == "despesa") {

            echo    "<script>$(document).ready(function(){
                        $('#modalDeleteDespesa').modal('show');
                    });</script>";
        } elseif ($_GET['type'] == "receita") {

            echo    "<script>$(document).ready(function(){
                        $('#modalDeleteReceita').modal('show');
                    });</script>";
        }
    }
}

if (@$_GET['edit'] != null && @$_GET['edit'] == "true") {
    if ($_GET['type'] == "despesa") {

        echo    "<script>$(document).ready(function(){
                    $('#modalEditDespesa').modal('show');
                });</script>";
    } elseif ($_GET['type'] == "receita") {

        echo    "<script>$(document).ready(function(){
                    $('#modalEditReceita').modal('show');
                });</script>";
    }
}

?>

<script>
    $(document).ready(function() {

        $('#modalDeleteDespesa').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalEditDespesa').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalEditReceita').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });

        $('#modalDeleteReceita').on('hidden.bs.modal', function() {
            window.history.pushState(null, null, window.location.pathname);
        });
    });
</script>