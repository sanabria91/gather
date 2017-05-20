<?php
//By Chen
    if(!defined("__root")) {
        require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\\configer.php");
    }
    include __root . "models/LocationModel.php";

    class LocationConnect
    {
        private $_db;

        public function __construct($dbConnection)
        {
             $this->_db = $dbConnection;
        }

        public function getAllBusinessLocations()
        {
            $allLocations = array();
            $sqlQuery = "SELECT l.*, b.businessName BusinessName FROM locations l JOIN business b ON l.Id = b.locationid;";
            $pdostmt = $this->_db->prepare($sqlQuery);
            $pdostmt -> execute();
            $results = $pdostmt -> fetchAll();
            foreach ($results as $result) {
                $location = new LocationModel($result);
                array_push($allLocations, $location);
            }
            return $allLocations;
        }

        public function getLocations()
        {
            $allLocations = array();
            $sqlQuery = "SELECT * FROM locations;";
            $pdostmt = $this->_db->prepare($sqlQuery);
            $pdostmt -> execute();
            $results = $pdostmt -> fetchAll();
            foreach ($results as $result) {
                $result["BusinessName"] = "Temp";
                $location = new LocationModel($result);
                array_push($allLocations, $location);
            }
            return $allLocations;
        }

        public function getBusinessLocation($id)
        {
            $sqlQuery = "SELECT l.*, b.businessName BusinessName FROM locations l JOIN business b ON l.Id = b.locationId, WHERE l.Id= :id;";
            $pdostmt = $this->_db->prepare($sqlQuery);
            $pdostmt-> bindValue(':id', $id);
            $pdostmt-> execute();
            $result = $pdostmt -> fetch();
            $location = new LocationModel($result);
            return $location;
        }

        public function getLocation($id)
        {
            $sqlQuery = "SELECT * FROM locations WHERE Id= :id;";
            $pdostmt = $this->_db->prepare($sqlQuery);
            $pdostmt-> bindValue(':id', $id);
            $pdostmt-> execute();
            $result = $pdostmt -> fetch();
            $location = new LocationModel($result);
            return $location;
        }

        public function createLocation($locationModel)
        {
           $query = "INSERT INTO locations
                        (StreetName, City, Province, Country, PostalCode)
                        VALUES(:streetName, :city, :province, :country, :postalCode);";
            $pdostmt = $this->_db->prepare($query);
            $pdostmt->bindValue(':streetName', $locationModel->getStreetName(), PDO::PARAM_STR);
            $pdostmt->bindValue(':city', $locationModel->getCity(), PDO::PARAM_STR);
            $pdostmt->bindValue(':province', $locationModel->getProvince(), PDO::PARAM_STR);
            $pdostmt->bindValue(':country', $locationModel->getCountry(), PDO::PARAM_STR);
            $pdostmt->bindValue(':postalCode', $locationModel->getPostalCode(), PDO::PARAM_STR);
            $result = $pdostmt->execute();
            $id = $this->_db->lastInsertId();
            return [$result, $id];
        }

        public function editLocation($locationModel)
        {
            $query = "UPDATE locations
                      SET StreetName= :streetName, City= :city, Province= :province, Country= :country, PostalCode= :postalCode
                      WHERE Id= :locationId;";
            $pdostmt = $this->_db->prepare($query);
            $pdostmt->bindValue(':locationId', $locationModel->getLocationId(), PDO::PARAM_STR);
            $pdostmt->bindValue(':streetName', $locationModel->getStreetName(), PDO::PARAM_STR);
            $pdostmt->bindValue(':city', $locationModel->getCity(), PDO::PARAM_STR);
            $pdostmt->bindValue(':province', $locationModel->getProvince(), PDO::PARAM_STR);
            $pdostmt->bindValue(':country', $locationModel->getCountry(), PDO::PARAM_STR);
            $pdostmt->bindValue(':postalCode', $locationModel->getPostalCode(), PDO::PARAM_STR);
            $result = $pdostmt->execute();
            return $result;
        }

        public function deleteLocation($locationModel)
        {
            $query = "DELETE FROM locations
                      WHERE Id = :id;";
            $pdostmt = $this->_db->prepare($query);
            $pdostmt-> bindValue(':id', $locationModel->getLocationId());
            $result = $pdostmt-> execute();
            return $result;
        }

        public function updateLocation($businessId, $locationId)
        {
        $query3 = "UPDATE business SET locationid = :locaitonid
                   WHERE id = :id";
        $pdostmt3 = $this->_db->prepare($query3);

        $pdostmt3->bindValue(':locaitonid',$locationId);
        $pdostmt3->bindValue(':id',$businessId);

        $pdostmt3->execute();
        }

    }
?>