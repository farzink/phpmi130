<?php
interface IMiddlewareBase {
    public function apply(&$router, &$server, &$cookies);    
}
?>