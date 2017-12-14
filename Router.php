<?php
class Router { 
    private $controller;
    private $action;
    public function analyzeRoute($route){        
        $explodedRoute = explode("/", $route);
        //todo: length needs to be checked
        if($route === ""){
            $this->controller = "home";
            $this->action = "index";
        }else{
        if(count($explodedRoute) > 0){
        $this->controller = $explodedRoute[0];
        }else{            
            $this->controller = "home";
        }
        if(count($explodedRoute) > 1){
        $this->action = $explodedRoute[1];  
        }else{            
            $this->action = "index";
        }
    }
    }
    function getCurrentController(){
        return $this->controller;
    }
    function getCurrentAction(){
        return $this->action;
    }
} 

?>