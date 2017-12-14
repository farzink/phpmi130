<?php
require_once("BaseController.php");
class AuthenticationController extends BaseController {
    public function __construct(){
        parent::__construct();
    }
    public function login(){
        $this->view("something");        
    }
    public function register(){
        $this->view("something");        
    }
}