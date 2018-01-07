<?php
require_once "CookieMaker.php";
require_once "./repository/CSRFRepository.php";
require_once "./model/CSRFModel.php";
require_once("./AuthConfig.php");

class CSRFHelper
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
        CSRFHelper::updateCSRF($email, $token, $expiration);
        return $token;
    }
    public static function updateCSRF($email, $token, $expiration){
        $dataAccess=new DataAccess();
        $repo = new CSRFRepository($dataAccess);
        $model = new CSRFModel();
        $model->email = $email;
        $model->token = $token;
        $model->expirationdatetime = $expiration;  
        $repo->removeByEmail($email);   
        $repo->add($model);
    }
    public static function validate($email, $token){
        $dataAccess=new DataAccess();
        $repo = new CSRFRepository($dataAccess);
        $csrf = $repo->getByToken($email, $token);       
        
        $now = date('Y-m-d H:i:s');        
        
         $isExpired = $now > date($csrf->expirationdatetime);
         if($csrf != null && !$isExpired)
             return TRUE;
         return FALSE;
    }

}