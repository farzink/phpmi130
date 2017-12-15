<?php
require('middleware/Init.php');
include 'data/DataAccess.php';
require_once('Router.php');
require_once('htmlhelper/TagHelper.php');

//include 'data/DBConfiguration.php';
include 'repository/ProfileRepository.php';
require_once('SimpleMVCNavigator.php');

$requestedRoute = $_GET["content"];
//repo test

//$data = new DataAccess();
//$repo = new ProfileRepository($data);

//MVC route test
$html = new TagHelper("");
$classDefinition = Router::class;
$router = new $classDefinition();
$router->analyzeRoute($requestedRoute);

//middleware
$init = new Init($router, $_SERVER, $_COOKIE);

//tag helper
//$html->div($router->getCurrentController(), "style = 'background-color: red'");

$navigator = new SimpleMVCNavigator();
$navigator->navigate($_SERVER, $router->getCurrentController(), $router->getCurrentAction());

