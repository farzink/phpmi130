<?php
include'MiddlewareBase.php';
class MiddlewareConfig {
    private $server;
    private $cookies;

    private $middlewares;
    function __construct($server, $cookies){
        $this->server = $server;
        $this->cookies = $cookies;
        $this->middlewares = array();
    }
    function consider($middleware){        
        array_push($this->middlewares, $middleware);
    }
    function apply(){
        foreach($this->middlewares as $m){
            $m->setParams($this->server, $this->cookies);
            if($m->apply("something")["next"] == false)
                break;
        }
    }
}


?>