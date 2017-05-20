
<?php
//require_once "database.php";


class Admin
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertimage($target_path,$id){

        $query = "INSERT INTO image_gallery 
                  (image_path,event_id)
                  VALUES (:target_path,:event_id)";

        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':target_path', $target_path, PDO::PARAM_STR);

        $pdostmt->bindValue(':event_id', $id, PDO::PARAM_STR);

        $row = $pdostmt->execute();

        return $row;
    }


    public function getimages()
    {
        $query = "SELECT * FROM  image_gallery";
        $pdostmt = $this->db->prepare($query);

        $row2 = $pdostmt->execute();
        $row2 = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $row2;
    }

    public function getevents()
    {
        //var_dump($value);
        $query="SELECT * FROM events ";
        $pdostmt = $this->db->prepare($query);

        $pdostmt->execute();
        $row3 = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $row3;
    }

    public function getimagebyeventid($id)
    {

            //var_dump($value);
            $query="SELECT * FROM image_gallery WHERE event_id = :id";
            $pdostmt = $this->db->prepare($query);
            $pdostmt->bindValue(':id',$id, PDO::PARAM_STR);
            $pdostmt->execute();
            $row4 = $pdostmt->fetchAll(PDO::FETCH_OBJ);
            return $row4;

    }

    public function getimagebyid($value)
    {
        {
            //var_dump($value);
            $query="SELECT * FROM image_gallery WHERE id = :value";
            $pdostmt = $this->db->prepare($query);
            $pdostmt->bindValue(':id',$value, PDO::PARAM_STR);
            $pdostmt->execute();
            $row5= $pdostmt->fetch(PDO::FETCH_OBJ);
            return $row5;
        }
    }


    public function todeletedata($image_id)
    {

        $query = "DELETE FROM image_gallery WHERE Id = :image_id";
        $pdostmt1 = $this->db->prepare($query);
        $pdostmt1->bindValue(':image_id',$image_id, PDO::PARAM_INT);
        $row6 = $pdostmt1->execute();
        return $row6;


    }

}