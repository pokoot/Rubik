<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );

/**
 * Generates headers that force a download to happen
 *
 * @access public
 * @param string $filename
 * @param string $data the data to be downloaded
 * @return void
 */
if( !function_exists('force_download')){

    function force_download( $filename = '', $data = '' ){

        GLOBAL $MIME;

        if($filename == '' OR $data == ''){
            return false;
        }

        // Try to determine if the filename includes a file extension.
        // We need it in order to set the MIME type
        if(false === strpos($filename, '.')){
            return false;
        }

        // Grab the file extension
        $x = explode('.', $filename);
        $extension = end($x);


        // Set a default mime if we can't find it
        if( !isset($MIME[$extension])){
            $mime = 'application/octet-stream';
        }else{
            $mime = (is_array($MIME[$extension])) ? $MIME[$extension][0] : $MIME[$extension];
        }


        // for stupid ie bug!
        if(ini_get('zlib.output_compression')){
             ini_set('zlib.output_compression', 'Off');
        };


        // Generate the server headers
        if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== false){

            header('Content-Type: "'.$mime.'"');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header("Content-Transfer-Encoding: binary");
            header('Pragma: public');
            header("Content-Length: ".strlen($data));

        }else{

            header('Content-Type: "'.$mime.'"');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Pragma: no-cache');
            header("Content-Length: ".strlen($data));

        }

        @ob_clean();
        @flush();

        exit( $data );


    }
}


?>
