<?php

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
            echo($query);
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    public function updateEmailToken(ProfileModel $model)
    {        
        try {
            $query = "UPDATE profiles set emailToken='{$model->emailToken}' where email = '{$model->email}'";            
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    
}
