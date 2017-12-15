<?php
require_once("BaseController.php");
require_once("./model/viewmodel/RegisterViewModel.php");
require_once("./repository/ProfileRepository.php");
require_once("./model/ProfileModel.php");
require_once("./utility/SigninHelper.php");


class AuthenticationController extends BaseController {
    private $profileRepo;
    private $authTempRepo;
    public function __construct(){
        parent::__construct();
        $dataAccess = new DataAccess();
        $this->profileRepo = new ProfileRepository($dataAccess);        
    }
    /**
     * verb:[post]
     * allowed:[admin]
     */
    public function login(RegisterViewModel $model, $type){
        if($type == "POST")
        {
            if(SigninHelper::signinWithEmailPassword($model->email, $model->password) == TRUE)
            {
                $this->redirect("home/index");
            }
            else
            {
                $this->addError("email", "wrong credentials");        
            }
        }
        $this->view();        
    }
    /**
     * verb:[post]
     * allowed:[admin]
     */
    public function register(RegisterViewModel $model, $type){
        //echo($model->email);
        if($type == "POST"){        
        $user = $this->profileRepo->getByEmail($model->email);
        if($user == null){            
            $profile = new ProfileModel();
            $profile->email = $model->email;
            $profile->password = $model->password;
            if($this->profileRepo->add($profile)){
                $uid = $this->profileRepo->getByEmail($model->email)->id;
                if(SigninHelper::signin($uid)){
                    $this->redirect("home/index");
                }
                else{
                    //go to error page
                }
            }
        }
        else
        {
        $this->addError("email", $user->email. " already exist, please use another email");
        }
    }
        $this->view($model);        
    }


    
}