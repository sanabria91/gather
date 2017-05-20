<?php

class ListDAO
{
    public function getItems($db){
        $query = "SELECT t.*, u.username FROM to_do t LEFT JOIN users u ON t.user_id = u.id ORDER BY t.created";
        $pdostmt = $db->prepare($query);
        $pdostmt->execute();

        $items = $pdostmt->fetchAll();
        return $items;
    }

    public function getItemsDetails($db, $id){
        $query7 = "SELECT * FROM to_do WHERE id = :id";
        $pdostmt2 = $db->prepare($query7);
        $pdostmt2->bindValue(':id',$id);
        $pdostmt2->execute();
        $list = $pdostmt2->fetch();

        return $list;
    }

    public function getItemsByUser($db, $user){
        $query = "SELECT id,listitem, done FROM to_do WHERE user_id = :user";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(':user',$user);
        $pdostmt->execute();

        $items = $pdostmt->fetchAll();
        return $items;
    }

    public function addItem($db, $listitem, $user){
        $insertedId = "";

        $query2 = "INSERT INTO to_do (listitem, user_id, done) VALUES (:listitem, :user, 0)";

        $pdostmt2 = $db->prepare($query2);
        $pdostmt2->bindValue(':listitem',$listitem);
        $pdostmt2->bindValue(':user',$user);

        $pdostmt2->execute();
        $insertedId = $db->lastInsertId();
        $pdostmt2->closeCursor();
        return $insertedId;
    }

    public function deleteItem($db, $id){
        $query4 = "DELETE FROM to_do WHERE id=:id";

        $pdostmt4 = $db->prepare($query4);
        $pdostmt4->bindValue(':id',$id);

        $pdostmt4->execute();
        $pdostmt4->closeCursor();
    }

    public function updateItem($db,$listitem, $done, $id){
        $query5 = "UPDATE to_do SET listitem=:listitem, done=:done WHERE id=:id";
        
        $pdostmt5 = $db->prepare($query5);
        $pdostmt5->bindValue(':listitem', $listitem);
        $pdostmt5->bindValue(':done', $done);
        $pdostmt5->bindValue(':id', $id);
        
        $pdostmt5->execute();
        $pdostmt5->closeCursor();
    }
}