<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );
/**
 * Author: Kim
 * License: Cellcity
 */



/**
 * Loads all the system helper 
 *
 * Print flag is to display all the helpers
 * 
 * @access public
 * @param mixed $print 
 * @return void
 */
if( !function_exists('autoload_helper')){     
    
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
}





/**
 * loads all system languages
 * 
 * @access public
 * @return void
 */
if( !function_exists('autoload_language')){ 
    
    function autoload_language(){

        GLOBAL $TRANSLATION ; 

        $country    = strtoupper( session_get( "country" ) );
        $language   = session_get( "language" );

        $locale = $language . "_" . $country;

        $directory_path = "./system/language/" . $locale ;
        print "<Br/> directory_path = " . $directory_path;

        $files = list_files( $directory_path , $directory_depth = 1 );
      
        foreach( $files AS $file ){
            
            $load_file = $directory_path . "/{$file}" ;
            print "<Br/> language load file = $load_file ";
            
            require_once $load_file;
          
        }  
    }
}





 

/**
 * Return the directory structure in an array
 * This function is the same as helper.directory.php
 * 
 * @access public
 * @param mixed $source_dir 
 * @param int $directory_depth 
 * @param bool $hidden 
 * @return void
 */
if( !function_exists('list_files')){ 
    function list_files( $source_dir , $directory_depth = 0 , $hidden = false){
		if ($fp = @opendir($source_dir)){
			$filedata	= array();
			$new_depth	= $directory_depth - 1;
			$source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
 
			while (false !== ($file = readdir($fp))){
				// Remove '.', '..', and hidden files [optional]
				if ( ! trim($file, '.') OR ($hidden == false && $file[0] == '.')){
					continue;
				}

				if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir.$file)){
					$filedata[$file] = list_files($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
				}else{
					$filedata[] = $file;
				}
			}
			closedir($fp);
			return $filedata;
		}
		return false;
    }
}





/**
 * Check php version
 * 
 * @access public
 * @param string $version 
 * @return void
 */
if( !function_exists("is_php")){
   
    function is_php( $version = '5.0.0' ){
            
		static $_is_php;
        //print "<Br/> is_php = $_is_php ";

		$version = (string) $version;

		if ( !isset($_is_php[$version])){
			$_is_php[$version] = (version_compare(PHP_VERSION, $version) < 0) ? FALSE : TRUE;
		}

		return $_is_php[$version];
    }
}




/**
 * Translate the files
 * 
 * @access protected
 * @param mixed $msg 
 * @return void
 */
if( !function_exists("__")){
    
    function __( $constant , $print = true ){

        GLOBAL $TRANSLATION;


        $value = ( $constant == '' OR !isset( $TRANSLATION[$constant] ) ) ? 
            FALSE : $TRANSLATION[ $constant ];

        if ($value === FALSE){

            if( $print == true ){
                print $constant;
            }else{
                return $constant;
            }
        }

        if( $print == true ){
            print $value;
        }else{
            return $value;
        }
    }

}
?>
