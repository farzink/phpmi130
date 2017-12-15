<?php
require_once "CookieMaker.php";
require_once "./repository/AuthTempRepository.php";
require_once "./model/AuthTempModel.php";
class SigninHelper
{
    public static function signin($uid)
    {
        try
        {
            $data = new DataAccess();
            $repo = new AuthTempRepository($data);
            $uniq = CookieMaker::unique();
            $mixed = CookieMaker::tokenGenerator($uniq, $uid->id);
            CookieMaker::cook("AuthCookie", $mixed, 30);
            $model = new AuthTempModel();
            $model->token = $mixed;
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
}
