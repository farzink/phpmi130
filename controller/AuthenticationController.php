<?php
require_once("BaseController.php");
class AuthenticationController extends BaseController {
    public function __construct(){
        parent::__construct();
    }
    public function login(){
        $this->view();        
    }
    public function register(){
        $this->addError("email", "sorry, the email is taken");
        $this->view();        
    }
}