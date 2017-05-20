<?php

class Booking
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function listEvents()
    {
        $query = "SELECT * FROM events";
        $pdostmt = $this->db->prepare($query);
        $pdostmt->execute();
        $list = $pdostmt->fetchAll(PDO::FETCH_OBJ);
        return $list;
    }

    public function eventDetails($id)
    {
        $query1 = "SELECT * FROM events 
                    JOIN business
                    ON events.BusinessId = business.id
                    WHERE events.id = :id ";
        $pdostmt1 = $this->db->prepare($query1);
        $pdostmt1->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt1->execute();
        $details = $pdostmt1->fetch(PDO::FETCH_OBJ);
        return $details;
    }

    public function eventBook($date, $time, $people, $user, $phone, $email, $event_id)
    {
        $query2 = "INSERT INTO bookings
                  (date, time, num_of_people, user_name, phone, email, event_id)
                  VALUES(:date, :time, :num_of_people, :user_name, :phone, :email, :event_id)";
        $pdostmt2 = $this->db->prepare($query2);
        $pdostmt2->bindValue(':date', $date, PDO::PARAM_STR);
        $pdostmt2->bindValue(':time', $time, PDO::PARAM_STR);
        $pdostmt2->bindValue(':num_of_people', $people, PDO::PARAM_INT);
        $pdostmt2->bindValue(':user_name', $user, PDO::PARAM_STR);
        $pdostmt2->bindValue(':phone', $phone, PDO::PARAM_STR);
        $pdostmt2->bindValue(':email', $email, PDO::PARAM_STR);
        $pdostmt2->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $add = $pdostmt2->execute();
        return $add;
    }

    public function deleteBooking($id)
    {
        $query4 = "DELETE FROM bookings WHERE id = :id";
        $pdostmt4 = $this->db->prepare($query4);
        $pdostmt4->bindValue(':id',$id, PDO::PARAM_INT);
        $delete = $pdostmt4->execute();
        return $delete;
    }

    public function bookingList()
    {
        $query9 = "SELECT * FROM bookings";
        $pdostmt9 = $this->db->prepare($query9);
        $pdostmt9->execute();
        $details = $pdostmt9->fetchAll(PDO::FETCH_OBJ);
        return $details;
    }

    public function bookingDetails($id)
    {
        $query10 = "SELECT * FROM bookings
                    WHERE id= :id";
        $pdostmt10 = $this->db->prepare($query10);
        $pdostmt10->bindValue(':id',$id, PDO::PARAM_INT);
        $pdostmt10->execute();
        $details = $pdostmt10->fetch(PDO::FETCH_OBJ);
        return $details;
    }

    public function checkBookingDate($date)
    {
        $query9 = "SELECT * FROM bookings WHERE date = :date";
        $pdostmt9 = $this->db->prepare($query9);
        $pdostmt9->bindValue(':date',$date, PDO::PARAM_STR);
        $pdostmt9->execute();
        $details = $pdostmt9->fetch(PDO::FETCH_OBJ);
        return $details;
    }




}