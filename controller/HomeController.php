<?php
require_once("BaseController.php");
class HomeController extends BaseController {
    public function __construct(){
        parent::__construct();
    }    
    public function index(){
        $this->addError("id", "some error");
        $this->view([
            "id" => "100",
            "name" => "someone"
        ]);        
    }    
    public function index1(){
        echo "index 1";
    }
}