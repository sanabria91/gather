<?php
//by Chen Batu
class LoginController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    /**
     * $username can be username or email
     * $password should be plain password from input field.
     */

    public function signup($userModel)
    {
        $passwordSaltandHash = \Util\CryptoEngine::hashPassword($userModel->getPassword());
        $userModel->setPasswordHash($passwordSaltandHash['hash']);
        $userModel->setPasswordSalt($passwordSaltandHash['salt']);
        $role = null;
        $sql = "INSERT INTO users
                        (username, email, passwordhash, passwordsalt, firstname, middlename, lastname, roleId, locationId)
                        VALUES(:username, :email, :passwordhash, :passwordsalt, :firstname, :middlename, :lastname, :roleId, :locationId);";
        try {
            if($userModel->getRole() == "normal") {
                $role = "1";
            } elseif ($userModel->getRole() == "business") {
                $role = "2";
            } elseif ($userModel->getRole() == "admin") {
                $role = "3";
            } else {
                throw new Exception("User role is not correct!");
            }
            $statement = $this->db->prepare($sql);
            $statement->bindValue(':username', $userModel->getUsername());
            $statement->bindValue(':email', $userModel->getEmail());
            $statement->bindValue(':passwordhash', $userModel->getPasswordHash());
            $statement->bindValue(':passwordsalt', $userModel->getPasswordSalt());
            $statement->bindValue(':firstname', $userModel->getFname());
            $statement->bindValue(':middlename', $userModel->getMname());
            $statement->bindValue(':lastname', $userModel->getLname());
            $statement->bindValue(':roleId', $role);
            $statement->bindValue(':locationId', $userModel->getLocation());
            $result = $statement->execute();
            return $result;
        } catch(Exception $e) {
            return $e;
        }
    }
    
    public function login($username, $password, $rememberme = false)
    {
        if ($username == null || $password == null) {
            return false;
        }
        
        $sql = "SELECT u.id UserId,
                       u.email,
                       u.firstname,
                       u.lastname,
                       u.passwordhash, 
                       u.passwordsalt,
                       u.username,
                       b.id BusinessId, 
                       ur.role UserRole 
                FROM users u LEFT JOIN business b ON u.id = b.userid 
                RIGHT JOIN user_roles ur 
                ON u.roleid = ur.id 
                WHERE (u.username = :uname OR u.email = :email)";
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindValue(':uname', $username);
            $statement->bindValue(':email', $username);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            $hash_result = \Util\CryptoEngine::hashPassword($password, $result['passwordsalt']);
            if ($hash_result['hash'] == $result['passwordhash']) {
                $_SESSION['LoggedIn']['UserId'] = $result['UserId'];
                $_SESSION['LoggedIn']['BusinessId'] = $result['BusinessId'];
                $_SESSION['LoggedIn']['UserRole'] = $result['UserRole'];
                $_SESSION['LoggedIn']['Email'] = $result['email'];
                $_SESSION['LoggedIn']['Firstname'] = $result['firstname'];
                $_SESSION['LoggedIn']['Lastname'] = $result['lastname'];
                $_SESSION['LoggedIn']['Username'] = $result['username'];

                // DEBUG(batuhan): Not tested.
                if ($rememberme && !isset($_COOKIE['UserId'])) {
                    $expire = 60 * 60 * 24 * 30;
                    setcookie('UserId', $result['UserId'], $expire);
                }
                
                return $result['UserId'];
            }
        } catch (PDOException $PDOException) {
            // TODO(batuhan): Redirect to error page.
            echo("Something went horribly wrong.");
            die;
        }
        return false;
    }

    public function loginBySession($userId)
    {
        if ($userId == null) {
            return false;
        }
        
        $sql = "SELECT u.id UserId,
                       u.email,
                       u.firstname,
                       u.middlename,
                       u.lastname,
                       u.username,
                       b.id BusinessId, 
                       ur.role UserRole 
                FROM users u LEFT JOIN business b ON u.id = b.userid 
                RIGHT JOIN user_roles ur 
                ON u.roleid = ur.id 
                WHERE u.id = :id";
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindValue(':id', $userId);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $_SESSION['LoggedIn']['UserId'] = $result['UserId'];
            $_SESSION['LoggedIn']['BusinessId'] = $result['BusinessId'];
            $_SESSION['LoggedIn']['UserRole'] = $result['UserRole'];
            $_SESSION['LoggedIn']['Email'] = $result['email'];
            $_SESSION['LoggedIn']['Firstname'] = $result['firstname'];
            $_SESSION['LoggedIn']['Lastname'] = $result['lastname'];
            $_SESSION['LoggedIn']['Username'] = $result['username'];
            return $result;
        } catch (PDOException $PDOException) {
            echo("Something went horribly wrong.");
            die;
        }
        return false;
    }
    
    public function logout()
    {
        //session_start();
        session_destroy();
    }
    
    public function getLoginModel($id)
    {
        $sql = "SELECT u.username, 
                       b.id BusinessId
                       FROM users u
                       LEFT JOIN business b
                       ON u.id = b.userid
                       WHERE 
                       u.id = :uid";
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindValue(':uid', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $model = new LoginModel($id, $result['username'], $result['BusinessId'], true);
            return $model;
        } catch (PDOException $PDOException) {
            // TODO(batuhan): Redirect to error page.
            echo ("Something went horribly wrong.");
            die;
        }
    }

    public function editUser($userModel)
    {
        $sql = "UPDATE users
                SET username=:username, email=:email, passwordhash=:passwordhash, passwordsalt=:passwordsalt, firstname=:firstname, middlename=:middlename, lastname=:lastname
                WHERE id=:id;";
        try {
            $passwordSaltandHash = \Util\CryptoEngine::hashPassword($userModel->getPassword());
            $userModel->setPasswordHash($passwordSaltandHash['hash']);
            $userModel->setPasswordSalt($passwordSaltandHash['salt']);
            $statement = $this->db->prepare($sql);
            $statement->bindValue(':username', $userModel->getUsername());
            $statement->bindValue(':email', $userModel->getEmail());
            $statement->bindValue(':passwordhash', $userModel->getPasswordHash());
            $statement->bindValue(':passwordsalt', $userModel->getPasswordSalt());
            $statement->bindValue(':firstname', $userModel->getFname());
            $statement->bindValue(':middlename', $userModel->getMname());
            $statement->bindValue(':lastname', $userModel->getLname());
            $statement->bindValue(':id', $userModel->getId());
            $result = $statement->execute();
            return $result;
        } catch(PDOException $PDOException) {
            echo ("Something went horribly wrong.");
            die;
        }
    }
}