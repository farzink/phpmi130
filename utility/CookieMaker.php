<?php
class CookieMaker {
    private static $aDay = 86400;    
    public static function unique(){
        return uniqid();
    }
    public static function cook($name, $content, $expiryInDays){
        $expiration = time() + (CookieMaker::$aDay * $expiryInDays);        
        setcookie($name, $content, $expiration, "/", NULL);        
    }
    public static function getCookie($name){
        if(isset($_COOKIE[$name]))
           return $_COOKIE[$name];
        else
            return NULL;
    }
    public function exists($name){
        if(isset($_COOKIE[$name]))
        return TRUE;
     else
         return FALSE;
    }
    public static function removeCookie($name){
        if(isset($_COOKIE[$name]))
        setcookie($name, "", time() - CookieMaker::$aDay, "/", NULL);
            //setcookie($name, "", time() - CookieMaker::$aDay);
    }
    public static function tokenGenerator($param1, $param2){
        $value = $param1.$param2;
        return password_hash($value, PASSWORD_DEFAULT);
    }
    public static function getExpirayForDays($days){
        return time() + (CookieMaker::$aDay * $days);
    }
}