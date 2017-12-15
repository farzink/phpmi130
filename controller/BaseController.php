<?php
require_once("./MI130ViewEngine.php");

class BaseController {
    private $viewEngine;
    private $modelErrors = [];
    public function __construct(){        
        $this->viewEngine = new MI130ViewEngine();
    }
    protected function view($model = []){
        $controller = debug_backtrace()[1]['class'];
        $action = debug_backtrace()[1]['function'];
        $model = array_merge($this->modelErrors, $model);
        echo($this->viewEngine->cook($controller, $action, $model));
    }
    protected function addError($key, $value){
        $this->modelErrors[$key."error"] = $value;
    }
}