<?php
require_once("BaseController.php");
require_once("./model/viewmodel/RegisterViewModel.php");
require_once("./repository/ProfileRepository.php");
require_once("./model/ProfileModel.php");

class AuthenticationController extends BaseController {
    private $repo;
    public function __construct(){
        parent::__construct();
        $this->repo = new ProfileRepository(new DataAccess());
    }
    public function login(){
        $this->view();        
    }
    /**
     * verb:[post]
     * allowed:[admin]
     */
    public function register(RegisterViewModel $model, $type){
        //echo($model->email);
        if($type == "POST"){
        $fgdfg = $this->repo->getById(1);
        $user = $this->repo->getByEmail($model->email);
        if($user == null){            
            $profile = new ProfileModel();
            $profile->email = $model->email;
            $profile->password = $model->password;
            if($this->repo->add($profile))
                $this->redirect("home/index");
        }
        else
        {
        $this->addError("email", $user->email. " already exist, please use another email");
        }
    }
        $this->view($model);        
    }


    
}