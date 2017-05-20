<?php
//by chen
class EventModel
{
    private $_eventId;
    private $_name;
    private $_description;
    private $_startDateTime;
    private $_endDateTime;
    private $_businessId;
    private $_businessName;
    private $_streetName;
    private $_postalCode;
    private $_city;
    private $_province;
    private $_country;
    private $_userId;
    private $_categoryId;
    private $_categoryTitle;

    public function __construct($queryResult)
    {   
        if(isset($queryResult['BusinessName']) && isset($queryResult['StreetName'])) {          
            $this->_businessName = $queryResult["BusinessName"];
            $this->_streetName = $queryResult["StreetName"];
            $this->_postalCode = $queryResult["PostalCode"];
            $this->_city = $queryResult["City"];
            $this->_province = $queryResult["Province"];
            $this->_country = $queryResult["Country"];
        }
        if(isset($queryResult['UsersId'])) {
            $this->_userId = $queryResult['UsersId'];
        }
        if(isset($queryResult['id'])) {
            $this->_eventId = $queryResult['id']; 
        }
        if(isset($queryResult["EventId"])) {
            $this->_eventId = $queryResult["EventId"]; 
        }
        if(isset($queryResult["CategoryId"])) {
            $this->setCategoryId($queryResult["CategoryId"]);
        }
        if(isset($queryResult["CategoryTitle"])) {
            $this->_categoryTitle =$queryResult["CategoryTitle"];
        }
        $this->setPrice($queryResult["price"]);
        $this->setName($queryResult["EventName"]);
        $this->setDescription( $queryResult["EventDescription"]);
        $this->_startDateTime = $this->formatDateTime($queryResult["StartDateTime"]);
        $this->_endDateTime = $this->formatDateTime($queryResult["EndDateTime"]);
        $this->setBusinessId($queryResult["BusinessId"]);
    }

    private function formatDateTime($dateTime)
    {
        $matchPattern1 = '/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}/';
        $matchPattern2 = '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/';
        $replacePattern1 = '/T/';
        $replacePattern2 = '/ /';
        $replacement1 = " ";
        $replacement2 = "T";
        if(preg_match($matchPattern1, $dateTime)) {
            $formattedTime = preg_replace($replacePattern1, $replacement1, $dateTime);
            //$formattedTime = $formattedTime . ":00";
            return $formattedTime;
        } else if(preg_match($matchPattern2, $dateTime)) {
            $formattedTime = preg_replace($replacePattern2, $replacement2, $dateTime);
            return $formattedTime;
        } else {
            throw new Exception('Date and time is not valide.');
        }
    }

    private function formatDateTimeForForm($dateTime)
    {
        $matchPattern = '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/';
        $replacePattern = '/ /';
        $replacement = "T";
        if(preg_match($matchPattern, $dateTime)) {
            $formattedTime = preg_replace($replacePattern, $replacement, $dateTime);
            return $formattedTime;
        } else {
            throw new Exception('Date and time is not valide.');
        }   
    }

    public function getEventId()
    {
        return $this->_eventId;
    }

    public function setEventId($id)
    {
        $this->_eventId = $id;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName($value)
    {
        $value = trim($value);
        if(strlen($value) > 5) {
            $this->_name = $value;
        } else {
            throw new Exception('Event Name is too short.');
        }
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription($value)
    {
        $value = trim($value);
        if(strlen($value) > 5) {
            $this->_description = $value;
        } else {
            throw new Exception('Event description is too short.');
        }
    }

    public function getStartDateTime($flag="detail")
    {
        if($flag == "edit") {
            $dateTime = $this->formatDateTimeForForm($this->_startDateTime);
            return $dateTime;
        } else if($flag == "detail") {
            return $this->_startDateTime;
        }
    }

    public function setStartDateTime($value)
    {   
        
        $this->_startDate = $this->formatDateTime($value);
    }

    public function getEndDateTime($flag="detail")
    {
        if($flag == "edit") {
            $dateTime = $this->formatDateTimeForForm($this->_endDateTime);
            return $dateTime;
        } else if($flag == "detail") {
            return $this->_endDateTime;
        }
    }

    public function setEndDateTime($value)
    {
        $this->_endDateTime = $this->formatDateTime($value);
    }

    public function getStreetName()
    {
        return $this->_streetName;
    }

    public function getPostalCode()
    {
        return $this->_postalCode;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function getProvince()
    {
        return $this->_province;
    }

    public function getCountry()
    {
        return $this->_country;
    }

    public function getBusinessName()
    {
        return $this->_businessName;
    }

    public function getBusinessId()
    {
        return $this->_businessId;
    }

    public function setBusinessId($value)
    {
        if(intval($value) > 0) {
            $this->_businessId = $value;
        } else {
            throw new Exception("Business not found!");
        }        
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function getCategoryId()
    {
        return $this->_categoryId;
    }

    public function setCategoryId($value)
    {
        if(intval($value) > 0) {
            $this->_categoryId = $value;
        } else {
            throw new Exception("Category not found!");
        }
    }

    public function getCategoryTitle()
    {
        return $this->_categoryTitle;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function setPrice($value)
    {
        if(intval($value) >= 0) {
            $this->_price = intval($value);
        } else {
            throw new Exception("Price must be bigger or equal than 0.");
        }
    }
}
?>