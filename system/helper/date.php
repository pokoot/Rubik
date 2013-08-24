<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );
/**
 * NOTE:: Definition of term
 *
 * mysql = 2012-12-30 12:59:59
 * timestamp  = 1324597315
 * human = Dec 30 2012 
 * machine 
 *      25-12-2011 09:23:45
 *      25-12-2011 15:41:55
 *      25-12-2011 03:41:55 PM
 *
 */

/*
    IMPORTANT FUNCTION

    mysql_to_human
    mysql_to_machine
    mysql_to_timestamp

    machine_to_mysql
    machine_to_timestamp

    timestamp_to_mysql
    timestamp_to_machine

 */ 



/**
 * Todays date in a mysql format
 * 
 * @access public
 * @return void
 */
if( !function_exists('today')){
    function today(){
        return date( "Y-m-d H:i:s" );
    }
}


/**
 * Get "now" time
 *
 * Returns time() or its GMT equivalent based on the config file preference
 *
 * @access	public
 * @return	integer
 */
if( !function_exists('now')){
	function now(){ 
		if( TIME_REFERENCE == 'GMT' ){
			$now = time();
			$system_time = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));
            if(strlen($system_time) < 10){                
				$system_time = time();
				debug('ERROR: The Date class could not set a proper GMT timestamp so the local time() value was used.');
			}
			return $system_time;
		}else{
			return time();
		}
	}
}


/**
 * Convert MySQL Style Datecodes
 *
 * This function is identical to PHPs date() function,
 * except that it allows date codes to be formatted using
 * the MySQL style, where each code letter is preceded
 * with a percent sign:  %Y %m %d etc...
 *
 * The benefit of doing dates this way is that you don't
 * have to worry about escaping your text letters that
 * match the date codes.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	integer
 */
if( !function_exists('mdate')){
	function mdate($datestr = '', $time = ''){
		if($datestr == '')
			return '';

		if($time == '')
			$time = now();

		$datestr = str_replace('%\\', '', preg_replace("/([a-z]+?){1}/i", "\\\\\\1", $datestr));
		return date($datestr, $time);
	}
}




/**
 * Standard Date
 *
 * Returns a date formatted according to the submitted standard.
 *
 * http://php.net/manual/en/class.datetime.php
 *
 * @access	public
 * @param	string	the chosen format
 * @param	integer	Unix timestamp
 * @return	string
 */
if( !function_exists('standard_date')){
	function standard_date($format = 'DATE_RFC822', $time = ''){
		$formats = array(
						'DATE_ATOM'		=>	'%Y-%m-%dT%H:%i:%s%Q',
						'DATE_COOKIE'	=>	'%l, %d-%M-%y %H:%i:%s UTC',
						'DATE_ISO8601'	=>	'%Y-%m-%dT%H:%i:%s%Q',
						'DATE_RFC822'	=>	'%D, %d %M %y %H:%i:%s %O',
						'DATE_RFC850'	=>	'%l, %d-%M-%y %H:%m:%i UTC',
						'DATE_RFC1036'	=>	'%D, %d %M %y %H:%i:%s %O',
						'DATE_RFC1123'	=>	'%D, %d %M %Y %H:%i:%s %O',
						'DATE_RSS'		=>	'%D, %d %M %Y %H:%i:%s %O',
						'DATE_W3C'		=>	'%Y-%m-%dT%H:%i:%s%Q'
						);

		if( !isset($formats[$format])){
			return false;
		}

		return mdate($formats[$format], $time);
	}
}


/**
 * Timespan
 *
 * Returns a span of seconds in this format:
 *	10 days 14 hours 36 minutes 47 seconds
 *
 * @access	public
 * @param	integer	a number of seconds
 * @param	integer	Unix timestamp
 * @return	integer
 */
