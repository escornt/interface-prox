<?php

require_once("config/global/config.php");
require_once("config/include.php");

preg_match("/^(.*)(\.)([a-z]{2})$/",$_SERVER["HTTP_HOST"],$urlMatch);
if(count($urlMatch) == 4){
    if($urlMatch[3] == "es"){
        require_once("config/lang/es.php");
    }else if($urlMatch[3] == "fr"){
        require_once("config/lang/fr.php");
    }

}

$app = new global_Controller();
$app->load();