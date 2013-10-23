<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );



/**
 * Resize image
 *
 * @access public
 * @param mixed $val
 * @param string $default
 * @return void
 */
if( !function_exists('resize')){

    function resize( $upload_data , $filename_destination , $width = "100" , $height = "100" ){

        $source = $upload_data["full_path"];

        $destination = $upload_data["file_path"] . $filename_destination . strtolower( $upload_data["file_ext"] );

        debug( "resize destination = " . $destination );

        $resizer = new Resizer();

        $resizer->load( $source );
        $resizer->resize( $width , $height );

        $resizer->save( $destination );

    }

}


/**
 * Remove the image on the existing folder
 *
 * @access public
 * @param mixed $folder
 * @param mixed $id
 * @return void
 */
if( !function_exists('remove_image')){

    function remove_image( $folder , $id ){

        // TINA
        $path = "./application/image/";
        $padded_folder = str_pad( $id , 8 , "0", STR_PAD_LEFT );
        $dir_path = $path . $folder . "/" . $padded_folder;

        if (! is_dir($dir_path)) {
            debug( $dir_path . " is not a directory " );
        }else{
            if (substr($dir_path, strlen($dir_path) - 1, 1) != '/') {
                $dir_path .= '/';
            }

            $files = glob($dir_path . '*', GLOB_MARK);
            foreach ($files as $file) {
                debug( "remove file = " . $file );
                unlink($file);
            }

            rmdir($dir_path);
        }

    }

}




/**
 * Compose http image url
 *
 * @access public
 * @param mixed $folder
 * @param mixed $filename
 * @param mixed $id
 * @param mixed $image_extension
 * @return void
*/
if( !function_exists('compose_image_url')){

    function compose_image_url( $folder , $filename , $id , $image_extension ){

        if( !$image_extension ){
            return "";
        }

        $padded_folder = str_pad( $id , 8 , "0", STR_PAD_LEFT );

        return APPLICATION_URL . "image/" . $folder . "/" . $padded_folder . "/" . $filename . $image_extension;
    }
}

?>
