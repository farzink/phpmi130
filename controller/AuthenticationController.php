<?php
require_once "BaseController.php";
require_once "./model/viewmodel/RegisterViewModel.php";
require_once "./repository/ProfileRepository.php";
require_once "./model/ProfileModel.php";
require_once "./utility/SigninHelper.php";
require_once "./utility/CookieMaker.php";
require_once "./utility/EmailTokenHelper.php";
require_once "./utility/Mailer.php";
require_once "./model/viewmodel/TokenViewModel.php";
require_once "./htmlhelper/TagHelper.php";

class AuthenticationController extends BaseController
{
    private $profileRepo;
    private $authTempRepo;
    public function __construct()
    {
        parent::__construct();
        $dataAccess = new DataAccess();
        $this->profileRepo = new ProfileRepository($dataAccess);
    }
    /**
     * verb:[post]
     * allowed:[admin]
     */
    public function login(RegisterViewModel $model, $type)
    {
        if ($type == "POST") {
            if (SigninHelper::signinWithEmailPassword($model->email, $model->password) == true) {
                $this->redirect("home/index");
            } else {
                $this->addError("email", "wrong credentials");
            }
        }
        $this->view();
    }
    /**
     * verb:[post]
     * allowed:[admin]
     */
    public function logout()
    {
        CookieMaker::removeCookie(AuthConfig::$cookieName);
        $this->redirect('/home/index');
    }
    /**
     * verb:[post]
     * allowed:[admin]
     */
    public function register(RegisterViewModel $model, $type)
    {
        //echo($model->email);
        if ($type == "POST") {
            $user = $this->profileRepo->getByEmail($model->email);
            if ($user == null) {
                $profile = new ProfileModel();
                $profile->email = $model->email;
                $profile->password = $model->password;
                $profile->roleId = 1;
                if ($this->profileRepo->add($profile)) {
                    $uid = $this->profileRepo->getByEmail($model->email)->id;
                    $emailToken = EmailTokenHelper::generate($model->email);
                    $html = new TagHelper();
                    $link = $html->link("http://localhost:9000/phpmi130/authentication/verify?token=" . $emailToken, "verify");
                    Mailer::send($model->email, "please verify your email address", $link);
                    if (SigninHelper::signin($uid)) {
                       $this->redirect("home/index");
                    } else {
                        //go to error page
                    }
                }
            } else {
                $this->addError("email", $user->email . " already exist, please use another email");
            }
        }
        $this->view($model);
    }
    /**
         * params
         * verb:[get]
         * 
         */
    public function verify(TokenViewModel $model)
    {
        $message = new ErrorModel();
        $result = EmailTokenHelper::validate($model->token);
       if($result->isSuccessfull){       
        $message->reason = "successful activation";       
       }
       else{
        $message->reason = "link is wrong or expired, resend?".$result->email;
        
       }
       $this->view($message);
    }

}
