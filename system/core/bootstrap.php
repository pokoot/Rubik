<?php

    $debug_bootstrap        = true;
	$system_folder          = "system";
    $application_folder     = "application";



    /**
     * The current working dir 
     */
    
    define( "BASE_PATH" , getcwd() . '/');

    

    /**
     * SYSTEM PATH 
     */
        
	if (defined('STDIN')){
        chdir(dirname(__FILE__));         
	}

    $system_path = '';
    if (realpath($system_folder) !== FALSE){        
        $system_path = realpath($system_folder) . '/';                
        $system_path = rtrim($system_path, '/') . '/';        
    }
    
    
    define( "SYSTEM_PATH" , $system_path );    

    if ( !is_dir( SYSTEM_PATH )){    
		exit( "System folder is not properly configured." );
    }
 


    /**
     * APPLICATION PATH
     */
    
    if (is_dir($application_folder)){        
        define( "APPLICATION_PATH" ,  BASE_PATH . $application_folder . '/' );        
    }else{
		if( !is_dir( BASE_PATH . $application_folder . '/' ) ){
			exit( "Application folder is not properly configured." );
		}
		define( "APPLICATION_PATH" , BASE_PATH . $application_folder.'/');
	}   



    /**
     * SITE HTTP URL
     */

    if (isset($_SERVER["HTTP_HOST"])){
	    $base_url = isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) !== "off" ? "https" : "http";
		$base_url .= "://". $_SERVER["HTTP_HOST"];
		$base_url .= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
	}else{
		$base_url = "http://localhost/";
    }
    define( "SITE_URL" , $base_url );



    /**
     * Debug and prints the output 
     */

    if( $debug_bootstrap ){            
        print "<br/> BASE_PATH = " . BASE_PATH;
        print "<br/> SYSTEM_PATH = " . SYSTEM_PATH;
        print "<br/> APPLICATION_PATH = " . APPLICATION_PATH;
        print "<br/> SITE_URL = " . SITE_URL;
    }


?>
