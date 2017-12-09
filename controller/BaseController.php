<?php
require_once("./MI130ViewEngine.php");

class BaseController {
    private $viewEngine;
    public function __construct(){
        $this->viewEngine = new MI130ViewEngine();
    }
    protected function view($context){
        echo($context);
    }
}