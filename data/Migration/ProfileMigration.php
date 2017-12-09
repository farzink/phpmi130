<?php
class ProfileMigration{
    public static $tableName = "profiles";
    public static function migrate(){
      $tableName = ProfileMigration::$tableName;
      return 
      "CREATE TABLE {$tableName}
      (
        id int(11) NOT NULL AUTO_INCREMENT,
        firstname varchar(45) DEFAULT NULL,
        lastname varchar(45) DEFAULT NULL,
        email varchar(45) DEFAULT NULL,
        phone varchar(45) DEFAULT NULL,
        extra INT DEFAULT 0,
        creationdatetime datetime DEFAULT CURRENT_TIMESTAMP,
        updateddatetime datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY email_UNIQUE (email),
        UNIQUE KEY phone_UNIQUE (phone)
      )      
      ";
    }
}
  