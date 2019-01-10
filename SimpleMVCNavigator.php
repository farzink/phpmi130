<?php
require_once "utility/CommentExtractor.php";
require_once "SimpleMVCNavigatorConfig.php";
require_once "utility/HTMLEncoder.php";

class SimpleMVCNavigator
{
    private $path = "controller";
    private $request;
    public function __construct($controller = "home", $action = "index")
    {

    }
    public function navigate(&$request, $controller = "home", $action = "index")
    {
        $this->request = $request;
        //echo($this->discoverController($controller));
        $controller = ($controller == "") ? "home" : $controller;
        $action = ($action == "") ? "index" : $action;
        try {
            if ($this->discoverController($controller)) {
                $targetController = require_once "controller/{$controller}Controller.php";
                $targetName = $controller . "Controller";
                $t = new $targetName();
                if ($this->discoverAction($t, $action)) {
                    $this->injectModelByVerb($t, $action);
                } else {
                    throw new Exception();
                }

            } else {
                echo "n f";
            }
        } catch (Exception $ex) {
            return false; //redirect to error page...
        }
    }
    public function discoverController($controller)
    {
        $files = array_filter(array_map(function ($tryMe) {
            return strtolower(explode("Controller.php", $tryMe)[0]);
        }, scandir($this->path)), function ($tryMe) {
            return ($tryMe == "." || $tryMe == "..") ? false : true;
        });
        return ((array_search($controller, $files) !== "") ? true : false);
    }
    public function discoverAction($controller, $action)
    {
        //check to see if its callable  ======= is_callable
        $controllerMethods = get_class_methods($controller);
        return ((array_search($action, $controllerMethods) !== "") ? true : false);
    }
    public function getRequestType()
    {
        return $this->request['REQUEST_METHOD'];
    }
    public function injectModelByVerb(&$controller, &$action)
    {
        $com = new CommentExtractor();
        $doc = $com->getParambyClass($controller)->getMethod($action);
        //echo(count($doc->getParameters()));
        //echo($this->prepareVerb($doc));
        if (count($doc->getParameters()) > 0) {
            $paramDefinition = $doc->getParameters()[0]->getClass()->name;
            //$def = "RegisterViewModel";
            //$t = new $def();
            //$class = get_class($t);
            $model = $this->model($doc, $paramDefinition);
            //echo($_POST);
            //echo(serialize($model->email));
            $controller->$action($model, $this->getRequestType());
        } else {
            $controller->$action();
        }
    }

    public function scriptTagSanitier($content) {
        $pattern = "<\/?[^>]*>";
        return str_replace($pattern, $targetContent, $this->content);
    }
    public function model($content, $paramDefinition)
    {

        preg_match(SimpleMVCNavigatorConfig::$verbPattern, $content, $found);
        //echo($found[1]);
        //echo($content);
        switch ($found[1]) {
            case "post":
                $model = $this->convertToModel([
                    "p" => $_POST,
                    "g" => $_GET], $paramDefinition);
                break;
            case "get":
                $model = $this->convertToModel([
                    "g" => $_GET], $paramDefinition);
                break;
            case "patch":
                //$model = $this->convertToModel($_GET, $paramDefinition);
                break;
            case "put":
                //$model = $this->convertToModel($_GET, $paramDefinition);
                break;
            case "delete":
            $model = $this->convertToModel([
                "p" => $_POST,
                "g" => $_GET], $paramDefinition);
                break;
        }
        return $model;
    }
    public function convertToModel(array $array, $className)
    {
        $encoder = new HTMLEncoder();
        $model = new $className();
        foreach ($array as $k => $v) {
            foreach ($model as $key => $value) {
                //print_r($array);
                if (array_key_exists($key, $v)) {
                    $model->$key = $encoder->encode($v[$key]);
                }
            }
        }
        return $model;
        // return unserialize(sprintf(
        //     'O:%d:"%s"%s',
        //     strlen($className),
        //     $className,
        //     strstr(serialize($array), ':')
        // ));
    }
}