if( !function_exists('timespan')){
	function timespan($seconds = 1, $time = ''){

		if( !is_numeric($seconds)){
			$seconds = 1;
		}

		if( !is_numeric($time)){
			$time = time();
		}

		if($time <= $seconds){
			$seconds = 1;
		}else{
			$seconds = $time - $seconds;
		}

		$str = '';
		$years = floor($seconds / 31536000);

		if($years > 0){
			$str .= $years.' '. __((($years > 1) ? 'DATE_YEARS' : 'DATE_YEAR') , false ).', ';
		}

		$seconds -= $years * 31536000;
		$months = floor($seconds / 2628000);

		if($years > 0 OR $months > 0){
			if($months > 0){
				$str .= $months.' '. __((($months > 1) ? 'DATE_MONTHS' : 'DATE_MONTH') , false ).', ';
			}
			$seconds -= $months * 2628000;
		}

		$weeks = floor($seconds / 604800);

		if($years > 0 OR $months > 0 OR $weeks > 0){
			if($weeks > 0){
				$str .= $weeks.' '. __((($weeks > 1) ? 'DATE_WEEKS' : 'DATE_WEEK') , false ).', ';
			}
			$seconds -= $weeks * 604800;
		}

		$days = floor($seconds / 86400);

		if($months > 0 OR $weeks > 0 OR $days > 0){
			if($days > 0){
				$str .= $days.' '. __((($days	> 1) ? 'DATE_DAYS' : 'DATE_DAY') , false ).', ';
			}

			$seconds -= $days * 86400;
		}

		$hours = floor($seconds / 3600);

		if($days > 0 OR $hours > 0){
			if($hours > 0){
				$str .= $hours.' '. __((($hours > 1) ? 'DATE_HOURS' : 'DATE_HOUR') , false ) .', ';
			}

			$seconds -= $hours * 3600;
		}

		$minutes = floor($seconds / 60);

		if($days > 0 OR $hours > 0 OR $minutes > 0){
			if($minutes > 0){
				$str .= $minutes.' '. __((($minutes > 1) ? 'DATE_MINUTES' : 'DATE_MINUTE') , false ).', ';
			}

			$seconds -= $minutes * 60;
		}

		if($str == ''){
			$str .= $seconds.' '. __((($seconds > 1) ? 'DATE_SECONDS' : 'DATE_SECOND') , false ) . ', ';
		}

		return substr(trim($str), 0, -1);
	}
}




/**
 * Number of days in a month
 *
 * Takes a month/year as input and returns the number of days
 * for the given month/year. Takes leap years into consideration.
 *
 * @access	public
 * @param	integer a numeric month
 * @param	integer	a numeric year
 * @return	integer
 */
if( !function_exists('days_in_month')){
	function days_in_month($month = 0, $year = ''){
		if($month < 1 OR $month > 12){
			return 0;
		}

		if( ! is_numeric($year) OR strlen($year) != 4){
			$year = date('Y');
		}

		if($month == 2){
			if($year % 400 == 0 OR ($year % 4 == 0 AND $year % 100 != 0)){
				return 29;
			}
		}

		$days_in_month	= array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		return $days_in_month[$month - 1];
	}
}




/**
 * Converts a local Unix timestamp to GMT
 *
 * @access	public
 * @param	integer Unix timestamp
 * @return	integer
 */
if( !function_exists('local_to_gmt')){
	function local_to_gmt($time = ''){
		if($time == '')
			$time = time();

		return mktime( gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time));
	}
}




/**
 * Converts GMT time to a localized value
 *
 * Takes a Unix timestamp (in GMT) as input, and returns
 * at the local value based on the timezone and DST setting
 * submitted
 *
 * @access	public
 * @param	integer Unix timestamp
 * @param	string	timezone
 * @param	bool	whether DST is active
 * @return	integer
 */
if( !function_exists('gmt_to_local')){
	function gmt_to_local($time = '', $timezone = 'UTC', $dst = false){
		if($time == ''){
			return now();
		}

		$time += timezones($timezone) * 3600;

		if($dst == true){
			$time += 3600;
		}

		return $time;
	}
}




/**
 * Timezone Menu
 *
 * Generates a drop-down menu of timezones.
 *
 * @access	public
 * @param	string	timezone
 * @param	string	classname
 * @param	string	menu name
 * @return	string
 */
if( !function_exists('timezone_menu')){
	function timezone_menu( $default = 'UTC', $class = "", $name = 'timezones'){

		if( TIME_REFERENCE  == 'GMT')
			$default = 'UTC';

		$menu = '<select name="'.$name.'"';

		if($class != ''){
			$menu .= ' class="'.$class.'"';
		}

		$menu .= ">\n";

		foreach (timezones() as $key => $val){
			$selected = ($default == $key) ? " selected='selected'" : '';
			$menu .= "<option value='{$key}'{$selected}>".  __( $key , false ) ."</option>\n";
		}

		$menu .= "</select>";

		return $menu;
	}
}





/**
 * Timezones
 *
 * Returns an array of timezones.  This is a helper function
 * for various other ones in this library
 *
 * @access	public
 * @param	string	timezone
 * @return	string
 */
