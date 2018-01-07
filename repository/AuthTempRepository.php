<?php

require_once './model/ModelFactory.php';
require_once './model/AuthTempModel.php';
require_once './utility/AuthHelper.php';

class AuthTempRepository
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function getByToken($token)
    {
        $query = "SELECT * FROM authtemp where token = '{$token}'";
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {
            //while($row = $result->fetch_assoc()) {
            return ModelFactory::rawToAuthTempModel($result->fetch_assoc());
            //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["email"]. "<br>";
            //}
        } else {
            return null;
        }
    }
    public function add(AuthTempModel $model)
    {        
        try {                        
            $query = "INSERT INTO authtemp (token, profileid, expirationdatetime) VALUES ('{$model->token}', {$model->profileid}, '{$model->expirationdatetime->format('y-m-d')}')";                        
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    public function removeByProfileid($profileid)
    {        
        try {                        
            $query = "delete FROM authtemp where profileid = '{$profileid}'";
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
