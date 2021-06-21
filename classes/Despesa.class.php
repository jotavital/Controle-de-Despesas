<?php

include_once(__DIR__ . "/../connections/Connection.class.php");
include_once(__DIR__ . "/../connections/loginVerify.php");
include_once(__DIR__ . "/Conta.class.php");
include_once(__DIR__ . "/Categoria.class.php");
include_once(__DIR__ . "/Categoria_Despesa.class.php");

class Despesa
{

    function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    function insertCategoriaDespesa()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO categoria (nome_categoria, fk_tipo, fk_usuario) VALUES (:nome_categoria, :fk_tipo, :fk_usuario)");
        $stm->bindValue(":nome_categoria", $_POST['nomeCategoriaInput']);
        $stm->bindValue(":fk_tipo", 3);
        $stm->bindValue(":fk_usuario", $_SESSION['userId']);

        try {
            $stm->execute();

            $msg = "Categoria cadastrada com sucesso!";
        } catch (PDOException $e) {
            echo $e->getMessage();
            $msg = "Erro ao cadastrar categoria!";
        }

        $conn->desconectar();
    }

    function insertDespesa()
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO despesa (descricao_despesa, imagem, data_despesa, data_vencimento, valor, data_inclusao, fk_conta, fk_usuario) VALUES (:descricao_despesa, :imagem, :data_despesa, :data_vencimento, :valor, :data_inclusao, :fk_conta, :fk_usuario)");
        $nomeImg = $_FILES['imgInput']['name'];
        $stm->bindValue(':descricao_despesa', $_POST['descDespesaInput']);
        $stm->bindValue(':imagem', $nomeImg);
        $stm->bindValue(':data_despesa', $_POST['dataDespesa']);
        $stm->bindValue(':data_vencimento', $_POST['dataVencimentoDespesa']);
        $stm->bindValue(':valor', $_POST['valorInput']);
        $stm->bindValue(':data_inclusao', date('Y' . '-' . 'm' . '-' . 'd'));
        $stm->bindValue(':fk_conta', $_POST['contaSelect']);
        $stm->bindValue(':fk_usuario', $_SESSION['userId']);

        try {
            $stm->execute();
            $_SESSION['msg'] = "Despesa adicionada!";

            //armazena imagem da despesa na pasta
            if ($nomeImg != null) {
                $directory = '../uploaded/user_images/despesas_images/' . $_SESSION['userId'];

                if (!file_exists($directory)) {
                    mkdir($directory, 0777);
                }
                $directory = $directory . '/' . $conexao->lastInsertId() . '/';
                mkdir($directory);

                if (copy($_FILES['imgInput']['tmp_name'], $directory . $nomeImg)) {
                    $_SESSION['msg'] = "Foto adicionada com sucesso! ";
                } else {
                    $_SESSION['msg'] = "Erro ao adicionar foto! ";
                }
            }

            //relacionando categorias com despesa
            $despesaId = $conexao->lastInsertId();

            $categoriaDespesaObj = new Categoria_Despesa;

            foreach ($_POST['categoriasSelect'] as $categoria) {
                $categoriaDespesaObj->relacionarCategoriaDespesa($categoria, $despesaId);
            }

            $conta = new Conta;
            $conta->subtrairValorDespesa($_POST['contaSelect'], $_POST['valorInput']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conexao = null;
    }

    function insertDespesaReajuste($valor, $fk_conta)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("INSERT INTO despesa (descricao_despesa, data_despesa, valor, data_inclusao, fk_conta, fk_usuario) VALUES (:descricao_despesa, :data_despesa, :valor, :data_inclusao, :fk_conta, :fk_usuario)");
        $stm->bindValue(':descricao_despesa', "Reajuste de saldo");
        $stm->bindValue(':data_despesa', date('Y' . '-' . 'm' . '-' . 'd'));
        $stm->bindValue(':valor', $valor);
        $stm->bindValue(':data_inclusao', date('Y' . '-' . 'm' . '-' . 'd'));
        $stm->bindValue(':fk_conta', $fk_conta);
        $stm->bindValue(':fk_usuario', $_SESSION['userId']);

        try {
            $stm->execute();

            //relacionando categorias com despesa
            $despesaId = $conexao->lastInsertId();

            $categoriaDespesaObj = new Categoria_Despesa;
            $categoriaDespesaObj->relacionarCategoriaDespesa(19, $despesaId);

            $conta = new Conta;
            $conta->subtrairValorDespesa($fk_conta, $valor);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conexao = null;
    }

    function deletarImagensDespesa($path)
    {
        $files = glob($path . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }

        rmdir($path);
    }

    function deletarDespesa($idDespesa)
    {

        $conn = new Connection;
        $conexao = $conn->conectar();

        $categoriaDespesaObj = new Categoria_Despesa;
        $categoriaDespesaObj->desvincularTodasCategoriasDespesa($idDespesa);

        $stm = $conexao->prepare("DELETE FROM despesa WHERE id = :idDespesa");
        $stm->bindValue("idDespesa", $idDespesa);

        try {

            $stm->execute();

            $conta = new Conta;
            $conta->somarValorDespesa($_POST['idConta'], $_POST['valorDespesa']);

            $path = "../uploaded/user_images/despesas_images/" . $_SESSION['userId'] . "/" . $idDespesa;
            $this->deletarImagensDespesa($path);

            header('Location: ../../pages/despesas.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn->desconectar();
    }

    function deletarTodasDespesasConta($idConta)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();
        $categoriaDespesaObj = new Categoria_Despesa;

        $stmSelectDespesasConta = $conexao->prepare("SELECT id as despesa_id FROM despesa where fk_conta = :idConta");
        $stmSelectDespesasConta->bindValue("idConta", $idConta);

        try {
            $stmSelectDespesasConta->execute();

            $resultDespesasConta = $stmSelectDespesasConta->fetchAll();

            foreach ($resultDespesasConta as $despesa) {
                $categoriaDespesaObj->desvincularTodasCategoriasDespesa($despesa['despesa_id']);
            }

            $stmDespesa = $conexao->prepare("DELETE FROM despesa WHERE fk_conta = :idConta");
            $stmDespesa->bindValue("idConta", $idConta);

            try {
                $stmDespesa->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn->desconectar();
    }

    function selectValorTotalDespesasByMonth($mes)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("SELECT SUM(valor) FROM despesa WHERE month(despesa.data_despesa) = :mes AND despesa.fk_usuario = :userId");
        $stm->bindValue(":mes", $mes);
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
            $result = $stm->fetch();

            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

        $conn->desconectar();
    }

    function selectValorTotalDespesasTodosDiasByMonth($mes)
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare(
            "SELECT sum(valor) as valor, 
            DAY(data_despesa) as dia,
            data_despesa
            FROM despesa 
            WHERE month(despesa.data_despesa) = :mes
            AND despesa.fk_usuario = :userId 
            AND despesa.data_despesa > DATE_SUB(data_despesa,INTERVAL DAYOFMONTH(data_despesa)-1 DAY) 
            AND despesa.data_despesa < LAST_DAY(data_despesa)
            GROUP BY dia"
        );

        $stm->bindValue(":mes", $mes);
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
            $result = $stm->fetchAll();

            $array = array();


            for ($i = 0; $i < 31; $i++) {
                array_push($array, 0);
            }

            foreach ($result as $row) {
                $array[$row["dia"]] = $row["valor"];
            }

            return $array;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

        $conn->desconectar();
    }

    function deletarTodasDespesasUsuario()
    {
        $conta = new Conta;
        $despesa = new Despesa;

        $todasContasUsuario = $conta->selectTodasContasUsuario();

        foreach ($todasContasUsuario as $idContaUsuario) {
            $despesa->deletarTodasDespesasConta($idContaUsuario['id']);
        }
    }

    function selectFromDespesa($campos = '', $condicao = '')
    {
        $conn = new Connection;
        $conexao = $conn->conectar();

        if ($campos == '') {
            $campos = '*';
        }

        if ($condicao != '') {
            $sql = "SELECT " . $campos .  " FROM despesa WHERE " . $condicao . "";
        } else {
            $sql = "SELECT " . $campos .  " FROM despesa ";
        }

        $stm = $conexao->prepare($sql);

        try {
            $stm->execute();

            $result = $stm->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function updateDespesa($idDespesa)
    {
        $conta = new Conta;
        $despesaObj = new Despesa;
        $categoriaDespesaObj = new Categoria_Despesa;
        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("  UPDATE despesa 
                                    SET descricao_despesa = :descricao_despesa,
                                    imagem = :imagem, 
                                    data_despesa = :data_despesa, 
                                    data_vencimento = :data_vencimento, 
                                    valor = :valor, 
                                    fk_conta = :fk_conta, 
                                    fk_usuario = :fk_usuario
                                    WHERE id = :idDespesa
                                    ");

        $nomeImg = $_FILES['imgInput']['name'];
        $stm->bindValue(':descricao_despesa', $_POST['descDespesaInput']);
        $stm->bindValue(':imagem', $nomeImg);
        $stm->bindValue(':data_despesa', $_POST['dataDespesa']);
        $stm->bindValue(':data_vencimento', $_POST['dataVencimentoDespesa']);
        $stm->bindValue(':valor', $_POST['valorInput']);
        $stm->bindValue(':fk_conta', $_POST['contaSelect']);
        $stm->bindValue(':fk_usuario', $_SESSION['userId']);
        $stm->bindValue(':idDespesa', $idDespesa);

        $dadosDespesa = $despesaObj->selectFromDespesa('valor, fk_conta', 'id = ' . $idDespesa);

        try {
            $stm->execute();
            $_SESSION['msg'] = "Despesa editada!";

            if ($nomeImg != null) {

                $path = "../uploaded/user_images/despesas_images/" . $_SESSION['userId'] . "/" . $idDespesa;
                $this->deletarImagensDespesa($path);

                $directory = '../uploaded/user_images/despesas_images/' . $_SESSION['userId'];

                if (!file_exists($directory)) {
                    mkdir($directory, 0777);
                }
                $directory = $directory . '/' . $idDespesa . '/';
                mkdir($directory);

                if (copy($_FILES['imgInput']['tmp_name'], $directory . $nomeImg)) {
                    $_SESSION['msg'] = "Foto adicionada com sucesso! ";
                } else {
                    $_SESSION['msg'] = "Erro ao adicionar foto! ";
                }
            }

            //relacionando categorias com despesa
            $categoriaDespesaObj->desvincularTodasCategoriasDespesa($idDespesa);

            foreach ($_POST['categoriasSelect'] as $categoria) {
                $categoriaDespesaObj->relacionarCategoriaDespesa($categoria, $idDespesa);
            }

            $conta->somarValorDespesa($dadosDespesa[0]['fk_conta'], $dadosDespesa[0]['valor']);
            $conta->subtrairValorDespesa($_POST['contaSelect'], $_POST['valorInput']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conexao = null;
    }
}

if (isset($_POST['deleteDespesa'])) {
    $deleteDespesa = new Despesa;
    $deleteDespesa->deletarDespesa($_POST['idDespesa']);
}

if (isset($_POST['editDespesa'])) {
    $editDespesa = new Despesa;
    $editDespesa->updateDespesa($_POST['idDespesa']);
}

if (isset($_POST['insertCategoriaDespesa'])) {
    $deleteDespesa = new Despesa;
    $deleteDespesa->insertCategoriaDespesa();
}

if (isset($_POST['insertDespesa'])) {
    $deleteDespesa = new Despesa;
    $deleteDespesa->insertDespesa();
}
