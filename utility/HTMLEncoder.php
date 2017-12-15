<?php
class HTMLEncoder {
    private $basicEncodingPattern = "/(<)|(>)/";
    private $replacements = '%3C,%3E';
    public function encode($content){
        return  preg_replace($this->basicEncodingPattern, $this->replacements, $content);
    }
}

//< %3C
//> %3E