<?php  if ( !defined('BASE_PATH')) exit('No direct script access allowed');
/**
 * Populate data value
 * 
 * Basic usage:
 * php cli.php --module=populate --table=merchant 
 *
 * @uses Cli
 * @package 
 * @version $id$
 * @author Kim
 * @license Cellcity
 */
class Populate extends Cli {
    
    protected $helper;
    protected $library = array( "text_generator" , "seed"  );
    protected $language;
    protected $model = array( "resource" );    
    protected $vendor;


    /**
     * Index
     * 
     * @access public
     * @param mixed $datas 
     * @return void
     */
    public function index(){

        if( !( ENVIRONMENT == "LOCALHOST" OR ENVIRONMENT == "DEVELOPMENT" ) ) {
            logln( "You can only load this on a specific environment." );
            $this->close();

        }

        $debug  = element( "d" , $this->argument , "false" );
        $table  = element( "table" , $this->argument  );
        $total  = element( "total" , $this->argument );

        if( !$table ){
            logln( "Argument --table not found" );
            $this->close();
        }

        if( !$total ){
            logln( "Argument --total not found" );
            $this->close();
        }

        logln( "table = " . $table );         
        logln( "total = " . $total );


        

        $default = array(
            'account_id' => 40 , 
            'module_id' => rand( 0 , 15 )
        );


        $seed = new Seed();
        $seed->fill( $table , $total , $default );
 
    }

}

?>
