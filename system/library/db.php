<?php

namespace Library;

if ( !defined("BASE_PATH")) exit("No direct script access allowed.");


/**
 * Wrapper Class for database functions
 *
 * @package
 * @version $id$
 * @author Harold Kim Cantil
 * @license http://pokoot.com/license.txt
 */
class Db {

    /**
     * table - the table name
     *
     * @var string
     * @access public
     */
    public $table;


    /**
     * query - the database query string
     *
     * @var string
     * @access public
     */
    public $query;


    /**
     * result - the mysql resource identifier
     *
     * @var mixed
     * @access public
     */
    public $result;


    /**
     * error - the sql error string
     *
     * @var boolean
     * @access public
     */
    public $error;


    /**
     * Constructor
     *
     * @access protected
     * @return void
     */
    public function __construct(){
    }




    /**
     * Connects to a mysql database
     *
     * @access public
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @return void
     */
    public function connect( $host , $username , $password , $database ){


        $connection = mysql_connect( $host , $username , $password );

        if( !$connection ){
            die('could not connect :'.mysql_error() );
            exit();
        }


        $selected = mysql_select_db( $database , $connection );

        if( !$selected ){
            die ('Cant use the '. $database . ' : ' . mysql_error() );
            exit();
        }

        mysql_query( "SET character_set_client=utf8" );
        mysql_query( "SET character_set_connection=utf8" );
        mysql_query( "SET character_set_results=utf8" );

        //mysql_query( "SET names utf8" );

    }




    /**
     * get the id of last inserted record
     *
     * @return integer - the number of rows in a result set
     */
    public function get_last_id(){
        return mysql_insert_id();
    }




    /**
     * returns the query string
     *
     * @access public
     * @return string - the sql query string
     */
    public function get_query(){
        //return htmlentities ( $this->query );
        return $this->query;
    }




    /**
     * sets the mysql table nameprint_r( $a );
     *
     * @param string the mysql table name
     * @access public
     * @return void
     */
    public function set_table( $table ){
        $this->table = ( STRING ) $table;
    }




    /**
     * returns the mysql table name
     *
     * @access public
     * @return string - the mysql table name
     */
    public function get_table(){
        return $this->table;
    }




    /**
     * returns TRUE on error and FALSE w/o error
     *
     * @access public
     * @return boolean
     */
    public function has_error(){
        return $this->error;
    }




    /**
     * sends a mysql query string
     *
     * @param string $query
     * @access public
     * @return mixed - the resource link identifier
     */
    public function query( $query ){
        $this->query = $query;
        $this->result = mysql_query( $query );
        $this->error = FALSE;
        if ( !$this->result ) {

            $mysql_error = mysql_error();
            print "<br/><font color='#FF0000'><b>$query</b></font>";
            print "<br/><font color='#0000FF' >Invalid query : " . $mysql_error;
            $this->error = TRUE;

        }
        return $this->result;
    }




    /**
     * creates a database
     *
     * @param string $name - the database name
     * @access public
     * @return mixed - the resource link identifier
     */
    public function create( $name ){
        $this->query = "CREATE DATABASE $name ";
        return $this->query ( $this->query );
    }





    /**
     * drop - drops the table in the database and deletes the database
     *
     * @param string $name - the database name
     * @access public
     * @return mixed - the resource link identifier
     */
    public function drop( $name ){
        $this->query = "DROP DATABASE IF EXISTS $name ";
        return $this->query ( $this->query );
    }




    /**
     * rename - rename one table to another name
     *
     * @param string $newName - the mysql new table name
     * @access public
     * @return mixed - the resource link identifier
     */
    public function rename( $newName ) {
        $this->query = "RENAME TABLE " . $this->table . " TO $newName ";
        return $this->query ( $this->query );
    }




    /**
     * truncate -  empties a table completely
     *
     * @access public
     * @return mixed - the resource link identifier
     */
    public function truncate(){
        $this->query = "TRUNCATE TABLE ".$this->table;
        return $this->query ( $this->query );
    }




