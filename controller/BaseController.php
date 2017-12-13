<?php
require_once("./MI130ViewEngine.php");

class BaseController {
    private $viewEngine;
    public function __construct(){
        $this->viewEngine = new MI130ViewEngine();
    }
    protected function view($model = NUll){
        $controller = debug_backtrace()[1]['class'];
        $action = debug_backtrace()[1]['function'];                     
        echo($this->viewEngine->cook($controller, $action, $model));
    }
}