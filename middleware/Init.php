<?php

require 'MiddlewareConfig.php';
require 'TestMiddleware.php';
require 'CSRFMiddleware.php';

class Init
{
    public function init($server, $cookies)
    {
        $config = new MiddlewareConfig($server, $cookies);

        $testMiddleware = new TestMiddleware();
        $csrfMiddleware = new CSRFMddleware();

        $config->consider($testMiddleware);
        $config->consider($csrfMiddleware);
        $config->apply();
    }
}
