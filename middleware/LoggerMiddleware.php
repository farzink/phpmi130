<?php
include_once("./utility/CommentExtractor.php");

class LoggerMiddleware implements IMiddlewareBase {
    private $AUTH_COOKIE = "auth";
    private $server;
    private $cookies;
    public function apply(&$router, &$server, &$cookies){
        $this->server = $server;
        $this->cookies = $cookies;
        $server['user'] = NULL;

        $controller =  "{$router->getCurrentController()}controller";
        $ce = new CommentExtractor();
        $doc = $ce->getParam("./controller", $controller);
        $annotaion = $doc->getMethod($router->getCurrentAction())->getDocComment();
        if(strpos($annotaion, "secure") !== false || strpos($annotaion, "secured") !== false){
            echo("secured");
        }
        else{
            echo("not secured");
        }



        //echo($request["HTTP_Authorize"]);
        // $headers = array();
        // foreach($request as $key => $value) {
        //     if (substr($key, 0, 5) <> 'HTTP_') {
        //         continue;
        //     }
        //     $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
        //     $headers[$header] = $value;
        //     echo($headers);
        // }
        if(!isset($this->cookie[$this->AUTH_COOKIE])){
            //echo "unauthorize...";
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

