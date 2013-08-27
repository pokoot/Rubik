<?php

    require_once SYSTEM_PATH . "helper/yaml.php";
    require_once SYSTEM_PATH . "library/spyc.php";    
    require_once SYSTEM_PATH . "library/config.php";     

    /**
     * Loads the configuration file
     */

    $CONFIG = new Library\Config();
    $environment = $CONFIG->search( array( "framework" , "environment" ) );

    // set the debug flag
    if( isset($_GET["debug"] ) ){ $CONFIG->set( ( $_GET["debug"] == "true" ) ? true : false ); } 


    $CONFIG->load( APPLICATION_PATH . "config/config.yml" , $merge = true ); 
    $CONFIG->load( APPLICATION_PATH . "config/" .  $environment . ".yml"   , $merge = true ); 
    $CONFIG->load( APPLICATION_PATH . "config/menu.yml"  , $merge = true ); 

 

    // MODEL



/*    
$MODEL = array();

$files = glob( BASE_PATH . 'model/*.php'  );
foreach( $files AS $file ){
    $MODEL[] = basename( $file , ".php" );
}
 */


    // VIEW
    /*
     *
     * 
$VIEW = array();

$files = glob( BASE_PATH . 'view/*.php'  );
foreach( $files AS $file ){
    $VIEW[] = basename( $file , ".php" );
}

 */


/*
    // CONTROLLER 

    $CONTROLLER = array();

$files = glob( BASE_PATH . 'controller/*.php'  );
foreach( $files AS $file ){
    $CONTROLLER[] = basename( $file , ".php" );
}

 */




/*

    $JS = array();

$files = glob( BASE_PATH . 'js/*.js'  );
foreach( $files AS $file ){
    $JS[] = basename( $file , ".js" );
}
 */





/*
    $CSS = array();

$files = glob( BASE_PATH . 'css/*.css'  );
foreach( $files AS $file ){
    $CSS[] = basename( $file , ".css" );
}
 */



   /* 
$CONFIG = array();

$files = glob( BASE_PATH . 'config/*.yaml'  );
foreach( $files AS $file ){
    $CONFIG[] = basename( $file , ".yaml" );
}
 */



   /* 
$AJAX = array();

$files = glob( BASE_PATH . 'ajax/*.php'  );
foreach( $files AS $file ){
    $AJAX[] = basename( $file , ".php" );
}
 */


    /*
      $API = array();

$files = glob( BASE_PATH . 'api/*.php'  );
foreach( $files AS $file ){
    $API[] = basename( $file , ".php" );
}
 */




     
    function autoload_helper( $print = false ){

        $directory_path = BASE_PATH . "helper";
 
        if( $print ) print "<Br/> directory_path = " . $directory_path;

        $files = list_files( $directory_path , $directory_depth = 1 );
      
        foreach( $files AS $file ){

            $load_file = BASE_PATH . "helper/{$file}";
            if( $print ) print "<Br/> helper file = " . $load_file;

            require_once $load_file;
                
        }  
    }




?>
