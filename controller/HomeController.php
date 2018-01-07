<?php
require_once("BaseController.php");
class HomeController extends BaseController {
    public function __construct(){
        parent::__construct();
    }    
    public function index(){
        $this->addError("id", "");
        $this->view([
            "id" => "",
            "name" => "someone"
        ]);        
    }    
    // public function error(ErrorModel $model){
    //     $this->view($model);
    // }
        /**
         * params
         * verb:[get]
         * 
         */
    public function error(ErrorModel $model){        
        $this->view($model);
    }
}