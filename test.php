<?php

include 'lib.php';
require('middleware/Init.php');


//$t = new Test();
//echo $t->aMemberFunc();
//header("Location: index.html");
//$path = '/middleware/TestMiddleware';
//echo __DIR__;

$init = new Init($_SERVER, $_COOKIE);



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