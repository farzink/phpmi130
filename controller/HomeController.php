<?php
require_once("BaseController.php");
require_once("./repository/ItemRepository.php");
class HomeController extends BaseController {
    private $itemsRepo;
    public function __construct(){
        parent::__construct();
        $dataAccess = new DataAccess();
        $this->itemsRepo = new ItemRepository($dataAccess);        
    }    
    public function index(){
        $this->addError("id", "");
        //print_r(sizeof($this->itemsRepo->getAll()));
        $this->view([
            "id" => "fddgsfgf",
            "name" => "someone",
            "items" => $this->itemsRepo->getAll()
        ]);        
    }    
    
    // public function error(ErrorModel $model){
    //     $this->view($model);
    // }
        /**
         * params
         * verb:[get]
         * 
         */
    public function error(ErrorModel $model){        
        $this->view($model);
    }
}