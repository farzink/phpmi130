<?php
class ResourceViewModel{
    public $id;
    public function __toString(){
        return (string)$this->id;
    }
}