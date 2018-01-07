<?php
include_once("./utility/CommentExtractor.php");
include_once("./AuthConfig.php");
include_once("./utility/CookieMaker.php");
include_once("./repository/AuthTempRepository.php");

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
            if(CookieMaker::exists(AuthConfig::$cookieName)){
                $cookie = CookieMaker::getCookie(AuthConfig::$cookieName);
                $repo = new AuthTempRepository(new DataAccess());
                $auth = $repo->getByToken($cookie);
                if($auth != NULL ){
                    //check the expiry
                    $server['user'] = $auth;                    
                    return [
                        "data" => "data",
                        "next" => true
                    ];            
                }               
            }
            header("Location: {$this->loginRoute}");            
            return [
                "data" => "data",
                "next" => false
            ];
        }
        else if(CookieMaker::exists(AuthConfig::$cookieName)){
            $cookie = CookieMaker::getCookie(AuthConfig::$cookieName);
            $repo = new AuthTempRepository(new DataAccess());
            $auth = $repo->getByToken($cookie);
            if($auth != NULL ){
                //check the expiry
                $server['user'] = $auth;                    
                return [
                    "data" => "data",
                    "next" => true
                ];            
            }               
        }
        return [
            "data" => "data",
            "next" => true
        ];            
    }
 public function consider(){
     return "considered...";
 }
}
?>