if( !function_exists('timezones')){
	function timezones($tz = ''){
		// Note: Don't change the order of these even though
		// some items appear to be in the wrong order

		$zones = array(
						'UM12'		=> -12,
						'UM11'		=> -11,
						'UM10'		=> -10,
						'UM95'		=> -9.5,
						'UM9'		=> -9,
						'UM8'		=> -8,
						'UM7'		=> -7,
						'UM6'		=> -6,
						'UM5'		=> -5,
						'UM45'		=> -4.5,
						'UM4'		=> -4,
						'UM35'		=> -3.5,
						'UM3'		=> -3,
						'UM2'		=> -2,
						'UM1'		=> -1,
						'UTC'		=> 0,
						'UP1'		=> +1,
						'UP2'		=> +2,
						'UP3'		=> +3,
						'UP35'		=> +3.5,
						'UP4'		=> +4,
						'UP45'		=> +4.5,
						'UP5'		=> +5,
						'UP55'		=> +5.5,
						'UP575'		=> +5.75,
						'UP6'		=> +6,
						'UP65'		=> +6.5,
						'UP7'		=> +7,
						'UP8'		=> +8,
						'UP875'		=> +8.75,
						'UP9'		=> +9,
						'UP95'		=> +9.5,
						'UP10'		=> +10,
						'UP105'		=> +10.5,
						'UP11'		=> +11,
						'UP115'		=> +11.5,
						'UP12'		=> +12,
						'UP1275'	=> +12.75,
						'UP13'		=> +13,
						'UP14'		=> +14
					);

		if($tz == ''){
			return $zones;
		}

		if($tz == 'GMT')
			$tz = 'UTC';

		return ( ! isset($zones[$tz])) ? 0 : $zones[$tz];
	}
}




/**
 * Add a 0 in front of times with 1 character
 * ex. 0  ==> 01
 * ex. 12 ==> 12 ( no change ) 
 *
 * @author Richard Sumilang <richard@richard-sumilang.com>
 * @param  string  $string
 * @return string
 */
if( !function_exists('fill_time')){
    function fill_time( $string ){
    	if(strlen($string)==1){
			$string="0" . $string;
		}
        return $string;
    }
}




/*
 * Return the number of days between the two dates:
 * http://stackoverflow.com/questions/676824/how-to-calculate-the-difference-between-two-dates-using-php
 *
 * day_difference( "2011-09-13" , "2011-09-13" );  ==> 0
 * day_difference( "2011-09-13" , "2011-09-14" );  ==> -1
 * day_difference( "2011-09-13" , "2011-05-01" );  ==> 135
 *
 * use this if php version is not 5.3 
 * otherwise use this
 * http://php.net/manual/en/function.date-diff.php
 
 * diff = minuend - subtrahend    
 */
if( !function_exists('day_difference')){
    function day_difference( $minuend , $subtrahend ) {        
        $minuend_unixtime       = strtotime($minuend);
        $subtrahend_unixtime    = strtotime($subtrahend);

        $difference = $minuend_unixtime - $subtrahend_unixtime ;

        $symbol = "";
        if( $difference <= 1 AND $difference != 0 ){
            $difference = abs( $difference );
            $symbol = "-";
        }
        return $symbol . round( $difference )/86400;
    } 
}



/**
 * This converts stuff like 3:00am to 03:00 and 4:00pm to like 16:00
 *
 * @param  string  $time   Time in the form of 1:00 or whatever
 * @param  string  $ampm   Values are am or pm
 * @return string
 */
if( !function_exists('to_24_hours')){

	function to_24_hours($time, $ampm ){
	
		/* Make sure it's lower case */
		$ampm=strtolower($ampm);		
		
		/* Split the time */
		list($hour, $min)=split(":", $time);
		
		switch($ampm){
			
			case "am":
				$hour=$this->fill_time($hour);
			break;
			
			case "pm":
				$hour=$hour + 12;
			break;
			
		}
		
		$min=$this->fill_time($min);
		
		return $hour . ":" . $min;
	
	}
	
}


/**
 * This converts stuff like 16:00 to 04:00pm
 *
 * @param  string  $time   Time in the form of HH:MI
 * @return array
 */
