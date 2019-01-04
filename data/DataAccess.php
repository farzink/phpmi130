<?php
require 'DBConfiguration.php';
class DataAccess
{
    private $connection;
    public function prepareConnection()
    {
        $this->connection = new mysqli(
            DBConfiguration::$hostname,
            DBConfiguration::$username,
            DBConfiguration::$password,
            DBConfiguration::$database
        );
    }
    public function getConnection()
    {
        if ($this->connection) {
            $this->prepareConnection();
        }
        return $this->connection;
    }
    public function close()
    {
        if ($this->connection == true) {            
            $this->connection->close();
            $this->connection = NULL;
        }

    }
    public function executeQuery($query)
    {
        try {
            if ($this->connection == null) {
                $this->prepareConnection();
                return $this->connection->query($query);
            }
        } catch (Exception $ex) {
            //some error reporting
        } finally {
            $this->close();
        }
    }
    //need to be tested out later on
    public function executeCommand($query)
    {
        try {
            if ($this->connection == null) {                
                $this->prepareConnection();
            }
            if ($this->connection->query($query) == true) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return false;
        } finally {
            $this->close();
        }
    }
    public function executeInitiationCommand($query)
    {
        $connection = new mysqli(
            DBConfiguration::$hostname,
            DBConfiguration::$username,
            DBConfiguration::$password
        );
        try {
            if ($connection->query($query) == true) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            return false;
        } finally {
            $connection->close();
        }
    }
    public function executeCustomCommand($query)
    {
        try {
            if ($this->connection == null) {                
                $this->prepareConnection();
            }
            return $this->connection->query($query);
            
        } catch (Exception $ex) {
            return false;
        } finally {
            $this->close();
        }
    }
}
