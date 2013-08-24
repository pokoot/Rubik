<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );

/**
 * Read File
 *
 * Opens the file specfied in the path and returns it as a string.
 * 
 * @access public
 * @param mixed $file the local file
 * @return string content
 */
if( !function_exists('read_file')){
    
	function read_file($file){
		if( !file_exists($file)){
			return false;
		}

		if(function_exists('file_get_contents')){
			return file_get_contents($file);
		}

		if( ! $fp = @fopen($file, FOPEN_READ)){
			return false;
		}

		flock($fp, LOCK_SH);

		$data = '';
		if(filesize($file) > 0){
			$data =& fread($fp, filesize($file));
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		return $data;
	}
}




/**
 * Write File
 *
 * Writes data to the file specified in the path.
 * Creates a new file if non-existent.
 * 
 * @access public
 * @param string $path  path to file
 * @param string $data  file data
 * @param mixed $mode 
 * @return bool
 */
if( !function_exists('write_file')){

	function write_file($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE) {
		if( ! $fp = @fopen($path, $mode)){
			return false;
		}
		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);

		return true;
	}
}




/**
 * Delete Files
 *
 * Deletes all files contained in the supplied directory path.
 * Files must be writable or owned by the system in order to be deleted.
 * If the second parameter is set to true, any directories contained
 * within the supplied base directory will be nuked as well.
 *
 * @access	public
 * @param	string	$path       path to file
 * @param	bool	$del_dir    whether to delete any directories found in the path
 * @param	int	    $level      directory level
 * @return	bool
 */
if( !function_exists('delete_files')){
	function delete_files($path, $del_dir = false, $level = 0){
		// Trim the trailing slash
		$path = rtrim($path, DIRECTORY_SEPARATOR);

		if( ! $current_dir = @opendir($path)){
			return false;
		}

		while (false !== ($filename = @readdir($current_dir))){
			if($filename != "." and $filename != ".."){
				if(is_dir($path.DIRECTORY_SEPARATOR.$filename)){
					// Ignore empty folders
					if(substr($filename, 0, 1) != '.'){
						delete_files($path.DIRECTORY_SEPARATOR.$filename, $del_dir, $level + 1);
					}
				}else{
					unlink($path.DIRECTORY_SEPARATOR.$filename);
				}
			}
		}
		@closedir($current_dir);

		if($del_dir == true AND $level > 0){
			return @rmdir($path);
		}

		return true;
	}
}




/**
 * Get Filenames
 *
 * Reads the specified directory and builds an array containing the filenames.
 * Any sub-folders contained within the specified path are read as well.
 *
 * @access	public
 * @param	string	$source_dir     path to source
 * @param	bool	$include_path   whether to include the path as part of the filename
 * @param	bool	$_recursion     internal variable to determine recursion status - do not use in calls
 * @return	array
 */
if( !function_exists('get_filenames')){
	function get_filenames($source_dir, $include_path = false, $_recursion = false){
		static $_filedata = array();

		if($fp = @opendir($source_dir)){
			// reset the array and make sure $source_dir has a trailing slash on the initial call
			if($_recursion === false){
				$_filedata = array();
				$source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			}

			while (false !== ($file = readdir($fp))){
				if(@is_dir($source_dir.$file) && strncmp($file, '.', 1) !== 0){
					get_filenames($source_dir.$file.DIRECTORY_SEPARATOR, $include_path, true);
				}elseif(strncmp($file, '.', 1) !== 0){
					$_filedata[] = ($include_path == true) ? $source_dir.$file : $file;
				}
			}
			return $_filedata;
		}else{
			return false;
		}
	}
}




/**
 * Get Directory File Information
 *
 * Reads the specified directory and builds an array containing the filenames,
 * filesize, dates, and permissions
 *
 * Any sub-folders contained within the specified path are read as well.
 *
 * @access	public
 * @param	string	$source_dir     path to source
 * @param	bool	$top_level_only Look only at the top level directory specified?
 * @param	bool	$_recursion     internal variable to determine recursion status - do not use in calls
 * @return	array
 */
