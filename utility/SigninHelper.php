<?php
require_once "CookieMaker.php";
require_once "./repository/AuthTempRepository.php";
require_once "./model/AuthTempModel.php";
require_once("./AuthConfig.php");

class SigninHelper
{
    private static $authName = "AuthCookie";
    public static function signin($uid)
    {
        try
        {
            
            $data = new DataAccess();
            $repo = new AuthTempRepository($data);
            $uniq = CookieMaker::unique();
            $mixed = CookieMaker::tokenGenerator($uniq, $uid);
            CookieMaker::cook(AuthConfig::$cookieName, $mixed, AuthConfig::$defaultCookieExpirationInDays);
            $model = new AuthTempModel();
            $model->token = $mixed;
            $model->profileid = $uid;
            $dt = CookieMaker::getExpirayForDays(AuthConfig::$defaultCookieExpirationInDays);            
            $model->expirationdatetime = new DateTime("@$dt");              
            $repo->removeByProfileid($uid);
            if ($repo->add($model)) {
                return true;
            } 
            else 
            {
                return false;
            }

        } catch (Exception $ex) {
            return false;
        }
    }
    public static function signinWithEmailPassword($email, $password)
    {
        try
        {
            $data = new DataAccess();
            $repo = new AuthTempRepository($data);
            $profileRepo = new ProfileRepository($data);
            $user = $profileRepo->getByEmail($email);
            if($user == NULL)
                return FALSE;
            
            if(!AuthHelper::verifyPassword($password, $user->password))
                return FALSE;
            $uid = $user->id;
            
            $uniq = CookieMaker::unique();
            $mixed = CookieMaker::tokenGenerator($uniq, $uid);
            CookieMaker::cook(AuthConfig::$cookieName, $mixed, AuthConfig::$defaultCookieExpirationInDays);
            $model = new AuthTempModel();
            $model->token = $mixed;
            $model->profileid = $uid;
            $dt = CookieMaker::getExpirayForDays(AuthConfig::$defaultCookieExpirationInDays);            
            $model->expirationdatetime = new DateTime("@$dt");     
            $repo->removeByProfileid($uid);         
            if ($repo->add($model)) {
                return true;
            } 
            else 
            {
                return false;
            }

        } catch (Exception $ex) {
            return false;
        }
    }
    public static function signout(){
        CookieMaker::removeCookie(AuthConfig::$cookieName);
    }
}
