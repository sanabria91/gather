<?php
//by chen
    class CategoryModel 
    {
        private $_categoryId;
        private $_categoryTitle;
        private $_categoryDescription;
        private $_eventId;
        private $_total;

        public function __construct($queryResult)
        {   
            try {
                if(isset($queryResult["Id"])) {
                    $this->setId($queryResult["Id"]);
                }
                if(isset($queryResult["EventId"])) {
                    $this->_eventId = $queryResult["EventId"];
                }
                if(isset($queryResult["Total"])) {
                    $this->_total = $queryResult["Total"];
                }
                $this->setTitle($queryResult['CategoryTitle']);
                $this->setDescription($queryResult["CategoryDescription"]);
            } catch(Exception $e){
              throw $e;
            }

        }

        public function getTitle()
        {
            return $this->_categoryTitle;
        }

        public function setTitle($title)
        {
            if(isset($title)) {
                $value = trim($title);
                if(strlen($value) > 3) {
                    $this->_categoryTitle = $value;
                } else {
                    return null;
                }
            } else {
                throw new Exception("Category title cannot be empty.");
            }
        }

        public function getDescription()
        {
            return $this->_categoryDescription;
        }

        public function setDescription($description)
        {   
            if(isset($description)) {
                $value = trim($description);
                if(strlen($value) > 5) {
                    $this->_categoryDescription = $value;
                } else {
                    return null;
                }
            } else {
                throw new Exception("Category description cannot be empty.");
            }
        }

        public function getId ()
        {
            return $this->_categoryId;
        }

        public function setId($id)
        {   
            $value = intval($id);
            if($value > 0) {
                $this->_categoryId = $id;
            } else {
                throw new Exception('Category must have ID.');
            }
        }

        public function getTotal()
        {
            return $this->_total;
        }
        
        public function __toString()
        {  
            return $this->_categoryTitle;
        }
    }
?>