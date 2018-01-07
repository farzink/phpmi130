<?php
class CSRFTokenMigration{
    public static $tableName = "csrftokens";
    public static function migrate(){
      $tableName = CSRFTokenMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,                
        email varchar(45) DEFAULT NULL,
        expirationdatetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        token varchar(250) DEFAULT NULL,
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),        
        UNIQUE KEY email_UNIQUE (email)        
      )      
      ";
    }
}
  