<?php


class gatheringsController
{


   function getGathersbyUser($db,$uid){
       $query1 = "SELECT g.*, gu.GatheringId FROM gatherings g JOIN gatherings_users gu ON g.id = gu.GatheringId JOIN users u on gu.UserId = u.id WHERE u.id = :uid";
       $pdostmt = $db->prepare($query1);
       $pdostmt->bindValue(':uid',$uid);

       $pdostmt->execute();
       $row = $pdostmt->fetchall();

       return $row;
    }


    function createGathering($db, $gatheringName, $gatheringDescription, $locationid, $userid){

            $query = "INSERT INTO  gatherings
                                (gatheringName, gatheringDescription, locationid, userid) 
                      VALUES 
                                (:gatheringName, :gatheringDescription, :locationid, :userid)";
            $pdostmt2 = $db->prepare($query);
            $pdostmt2->bindValue(':gatheringName', $gatheringName);
            $pdostmt2->bindValue(':gatheringDescription', $gatheringDescription);
            $pdostmt2->bindValue(':locationid', $locationid);
            $pdostmt2->bindValue(':userid', $userid);
            $row = $pdostmt2->execute();
            $pdostmt2->closeCursor();
            return $row;

    }

    public function selectUserDetails($db, $id)
    {
        /*insertUser($pdoconnection, $username, $email, $password_hash, $password_salt,
            $firstname, $middlename, $lastname, $location_id, $role_id);*/

        $query = "SELECT username, email, firstname, lastname FROM users WHERE id = :userid";
        $pdostmt2 = $db->prepare($query);
        $pdostmt2->bindValue(":userid", $id);
        /*$result = */$pdostmt2->execute();
        $userFetch = $pdostmt2->fetch(PDO::FETCH_ASSOC);
        $pdostmt2->closeCursor();
        return $userFetch;
    }

    public function getUser($db, $username,  $id)
    {
        /*insertUser($pdoconnection, $username, $email, $password_hash, $password_salt,
            $firstname, $middlename, $lastname, $location_id, $role_id);*/

        $query = "SELECT username FROM users WHERE id = :userid";
        $pdostmt2 = $db->prepare($query);
        $pdostmt2->bindValue(":userid", $id);
        $pdostmt2->bindValue(":username", $username);
        /*$result = */$pdostmt2->execute();
        $userFetch = $pdostmt2->fetch(PDO::FETCH_ASSOC);
        $pdostmt2->closeCursor();
        return $userFetch;
    }

    public function get_location_id($db)
    {
        $query = "SELECT StreetName, id FROM locations;";
        $pdostmt2 = $db->prepare($query);
        $pdostmt2->execute(); // now we execute the statement
        $locationResult= $pdostmt2->fetchAll(PDO::FETCH_ASSOC);
        $pdostmt2->closeCursor(); //dont forget this, because it disconnects your connection to db cuz there can only be 1 at a atime

        return $locationResult; //return ture because its succesfful
    }



    public function selectGathering($db, $gatheringid)
    {
        /*insertUser($pdoconnection, $username, $email, $password_hash, $password_salt,
            $firstname, $middlename, $lastname, $location_id, $role_id);*/

        $query = "SELECT * FROM gatherings WHERE id = :gatheringid";
        $pdostmt2 = $db->prepare($query);
        $pdostmt2->bindValue(":gatheringid", $gatheringid);
        /*$result = */$pdostmt2->execute();
        $userFetch = $pdostmt2->fetch(PDO::FETCH_ASSOC);
        $pdostmt2->closeCursor();
        return $userFetch;
    }

    public function getGatheringusers($db, $gatheringid)
    {
        $query = "SELECT u.username, u.email, u.id userId, u.firstname, u.lastname, g.id gatheringId, g.gatheringName 
                  FROM gatherings_users gu 
                  JOIN users u ON gu.UserId = u.id 
                  JOIN gatherings g ON gu.GatheringId = g.id WHERE g.id = :id";
        $pdostmt2 = $db->prepare($query);
        $pdostmt2->bindValue(":id", $gatheringid);
        $pdostmt2->execute();
        $gatherresult= $pdostmt2->fetchall(PDO::FETCH_ASSOC);
        return $gatherresult; 
    }

    public function getBusinessInfo($db, $id){
        $query = "SELECT b.*, l.* FROM business b LEFT JOIN locations l ON b.locationid = l.id WHERE b.id  = :id";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(':id',$id);
        $pdostmt->execute();

        $businessinfo = $pdostmt->fetchall();
        return $businessinfo;
    }
    public function getGathering($db)
    {
        $query = "SELECT * FROM gatherings WHERE id = 1;";
        $pdostmt2 = $db->prepare($query);
        $pdostmt2->execute(); // now we execute the statement
        $gatherresult= $pdostmt2->fetch(PDO::FETCH_ASSOC);
        $pdostmt2->closeCursor(); //dont forget this, because it disconnects your connection to db cuz there can only be 1 at a atime
        return $gatherresult; //return ture because its succesfful
    }

    public function getEvents($db, $id)
    {
        $query = "SELECT e.id, e.EventName, e.EventDescription, e.BusinessId, e.StartDateTime, e.EndDateTime, e.price, g.gatheringName, b.businessName
                  FROM gatherings_events ge 
                  JOIN events e ON ge.EventId = e.id 
                  JOIN gatherings g ON ge.GatheringId = g.id
                  JOIN business b ON e.BusinessId = b.id
                  WHERE g.id = :id";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(":id", $id);
        $pdostmt->execute();
        $result = $pdostmt->fetchall();
        return $result;

    }

    public function getEventList($db,$id){
        $query = "SELECT e.id,e.EventName,e.EventDescription,d.discount FROM events e LEFT JOIN discounts d ON e.id = d.eventid WHERE businessid = :id";

        $pdostmt2 = $db->prepare($query);
        $pdostmt2->bindValue(':id',$id);
        $pdostmt2->execute();
        $events = $pdostmt2->fetchAll();
        return $events;
    }

   public function getgatheringsEvents($db){
      $query = "SELECT * FROM gatheringevents";
       $pdostmt2 = $db->prepare($query);
       $pdostmt2->execute();
       $events = $pdostmt2->fetchAll(PDO::FETCH_OBJ);
       return $events;
   }

   public function addEventToGathering($db, $gatherId, $eventsId)
   {
       $query = "INSERT INTO gatherings_events
                           (GatheringId, EventId)
                    VALUES(:gatheringId, :eventId);";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(':gatheringId', $gatherId);
        $pdostmt->bindValue(':eventId', $eventsId);
        $result = $pdostmt->execute();
        return $result;
   }


}