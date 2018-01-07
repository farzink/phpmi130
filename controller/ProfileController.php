<?php
require_once("BaseController.php");

require_once("./repository/ProfileRepository.php");
require_once("./model/viewmodel/ProfileViewModel.php");
require_once("./utility/CSRFHelper.php");
class ProfileController extends BaseController {
    private $profileRepo;
    private $authTempRepo;
    public function __construct(){
        parent::__construct();
        $dataAccess = new DataAccess();
        $this->profileRepo = new ProfileRepository($dataAccess);        
    }
    
    /**
     * @param secure
     *  verb:[post]
     * @return void
     */
    public function edit(ProfileViewModel $model, $type){
        //echo($this->getAuth()->profileid);
        $profile = $this->profileRepo->getById($this->getAuth()->profileid);       
        
        
        if($type == "GET"){        
            $model->csrf = CSRFHelper::generate($profile->email);
            $this->view($model);        
        }
        if($type == "POST"){ 
            if(!CSRFHelper::validate($profile->email, $this->getCSRF())){
            // $errorModel = new ErrorModel();
            // $errorModel->reason = "your session is expired";
             $this->redirect("home/error?reason=your session is expired&link=profile/edit");
            }
            //$this->redirect("home/index");    
        }
    }
}



// RegisterViewModel $model, $type){
//     //echo($model->email);
//     if($type == "POST"){        


















