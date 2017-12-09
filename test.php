<?php


require('middleware/Init.php');
include 'data/DataAccess.php';
require_once('Router.php');
require_once('htmlhelper/TagHelper.php');

//include 'data/DBConfiguration.php';
include 'repository/ProfileRepository.php';
require_once('SimpleMVCNavigator.php');

$requestedRoute = $_GET["content"];


//$t = new Test();
//echo $t->aMemberFunc();
//header("Location: index.html");
//$path = '/middleware/TestMiddleware';
//echo __DIR__;

//$init = new Init($_SERVER, $_COOKIE);


//repo test

$data = new DataAccess();
$repo = new ProfileRepository($data);

//echo(serialize($repo->getById(1)));




//MVC route test
$html = new TagHelper("");
$classDefinition = Router::class;
$router = new $classDefinition();
$router->analyzeRoute($requestedRoute);

$html->div($router->getCurrentController(), "style = 'background-color: red'");
//echo($router->getCurrentAction());
//echo(Router::class);

$navigator = new SimpleMVCNavigator();
$navigator->navigate($router->getCurrentController(), $router->getCurrentAction());


// $headers = array();
// foreach($_SERVER as $key => $value) {
//     if (substr($key, 0, 5) <> 'HTTP_') {
//         continue;
//     }
//     $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
//     $headers[$header] = $value;
//     echo serialize($headers);
// }


//echo serialize($_SERVER);
//echo($f->consider());
//echo($_GET["content"]);
//echo serialize($_REQUEST);
?>