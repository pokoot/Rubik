<?php if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );  
 
/**
 * Auto-linker
 *
 * Automatically links URL and Email addresses.
 * Note: There's a bit of extra code here to deal with
 * URLs or emails that end in a period.  We'll strip these
 * off and add them after the link.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the type: email, url, or both
 * @param	bool	whether to create pop-up links
 * @return	string
 */
if( !function_exists('auto_link')){

	function auto_link($str, $type = 'both', $popup = false){
		if($type != 'email'){
			if(preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches)){
				$pop = ($popup == true) ? " target=\"_blank\" " : "";

				for ($i = 0; $i < count($matches['0']); $i++){
					$period = '';
					if(preg_match("|\.$|", $matches['6'][$i])){
						$period = '.';
						$matches['6'][$i] = substr($matches['6'][$i], 0, -1);
					}

					$str = str_replace( $matches['0'][$i],
										$matches['1'][$i].'<a href="http'.
										$matches['4'][$i].'://'.
										$matches['5'][$i].
										$matches['6'][$i].'"'.$pop.'>http'.
										$matches['4'][$i].'://'.
										$matches['5'][$i].
										$matches['6'][$i].'</a>'.
										$period, $str);
				}
			}
		}

		if($type != 'url'){
			if(preg_match_all("/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $str, $matches)){
				for ($i = 0; $i < count($matches['0']); $i++){
					$period = '';
					if(preg_match("|\.$|", $matches['3'][$i])){
						$period = '.';
						$matches['3'][$i] = substr($matches['3'][$i], 0, -1);
					}

					$str = str_replace($matches['0'][$i], safe_mailto($matches['1'][$i].'@'.$matches['2'][$i].'.'.$matches['3'][$i]).$period, $str);
				}
			}
		}

		return $str;
	}
}



/**
 * Prep URL
 *
 * Simply adds the http:// part if no scheme is included
 *
 * @access	public
 * @param	string	the URL
 * @return	string
 */
if( !function_exists('prep_url')){
	function prep_url($str = ''){
		if($str == 'http://' OR $str == ''){
			return '';
		}

		$url = parse_url($str);

		if( ! $url OR !isset($url['scheme'])){
			$str = 'http://'.$str;
		}

		return $str;
	}
}




/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if( !function_exists('url_title')){
	function url_title($str, $separator = 'dash', $lowercase = false){
		if($separator == 'dash'){
			$search		= '_';
			$replace	= '-';
		}else{
			$search		= '-';
			$replace	= '_';
		}

		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						'[^a-z0-9\-\._]'		=> '',
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					);

		$str = strip_tags($str);

		foreach ($trans as $key => $val){
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if($lowercase === true){
			$str = strtolower($str);
		}

		return trim(stripslashes($str));
	}
}



/**
 * Header Redirect
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the method: location or redirect
 * @return	string
 */
if( !function_exists('redirect')){
    function redirect( $uri = '' , $method = 'location', $http_response_code = 302 ){
		switch($method){
			case 'refresh'	: header("Refresh:0;url=" . $uri );
				break;
			default			: header("Location: ".$uri, true, $http_response_code);
				break;
		}
		exit();
	}
}




/**
 * Gets the current page url 
 * 
 * @access public
 * @return void
 */
if( !function_exists( 'get_current_url' ) ){
    
    function current_url(){

        $page_url = 'http';

        $server_https   = element( "HTTPS" , $_SERVER );
        $server_name    = element( "SERVER_NAME" , $_SERVER );
        $server_port    = element( "SERVER_PORT" , $_SERVER );        
        $server_uri     = element( "SERVER_URI" , $_SERVER );


        if( $server_https  == "on" ) {
            $page_url .= "s";
        }

        $page_url .= "://";

        if( $server_port != "80") {

            $page_url .= 
                $server_name .":".
                $server_port .
                $server_uri ;

        }else{

            $page_url .= $server_name . $server_uri ;

        }

        return $page_url;

    }
 
}




?>
