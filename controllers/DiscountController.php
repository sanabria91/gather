<?php


class DiscountDAO

{
    public function getBusinessName($db, $businessid){
        $query = "SELECT DISTINCT businessName, id FROM business WHERE businessid = :businessid";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(':businessid',$businessid);
        $pdostmt->execute();

        $business = $pdostmt->fetchAll();
        return $business;
    }

    public function getEventDropdown($db){
        $query = "SELECT DISTINCT EventName, id FROM events";
        $pdostmt = $db->prepare($query);
        $pdostmt->execute();

        $business = $pdostmt->fetchAll();
        return $business;
    }

    public function getAllDiscount($db){
        $query = "SELECT e.id,e.EventName,e.EventDescription,d.discount FROM events e LEFT JOIN discounts d ON e.id = d.eventid";
        $pdostmt = $db->prepare($query);
        $pdostmt->execute();

        $events = $pdostmt->fetchAll();
        return $events;
    }


    public function getEventName($db, $businessid){
        $query = "SELECT DISTINCT EventName, id FROM events WHERE id = :businessid";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(':businessid',$businessid);
        $pdostmt->execute();

        $business = $pdostmt->fetchAll();
        return $business;
    }

    public function getDiscountListbyBusiness($db,$businessid){
    $query = "SELECT d.*,EventName, EventDescription FROM discounts d JOIN events e ON d.eventid = e.id WHERE businessid = :businessid";
    $pdostmt = $db->prepare($query);
    $pdostmt->bindValue(':businessid',$businessid);
    $pdostmt->execute();

    $discounts = $pdostmt->fetchAll();
    return $discounts;
    }

    public function getEventList($db, $businessid){
        $query = "SELECT e.id,e.EventName,e.EventDescription,d.discount FROM events e LEFT JOIN discounts d ON e.id = d.eventid WHERE businessid = :businessid";
        $pdostmt = $db->prepare($query);
        $pdostmt->bindValue(':businessid',$businessid);
        $pdostmt->execute();

        $events = $pdostmt->fetchAll();
        return $events;
    }

    public function getDiscount($db, $id){
        $query2 = "SELECT * FROM discounts WHERE id = :id";
        $pdostmt2 = $db->prepare($query2);
        $pdostmt2->bindValue(':id',$id);
        $pdostmt2->execute();
        $list = $pdostmt2->fetch();

        return $list;
    }

    public function updatePromotion($db, $title, $discount,$eventid, $datestart, $expiry, $id){
        $query3 = "UPDATE discounts SET title = :title, discount = :discount, eventid = :eventid,
                   datestart = :datestart, expiry = :expiry WHERE id = :id";
        $pdostmt3 = $db->prepare($query3);

        $pdostmt3->bindValue(':title',$title);
        $pdostmt3->bindValue(':discount',$discount);
        $pdostmt3->bindValue(':eventid',$eventid);
        $pdostmt3->bindValue(':datestart',$datestart);
        $pdostmt3->bindValue(':expiry',$expiry);
        $pdostmt3->bindValue(':id',$id);

        $pdostmt3->execute();

    }

    public function deletePromotion($db, $id){
        $query4 = "DELETE FROM discounts WHERE id = :id";

        $pdostmt4 = $db->prepare($query4);
        $pdostmt4->bindValue(':id',$id);

        $pdostmt4->execute();

    }



    public function addPromotion($db, $eventid, $title, $discount, $datestart, $expiry)
    {
        $query5 = "INSERT INTO discounts (eventid, title, discount, datestart, expiry) VALUES (:eventid, :title, :discount, :datestart, :expiry)";

        $pdostmt5 = $db->prepare($query5);
        $pdostmt5->bindValue(':eventid', $eventid);
        $pdostmt5->bindValue(':title', $title);
        $pdostmt5->bindValue(':discount', $discount);
        $pdostmt5->bindValue(':datestart', $datestart);
        $pdostmt5->bindValue(':expiry', $expiry);

        $pdostmt5->execute();
    }

}
