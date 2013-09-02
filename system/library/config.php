<?php

namespace Library;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');


/**
 * A Global configuration class
 *
 * Parse the .yml file configuration
 *
 * Ex.
 *  $CONFIG->set( ... );
 * 
 * @package 
 * @version $id$
 * @author Kim 
 * @license Cellcity
 */

class Config{

    /**
     * The general settings 
     * 
     * @var array
     * @access public
     */
    public $settings = array();


    /**
     * Class constructor 
     * 
     * @access public
     * @return void
     */
    public function __construct(){        
    }


    /**
     * Set a temporary variable. 
     * Works like a global constant
     * 
     * @access public
     * @param mixed $key 
     * @param mixed $value 
     * @return void
     */
    public function set( $key , $value = null ){
        $this->$key = $value;
    }


    /**
     * Get the temporary variable
     *
     * @access public
     * @param mixed $key
     * @return mixed  
     */
    public function get( $key ){        
        return $this->$key;
    }


    /**
     * Return an item on the settings array 
     * 
     * @access public
     * @param mixed $key 
     * @return void
     */
    public function get_setting( $key ){
        return $this->settings[ $key ];
    }



    /**
     * Retrieves the settings array that are loaded on the .yml file
     * 
     * @access public
     * @return void
     */
    public function get_settings(){
       return $this->settings;    
    }


    /**
     * Loads a .yml file then merge the array to the this->settings array 
     * depending on the merge flag 
     * 
     * @access public
     * @param mixed $file 
     * @param booleen $merge_flag 
     * @return void
     */
    public function load( $file , $merge_flag = false ){

        if( !file_exists( $file ) ){
            die( "Unable to load configuration file. Please check $file " );
        }
        
        $array = yaml_load_file( $file );

        if( $merge_flag == true )
            $array = array_merge( $this->settings , $array );

        $this->settings = $array;

        return $this;
    }

 

  
   
    /**
     * Recursively search the configuration file. 
     *
     * Example:
     *  search( array( "level_1" , "level_2" , "level_3" ) ); 
     * @access public     
     *
     */
    public function search( $search , $level = 0 , $array = null ){                

        if( $level == 0 ){        
            $array = $this->settings;
        }else{            
            $array = $array;
        }

        foreach( $array AS $k => $v ){
            
            if( $search[ $level] == $k ) {     

                if( is_array( $v )){                    
                    return $this->search( $search  , ++$level , $v );                
                }else{                 
                    return $v;              
                }
          
            }
       
        }
 
        return '';
    }




}

?>
