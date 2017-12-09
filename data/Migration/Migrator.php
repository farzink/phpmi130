<?php

//this script is supposed to be run through shell to only initialize th edatabase tables
require_once "../DataAccess.php";
require_once "../DBConfiguration.php";
require_once "ProfileMigration.php";
require_once "AuthTempMigration.php";



function pl($message){
    print($message);
    print("\n");
}
function pld(){
    pl("---------------------------------------------------------------");
}




$database = DBConfiguration::$database;
try {
    $dataAccess = new DataAccess();

    $command = "DROP DATABASE {$database}";
    if ($dataAccess->executeInitiationCommand($command) == true) {
        pl("database {$database} is susccessfully dropped.");
    }

    $command = "CREATE DATABASE {$database}";
    if ($dataAccess->executeInitiationCommand($command) == true) {
        pl("database {$database} is susccessfully created.");
    }
    

    pld();
    $counter = 1;
    $table = ProfileMigration::$tableName;
    $command = ProfileMigration::migrate();    
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }

    $command = AuthTempMigration::migrate();        
    $table = AuthTempMigration::$tableName;
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }



    pld();

} catch (Exception $ex) {
    //log("error while creating database, make sure the database {$database} does not exist");
    pl($ex);
}
