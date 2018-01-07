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
        $aSeoncd = 300;
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
        $model->emailToken = $token;
        $model->expirationdatetime = $expiration;          
        $repo->updateEmailToken($model);
    }
    public static function validate($token){
        $dataAccess=new DataAccess();
        $repo = new ProfileRepository($dataAccess);
        $profile = $repo->getByEmailToken($token);       
        
        $now = date('Y-m-d H:i:s');        
        
        if($profile != null){
            $isExpired = $now > date($profile->expirationdatetime);
         if($profile->emailToken == $token && !$isExpired){
             $repo->activateProfilebyEmail($profile->email);
            return (object) [ 'isSuccessfull' => TRUE, 'email' => null];
         }
         else
         {
            return (object) [ 'isSuccessfull' => FALSE, 'email' => $profile->email];
         }
             
         return FALSE;
        }
        else
        {
            return (object) [ 'isSuccessfull' => FALSE, 'email' => null];
        }
    }

}