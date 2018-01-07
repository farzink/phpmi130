<?php
require_once "CookieMaker.php";
require_once "./repository/ProfileRepository.php";

require_once("./AuthConfig.php");

class EmailTokenHelper
{      
    public static function unique(){
        return uniqid();
    }
    public static function generate($email){
        //$aSeoncd = 3600;
        $aSeoncd = 5;
        $id = uniqid();
        $time = time();
        $val = $email . $id . $time;
        $expiration = time() + ($aSeoncd * 2);
        $token = password_hash($val, PASSWORD_DEFAULT);
        EmailTokenHelper::updateEmailToken($email, $token, $expiration);
        return $token;
    }
    public static function updateEmailToken($email, $token, $expiration){
        $dataAccess=new DataAccess();
        $repo = new ProfileRepository($dataAccess);
        $model = new ProfileModel();
        $model->email = $email;
        $model->token = $token;
        $model->expirationdatetime = $expiration;          
        $repo->updateEmailToken($model);
    }
    public static function validate($token){
        $dataAccess=new DataAccess();
        $repo = new ProfileRepository($dataAccess);
        $csrf = $repo->getByToken($email, $token);       
        
        $now = date('Y-m-d H:i:s');        
        
         $isExpired = $now > date($csrf->expirationdatetime);
         if($csrf != null && !$isExpired)
             return TRUE;
         return FALSE;
    }

}