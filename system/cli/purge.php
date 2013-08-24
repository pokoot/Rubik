<?php  if ( !defined('BASE_PATH')) exit('No direct script access allowed');
/**
 * Purge data data on the last 90 days
 * 
 * Basic usage:
 * php cli.php --module=purge --log=file
 *
 * Advance usage:
 * php cli.php --module=purge --table=history --log=file
 * php cli.php --module=purge --table=history --days=90 --log=file
 *
 * @uses Cli
 * @package 
 * @version $id$
 * @author Kim
 * @license Cellcity
 */
class Purge extends Cli {

    protected $model = array( "history" );    
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

        $debug  = element( "d" , $this->argument , "false" );
        $days   = element( "days" , $this->argument , 90 );
        $table  = element( "table" , $this->argument , "history" );

        writeln( "debug = $debug " );
        writeln( "days = $days " );

        $model = new Model_History();

        $query = "
            DELETE 
            FROM $table 
            WHERE   
                created_date < NOW() - INTERVAL $days DAY 
        ";

        writeln( $query );

        $model->query( $query );

        $total = $model->get_total();

        logln( "Total data purge in history table = " . $total );
    
    }

}

?>
