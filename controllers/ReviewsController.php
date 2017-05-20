
<?php
class Admin
{
    private $db;


    public function __construct($db)
    {
         $this->db=$db;
    }

    public function getalldata()
    {
        $query = "SELECT * FROM review ORDER BY date DESC";
        $pdostmt = $this->db->prepare($query);
        $pdostmt->execute();

        $review = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $review;
    }

    public function getalldatabyId($id)
    {
        $query = "SELECT * FROM review  WHERE business_id= :id ORDER BY date DESC";
        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':id',$id);
        $pdostmt->execute();

        $review = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $review;
    }


    public function displayalldata($post_id)
    {

        $query2 = "SELECT * FROM review WHERE post_id = :post_id";
        $pdostmt1 = $this->db->prepare($query2);
        $pdostmt1->bindValue(':post_id',$post_id, PDO::PARAM_INT);
        $pdostmt1->execute();

        $row = $pdostmt1->fetch(PDO::FETCH_OBJ);

        return $row;
    }

    public function todeletedata($post_id)
{

    $query = "DELETE FROM review WHERE post_id = :post_id";
    $pdostmt1 = $this->db->prepare($query);
    $pdostmt1->bindValue(':post_id',$post_id, PDO::PARAM_INT);
    $row = $pdostmt1->execute();
    return $row;
    //echo "Deleted " . $row;
   //header("Location: admin-view.php");
    }


    public function toeditdata($status,$post_id)

    {
        $query2="UPDATE review SET status=:status WHERE post_id=:post_id ";

        $pdostmt2 = $this->db->prepare($query2);
        $pdostmt2->bindValue(':post_id',$post_id, PDO::PARAM_INT);
        $pdostmt2->bindValue(':status',$status, PDO::PARAM_STR);
        $row2 = $pdostmt2->execute();
        return $row2;
    }
    public function searchdata($value)

    {
        $query3="SELECT * FROM review WHERE status = :value";
        $pdostmt3 = $this->db->prepare($query3);
        $pdostmt3->bindValue(':value',$value, PDO::PARAM_STR);
        $pdostmt3->execute();
        $row3 = $pdostmt3->fetchAll(PDO::FETCH_OBJ);
        return $row3;
    }

    public function insertdata($fname,$email,$review,$businessId ){

        $query = "INSERT INTO review 
                  (fname, email,review,business_id)
                  VALUES (:fname, :email,:review,:businessId)";

        $pdostmt = $this->db->prepare($query);
        $pdostmt->bindValue(':fname', $fname, PDO::PARAM_STR);
        $pdostmt->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt->bindValue(':review', $review, PDO::PARAM_STR);

        $pdostmt->bindValue(':businessId', $businessId, PDO::PARAM_INT);
        $row = $pdostmt->execute();

        return $row;
    }

    public function searchbusinessbyID($value)
    {
        //var_dump($value);
        $query3="SELECT * FROM business WHERE id = :id";
        $pdostmt3 = $this->db->prepare($query3);
        $pdostmt3->bindValue(':id',$value, PDO::PARAM_INT);
        $pdostmt3->execute();
        $row3 = $pdostmt3->fetch(PDO::FETCH_OBJ);
        return $row3;
    }

    public function getlikes($post_id)
    {
      $query4=  "UPDATE review set likes = likes+1 where post_id = :post_id ";
        $pdostmt3 = $this->db->prepare($query4);
        $pdostmt3->bindValue(':post_id',$post_id, PDO::PARAM_INT);
        $row4 = $pdostmt3->execute();
        return $row4;
    }

    public function getbusiness()
    {

        $query5="SELECT * FROM business ";
        $pdostmt3 = $this->db->prepare($query5);

        $pdostmt3->execute();
        $row5 = $pdostmt3->fetchAll(PDO::FETCH_OBJ);
        return $row5;

    }

    public function displayreviewsbybusinessid($businessId)
    {

        $query6="SELECT * FROM review WHERE business_id = :businessId ORDER BY date DESC";
        $pdostmt3 = $this->db->prepare($query6);
        $pdostmt3->bindValue(':businessId',$businessId, PDO::PARAM_INT);
        $pdostmt3->execute();
        $row6 = $pdostmt3->fetchAll(PDO::FETCH_OBJ);
        return $row6;
    }


    public function insertintorating($businessid,$clicked_val ){

        $query = "INSERT INTO rating 
                  (business_id,rating)
                  VALUES (:businessId,:rating)";

        $pdostmt = $this->db->prepare($query);


        $pdostmt->bindValue(':businessId', $businessid, PDO::PARAM_INT);
        $pdostmt->bindValue(':rating', $clicked_val, PDO::PARAM_INT);
        $row7 = $pdostmt->execute();

        return $row7;
    }

    public function getCountReviews($bid){
        $query = "SELECT COUNT(review) AS totalreview FROM review WHERE business_id = :bid AND status = 'Approved'";

        $pdostmt = $this->db->prepare($query);


        $pdostmt->bindValue(':bid', $bid, PDO::PARAM_INT);
        $pdostmt->execute();

        $row11 = $pdostmt->fetchall();

        return $row11;
    }




    public function getratingbybusinessid($bid)
    {
        //var_dump($value);
        $query3="SELECT * FROM rating WHERE business_id = :id";
        $pdostmt3 = $this->db->prepare($query3);
        $pdostmt3->bindValue(':id',$bid, PDO::PARAM_INT);
        $pdostmt3->execute();
        $row8 = $pdostmt3->fetch(PDO::FETCH_OBJ);
        return $row8;
    }

    public function getrating()
    {

        $query5="SELECT * FROM rating ORDER BY date ";
        $pdostmt3 = $this->db->prepare($query5);

        $pdostmt3->execute();
        $row9 = $pdostmt3->fetchAll(PDO::FETCH_OBJ);
        return $row9;

    }

    public function deleterating($id)
    {

        $query = "DELETE FROM rating WHERE id= :id";
        $pdostmt1 = $this->db->prepare($query);
        $pdostmt1->bindValue(':id',$id, PDO::PARAM_INT);
        $row10 = $pdostmt1->execute();
        return $row10;
        //echo "Deleted " . $row;
        //header("Location: admin-view.php");
    }
}