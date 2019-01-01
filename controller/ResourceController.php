<?php
require_once("BaseController.php");
require_once("./model/viewmodel/ResourceViewModel.php");
class ResourceController extends BaseController {
    
    public function __construct(){
        parent::__construct();        
    }    
    /**
         * params
         * verb:[get]
         * 
         */
    public function get(ResourceViewModel $model){        
        
        $address =  "./assets/images/".$model->id;
        ob_clean();        
        header("Content-Type: image/jpeg");
        //to download
        //header('Content-Disposition: attachment; filename="'.$model->id.'"');           
        header('Content-length:'.filesize($address)); 
        readfile($address);
    }
    public function index(){
        echo "dsfasdfasdf";                  
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


?>