if( !function_exists('to_12_hours')){

	function to_12_hours($time){
	
		/* Split up the time */
		list($hour, $min)=split(":", $time);
		
		if($hour > 12){
			$hour=$hour-12;
			$ampm="pm";
		}else{
			$ampm="am";
		}
		
		if($hour=="00"){
			$hour="24";
		}
		
		
		$result = array(
					"time" => $hour . ":" . $min,
					"ampm" => $ampm
		);
		
		return $result;
	
    }	

}



 

/**
 * Formated human with br
 * 
 * @access public
 * @param mixed $date 
 * @return void
 */
if( !function_exists('human_to_br')){
    function human_to_br( $date , $br = "<br/>"){
        list( $m , $d , $y , $hm , $ampm ) = explode( " " , $date ) ;
        return "{$m} {$d} {$y}{$br}{$hm} $ampm ";
    }
}

 



 





///////////////////////////////////////////////////////////////////////////////
// TIMESTAMP TO _________________
///////////////////////////////////////////////////////////////////////////////





/**
 *
 * Formats Unix timestamp 
 *
 * @access	public
 * @param	integer Unix timestamp
 * @param	bool	whether to show seconds
 * @param	string	format: us or euro
 * @return	string
 */
if( !function_exists('timestamp_to_machine')){
    function timestamp_to_machine( $unixtime = '', $time = false , $seconds = false, $ampm = false ,  $format = 'SG' ){
        
        $r  = date('d', $unixtime).'-'.date('m', $unixtime).'-'.date('Y', $unixtime);

        if( $time ){

            $r .= ' ';

            if( $format == 'SG' ){
			    $r .= date('h', $unixtime ).':'.date('i', $unixtime );
    		}else{
	    		$r .= date('H', $unixtime ).':'.date('i', $unixtime );
		    }

            if( $seconds ){
                $r .= ':'.date('s', $unixtime );
            }

            if( $ampm ){
                $r .= ' '.date('A', $unixtime );
            }
        }

		return $r ;
	}
}




if( !function_exists('timestamp_to_mysql')){
    function timestamp_to_mysql( $unixtime = ''){
        return date( "Y-m-d H:i:s" , $unixtime );
    }
}






///////////////////////////////////////////////////////////////////////////////
// MACHINE TO _________________
///////////////////////////////////////////////////////////////////////////////




/**
 * Convert "human" date to GMT
 *
 * Note: format ==>  
 *      '06-02-2012 05:12:56'
 *      '06-02-2012'
 *
 * @access	public
 * @param	string	format: us or euro
 * @return	integer
 */
if( !function_exists('machine_to_timestamp')){

	function machine_to_timestamp($datestr = ''){
		if($datestr == ''){
			return false;
		}

		$datestr = trim($datestr);
        $datestr = preg_replace("/\040+/", ' ', $datestr);


        if( !preg_match('/^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{2,4}\s[0-9]{1,2}:[0-9]{1,2}(?::[0-9]{1,2})?(?:\s[AP]M)?$/i', $datestr)){            
            debug( "Invalid format YYYY-MM-DD HH:MM:SS" );
			return false;
		}

        $split = explode(' ', $datestr);
        //debug_array( $split );


        $ex = explode("-", $split['0']);


        //debug_array( $ex );

		$year  = (strlen($ex['2']) == 4 ) ? $ex['2'] : $ex['2'];
		$month = (strlen($ex['1']) == 1) ? '0'.$ex['1']  : $ex['1'];
        $day   = (strlen($ex['0']) == 1) ? '0'.$ex['0']  : $ex['0'];

      

        $ex = explode(":", $split['1']);

        //debug_array( $ex );

		$hour = (strlen($ex['0']) == 1) ? '0'.$ex['0'] : $ex['0'];
        $min  = (strlen($ex['1']) == 1) ? '0'.$ex['1'] : $ex['1'];

        //debug( $hour );

		if(isset($ex['2']) && preg_match('/[0-9]{1,2}/', $ex['2'])){
			$sec  = (strlen($ex['2']) == 1) ? '0'.$ex['2'] : $ex['2'];
		}else{
			// Unless specified, seconds get set to zero.
			$sec = '00';
		}

		if(isset($split['2'])){
			$ampm = strtolower($split['2']);

			if(substr($ampm, 0, 1) == 'p' AND $hour < 12)
				$hour = $hour + 12;

			if(substr($ampm, 0, 1) == 'a' AND $hour == 12)
				$hour =  '00';

			if(strlen($hour) == 1)
				$hour = '0'.$hour;
		}

		return mktime($hour, $min, $sec, $month, $day, $year);
	}
}




