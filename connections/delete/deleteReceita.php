<?php
    include("../connection.php");

    class DeleteReceita{

        function deleteReceita($idReceita){
            $conn = (new Connection)->conectar();
        
            $stm = $conn->prepare("DELETE FROM categoria_receita WHERE fk_receita = :idReceita");
            $stm->bindValue("idReceita", $idReceita);
        
            try {
                $stm->execute();
        
                $stm2 = $conn->prepare("DELETE FROM receita WHERE id = :idReceita");
                $stm2->bindValue("idReceita", $idReceita);
            
                try {
                    $stm2->execute();
            
                    header('Location: ../../pages/receitas.php');
                } catch (PDOException $e) {
                    print_r($e);
                }
            } catch (PDOException $e) {
                print_r($e);
            }
        }

    }
