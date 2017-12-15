<?php
require_once("BaseController.php");
require_once("./model/viewmodel/RegisterViewModel.php");

class AuthenticationController extends BaseController {
    public function __construct(){
        parent::__construct();
    }
    public function login(){
        $this->view();        
    }
    /**
     * verb:[post]
     * allowed:[admin]
     */
    public function register(RegisterViewModel $model){
        //echo($model->email);
        $this->addError("email", "sorry, the email is taken");
        $this->view($model);        
    }
}