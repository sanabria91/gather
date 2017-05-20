<?php

class Suggest
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function listSuggestions()
    {
        $query = "SELECT * FROM suggestions";
        $pdostmt = $this->db->prepare($query);
        $pdostmt->execute();
        $list = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $list;
    }

    public function getDetails($id)
    {
        $query2 = "SELECT * FROM suggestions WHERE id = :id";
        $pdostmt2 = $this->db->prepare($query2);
        $pdostmt2->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt2->execute();
        $details = $pdostmt2->fetch(PDO::FETCH_OBJ);
        return $details;
    }

    public function addSuggest($fname, $lname ,$email, $date, $title, $suggest, $sugg_id)
    {
        $query3 = "INSERT INTO suggestions
                    (first_name, last_name, email, date, title, suggest, BusinessId)
                    VALUES(:first_name, :last_name, :email, :date, :title, :suggest, :BusinessId)";
        $pdostmt3 = $this->db->prepare($query3);
        $pdostmt3->bindValue(':first_name',$fname, PDO::PARAM_STR);
        $pdostmt3->bindValue(':last_name',$lname, PDO::PARAM_STR);
        $pdostmt3->bindValue(':email',$email,PDO::PARAM_STR);
        $pdostmt3->bindValue(':date',$date,PDO::PARAM_STR);
        $pdostmt3->bindValue(':title',$title,PDO::PARAM_STR);
        $pdostmt3->bindValue(':suggest',$suggest,PDO::PARAM_STR);
        $pdostmt3->bindValue(':BusinessId',$sugg_id,PDO::PARAM_INT);
        $add = $pdostmt3->execute();
        return $add;
    }

    public function deleteSuggest($id)
    {
        $query4 = "DELETE FROM suggestions WHERE id = :id";
        $pdostmt4 = $this->db->prepare($query4);
        $pdostmt4->bindValue(':id',$id, PDO::PARAM_INT);
        $delete = $pdostmt4->execute();
        return $delete;
    }

    public function updateDetails($id, $fname, $lname ,$email, $date, $title, $suggest)
    {
        $query5 = "UPDATE suggestions SET first_name= :first_name, last_name= :last_name, email= :email,
                    date= :date, title= :title, suggest= :suggest
                    WHERE id= :id";
        $pdostmt5= $this->db->prepare($query5);
        $pdostmt5->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt5->bindValue(':first_name',$fname, PDO::PARAM_STR);
        $pdostmt5->bindValue(':last_name',$lname, PDO::PARAM_STR);
        $pdostmt5->bindValue(':email',$email,PDO::PARAM_STR);
        $pdostmt5->bindValue(':date',$date,PDO::PARAM_STR);
        $pdostmt5->bindValue(':title',$title,PDO::PARAM_STR);
        $pdostmt5->bindValue(':suggest',$suggest,PDO::PARAM_STR);
        $update = $pdostmt5->execute();
        return $update;
    }

    public function postMsg($id, $Reply)
    {
        $query6 = "UPDATE suggestions SET Reply = :Reply
                    WHERE id = :id";
        $pdostmt6 = $this->db->prepare($query6);
        $pdostmt6->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt6->bindValue(':Reply',$Reply, PDO::PARAM_STR);
        $addMsg = $pdostmt6->execute();
        return $addMsg;
    }

    public function getMsg($id)
    {
        $query7 = "SELECT Reply from suggestions
                    WHERE id= :id";
        $pdostmt7= $this->db->prepare($query7);
        $pdostmt7->bindValue(':id', $id, PDO::PARAM_INT);
        $msg = $pdostmt7->execute();
        return $msg;
    }

    public function blogDetails($id)
    {
        $query8 = "SELECT * FROM business
                    WHERE id = :id ";
        $pdostmt8 = $this->db->prepare($query8);
        $pdostmt8->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt8->execute();
        $details = $pdostmt8->fetch(PDO::FETCH_OBJ);
        return $details;
    }

    public function listBusiness(){
        $query10 = "SELECT * FROM business";
        $pdostmt10 = $this->db->prepare($query10);
        $pdostmt10->execute();
        $list = $pdostmt10->fetchAll(PDO::FETCH_OBJ);
        return $list;
    }
}

?>