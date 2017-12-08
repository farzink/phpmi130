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
}


?>