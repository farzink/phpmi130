<?php
require 'DBConfiguration.php';
class DataAccess {
    private $connection;
    public function prepareConnection(){
        $this->connection = new mysqli(
            DBConfiguration::$hostname,
            DBConfiguration::$username,
            DBConfiguration::$password,
            DBConfiguration::$database
        );
    }
    public function getConnection(){
        if($this->connection == null){
            $this->prepareConnection();
        }
        return $this->connection;
    }
    public function closeConnection(){
        $this->connection->close();
    }
    public function executeQuery($query){
        try{
        if($this->connection == null){
            $this->prepareConnection();
            return $this->connection->query($query);            
        }
        }catch(Exception $ex){
        //some error reporting  
        }finally{
            $this->connection->close();
        }        
    }
    //need to be tested out later on
    public function executeCommand($query){
        try{
        if($this->connection == null){
            $this->prepareConnection();
            if($this->connection->query($query) == TRUE)
                return TRUE;
            return FALSE;            
        }
        }catch(Exception $ex){
            return FALSE;        
        }finally{
            $this->connection->close();
        }        
    }
    public function executeInitiationCommand($query){
        $connection = new mysqli(
            DBConfiguration::$hostname,
            DBConfiguration::$username,
            DBConfiguration::$password
        );  
        try{                  
            if($connection->query($query) == TRUE)
                return TRUE;
            return FALSE;            
        }
        catch(Exception $ex){
            return FALSE;        
        }finally{
            $connection->close();
        }        
    }
}


?>