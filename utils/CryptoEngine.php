<?php
/**
 * @Author: mindfog
 */

namespace Util;

class CryptoEngine
{
    public function __construct()
    {
    }
    
    public static function hashPassword($password, $password_salt = null, $algorithm = 'sha256')
    {
        $salt = $password_salt == null ?
            (string)self::generateRandomString(64) :
            $password_salt;
        
        $password = $password . $salt;
        $password_hash = hash($algorithm, $password);
        
        return ["hash" => $password_hash, "salt" => $salt];
    }
    
    public static function generateRandomString($length)
    {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charactersLength = strlen($characters);
        $randomString = "";
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}