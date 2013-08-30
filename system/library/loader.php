<?php

namespace Library;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');


/**
 * Include multiple files at once 
 * 
 * @package 
 * @version $id$
 * @author Harold Kim Cantil 
 * @license http://pokoot.com/license.txt
 */
class Loader{


    /**
     * Include file base on array
     *
     * Ex, 
     *
     *  $LOADER->add( "file_1" , "file_2" );
     *  
     * @access public
     * @param array $files 
     * @return void
     */
    public function add( $files ){

        $files = func_get_args();

        print_r( $files );

        foreach( $files AS $file ){            
            debug_init( $file );
            require_once $file;
        }
    
    }


    /**
     * Multiple require once 
     * 
     * @access public
     * @param mixed $path 
     * @return void
     */
    public function multiple_require( $path ){

        foreach( glob( $path ) AS $file ){                    
            debug_init( $file );
            require_once $file;        
        }

    }


    /**
     * Multiple include once 
     * 
     * @access public
     * @param mixed $path 
     * @return void
     */
    public function multiple_include( $path ){

        foreach( glob( $path ) AS $file ){                    
            debug_init( $file );
            include_once $file;        
        }

    }

    
}

?>
