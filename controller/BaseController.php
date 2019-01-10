<?php
require_once("./MI130ViewEngine.php");
require_once("./AppConfig.php");
require_once("./model/ErrorModel.php");

class BaseController {

    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const NOT_FOUND = 404;
    const NOT_ACCEPTABLE = 406;
    const INTERNAL_SERVER_ERROR = 500;

    private $viewEngine;
    private $modelErrors = [];
    private $auth;
    public function __construct(){        
        $this->viewEngine = new MI130ViewEngine();
        $this->auth = $_SERVER['user'];        
    }
    protected function getAuth(){
        return $this->auth;
    }
    protected function view($model = NULL){
        $auth['isLoggedin'] = false;        
        if($this->getAuth() !== NULL){
            $auth['isLoggedin'] = true;
        }       
        
        $controller = debug_backtrace()[1]['class'];
        $action = debug_backtrace()[1]['function'];
        if($model != NULL)
            $model = array_merge($this->modelErrors, (array)$model, $auth);
        else
            $model = array_merge($this->modelErrors, $auth);
        echo($this->viewEngine->cook($controller, $action, $model));
    }
    protected function json($model = NULL, $httpStatus=BaseController::OK){
        http_response_code($httpStatus);
        echo json_encode($model);
    }
    protected function status($httpStatus=BaseController::OK){
        ob_clean();
        http_response_code($httpStatus);        
    }
    protected function addError($key, $value){
        $this->modelErrors[$key."error"] = $value;
    }
    protected function redirect($route)
    {
        $base = AppConfig::$base;
        header("Location: {$base}/{$route}");
    }
    protected function getCSRF(){
        return $_POST["csrf_token"];
    }
    protected function isAuthorized(){
        if(!isset($this->auth)){
            $this->status($this::UNAUTHORIZED);            
            return false;
        }
        return true;
    }
}