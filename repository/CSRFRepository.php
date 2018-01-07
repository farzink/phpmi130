<?php

require_once './model/ModelFactory.php';
require_once './model/CSRFModel.php';
require_once './utility/AuthHelper.php';

class CSRFRepository
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function getByEmail($email)
    {
        $query = "SELECT * FROM csrftokens where email = {$email}";
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {            
            return ModelFactory::rawToCSRFModel($result->fetch_assoc());            
        } else {
            return null;
        }
    }
    public function getByToken($email, $token)
    {
        
    $query = "SELECT * FROM csrftokens where email = '{$email}' and token='{$token}'";
    
        $result = $this->data->executeQuery($query);        
        if ($result->num_rows > 0) {            
            return ModelFactory::rawToCSRFModel($result->fetch_assoc());            
        } else {
            
            return null;
        }
    }
    public function removeByEmail($email)
    {        
        try {                        
            $query = "delete FROM csrftokens where email = '{$email}'";
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    public function removeByToken($email, $token)
    {        
        try {                        
            $query = "delete FROM csrftokens where email = '{$email}' and token = '{$token}'";
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    public function add(CSRFModel $model)
    {        
        
        try {         
            $date = date('Y-m-d H:i:s', $model->expirationdatetime);
            $query = "INSERT INTO csrftokens (email, token, expirationdatetime) VALUES ('{$model->email}', '{$model->token}', '{$date}')";            
            
            $this->data->executeQuery($query);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
