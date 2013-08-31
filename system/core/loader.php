<?php

    require_once SYSTEM_PATH . "/helper/yaml.php";
    require_once SYSTEM_PATH . "/library/spyc.php";    
    require_once SYSTEM_PATH . "/library/config.php";     
    require_once SYSTEM_PATH . "/library/loader.php";


    /**
     * $CONFIG global object
     */

    $CONFIG = new \Library\Config();
  
    // set the debug flag
    if( isset($_GET["debug"] ) ){ $CONFIG->set( ( $_GET["debug"] == "true" ) ? true : false ); } 


    $CONFIG->load( APPLICATION_PATH . "/config/config.yml" , $merge = true ); 
    $environment = $CONFIG->search( array( "framework" , "environment" ) );

    $CONFIG->load( APPLICATION_PATH . "/config/" .  $environment . ".yml"   , $merge = true ); 
    $CONFIG->load( APPLICATION_PATH . "/config/menu.yml"  , $merge = true );     

    

    /**
     * Init the $LOADER global object
     */

    $LOADER = new \Library\Loader();

    $LOADER->multiple_require( SYSTEM_PATH . '/library/*.php'  );
    $LOADER->multiple_require( SYSTEM_PATH . '/helper/*.php'  );
 
    
?>
