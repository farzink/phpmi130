<?php
class OrderHistoryMigration {
    public static $tableName = "orderhistories";
    public static function migrate(){
      $tableName = OrderHistoryMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,
        profileId int(11) NOT NULL,
        total INT default 0,           
        items INT default 0,
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)        
      )      
      ";
    }
}