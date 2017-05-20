<?php
    class LocationModel
    {
        private $_locationId;
        private $_businessName;
        private $_streetName;
        private $_city;
        private $_province;
        private $_postalCode;
        private $_country;

        public function __construct($queryResult)
        {
            if(isset($queryResult["Id"])) {
                $this->_locationId = $queryResult["Id"];
            }
            $this->_streetName = $queryResult["StreetName"];
            $this->_postalCode = $queryResult["PostalCode"];
            $this->_city = $queryResult["City"];
            $this->_province = $queryResult["Province"];
            $this->_country = $queryResult["Country"];
            if(isset($queryResult["BusinessName"])) {
                $this->_businessName = $queryResult["BusinessName"];
            }
        }

        public function getLocationId()
        {
            return $this->_locationId;
        }

        public function getStreetName()
        {
            return $this->_streetName;
        }

        public function setStreetName($value)
        {
            $this->_streetName = $value;
        }

        public function getCity()
        {
            return $this->_city;
        }

        public function setCity($value)
        {
            $this->_city = $value;
        }

        public function getPostalCode()
        {
            return $this->_postalCode;
        }

        public function setPostalCode($value)
        {
            $this->_postalCode = $value;
        }

        public function getProvince()
        {
            return $this->_province;
        }

        public function setProvince($value)
        {
            $this->_province = $value;
        }

        public function getCountry()
        {
            return $this->_country;
        }

        public function setCountry($value)
        {
            $this->_country = $value;
        }

        public function getBusinessName()
        {
            return $this->_businessName;
        }

        public function setBusinessName($value)
        {
            $this->_businessName = $value;
        }
    }
?>