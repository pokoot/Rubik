<?php  

namespace Library;

if ( !defined("BASE_PATH")) exit("No direct script access allowed.");

 
/**
 * Sql - mysql wrapper class  
 *
 * TODO:: gettype change to is_array is_string , decpreciated commands.
 * 
 * @uses Db
 * @package 
 * @version $id$
 * @author Harold Kim Cantil 
 * @license http://pokoot.com/license.txt
 */
class Sql extends Db {
     
    /**
     * Sql - the class constructor  
     * 
     * @access protected     
     * @return object
     */
    public function __construct(){
        parent::__construct();
    }
    


    /**
     *  get the number of rows in a result set 
     * 
     * @access public
     * @return integer - the number of rows in a result set
     */    
    public function get_count(){
        if ( is_resource( $this->result ) ){
            return mysql_num_rows( $this->result );
        }else {
            return 0;
        }
    }




    /**
     * get number of affected rows in previous MySQL operation  
     * 
     * @access public
     * @return integer - the number of rows in a result set
     */
    public function get_total(){
        return mysql_affected_rows();
    }




    /**
     * Sends a mysql query string
     * 
     * @param string $query 
     * @access public
     * @return mixed - the resource link identifier
     */
    public function query( $query ){
        $this->query    = $query;
        $this->result   = mysql_query( $query );         
        $this->error    = false;
        if ( !$this->result ) {
            $this->error = true;

            $mysql_error = mysql_error();

            debug( "ERROR QUERY = " .  $query );
            debug( "<font color='red'>" . $mysql_error . "</font>" );


            if( defined( "ADMIN_EMAIL" ) &&  ENVIRONMENT != "LOCALHOST" ){

                $current_url = current_url();

                $body = "
---------------------------------------
MODULE
---------------------------------------
" . CURRENT_MODULE . "

---------------------------------------
 PAGE
---------------------------------------
$current_url

---------------------------------------
 ERROR
---------------------------------------
$mysql_error

---------------------------------------
 QUERY
---------------------------------------
$query";


                $title = 
                    APPLICATION_NAME . ' - ' . 
                    ENVIRONMENT . ' - ' .
                    strtoupper( CURRENT_MODULE ) . ' - ' .
                    $mysql_error; 

                send_email( ADMIN_EMAIL , $title , $body ); 
            }

        }
        return $this->result;
    }        




    /**
     * returns the query string  
     * 
     * @return string - the sql query string
     */
    public function get_query(){
        //return htmlentities ( $this->query );
        return $this->query;
    }



    
    /**
     * fetch rows
     * @return array - associative array
     */
    public function fetch_rows( $query = '' ){

        if( !$query ){
            $query = $this->query;
        }

        $data = array();

        $results = $this->query( $query );

        if( $results ){

            $cnt = 0;

            while( $row = mysql_fetch_row( $results ) ){
            
                foreach( $row as $key => $val ){

                    $data[$cnt]= html_entity_decode( ( $val ) );                    
                }

                $cnt++;
                
            }

        }
        return $data;
    }        




   
    /**
     * fetch a results row as an associative array  
     * 
     * @access public
     * @param string $query 
     * @return array - associative array
     */
    public function fetch_datas( $query = '' ){

        if( !$query ){
            $query = $this->query;
        }

        $data = array();

        $results = $this->query( $query );

        if( $results ){

            while( $row = mysql_fetch_assoc( $results ) ){
                $temp = array();
                foreach( $row as $key => $val ){
                    $temp[$key] = html_entity_decode( ( $val ) );
                }
                $data[] = $temp;
            }

        }
        return $data;
    }        




    /**
     * Fetch 1 data 
     * 
     * @access public
     * @param string $query 
     * @return void
     */
    public function fetch_data( $query = '' ){

        if( !$query ){
            $query = $this->query;
        }

        $data = array();

        $result = $this->query( $query );

        if( $result ){
            while( $row = mysql_fetch_assoc( $result ) ){
                foreach( $row as $key => $val ){
                    $data[$key] = html_entity_decode( $val );
                }
            }
        }
        return $data;
    }




    /**
     * mysql select statement 
     * 
     * @param mixed can be an array or a string - selection fields
     * @param string can be an associative array or a string - query condtions
     * @param string miscellaneous conditions
     * @return void
     */
    public function select( $table , $select , $condition = "" , $misc = "" ){

        if( gettype( $select ) === "array" ){                
            $select = implode( " , " , $select );
        }

        if( gettype( $condition ) === "array" ){
            $temp = array();
            foreach( $condition as $key => $val ){

                $val = $this->clean( $val );

                if ( $val != null ) {                                           
                    $temp[] = "$key = '$val'";
                }else{
                    $temp[] = "$key IS null";
                }
           }
           $condition = " WHERE " . implode( ' AND ' , $temp );

        }else if( gettype( $condition ) === "string" ){
            if ( $condition != "" ){
                $condition = " WHERE $condition ";             
            }
        }

        $this->query = " SELECT $select FROM $table $condition $misc ";
        $this->query( $this->query );
        return $this->query;
    }




