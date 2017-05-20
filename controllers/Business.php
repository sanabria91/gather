<?php


class BusinessDAO

{
    public function getBusinessInfo($db, $id){
        $query = "SELECT b.*, l.* FROM business b LEFT JOIN locations l ON b.locationid = l.id WHERE b.id  = :id";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(':id',$id);
        $pdostmt->execute();

        $businessinfo = $pdostmt->fetchall();
        return $businessinfo;
    }

    public function getBusinessProfile($db,$id){
        $query = "SELECT * FROM business WHERE id  = :id";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(':id',$id);
        $pdostmt->execute();

        $businessprofile = $pdostmt->fetch();
        return $businessprofile;
    }

    public function getAll($db){
        $query = "SELECT * FROM business";
        $pdostmt = $db->prepare($query);
        $pdostmt->execute();

        $businessall = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $businessall;
    }

    public function getEventList($db,$id){
        $query = "SELECT e.id,e.EventName,e.EventDescription,d.discount FROM events e LEFT JOIN discounts d ON e.id = d.eventid WHERE businessid = :id";

        $pdostmt2 = $db->prepare($query);
        $pdostmt2->bindValue(':id',$id);
        $pdostmt2->execute();

        $events = $pdostmt2->fetchAll();
        return $events;
    }

    public function updateBusiness($db, $businessName, $businessDescription, $businessCapacity, $id){
        $query3 = "UPDATE business SET businessName = :businessName, businessDescription = :businessDescription, businessCapacity = :businessCapacity
                   WHERE id = :id";
        $pdostmt3 = $db->prepare($query3);

        $pdostmt3->bindValue(':businessName',$businessName);
        $pdostmt3->bindValue(':businessDescription',$businessDescription);
        $pdostmt3->bindValue(':businessCapacity',$businessCapacity);
        $pdostmt3->bindValue(':id',$id);

        $pdostmt3->execute();

    }

    public function addBusiness($db, $businessName, $businessDescription, $businessCapacity, $userID)
    {
        $query5 = "INSERT INTO business (businessName, businessDescription, businessCapacity, userid) VALUES (:businessName, :businessDescription, :businessCapacity, :userID)";

        $pdostmt5 = $db->prepare($query5);
        $pdostmt5->bindValue(':businessName',$businessName);
        $pdostmt5->bindValue(':businessDescription',$businessDescription);
        $pdostmt5->bindValue(':businessCapacity',$businessCapacity);
        $pdostmt5->bindValue(':userID', $userID);

        $pdostmt5->execute();
    }

}
