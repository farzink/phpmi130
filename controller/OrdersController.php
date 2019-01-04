<?php
require_once("BaseController.php");

require_once("./repository/OrderRepository.php");

require_once("./model/viewmodel/OrderViewModel.php");
require_once("./model/ModelFactory.php");
require_once("./utility/CSRFHelper.php");

class OrdersController extends BaseController {
    private $orderRepo;
    private $profileRepo;
    
    
    public function __construct(){
        parent::__construct();
        $dataAccess = new DataAccess();
        $this->orderRepo = new OrderRepository($dataAccess);                
        $this->profileRepo = new ProfileRepository($dataAccess);                
    }

    
    /**
     * @param secure 
     *  verb:[get]
     * @return void
     */
    public function index(){
        $this->addError("id", "");
        //print_r(sizeof($this->itemsRepo->getAll()));
        $this->view([
            "id" => "fddgsfgf"
        ]);        
    }    




    /**
     * 
     *  verb:[get]
     * @return void
     */
    public function addItem(OrderViewModel $model){
        if(!$this->isAuthorized())
            return;               
        $profile = ($this->profileRepo->getById($this->getAuth()->profileid));
        $model->profileId = $profile->id;
    
        $result = $this->orderRepo->add(ModelFactory::OrderItemViewModelToOrderItem($model));
        if($result != null)
            return $this->json($result, $this::CREATED);
        return $this->status($this::BAD_REQUEST);
    }


    /**
     * 
     *  verb:[post]
     * @return void
     */
    public function create(OrderViewModel $model){                
        if(!$this->isAuthorized())
            return;                      
        $profile = ($this->profileRepo->getById($this->getAuth()->profileid));
        $model->profileId = $profile->id;
    
        $result = $this->orderRepo->add(ModelFactory::OrderItemViewModelToOrderItem($model));
        if($result != null)
            return $this->json($result, $this::CREATED);
        return $this->status($this::BAD_REQUEST);
    }


    public function card(){
        if(!$this->isAuthorized())
            return;                
        $profile = ($this->profileRepo->getById($this->getAuth()->profileid));            
        if(!isset($profile)){
            return $this->status($this::UNAUTHORIZED);
        }
        return $this->json($this->orderRepo->getOrderByProfileId($profile->id));
        
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




