if( !function_exists('get_dir_file_info')){
	function get_dir_file_info($source_dir, $top_level_only = true, $_recursion = false){
		static $_filedata = array();
		$relative_path = $source_dir;

		if($fp = @opendir($source_dir)){
			// reset the array and make sure $source_dir has a trailing slash on the initial call
			if($_recursion === false){
				$_filedata = array();
				$source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
			}

			// foreach (scandir($source_dir, 1) as $file) // In addition to being PHP5+, scandir() is simply not as fast
			while (false !== ($file = readdir($fp))){
				if(@is_dir($source_dir.$file) AND strncmp($file, '.', 1) !== 0 AND $top_level_only === false){
					get_dir_file_info($source_dir.$file.DIRECTORY_SEPARATOR, $top_level_only, true);
				}elseif(strncmp($file, '.', 1) !== 0){
					$_filedata[$file] = get_file_info($source_dir.$file);
					$_filedata[$file]['relative_path'] = $relative_path;
				}
			}
			return $_filedata;
		}else{
			return false;
		}
	}
}




/**
* Get File Info
*
* Given a file and path, returns the name, path, size, date modified
* Second parameter allows you to explicitly declare what information you want returned
* Options are: name, server_path, size, date, readable, writable, executable, fileperms
* Returns false if the file cannot be found.
*
* @access	public
* @param	string	path to file
* @param	mixed	array or comma separated string of information returned
* @return	array
*/
if( !function_exists('get_file_info')){
	function get_file_info($file, $returned_values = array('name', 'server_path', 'size', 'date')){

		if( !file_exists($file)){
			return false;
		}

		if(is_string($returned_values)){
			$returned_values = explode(',', $returned_values);
		}

		foreach ($returned_values as $key){
			switch ($key){
				case 'name':
					$fileinfo['name'] = substr(strrchr($file, DIRECTORY_SEPARATOR), 1);
					break;
				case 'server_path':
					$fileinfo['server_path'] = $file;
					break;
				case 'size':
					$fileinfo['size'] = filesize($file);
					break;
				case 'date':
					$fileinfo['date'] = filemtime($file);
					break;
				case 'readable':
					$fileinfo['readable'] = is_readable($file);
					break;
				case 'writable':
					// There are known problems using is_weritable on IIS.  It may not be reliable - consider fileperms()
					$fileinfo['writable'] = is_writable($file);
					break;
				case 'executable':
					$fileinfo['executable'] = is_executable($file);
					break;
				case 'fileperms':
					$fileinfo['fileperms'] = fileperms($file);
					break;
			}
		}

		return $fileinfo;
	}
}




/**
 * Get Mime by Extension
 *
 * Translates a file extension into a mime type based on config/mimes.php.
 * Returns false if it can't determine the type, or open the mime config file
 *
 * Note: this is NOT an accurate way of determining file mime types, and is here strictly as a convenience
 * It should NOT be trusted, and should certainly NOT be used for security
 *
 * @access	public
 * @param	string	path to file
 * @return	mixed
 */
if( !function_exists('get_mime_by_extension')){
    function get_mime_by_extension($file){

		$extension = strtolower(substr(strrchr($file, '.'), 1));

		GLOBAL $MIME;

		if( ! is_array($MIME)){
			if( ! is_array($MIME)){
				return false;
			}
		}
        if(array_key_exists($extension, $MIME)){
            
            if(is_array($MIME[$extension])){
                
				// Multiple mime types, just give the first one
				return current($MIME[$extension]);
            }else{
				return $MIME[$extension];
			}
		}else{
			return false;
		}
	}
}




/**
 * Symbolic Permissions
 *
 * Takes a numeric value representing a file's permissions and returns
 * standard symbolic notation representing that value
 *
 * @access	public
 * @param	int
 * @return	string
 */