/**
 * Note: 
 *      '06-02-2012 05:12:56'   =>  2012-02-06 05:12:56
 *      '06-02-2012'            =>  2012-02-06 00:00:00
 *
 * @access	public
 * @return	integer
 */
if( !function_exists('machine_to_mysql')){

    function machine_to_mysql( $datestr = '' ){

        if($datestr == ''){
			return false;
		}

		$datestr = trim($datestr);
        $datestr = preg_replace("/\040+/", ' ', $datestr);


        //if( !preg_match('/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}\s[0-9]{1,2}:[0-9]{1,2}(?::[0-9]{1,2})?(?:\s[AP]M)?$/i', $datestr)){            
        //  debug( "machine to mysql invalid format yyyy-mm-dd hh:ii:ss" );
		//  return false;
        //}

        $split = explode( " " , $datestr );

        $ex = explode( "-" , $split[0] );
        list( $day , $month , $year ) = $ex;


        $timestr = " 00:00:00";

        if( isset( $split[1] ) ){
            $ex = explode( ":" , $split[1] );
        
            if( count( $ex )  > 1){
                
                list( $hour , $minute , $second ) = $ex;

                $timestr = " {$hour}:{$minute}:{$second}";
            }              

        }
        return $year . "-" . $month . "-" . $day . $timestr;        
    }

}



///////////////////////////////////////////////////////////////////////////////
// MYSQL TO _________________
///////////////////////////////////////////////////////////////////////////////



 

/**
 * Converts a MySQL Timestamp to Unix
 
 *
 * @access	public
 * @param	integer Unix timestamp
 * @return	integer
 */
if( !function_exists('mysql_to_timestamp')){
	function mysql_to_timestamp($time = ''){

		$time = str_replace('-', '', $time);
		$time = str_replace(':', '', $time);
		$time = str_replace(' ', '', $time);
		
		return  mktime(
						substr($time, 8, 2),
						substr($time, 10, 2),
						substr($time, 12, 2),
						substr($time, 4, 2),
						substr($time, 6, 2),
						substr($time, 0, 4)
						);
	}
}





/**
 * Mysql To Machine date
 */
if( !function_exists('mysql_to_machine')){   
    function mysql_to_machine( $mysql = '', $time = false , $seconds = false , $ampm = false , $format = 'SG' ){

        if( !$mysql ){
            return;
        }

        $mysql = mysql_to_timestamp(  $mysql );
        return timestamp_to_machine( $mysql , $time , $seconds , $ampm , $format );
     }
}






/**
 * To a human readable format 
 * 
 * @access public
 * @param string $mysql 
 * @param mixed $time 
 * @param mixed $seconds 
 * @param string $format 
 * @return void
 */
if( !function_exists('mysql_to_human')){
    
    function mysql_to_human( $mysql = '' , $time = false , $seconds = false, $format = 'SG' ){

        $unixtime = mysql_to_timestamp( $mysql );
        
        $r  = date('M', $unixtime).' '.date('j', $unixtime).' '.date('Y', $unixtime).' ';

        if( $time ){

            if( $format == 'SG' ){
			    $r .= date('h', $unixtime ).':'.date('i', $unixtime );
    		}else{
	    		$r .= date('H', $unixtime ).':'.date('i', $unixtime );
		    }

            if($seconds){
                $r .= ':'.date('s', $unixtime );
            }

            if( $format == 'SG' ){
                $r .= ' '.date('A', $unixtime );
            }
        }

		return $r;
	}
}




function datetime_to_mysql( $date ){
    if( 
		$date != "0000-00-00 00:00:00" &&
		$date != "0000-00-00" 
        ){

        return date( "Y-m-d H:i:00" , strtotime( $date ) ); 
    }

    return;
}



function date_to_mysql( $date ){
    if( 
		$date != "0000-00-00 00:00:00" &&
		$date != "0000-00-00" 
        ){

        return date( "Y-m-d 00:00:00" , strtotime( $date ) ); 
    }

    return '';
}



function mysql_to_datetime( $date ){
    if( 
		$date != "0000-00-00 00:00:00" &&
		$date != "0000-00-00" 
		){
		
        return date( "d-m-Y h:i A" , strtotime( $date ) );
    }

    return '';

}



function mysql_to_date( $date ){
	if( 
		$date != "0000-00-00 00:00:00" &&
		$date != "0000-00-00" 
		){
		
		return date( "d-m-Y" , strtotime( $date ) );
	}
    
    return '';	
}



?>
