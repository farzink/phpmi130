<?php

//this script is supposed to be run through shell to only initialize the database tables
require_once "../DataAccess.php";
require_once "../DBConfiguration.php";
require_once "ProfileMigration.php";
require_once "AuthTempMigration.php";
require_once "UserLogMigration.php";
require_once "RoleMigration.php";
require_once "EmailTokenMigration.php";
require_once "AccountRemovalMigration.php";
require_once "CSRFTokenMigration.php";
require_once "ItemMigration.php";
require_once "OrderMigration.php";
require_once "OrderHistoryMigration.php";
require_once('../../utility/AuthHelper.php');

$u = "";
$p = "";

//username and password are supposed to be provided as arguments
//for testing purpose only hard-coded user: user and password: password are used
//database name is being read from dbconfiguration file
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
    seedItems();
    // $command = "INSERT INTO profiles (firstname, lastname, email, password, phone, roleId)
    //             VALUES ('farzin', 'khoshneyat', 'farzin_fz@yahoo.com','". AuthHelper::hashPassword("12") ."', '0157 573383242342', 1)";
    
    // $dataAccess->executeCommand($command);
}

function seedItems(){
    $dataAccess = new DataAccess();
    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Monitor', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.', 
    'monitor.png', 
    800, 2)";
    $dataAccess->executeCommand($command);

    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Keyboard', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.', 
    'keyboard.jpg', 
    100, 10)";
    $dataAccess->executeCommand($command);

    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Mouse', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.',
    'mouse.jpg', 
    25, 10)";
    $dataAccess->executeCommand($command);

    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Speaker', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.', 
    'speaker.jpg', 
    125, 4)";
    $dataAccess->executeCommand($command);

    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Headphone', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.', 
    'headphone.jpg', 
    40, 5)";
    $dataAccess->executeCommand($command);

    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Laptop', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.', 
    'laptop.jpg', 
    1255, 1)";
    $dataAccess->executeCommand($command);

    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Microphone', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.', 
    'microphone.jpg', 
    30, 5)";
    $dataAccess->executeCommand($command);

    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Ram', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.', 
    'ram.jpg', 
    200, 10)";
    $dataAccess->executeCommand($command);

    $command = "INSERT INTO items (title, description, imageAddress, price, quantity) VALUES ('Cellphone', 
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum sed enim id dictum. Maecenas ut erat nibh.', 
    'cellphone.jpg', 
    400, 4)";
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


    $command = EmailTokenMigration::migrate();        
    $table = EmailTokenMigration::$tableName;
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }

    $command = AccountRemovalMigration::migrate();        
    $table = AccountRemovalMigration::$tableName;
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }


    $command = CSRFTokenMigration::migrate();        
    $table = CSRFTokenMigration::$tableName;
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }

    $command = ItemMigration::migrate();        
    $table = ItemMigration::$tableName;
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }

    $command = OrderMigration::migrate();        
    $table = OrderMigration::$tableName;
    if($dataAccess->executeCommand($command) == true) {
        pl("{$counter}. {$table} table is susccessfully created.");
        $counter++;
    }


    $command = OrderHistoryMigration::migrate();        
    $table = OrderHistoryMigration::$tableName;
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