if( !function_exists('symbolic_permissions')){
	function symbolic_permissions($perms){
		if(($perms & 0xC000) == 0xC000){
			$symbolic = 's'; // Socket
		}elseif(($perms & 0xA000) == 0xA000){
			$symbolic = 'l'; // Symbolic Link
		}elseif(($perms & 0x8000) == 0x8000){
			$symbolic = '-'; // Regular
		}elseif(($perms & 0x6000) == 0x6000){
			$symbolic = 'b'; // Block special
		}elseif(($perms & 0x4000) == 0x4000){
			$symbolic = 'd'; // Directory
		}elseif(($perms & 0x2000) == 0x2000){
			$symbolic = 'c'; // Character special
		}elseif(($perms & 0x1000) == 0x1000){
			$symbolic = 'p'; // FIFO pipe
		}else{
			$symbolic = 'u'; // Unknown
		}

		// Owner
		$symbolic .= (($perms & 0x0100) ? 'r' : '-');
		$symbolic .= (($perms & 0x0080) ? 'w' : '-');
		$symbolic .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));

		// Group
		$symbolic .= (($perms & 0x0020) ? 'r' : '-');
		$symbolic .= (($perms & 0x0010) ? 'w' : '-');
		$symbolic .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));

		// World
		$symbolic .= (($perms & 0x0004) ? 'r' : '-');
		$symbolic .= (($perms & 0x0002) ? 'w' : '-');
		$symbolic .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));

		return $symbolic;
	}
}




/**
 * Octal Permissions
 *
 * Takes a numeric value representing a file's permissions and returns
 * a three character string representing the file's octal permissions
 *
 * @access	public
 * @param	int
 * @return	string
 */
if( !function_exists('octal_permissions')){
	function octal_permissions($perms){
		return substr(sprintf('%o', $perms), -3);
	}
}




/**
 * Shows the directory structure
 *
 
 * @access	public
 * @param	string	path
 * @param	int	    0 for unlimited depth
 * @param	boolean	shows hidden files
 * @return	array
 */
if( !function_exists('directory_map') ){
     
    function directory_map( $source_dir, $directory_depth = 0, $hidden = false){

		if($fp = @opendir($source_dir)){
			$filedata	= array();
			$new_depth	= $directory_depth - 1;
			$source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
 
			while (false !== ($file = readdir($fp))){
				// Remove '.', '..', and hidden files [optional]
				if( ! trim($file, '.') OR ($hidden == false && $file[0] == '.')){
					continue;
				}

				if(($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir.$file)){
					$filedata[$file] = directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
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
 * Tests for file writability
 *
 * is_writable() returns TRUE on Windows servers when you really can't write to
 * the file, based on the read-only attribute.  is_writable() is also unreliable
 * on Unix servers if safe_mode is on.
 *
 * @access	private
 * @return	void
 */
if ( ! function_exists('is_really_writable')){
    function is_really_writable($file){

		// If we're on a Unix server with safe_mode off we call is_writable
		if (DIRECTORY_SEPARATOR == '/' AND @ini_get("safe_mode") == FALSE){
			return is_writable($file);
		}

		// For windows servers and safe_mode "on" installations we'll actually
		// write a file then read it.  Bah...
		if (is_dir($file)){
			$file = rtrim($file, '/').'/'.md5(mt_rand(1,100).mt_rand(1,100));

			if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE){
				return FALSE;
			}

			fclose($fp);
			@chmod($file, DIR_WRITE_MODE);
			@unlink($file);
			return TRUE;
		}elseif ( ! is_file($file) OR ($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE){
			return FALSE;
		}

		fclose($fp);
		return TRUE;
	}
}




/**
 * Make a padded folder based on the id parameter
 * 
 * @access public
 * @param string $folder 
 * @param mixed $id 
 * @return string
 */
if ( !function_exists('mkdir_pad_folder')){

    function mkdir_pad_folder( $folder  , $id , $path = "./application/image/" ){

        $padded_folder = str_pad( $id , 8 , "0", STR_PAD_LEFT );  

        $path = $path . $folder . "/" . $padded_folder;

        @mkdir( $path, 0777);
        
        return $path;
    }
}





/**
 * Create folders in year , month & day
 * 
 * @access public
 * @param mixed $folder_path 
 * @return void
*/
if ( !function_exists('mkdir_calendar')){
    
    function mkdir_calendar( $folder_path ){

        $path       = CONTROLLER_PATH . APPLICATION_PATH . $folder_path ;
        $path_year  = $path . "/" . date( "Y" );
        $path_month = $path_year . "/" . date( "m" );
        $path_day   = $path_month . "/" . date( "d" );                      

        if( !file_exists( $path_year) ){
            @mkdir( $path_year );
        }

        if( !file_exists( $path_month ) ){
            @mkdir( $path_month );
        }

        if( !file_exists( $path_day) ){
            @mkdir( $path_day );
        } 

        return $path_day;
    }
}



?>
