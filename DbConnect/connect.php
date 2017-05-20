<?php
/**
 *This is the database class, it is a singleton. by chen
 */
class Connect
{
  private static $dsn = "mysql:host=my03.winhost.com;dbname=mysql_108240_gatheringdb";
  private static $username = "gatheradmin";
  private static $password = "gather12345678";
  private static $db;

  private function __construct()
  {
    
  }
  public static function dbConnect() {
    if(!isset(self::$db)){
      try {
        self::$db = new PDO(self::$dsn, self::$username, self::$password);
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOEXCEPTION $e) {
        echo $e->getMessage();
      }
      return self::$db;
    }
  }
}
?>
