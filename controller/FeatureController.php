<?php
require_once("BaseController.php");
class FeatureController extends BaseController {
    public function __construct(){
        parent::__construct();
    }
    /**
     * @param secure
     *
     * @return void
     */
    public function index(){
        $this->view();        
    }
}






















