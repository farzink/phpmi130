<?php
interface IMiddlewareBase {
    public function apply($server, $cookies);    
}
?>