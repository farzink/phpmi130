<?php
class Router { 
    private $controller;
    private $action;
    public function analyzeRoute($route){
        $explodedRoute = explode("/", $route);
        $this->controller = $explodedRoute[0];
        $this->action = $explodedRoute[1];        
    }
    function getCurrentController(){
        return $this->controller;
    }
    function getCurrentAction(){
        return $this->action;
    }
} 

?>