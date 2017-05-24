<?php


class newsfeedController
{

    private $_db;

    public function __construct($dbConnection)
    {
        $this->_db = $dbConnection;
    }

    public function selectUserDetails($db, $id)
    {

        $query = "SELECT * FROM users WHERE id = :userid";
        $pdostmt2 = $db->prepare($query);
        $pdostmt2->bindValue(":userid", $id);
        /*$result = */
        $pdostmt2->execute();
        $userFetch = $pdostmt2->fetch(PDO::FETCH_ASSOC);
        $pdostmt2->closeCursor();
        return $userFetch;
    }

    public function addPost($db, $user_id, $user_name, $post_text, $postimage, $dateposted)
    {
//        $insertedId = "";

        $query2 = "INSERT INTO newsfeed (user_id, user_name, post_text, postimage, dateposted) 
        VALUES (:user_id, :user_name, :post_text, :postimage, :dateposted)";

        $pdostmt2 = $db->prepare($query2);
        $pdostmt2->bindValue(':user_id', $user_id);
        $pdostmt2->bindValue(':user_name', $user_name);
        $pdostmt2->bindValue(':user_name', $user_name);
        $pdostmt2->bindValue(':post_text', $post_text);
        $pdostmt2->bindValue(':postimage', $postimage);
        $pdostmt2->bindValue(':dateposted', $dateposted);
        $pdostmt2->execute();
//        $insertedId = $db->lastInsertId();
        $pdostmt2->closeCursor();
//        return $insertedId;
    }

    public function getAllPosts($db)
    {
//        $insertedId = "";

//        $query2 = "SELECT * FROM newsfeed ORDER BY dateposted DESC";
//        $pdostmt2 = $db->prepare($query2);
//        $result = $pdostmt2->execute();
//        $pdostmt2->closeCursor();
//        return $result;

        $query2 = "SELECT * FROM newsfeed ORDER BY id DESC";
        //$himat= Connect::dbConnect();

        $pdostmt2 = $db->prepare($query2);
        $pdostmt2->execute();
        $result =$pdostmt2->fetchAll(PDO::FETCH_ASSOC);
        $pdostmt2->closeCursor();
        return $result;
    }

}