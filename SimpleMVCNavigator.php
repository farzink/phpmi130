<?php

class SimpleMVCNavigator {
    private $path = "controller";
    public function __construct($controller="home", $action="index"){
        
    }
    public function navigate($controller="home", $action="index") {
        //echo($this->discoverController($controller));
        try{
        if($this->discoverController($controller)){
            $targetController = require_once("controller/{$controller}Controller.php");
            $targetName = $controller."Controller";
            $t = new  $targetName();
            if($this->discoverAction($t, $action)){                
                $t->$action();
            }
            else{                
                throw new Exception();
            }
            
        }else{
            echo "n f";
        }
        }
        catch(Exception $ex){
            return False;//redirect to error page...
        }
    }
    function discoverController($controller){
        $files = array_filter(array_map(function($tryMe){            
            return strtolower(explode("Controller.php", $tryMe)[0]);                          
        }, scandir($this->path)), function($tryMe){            
            return ($tryMe == "." || $tryMe == "..") ? false : true;        
        });
        return ((array_search($controller, $files) !== "") ? TRUE : FALSE);        
    }
    function discoverAction($controller, $action){
        //check to see if its callable  ======= is_callable        
        $controllerMethods = get_class_methods($controller);        
        return ((array_search($action, $controllerMethods) !== "") ? TRUE : FALSE);        
    }
}