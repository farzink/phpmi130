<?php
require_once("BaseController.php");
class HomeController extends BaseController {
    public function __construct(){
        parent::__construct();
    }
    /**
     * @param secure
     *
     * @return void
     */
    public function index(){
        $this->view("something");
        //echo "index";
    }    
    public function index1(){
        echo "index 1";
    }
}