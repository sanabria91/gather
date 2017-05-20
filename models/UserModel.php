<?php
//by chen
class UserModel
{
    private $_username;
    private $_password;
    private $_passwordHash;
    Private $_passwordSalt;
    private $_fname;
    private $_lname;
    private $_mname;
    private $_role;
    private $_location;
    private $_email;
    private $_id;

    public function __construct($queryResult)
    {
        try {
            $this->setUsername($queryResult['username']);
            $this->setPassword($queryResult['password']);
            $this->setFname($queryResult['firstname']);
            $this->setLname($queryResult['lastname']);
            $this->setEmail($queryResult['email']);
            if(isset($queryResult['middlename'])) {
                $this->setMname($queryResult['middlename']);
            } else {
                $this->setMname("N");
            }
            if(isset($queryResult['passwordHash'])) {
                $this->setPasswordHash($queryResult['passwordHash']);
            }
            if(isset($queryResult['passwordSalt'])) {
                $this->setPasswordSalt($queryResult['passwordSalt']);
            }
            if(isset($queryResult['roleId'])) {
                $this->setRole($queryResult['roleId']);
            }
            if(isset($queryResult['accountType'])) {
                $this->setRole($queryResult['accountType']);
            }
            if(isset($queryResult['locationId'])) {
                $this->setLocation($queryResult['locationId']);
            }
        } catch(Exception $e) {
            return $e;
        }     
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($value)
    {
        $this->_id = $value;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function getLocation()
    {
        return $this->_location;
    }

    public function setLocation($location)
    {
        $this->_location = $location;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function getPassword()
    {
        return $this->_password;
    }
    
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function getFname()
    {
        return $this->_fname;
    }
    
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    public function getLname()
    {
        return $this->_lname;
    }
    
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    public function getMname()
    {
        return $this->_mname;
    }
    
    public function setMname($Mname)
    {
        $this->_mname = $Mname;
    }

    public function getPasswordHash()
    {
        return $this->_passwordHash;
    }
    
    public function setPasswordHash($passwordHash)
    {
        $this->_passwordHash = $passwordHash;
    }

    public function getPasswordSalt()
    {
        return $this->_passwordSalt;
    }
    
    public function setPasswordSalt($passwordSalt)
    {
        $this->_passwordSalt = $passwordSalt;
    }

    public function getRole()
    {
        return $this->_role;
    }
    
    public function setRole($role)
    {
        $this->_role = $role;
    }
}