<?php

namespace Library;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');


/**
 * Parse the .yml file configuration
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
     * Loads a .yml file then merge the array to the this->settings array 
     * depending on the merge flag 
     * 
     * @access public
     * @param mixed $file 
     * @param booleen $merge_flag 
     * @return void
     */
    public function load( $file , $merge_flag = false ){
        
        $array = yaml_load_file( $file );

        if( $merge_flag == true )
            $array = array_merge( $this->settings , $array );

        $this->settings = $array;

        return $this;
    }




    /**
     * Return an item on the settings array 
     * 
     * @access public
     * @param mixed $key 
     * @return void
     */
    public function get( $key ){
        return $this->settings[ $key ];
    }


 

  
   
    /**
     * Recursively search the configuration file. 
     *
     * Example:
     *  search( array( "level_1" , "level_2" , "level_3" ) ); 
     * @access public     
     *
     */
    public function item( $search , $level = 0 , $array = null ){                

        if( $level == 0 ){        
            $array = $this->settings;
        }else{            
            $array = $array;
        }

        foreach( $array AS $k => $v ){
            
            if( $search[ $level] == $k ) {     

                if( is_array( $v )){                    
                    return $this->item( $search  , ++$level , $v );                
                }else{                 
                    return $v;              
                }
          
            }
       
        }
 
        return '';
    }

      


    /**
     * Retrieves the settings array
     * 
     * @access public
     * @return void
     */
    public function show(){
       return $this->settings;
    
    }


}

?>
