<?php

include_once(__DIR__ . "/../connections/Connection.class.php");
include_once(__DIR__ . "/../connections/loginVerify.php");

class Transacao
{

    function selectTodasTransacoesUsuario()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $conn = new Connection;
        $conexao = $conn->conectar();

        $stm = $conexao->prepare("  SELECT * FROM 
                                    ( SELECT despesa.id as id, despesa.descricao_despesa AS descricao, despesa.data_despesa AS data_transacao, 
                                    despesa.data_vencimento AS data_vencimento, despesa.valor AS valor, despesa.fk_conta, 
                                    despesa.tipo AS tipo 
                                    FROM despesa 
                                    WHERE despesa.fk_usuario = :userId 
                                    UNION ALL 
                                    SELECT receita.id, receita.descricao_receita, receita.data_receita, NULL, receita.valor, 
                                    receita.fk_conta, receita.tipo AS tipo 
                                    FROM receita 
                                    WHERE receita.fk_usuario = :userId  ) recdes 
                                    INNER JOIN 
                                    (SELECT conta.id as idConta, conta.nome_conta FROM conta) c on c.idConta = recdes.fk_conta
                                    ORDER BY recdes.data_transacao DESC
                                ");
        $stm->bindValue(":userId", $_SESSION['userId']);

        try {
            $stm->execute();
            $resultado = $stm->fetchAll();

            return $resultado;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}
