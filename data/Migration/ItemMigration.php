<?php
class ItemMigration {
    public static $tableName = "items";
    public static function migrate(){
      $tableName = ItemMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,
        title varchar (45) DEFAULT NULL,
        description varchar (512) DEFAULT NULL,
        imageAddress varchar (512) DEFAULT NULL,
        price INT default 0,
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)        
      )      
      ";
    }
}