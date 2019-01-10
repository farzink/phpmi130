<?php
require_once("BaseController.php");

require_once("./repository/OrderRepository.php");
require_once("./repository/ItemRepository.php");

require_once("./model/viewmodel/OrderViewModel.php");
require_once("./model/ModelFactory.php");
require_once("./utility/CSRFHelper.php");

class OrdersController extends BaseController {
    private $orderRepo;
    private $profileRepo;
    private $itemRepo;
    
    
    public function __construct(){
        parent::__construct();
        $dataAccess = new DataAccess();
        $this->orderRepo = new OrderRepository($dataAccess);                
        $this->profileRepo = new ProfileRepository($dataAccess);                
        $this->itemRepo = new ItemRepository($dataAccess);                
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
        if (!$this->isAuthorized())
            return;
        $profile = ($this->profileRepo->getById($this->getAuth()->profileid));

        $item = $this->itemRepo->getById($model->itemId);

        if ($item != null) {

            $availableStocks = $item->quantity;
            
            $qty = $this->orderRepo->orderCountByProfileId($profile->id, $item->id);
            
            if ($availableStocks > $qty) {
                $model->price = $item->price;
                $model->profileId = $profile->id;

                $result = $this->orderRepo->add(ModelFactory::OrderItemViewModelToOrderItem($model));               
                //if ($result != null)
                
                return $this->status($this::CREATED);                
            } else {
                return $this->status($this::NOT_ACCEPTABLE);
            }
        }
        return $this->status($this::BAD_REQUEST);
    }

    /**
     * 
     *  verb:[delete]
     * @return void
     */
    public function removeItem(OrderViewModel $model){
        if(!$this->isAuthorized())
            return;               
        
        $profile = ($this->profileRepo->getById($this->getAuth()->profileid));
        $model->profileId = $profile->id;

    
        $result = $this->orderRepo->remove(ModelFactory::OrderItemViewModelToOrderItem($model));
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
     * 
     *  verb:[get]
     * @return void
     */
    public function validateOrder(){                
        if(!$this->isAuthorized())
            return;                      
        $profile = ($this->profileRepo->getById($this->getAuth()->profileid));        
    
        $orders = $this->orderRepo->getGroupedOrderByProfileId($profile->id);
        //return $this->json($orders, $this::OK);
        foreach($orders as $count => $item){
            $itm = $this->itemRepo->getById($item->itemId);
            
            if($item->count > $itm->quantity){
                return $this->json([ "error" =>
                "{$itm->title} more than available quantity, please decrease the quantity (max avilable: {$itm->quantity})"],
                $this::NOT_ACCEPTABLE);
            }
        }      
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




















