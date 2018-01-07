<?php
class EmailTokenMigration{
    public static $tableName = "emailtokens";
    public static function migrate(){
      $tableName = EmailTokenMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,                
        email varchar(45) DEFAULT NULL,
        expirationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        emailToken varchar(250) DEFAULT NULL,
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),        
        UNIQUE KEY email_UNIQUE (email)        
      )      
      ";
    }
}
  