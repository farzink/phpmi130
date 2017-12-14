<?php
include_once("./utility/CommentExtractor.php");
include_once("./AuthConfig.php");

class AuthMiddleware implements IMiddlewareBase {
    private $AUTH_COOKIE = "auth";
    private $server;
    private $cookies;
    private $loginRoute;
    public function __construct(){
        $this->loginRoute = AuthConfig::$loginRoute;
    }
    public function apply(&$router, &$server, &$cookies){
        $this->server = $server;
        $this->cookies = $cookies;
        $server['user'] = NULL;

        $controller =  "{$router->getCurrentController()}controller";
        $ce = new CommentExtractor();
        $doc = $ce->getParam("./controller", $controller);
        $annotaion = $doc->getMethod($router->getCurrentAction())->getDocComment();
        if(strpos($annotaion, "secure") !== false || strpos($annotaion, "secured") !== false){
            if(!isset($this->cookie[$this->AUTH_COOKIE])){
                //echo "unauthorize...";
            }
            header("Location: {$this->loginRoute}");            
            return [
                "data" => "data",
                "next" => false
            ];            
        }
        else{
            if(!isset($this->cookie[$this->AUTH_COOKIE])){
                //echo "unauthorize...";
            }
            return [
                "data" => "data",
                "next" => true
            ];
            
        }



      
    }
 public function consider(){
     return "considered...";
 }
}
?>

