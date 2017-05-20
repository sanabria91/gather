<?php
//by Chen
    if(!defined("__root")) {
        require( $_SERVER['DOCUMENT_ROOT']. "\php_gather\configer.php");
    }
    include __root . "models\CategoryModel.php";

    class CategoryConnect
    {
        private $_db;

        public function __construct($dbConnection)
        {
            $this->_db = $dbConnection;
        }
        public function getCategories()
        {
            $allCategories = array();
            $sqlQuery = "SELECT * FROM category";
            $pdostmt = $this->_db->prepare($sqlQuery);
            $pdostmt -> execute();
            $results = $pdostmt -> fetchAll();
            foreach($results as $result)
            {
                $category = new CategoryModel($result);
                array_push($allCategories, $category);
            }
            return $allCategories;
        }
        public function createCategory($categoryModel)
        {
            $query = "INSERT INTO category
                        (CategoryTitle, CategoryDescription)
                        VALUES(:categoryTitle, :categoryDescription);";
            $pdostmt = $this->_db->prepare($query);
            $pdostmt->bindValue(':categoryTitle', $categoryModel->getTitle(), PDO::PARAM_STR);
            $pdostmt->bindValue(':categoryDescription', $categoryModel->getDescription(), PDO::PARAM_STR);
            $result = $pdostmt->execute();
            return $result;
        }
        public function getCategory($id) 
        {   
            $sqlQuery = "SELECT * FROM category WHERE Id = :id";
            $pdostmt = $this->_db->prepare($sqlQuery);
            $pdostmt->bindValue(":id", $id, PDO::PARAM_STR);
            $pdostmt -> execute();
            $result = $pdostmt -> fetch();
            if($result) {
                $category = new CategoryModel($result);
                return $category;
            } else {
                return new Exception("Category not found!");
            }
        }
        public function deleteCategory($categoryModel)
        {
            $query = "DELETE FROM category
                      WHERE Id = :id;";
            $pdostmt = $this->_db->prepare($query);
            $pdostmt-> bindValue(':id', $categoryModel->getId());
            $result = $pdostmt-> execute();
            return $result;
        }
        public function editCategory($categoryModel)
        {
            $query = "UPDATE category SET CategoryTitle = :categoryTitle, CategoryDescription = :categoryDescription WHERE Id= :categoryId;";
            $pdostmt = $this->_db->prepare($query);
            $pdostmt->bindValue(':categoryId', $categoryModel->getId(), PDO::PARAM_STR);
            $pdostmt->bindValue(':categoryTitle', $categoryModel->getTitle(), PDO::PARAM_STR);
            $pdostmt->bindValue(':categoryDescription', $categoryModel->getDescription(), PDO::PARAM_STR);
            $result = $pdostmt->execute();
            return $result;
        }
        public function getEventsByCategory($id)
        {
            include_once __root . "models\EventModel.php";
            $allEvents = array();
            $query = "SELECT e.*, eg.CategoryId, c.CategoryTitle, b.*, l.* FROM events e JOIN eventcategory eg ON e.id = eg.EventId JOIN category c ON eg.CategoryId = c.Id JOIN business b ON e.BusinessId = b.id JOIN locations l ON l.Id = b.locationid WHERE eg.CategoryId = :id";
            $pdostmt = $this->_db->prepare($query);
            $pdostmt->bindValue(":id", $id, PDO::PARAM_STR);
            $pdostmt -> execute();
            $results = $pdostmt -> fetchAll();
            foreach($results as $result)
            {
                $event = new EventModel($result);
                array_push($allEvents, $event);
            }
            return $allEvents;
        }

        public function getEventCategories($id)
        {
            try{
                $allCategories = array();
                $sqlQuery = "SELECT * FROM eventcategory ec JOIN category c ON ec.CategoryId = c.Id WHERE ec.EventId = :id ";
                $pdostmt = $this->_db->prepare($sqlQuery);
                $pdostmt->bindValue(":id", $id, PDO::PARAM_STR);
                $pdostmt -> execute();
                $results = $pdostmt -> fetchAll();
                foreach($results as $result)
                {
                    $category = new CategoryModel($result);
                    array_push($allCategories, $category);
                }
                return $allCategories;
            } catch(Exception $e) {
                return $e;
            }
        }

        public function getCategoriesWithTotal()
        {
            $allCategories = array();
            $sqlQuery = "SELECT COUNT(eventcategory.EventId) AS Total, category.* FROM eventcategory RIGHT JOIN category ON eventcategory.CategoryId = category.Id GROUP BY category.Id ORDER BY category.Id ASC";
            $pdostmt = $this->_db->prepare($sqlQuery);
            $pdostmt -> execute();
            $results = $pdostmt -> fetchAll();
            foreach($results as $result)
            {
                $category = new CategoryModel($result);
                array_push($allCategories, $category);
            }
            return $allCategories;
        }
    }
?>