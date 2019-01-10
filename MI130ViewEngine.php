<?php
require_once('MI130ViewEngineConfig.php');


class MI130ViewEngine {
    private $content;
    private $viewPath;
    private $viewExtension; 
    public function __construct(){
        $this->content = "";
        $this->viewPath = "";
        $this->viewExtension = MI130ViewEngineConfig::$viewExtension;
    }
    function prepareHeader(){
        $headerTag = MI130ViewEngineConfig::$headerTag;
        $header = MI130ViewEngineConfig::$header;
        $headerPath = "{$this->viewPath}/{$header}";
        $headerContent = file_get_contents($headerPath, true);
        $this->content = str_replace($headerTag, $headerContent, $this->content);
    }
    function prepareFooter(){
        $footerTag = MI130ViewEngineConfig::$footerTag;
        $footer = MI130ViewEngineConfig::$footer;
        $footerPath = "{$this->viewPath}/{$footer}";
        $footerContent = file_get_contents($footerPath, true);
        $this->content = str_replace($footerTag, $footerContent, $this->content);
    }
    function prepareStyles(){
        //$this->content = str_replace($styleTag, $targetContent, $this->content);
    }
    function prepareJavaScripts() {

    }
    function preparelinks(){
        $this->content = preg_replace(MI130ViewEngineConfig::$linkPattern, "/".MI130ViewEngineConfig::$base."/"."$1", $this->content);
    }
    function prepareBody($controller, $action, $model=NULL){
        try{
        $bodyTag = MI130ViewEngineConfig::$bodyTag;
        $styleTag = MI130ViewEngineConfig::$styleTag;
        $controller = explode("Controller", $controller)[0]; 
        $targetPath = "{$this->viewPath}/{$controller}/{$action}.{$this->viewExtension}"; 
        
        $targetContent = file_get_contents($targetPath, true);
        //$modeledContent = $this->modelInjector($targetContent, $model);        
        //$this->modelInjector($targetContent, $model);        
        
        $this->content = str_replace($bodyTag, $targetContent, $this->content);

        //for styles
        //$this->content = str_replace($styleTag, $targetContent, $this->content);
        
        $this->modelInjector($model);        
        

        }
        catch(Exception $ex){
            echo("no such view file, check if your target view exists");
        }
    }
    function modelInjector(&$model){           
        $this->content = preg_replace_callback(MI130ViewEngineConfig::$modelPattern, function(array $m) use($model){            
            return $model[$m[1]];
        }
        , $this->content);            
    }
    function runExecutables($model){                
        $this->content = preg_replace_callback(MI130ViewEngineConfig::$executablePattern, function($m) use ($model){                        
            extract($model);                             
            return eval($m[1]);            
            
        }
        , $this->content);                        
    }
    function replace($model){
        echo($model);
    }
    public function cook($controller, $action, $model = []){
        $this->viewPath = MI130ViewEngineConfig::$viewPath;
        $master = MI130ViewEngineConfig::$master;
        $masterPath = "{$this->viewPath}/{$master}";
        $this->content = file_get_contents($masterPath, true);
        
        $this->prepareHeader();
        $this->prepareFooter();
        
        $this->prepareBody($controller, $action, $model);
        $this->runExecutables($model);
        
        $this->preparelinks();
        
        //$this->prepareStyles();
        //return $this->content;
        return $this->content;
        
    }
}