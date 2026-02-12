<?php
function echange_insertion ($pdo, $id_users1, $id_users2, $id_items1, $id_items2){
    try{
        $sql = "INSERT INTO echange_transaction (id_users1, id_users2, id_items1, id_items2)
                VALUES (:id_users1, :id_users2, :id_items1, :id_items2)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_users1', $id_users1, PDO::PARAM_INT);
        $stmt->bindParam(':id_users2', $id_users2, PDO::PARAM_INT);
        $stmt->bindParam(':id_items1', $id_items1, PDO::PARAM_INT);
        $stmt->bindParam(':id_items2', $id_items2, PDO::PARAM_INT);

        $stmt->execute();
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

function plusapparetenir($pdo, $id_item_users){
    try{
        $etat = 0;
        $sql = "UPDATE item_users
                SET etat = :etat
                WHERE id_items = :id_item_users";
        $stmtUpdate = $pdo->prepare($sql);
        $stmtUpdate->bindParam(':etat', $etat, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id_item_users', $id_item_users, PDO::PARAM_INT);
        $stmtUpdate->execute();

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
?>