    /**
     * shows the statement that creates the given table
     *
     * @access public
     * @return string - the table creation string
     */
    public function get_create_table(){
        $this->query = "SHOW CREATE TABLE " . $this->table ;
        return $this->query ( $this->query );
    }




    /**
     * optimize - reclaim the unused space and to defragment the data file
     *
     * @access public
     * @return mixed - the resource link identifier
     */
    public function optimize(){
        $this->query = "OPTIMIZE TABLE " . $this->table;
        return $this->query( $this->query );
    }




    /**
     * provide information about the table fields
     *
     * @access public
     * @return string - the field information
     */
    public function get_fields(){
        $this->query = "SHOW FIELDS FROM " . $this->table;
        return $this->query( $this->query );
    }




    /**
     *  provide information about the database
     *
     * @access public
     * @return string - the databases information
     */
    public function get_databases(){
        $this->query = "SHOW DATABASES";
        return $this->query( $this->query );
    }




    /**
     * shows the tables in the database
     *
     * @access public
     * @return string - the tables names
     */
    public function get_tables(){
        $this->query = "SHOW TABLES";
        return $this->query( $this->query );
    }




    /**
     * returns table index information in a format that resembles the SQLStatistics call in ODBC
     *
     * SHOW KEYS is a synonym for SHOW INDEX
     *
     * @access public
     * @return mixed - the index information
     */
    public function get_keys(){
        $this->query = "SHOW KEYS FROM " . $this->table ;
        return $this->query ( $this->query );
    }




    /**
     * displays information about the columns in a given table
     *
     * same as DESCRIBE
     *
     * @access public
     * @return mixed - the table information
     */
    public function get_columns(){
        $this->query = "SHOW COLUMNS FROM  " . $this->table ;
        return $this->query ( $this->query );
    }




    /**
     * describe - displays information about the columns in a a given table
     *
     * same as SHOW COLUMNS
     *
     * @access public
     * @return mixed - the table informtaion
     */
    public function describe(){
        $this->query = "DESCRIBE " . $this->table ;
        return $this->query ( $this->query );
    }




    /**
     * shows you which threads are running
     *
     * @access public
     * @return mixed - the running threads
     */
    public function get_process(){
        $this->query = "SHOW FULL PROCESSLIST";
        return $this->query ( $this->query );
    }




    /**
     * status - provides server status information.
     *
     * @param string $status
     * @access public
     * @return mixed - status information
     */
    public function status( $status = "%" ) {
        $this->query = "SHOW STATUS LIKE '$status'";
        return $this->query ( $this->query );
    }



    /**
     * analyze - analyzes and stores the key distribution for a table.
     *
     * @access public
     * @return mixed - table analysis information
     */
    public function analyze(){
        $this->query = "ANALYZE TABLE " . $this->table ;
        return $this->query ( $this->query );
    }



    /**
     * check - checks table for errors
     *
     * @access public
     * @return mixed - table status
     */
    public function check(){
        $this->query = "CHECK TABLE " . $this->table ;
        return $this->query ( $this->query );
    }



    /**
     * check table for all errors
     *
     * @access public
     * @return mixed - table status
     */
    public function check_all(){
        $this->query = "CHECK TABLE " . $this->table . " QUICK FAST MEDIUM EXTENDED CHANGED ";
        return $this->query ( $this->query );
    }



    /**
     * reports a table checksum.
     *
     * @access public
     * @return mixed - the table status information
     */
    public function check_sum(){
        $this->query = "CHECKSUM TABLE " . $this->table . " EXTENDED " ;
        return $this->query ( $this->query );
    }



    /**
     * repair - repairs a possibly corrupted table
     *
     * @access public
     * @return mixed - the repair status
     */
    public function repair(){
        $this->query = "REPAIR TABLE " . $this->table . " QUICK EXTENDED" ;
        return $this->query ( $this->query );
    }



    /**
     * version - shows the mysql version
     *
     * @access public
     * @return string - the mysql version
     */
    public function version(){
        $this->query = "SELECT @@VERSION" ;
        return $this->query ( $this->query );
    }



    /**
     * Close the mysql connection
     *
     * @access public
     * @return void
     */
    public function close(){
        mysql_close();
    }


}

?>
