<?php
class TagHelper {
    private $defaultWriter;
    public function __construct($defaultWriter=null){
        $this->defaultWriter = $defaultWriter;
    }
    public function div($content, $extras=""){
       echo(
        ($extras ===  "") ?  ("<div>{$content}</div>") : ("<div {$extras}>{$content}</div>")
       );
    }
    public function h1($content, $extras=""){
        echo(
         ($extras ===  "") ?  ("<h1>{$content}</h1>") : ("<h1 {$extras}>{$content}</h1>")
        );
     }
     public function h2($content, $extras=""){
        echo(
         ($extras ===  "") ?  ("<h2>{$content}</h2>") : ("<h2 {$extras}>{$content}</h2>")
        );
     }
     public function h3($content, $extras=""){
        echo(
         ($extras ===  "") ?  ("<h3>{$content}</h3>") : ("<h3 {$extras}>{$content}</h3>")
        );
     }
     public function h4($content, $extras=""){
        echo(
         ($extras ===  "") ?  ("<h4>{$content}</h4>") : ("<h4 {$extras}>{$content}</h4>")
        );
     }
     public function h5($content, $extras=""){
        echo(
         ($extras ===  "") ?  ("<h5>{$content}</h5>") : ("<h5 {$extras}>{$content}</h5>")
        );
     }
     public function h6($content, $extras=""){
        echo(
         ($extras ===  "") ?  ("<h6>{$content}</h6>") : ("<h6 {$extras}>{$content}</h6>")
        );
     }
     public function span($content, $extras=""){
        echo(
         ($extras ===  "") ?  ("<span>{$content}</span>") : ("<span {$extras}>{$content}</span>")
        );
     }

}