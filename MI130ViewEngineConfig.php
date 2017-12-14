<?php 

class MI130ViewEngineConfig {
    public static $bodyTag = "@@body";
    public static $headerTag = "@@header";
    public static $footerTag = "@@footer";
    public static $master = "/shared/master.mi130";
    public static $viewPath = "view";
    public static $header = "shared/header.mi130";
    public static $footer = "shared/footer.mi130";
    public static $viewExtension = "mi130";
    public static $base = "phpmi130";



    //patterns
    public static $linkPattern = "/link:\[(?<link>.*)\]/";
    public static $modelPattern = "/model:\[(.*)\]/";
    public static $executablePattern = "/function:\[((.|\n)*)\]/";
}