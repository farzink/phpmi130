<?php
class AuthTempMigration{
    public static $tableName = "authtemp";
    public static function migrate(){
      $tableName = AuthTempMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,
        token varchar(250) DEFAULT NULL,
        profileid int(11) NOT NULL,
        expirationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)        
      )      
      ";
    }
}
  