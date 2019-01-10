<?php
require_once("BaseController.php");

require_once("./repository/ProfileRepository.php");

require_once("./model/viewmodel/ProfileViewModel.php");
require_once("./model/ModelFactory.php");
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
     *  verb:[get]
     * @return void
     */
    public function info(){
        $profile = $this->profileRepo->getById($this->getAuth()->profileid);
        return $this->json($profile, $this::OK);
    }
    /**
     * @param secure
     *  verb:[get]
     * @return void
     */
    public function updateAddress(ProfileViewModel $model){
        $profile = $this->profileRepo->getById($this->getAuth()->profileid);
        $profile->address = $model->address;
        $this->profileRepo->update(ModelFactory::ProfileViewModelToProfile($profile));
        return $this->status($this::OK);
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
            $model->firstname = $profile->firstname;
            $model->lastname = $profile->lastname;
            $model->phone = $profile->phone;
            $model->address = $profile->address;
            
            $this->view($model);        
        }
        if($type == "POST"){ 
            //$result = CSRFHelper::validate($profile->email, $this->getCSRF());
            //echo($result); 
            if(!CSRFHelper::validate($profile->email, $this->getCSRF())){
            
            // $errorModel = new ErrorModel();
            // $errorModel->reason = "your session is expired";
             $this->redirect("home/error?reason=your session is expired&link=profile/edit");
            }
            $model->email = $profile->email;
            $this->profileRepo->update(ModelFactory::ProfileViewModelToProfile($model));
            $this->redirect("home/index");    
        }
    }
}



// RegisterViewModel $model, $type){
//     //echo($model->email);
//     if($type == "POST"){        


















