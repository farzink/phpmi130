<?php

class TestMiddleware implements IMiddlewareBase {
    private $AUTH_COOKIE = "auth";
    private $server;
    private $cookies;
    public function apply(&$server, &$cookies){
        $this->server = $server;
        $this->cookies = $cookies;
        $server['user'] = NULL;
        
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