<?php
class UserLogMigration {
    public static $tableName = "userlogs";
    public static function migrate(){
      $tableName = UserLogMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,
        ip varchar(45) DEFAULT NULL,
        route varchar(80) DEFAULT NULL,
        param_1 varchar(45) DEFAULT NULL,
        param_2 varchar(45) DEFAULT NULL,        
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)        
      )      
      ";
    }
}
  