<?php

require 'MiddlewareConfig.php';
require 'AuthMiddleware.php';
require 'CSRFMiddleware.php';

class Init
{
    public function init(&$router, &$server, &$cookies)
    {
        $config = new MiddlewareConfig($router, $server, $cookies);
        
        $authMiddleware = new AuthMiddleware();
        $csrfMiddleware = new CSRFMddleware();

        $config->consider($authMiddleware);
        $config->consider($csrfMiddleware);
        $config->apply();
    }
}
