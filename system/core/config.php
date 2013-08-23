<?php

    require_once SYSTEM_PATH . "helper/yaml.php";
    require_once SYSTEM_PATH . "library/spyc.php";    
    require_once SYSTEM_PATH . "library/config.php";     

    $CONFIG = new Library\Config();

    $CONFIG->load( APPLICATION_PATH . "config/config.yml" , true );
  

    $environment = $CONFIG->search( array( "framework" , "environment" ) );
 

    $path = APPLICATION_PATH . "config/" .  $environment . ".yml" ;
 
    $CONFIG->load( $path , $merge = true ); 

    $CONFIG->load( APPLICATION_PATH . "config/menu.yml"  , $merge = true ); 
 
?>
