<?php

class CSRFMddleware implements IMiddlewareBase {
    private $server;
    private $cookies;
    public function apply($server, $cookies){
        $this->server= $server;
        $this->cookies = $cookies;
        //the actual process related
        //to this specific
        //middleware
        echo("csrf");
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