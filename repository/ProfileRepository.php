<?php

use PHPMailer\PHPMailer\Exception;

require_once './model/ModelFactory.php';
require_once './model/ProfileModel.php';
require_once './utility/AuthHelper.php';

class ProfileRepository
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function getById($id)
    {
        $query = "SELECT * FROM profiles where id = {$id}";
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {
            //while($row = $result->fetch_assoc()) {
            return ModelFactory::rawToProfileModel($result->fetch_assoc());
            //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["email"]. "<br>";
            //}
        } else {
            return null;
        }
    }
    public function getByEmail($email)
    {
        $query = "SELECT * FROM profiles where email = '{$email}'";
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {
            return ModelFactory::rawToProfileModel($result->fetch_assoc());
        } else {
            return null;
        }
    }
    public function add(ProfileModel $model)
    {
        $password = AuthHelper::hashPassword($model->password);
        try {
            $query = "INSERT INTO profiles (email, password) VALUES ('{$model->email}', '{$password}')";            
            
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    public function updateEmailToken(ProfileModel $model)
    {        
        try {
            $date = date('Y-m-d H:i:s', $model->expirationdatetime);
            $query = "UPDATE profiles set emailToken='{$model->emailToken}', expirationdatetime='{$date}' where email = '{$model->email}'";  

            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function update(ProfileModel $model)
    {        
        try {            
            $query = "UPDATE profiles set firstname='{$model->firstname}', 
            lastname='{$model->lastname}', 
            phone='{$model->phone}', address='{$model->address}'
             where email = '{$model->email}'";  
            
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    public function getByEmailToken($emailToken)
    {
        $query = "SELECT * FROM profiles where emailToken = '{$emailToken}'";
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {
            return ModelFactory::rawToProfileModel($result->fetch_assoc());
        } else {
            return null;
        }
    }

    public function activateProfilebyEmail($email)
    {
        try
        {
        $query = "UPDATE profiles set isActivated=1 where email = '{$email}'";        
        $this->data->executeQuery($query);
        }
        catch(Exception $ex)
        {
            return FALSE;
        }
    }

    
    
}


