<?php

    /**
     * The loader files for admin.php front controller
     */    


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


    $CONFIG->load( APPLICATION_PATH . "/setting/config.yml" , $merge = true ); 
    $environment = $CONFIG->search( array( "framework" , "environment" ) );

    $CONFIG->load( APPLICATION_PATH . "/setting/" .  $environment . ".yml"   , $merge = true ); 
    $CONFIG->load( APPLICATION_PATH . "/setting/menu.yml"  , $merge = true );     

    

    /**
     * Init the $LOADER global object
     */

    $LOADER = new \Library\Loader();

    $LOADER->multiple_require( SYSTEM_PATH . '/helper/*.php'  );
    $LOADER->multiple_require( SYSTEM_PATH . '/library/*.php'  );


    /**
     * Load the form library depending on their hierarchy
     */

    require_once SYSTEM_PATH . "/library/form/form.php";
    require_once SYSTEM_PATH . "/library/form/action.php";
    require_once SYSTEM_PATH . "/library/form/listing.php";
    require_once SYSTEM_PATH . "/library/form/listing/query.php";
    require_once SYSTEM_PATH . "/library/form/listing/control.php";
    require_once SYSTEM_PATH . "/library/form/listing/control/search.php";
    require_once SYSTEM_PATH . "/library/form/listing/control/button.php";
    require_once SYSTEM_PATH . "/library/form/listing/control/filter.php";
    require_once SYSTEM_PATH . "/library/form/listing/control/grid.php";
    require_once SYSTEM_PATH . "/library/form/listing/control/grid/text.php";
    require_once SYSTEM_PATH . "/library/form/entry.php";
    require_once SYSTEM_PATH . "/library/form/entry/button.php";
    require_once SYSTEM_PATH . "/library/form/entry/element.php";
    require_once SYSTEM_PATH . "/library/form/entry/element/select.php";
    require_once SYSTEM_PATH . "/library/form/entry/element/select.php";
    require_once SYSTEM_PATH . "/library/form/entry/element/upload.php";


    
?>
