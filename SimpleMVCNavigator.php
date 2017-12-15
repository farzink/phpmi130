<?php
require_once("utility/CommentExtractor.php");
require_once("SimpleMVCNavigatorConfig.php");
require_once("utility/HTMLEncoder.php");

class SimpleMVCNavigator {
    private $path = "controller";
    private $request;
    public function __construct($controller="home", $action="index"){
        
    }
    public function navigate(&$request, $controller="home", $action="index") {
        $this->request = $request;
        //echo($this->discoverController($controller));
        $controller = ($controller == "") ? "home" : $controller;
        $action = ($action ==  "") ? "index" : $action;
        try{
        if($this->discoverController($controller)){
            $targetController = require_once("controller/{$controller}Controller.php");
            $targetName = $controller."Controller";
            $t = new  $targetName();
            if($this->discoverAction($t, $action)){                
                $this->injectModelByVerb($t, $action);
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
    function getRequestType(){
        return $this->request['REQUEST_METHOD'];
    }
    function injectModelByVerb(&$controller,&$action){
        $com = new CommentExtractor();
        $doc = $com->getParambyClass($controller)->getMethod($action);
        
        //echo($this->prepareVerb($doc));
        if(count($doc->getParameters()) > 0)
        {
            $paramDefinition = $doc->getParameters()[0]->getClass()->name;
        //$def = "RegisterViewModel";
        //$t = new $def();
        //$class = get_class($t);
        $model = $this->model($doc, $paramDefinition);  
        //echo($_POST); 
        //echo(serialize($model->email));
        $controller->$action($model);
        }
        else
        {
            $controller->$action();
        }
    }
    function model($content, $paramDefinition){
        $model;
        preg_match(SimpleMVCNavigatorConfig::$verbPattern, $content, $found);
        switch($found[1])
        {
            case "post":            
            $model = $this->convertToModel($_POST, $paramDefinition);
            break;
            case "get":            
            $model = $this->convertToModel($_GET, $paramDefinition);
            break;
        }
        return $model;        
    }
    function convertToModel(array $array, $className) {
        $encoder = new HTMLEncoder();
        $model = new $className();        
        foreach ($model as $key => $value){            
            if(array_key_exists($key, $array)){                
                $model->$key = $encoder->encode($array[$key]);                
            }
        }
        return $model;
        // return unserialize(sprintf(
        //     'O:%d:"%s"%s',
        //     strlen($className),
        //     $className,
        //     strstr(serialize($array), ':')
        // ));
    }
}