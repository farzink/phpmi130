<?php
interface MiddlewareBase {
    public function apply($server, $cookies);    
}
?>