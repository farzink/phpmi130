<?php
class OrderMigration {
    public static $tableName = "orders";
    public static function migrate(){
      $tableName = OrderMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,
        profileId varchar (45) DEFAULT NULL,
        itemId varchar (512) DEFAULT NULL,           
        price INT default 0,
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)        
      )      
      ";
    }
}