    /**
     * mysql insert statement 
     * eg. 
     *   $a = array();
     *   $a['fieldName'] = "message";
     *   $ret = $sql->insert($a);
     * 
     * @param mixed $insert - an associative array that is being index by a string
     * @return boolean - returns true on success and false on error
     */
    public function insert( $table , $insert ){

        $fields = implode( " , " , array_keys( $insert ) );

        $temp = array();
        foreach( $insert as $val ){
            $temp[] = $this->clean( $val );                             
        }

        $values = implode( "' , '" , $temp );
        $this->query = " INSERT INTO $table ( $fields ) VALUES ( '$values' ) " ;
        return $this->query( $this->query );
    }




    /**
     * update - mysql update statement
     * 
     * eg.
     *   $set = array();
     *   $set['fieldName'] = "message";
     *   $cond = array();
     *   $cond['fieldname'] = "condition";
     *   $ret = $sql->update( $set , $cond );
     *
     * @param mixed $set - can be an associative array or a string - set statements
     * @param mixed $cond - can be an associative array or a string - query condtions
     * @return boolean - returns true on success and false on error
     */
    public function update( $table , $set , $cond = "" , $misc = "" ){           

        if( gettype( $set ) === "array" ){
            $temp = array();
            foreach ( $set as $key => $val ){

                $val = $this->clean( $val );                             
                
                if ( $val != '' ) {                                                    
                    $temp[] = "$key = '$val' ";
                }else{
                    $temp[] = "$key = '' ";
                }
            }
            $set = implode( ' , ' , $temp );
        }


        if(  gettype( $cond ) === "array" ) {

            $temp = array();
            foreach ( $cond as $key => $val ){

                $val = $this->clean( $val );  

                if ( $val != '' ) {                                           
                    $temp[] = "$key = '$val'";
                }else{
                    $temp[] = "$key = '' ";
                }
            }
            $cond = " WHERE " .implode( ' AND ' , $temp );            

        }else if( gettype( $cond ) === "string" ){
            if ( $cond != "" ){
                $cond = " WHERE $cond ";
            }
        }

        $this->query = " UPDATE $table SET $set $cond $misc ";
        return $this->query( $this->query ); 
    }




    /**
     * mysql delete statement 
     * 
     * @param mixed $cond - can be an associative array or a string - query condtions
     * @access public
     * @return boolean - returns true on success and false on error
     */
    public function remove( $table , $cond ){

        if ( gettype( $cond ) === "array" ) {

            foreach ( $cond as $key => $val ){
                $val = $this->clean( $val );    
                $temp[] = " $key = '$val' ";
            }
            $cond = " WHERE ". implode( ' AND ' , $temp );

        }else if( gettype( $cond ) === "string" ){
            if ( $cond != "" ){
                $cond = " WHERE $cond ";
            }
        }

        $this->query = " DELETE from $table $cond ";

        return $this->query ( $this->query );
    }
 



    /**
     * Cleans strings 
     * 
     * @access public
     * @param mixed $str 
     * @param mixed $encode_ent 
     * @return void
     */
    public function clean( $str , $encode_ent = false ){

        $str = @trim( $str );

        if( $encode_ent ){
            $str = htmlentities($str);
        }
        if( version_compare( phpversion() ,'4.3.0') >= 0 ){
            
            if(get_magic_quotes_gpc()){
                $str = stripslashes($str);
            }

            if( @mysql_ping() ){                
                $str = mysql_real_escape_string($str);                
            }else{                
                $str = addslashes($str);                
            }

        }else{

            if( !get_magic_quotes_gpc() ){
                $str = addslashes($str);
            }
        }

        return $str;
    }




    /**
     * Retrieves the enum values
     * 
     * @access public
     * @param mixed $table 
     * @param mixed $field 
     * @return void
     */
    public function enum( $table , $field ){

        $query = " SHOW COLUMNS FROM $table LIKE '$field'  ";

        $data = array();

        $results = $this->fetch_datas( $query );

        foreach( $results as $row ) {
            
            $types = $row['Type'];
            preg_match_all( "/enum\((.*)\)/isU" , $types , $matches );            
            
            for( $i = 0; $i < count( $matches[0] ) ; $i++ ){
                $types =  $matches[1][$i];
                
                $types = preg_replace( '/\'/' , '' , $types  );
                
                $types = explode( "," , $types );
                
                sort( $types );
                return $types;
            } 
        }
    }

}

?>
