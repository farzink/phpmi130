<?php
class CommentExtractor {    
    public function getParam($path, $class){
        include_once("{$path}/{$class}.php");
        $doc = new ReflectionClass($class);
        return $doc;
    }
    public function getParambyClass($class){        
        $doc = new ReflectionClass($class);
        return $doc;
    }
}