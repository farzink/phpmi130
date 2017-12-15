<?php

//this script is supposed to be run through shell to only initialize th edatabase tables
require_once "../DataAccess.php";
require_once "../DBConfiguration.php";
require_once "ProfileMigration.php";
require_once "AuthTempMigration.php";
require_once "UserLogMigration.php";
require_once "RoleMigration.php";
require_once('../../utility/AuthHelper.php');

$u = "";
$p = "";


if($argc > 2)
{
$u = $argv[1];
$p = $argv[2];
}

function pl($message){
    print($message);
    print("\n");
}
function pld(){
    pl("---------------------------------------------------------------");
}


function seed(){
    $dataAccess = new DataAccess();
    $command = "INSERT INTO roles (role, rank) VALUES ('admin', 100)";


    $dataAccess->executeCommand($command);

    $command = "INSERT INTO profiles (firstname, lastname, email, password, phone, roleId)
                VALUES ('farzin', 'k', 'farzin@somewhere.fart','". AuthHelper::hashPassword("12343sdfsdfs") ."', '3423345345', 1)";
    
    $dataAccess->executeCommand($command);
}
    

if($u === "user" && $p === "password")
{

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



    $command = RoleMigration::migrate();        
    $table = RoleMigration::$tableName;
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }



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

    $command = UserLogMigration::migrate();        
    $table = UserLogMigration::$tableName;
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }

    

    seed();

    pld();

} catch (Exception $ex) {
    //log("error while creating database, make sure the database {$database} does not exist");
    pl($ex);
}

}
