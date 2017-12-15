<?php
class RoleMigration {
    public static $tableName = "roles";
    public static function migrate(){
      $tableName = RoleMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,        
        role varchar(45) DEFAULT NULL,
        rank int DEFAULT 0,
        isDefault BIT DEFAULT 0,
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)        
      )      
      ";
    }
}
  