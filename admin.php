<?php

    Header("Cache-Control: must-revalidate");
    Header("Expires: " . gmdate( "D, d M Y H:i:s", time() +  60 * 60 * 24 * 3 ) . " GMT");

    if( isset($_GET["debug"] ) ){
        $DEBUG = ( $_GET["debug"] == "true" ) ? true : false;       
    }

    set_time_limit(90);

    //ini_set( "session.cookie_secure" , "On" ); // VIA SSL?
    ini_set( "session.cookie_httponly" , "On" );

    @session_regenerate_id(false);
    @session_destroy();
    session_start();


    // Don't edit both the system_path and application folder 
	$system_path        = "system";
	$application_folder = "application";

	
	if (defined('STDIN')){
		chdir(dirname(__FILE__));
	}

	if (realpath($system_path) !== FALSE){
		$system_path = realpath($system_path) . '/';
	}
	
    $system_path = rtrim($system_path, '/') . '/';
    print "<Br/> system_path = $system_path ";

	if ( !is_dir($system_path)){
		exit( "Your system folder path does not appear to be set correctly. 
               Please open the following file and correct this: " .
               pathinfo( __FILE__ ,  PATHINFO_BASENAME ));
    }
    
 
	// The name of THIS file
    define( "SELF" , pathinfo( __FILE__ , PATHINFO_BASENAME ) );
    print "<Br/> SELF = " . SELF;
    
  
	// Path to the system folder
    define( "BASE_PATH" , str_replace( "\\" , "/" , $system_path));
    print "<Br/> BASE_PATH = " . BASE_PATH;

	// Path to the front controller (this file)
    define( "CONTROLLER_PATH" , str_replace( SELF , '' , __FILE__));
    print "<Br/> CONTROLLER_PATH = " . CONTROLLER_PATH;

	// Name of the "system folder"
    define('SYSTEM_DIR', trim(strrchr(trim(BASE_PATH, '/'), '/'), '/'));
    print "<Br/> SYSTEM_DIR = " . SYSTEM_DIR ;



    if (isset($_SERVER["HTTP_HOST"])){
	    $base_url = isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) !== "off" ? "https" : "http";
		$base_url .= "://". $_SERVER["HTTP_HOST"];
		$base_url .= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
	}else{
		$base_url = "http://localhost/";
    }
    define( "APPLICATION_URL" , $base_url );
    print "<Br/> APPLICATION_URL = " . APPLICATION_URL ;


	// The path to the "application" folder
    if (is_dir($application_folder)){
        define( "APPLICATION_PATH" , $application_folder . '/' );        
    }else{
		if( !is_dir( BASE_PATH . $application_folder . '/' ) ){
			exit("Your application folder path does not appear to be set correctly.
                    Please open the following file and correct this: " . SELF );
		}
		define( "APPLICATION_PATH" , BASE_PATH.$application_folder.'/');
	}
    print "<Br/> APPLICATION_PATH = " . APPLICATION_PATH;






    


    include_once "./system/helper/yaml.php";
    include_once "./system/library/spyc.php";    
    




?>
