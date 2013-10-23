<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


function argument($argv){
    $_ARG = array();
    foreach ($argv as $arg) {
        if ( preg_match('/--([^=]+)=(.*)/',$arg,$reg)) {
            $_ARG[$reg[1]] = $reg[2];
        }else if(preg_match('/-([a-zA-Z0-9])/',$arg,$reg)) {
            $_ARG[$reg[1]] = 'true';
        }
    }
    return $_ARG;
}


// More info here : http://www.tldp.org/HOWTO/Bash-Prompt-HOWTO/x329.html
if( !function_exists("writeln")){
    function writeln( $msg ){

        GLOBAL $DEBUG;

        if( $DEBUG != "true" ){
            return;
        }

        $backtrace = debug_backtrace();

        foreach($backtrace AS $entry) {

            if( $entry['function'] ){
                $file   = basename( $entry['file'] );
                $line   = str_pad( $entry['line'] , 4 , "0" , STR_PAD_LEFT );

                //echo "\033[0m";
                echo "line $line : " . $msg;
                echo "\n";

                return true;

            }

        }



    }
}


/**
 * Log anything that is printed
 *
 * @access public
 * @param mixed $msg
 * @return void
 */
function logln( $msg ){

    $backtrace = debug_backtrace();

    foreach($backtrace AS $entry) {

        if( $entry['function'] ){

            $file   = basename( $entry['file'] );

            $line   = str_pad( $entry['line'] , 4 , "0" , STR_PAD_LEFT );

            //echo "\033[0m";
            echo "line $line : " . $msg;
            echo "\n";

            return true;

        }

    }
}



/**
 * log including the breaks
 *
 * @access public
 * @param float $count
 * @return void
 */
function logbr( $count = 1 ){

    if( !is_int( $count ) ){
        $count = 1;
    }

    for( $x = 0 ; $x < $count ;  $x++ ){
        logln( '' );
    }
}


function writebr( $count = 1 ){

    if( !is_int( $count ) ){
        $count = 1;
    }

    for( $x = 0 ; $x < $count ;  $x++ ){
        writeln( '' );
    }
}



function logh( $message ){
    logbr();
    logln( "-------------------------------------------------------------------" );
    logln( strtoupper( $message ) ) ;
    logln( "-------------------------------------------------------------------" );
    logbr();
}



function writeh( $message ){
    writebr();
    writeln( "-------------------------------------------------------------------" );
    writeln( strtoupper( $message ) ) ;
    writeln( "-------------------------------------------------------------------" );
    writebr();
}




if( !function_exists("colorln")){
    function colorln( $msg ){
        GLOBAL $DEBUG;
        if( $DEBUG != "true" ){
            return;
        }
        echo "\033[44;1;31m";
        echo $msg;
        // reset to normal
        echo "\033[0m";
        echo "\n";
    }
}



function is_cli(){
    return (php_sapi_name() == 'cli') or defined('STDIN');
}




function cls($out = true ){
    $cls = chr(27)."[H".chr(27)."[2J";
    if( $out ){
        echo $cls;
    }else{
        return $cls;
    }
}



function scanf( $format , &$a0=null , &$a1=null, &$a2=null , &$a3=null, &$a4=null, &$a5=null, &$a6=null, &$a7=null ){
    $num_args = func_num_args();
    if($num_args > 1) {
        $inputs = fscanf(STDIN, $format);
        for($i=0; $i<$num_args-1; $i++) {
            $arg = 'a'.$i;
            $$arg = $inputs[$i];
        }
    }
}





?>
