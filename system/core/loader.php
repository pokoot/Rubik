<?php

    require_once SYSTEM_PATH . "helper/yaml.php";
    require_once SYSTEM_PATH . "library/spyc.php";    
    require_once SYSTEM_PATH . "library/config.php";     

    /**
     * Loads the configuration file
     */


    $CONFIG = new Library\Config();

    $CONFIG->load( APPLICATION_PATH . "config/config.yml" , true );
  

    $environment = $CONFIG->item( array( "framework" , "environment" ) );
 

    $path = APPLICATION_PATH . "config/" .  $environment . ".yml" ;
 
    $CONFIG->load( $path , $merge = true ); 

    $CONFIG->load( APPLICATION_PATH . "config/menu.yml"  , $merge = true ); 


    /**
     * Load the rest of the file 
     */

 
?>
