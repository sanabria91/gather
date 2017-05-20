
<?php
//require_once "database.php";


class Admin
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function getevents()
    {
        $query = "SELECT * FROM  events";
        $pdostmt = $this->db->prepare($query);

        $row = $pdostmt->execute();
        $row = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $row;
    }

    public function insertdata($user_email,$payment_amount,$event_id,$gathering_id){

        $query = "INSERT INTO payments 
                  (user_email,payment_amount,event_id,gathering_id)
                  VALUES (:user_email,:payment_amount,:event_id,:gathering_id)";

        $pdostmt = $this->db->prepare($query);

        $pdostmt->bindValue('user_email', $user_email, PDO::PARAM_INT);
        $pdostmt->bindValue('payment_amount', $payment_amount, PDO::PARAM_INT);
        $pdostmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $pdostmt->bindValue(':gathering_id', $gathering_id, PDO::PARAM_INT);
        $row2 = $pdostmt->execute();

        return $row2;
    }

    public function getpayments($businessid)
    {
        $query = "SELECT * FROM  payments JOIN events ON payments.event_id=events.id WHERE events.BusinessId = :businessid";
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':businessid', $businessid, PDO::PARAM_INT);
        $row3 = $pdostmt->execute();
        $row3 = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $row3;
    }

    public function geteventbyid($id)
    {
        //var_dump($value);
        $query3="SELECT * FROM events WHERE id = :id";
        $pdostmt3 = $this->db->prepare($query3);
        $pdostmt3->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt3->execute();
        $row4 = $pdostmt3->fetch(PDO::FETCH_OBJ);
        return $row4;
    }


    public function deletepayment($id)
    {

        $query = "DELETE FROM payments WHERE id= :id";
        $pdostmt1 = $this->db->prepare($query);
        $pdostmt1->bindValue(':id',$id, PDO::PARAM_INT);
        $row5 = $pdostmt1->execute();
        return $row5;

    }

    public function getpaymentsbyid($id)
    {

        $query3="SELECT * FROM payments WHERE id = :id";
        $pdostmt3 = $this->db->prepare($query3);
        $pdostmt3->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt3->execute();
        $row6 = $pdostmt3->fetch(PDO::FETCH_OBJ);
        return $row6;
    }

    public function getPaymentbyEvent($eid){
        $query4 = "SELECT price FROM payments p LEFT JOIN events e ON event_id = e.id WHERE e.id = :eid";

        $pdostmt6 = $this->db->prepare($query4);
        $pdostmt6->bindValue(':eid',$eid);

        $pdostmt6->execute();
        $row = $pdostmt6->fetch(PDO::FETCH_OBJ);

        return $row;

    }



}
