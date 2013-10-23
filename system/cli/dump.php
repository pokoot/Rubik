<?php  if ( !defined('BASE_PATH')) exit('No direct script access allowed');

if( ENVIRONMENT == "PRODUCTION" ){
    die( "Production servers are not allowed to dump sql files. " );
}

/**
 * Dumps all sql file except history.sql
 *
 * php cli.php --module=dump
 *
 * @uses Application
 * @package
 * @version $id$
 * @author Kim
 * @license Cellcity
 */
class Dump extends Cli {

    protected $model = array( "resource" );
    protected $helper;
    protected $library;
    protected $language;
    protected $vendor;



    /**
     * Index
     *
     * @access public
     * @param mixed $datas
     * @return void
     */
    public function index(){

        $debug = element( "d" , $this->argument , "false" );

        $exclude = array(
            "history"
        );

        logh( "Dumping all tables " );

        $m = new Resource();
        $tables = $m->fetch_rows( "SHOW TABLES" );

        $path = mkdir_calendar( "backup" );

        foreach( $tables AS $k => $v ){

            $table_name = $v;

            if( in_array( $v , $exclude ) ){
                continue;
            }

            // for localhost
            if( !DB_PASSWORD ){
                $syntax = "mysqldump -u%s %s %s %s > %s ";
            }else{
                $syntax = "mysqldump -u%s -p %s %s %s > %s ";
            }



            $syntax = sprintf(  $syntax ,
                                DB_USERNAME ,
                                DB_PASSWORD ,
                                DB_DATABASE ,
                                $table_name ,
                                $path . "/" . $table_name . ".sql" );

            logln( $syntax );

            if( $debug != "false" ){
                exec( $syntax );
            }

        }

    }




}


?>
