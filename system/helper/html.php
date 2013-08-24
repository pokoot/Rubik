<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * Create a link
 * 
 * @access public
 * @param mixed $attributes 
 * @param mixed $index_page 
 * @return void
 */
if( !function_exists( 'html_link' ) ){
    
    function html_link( $attributes , $index_page = false ){

        if( isset( $attributes['href'] ) ){

            $href = $attributes['href'];         

            if( $index_page === true ){
				$attributes['href'] = APPLICATION_URL . 'image' . SEP . $href ;
			}else{
                $attributes['href'] = 'image'. SEP . $href ;
            }
            
        }

        $attributes = _parse_attributes( $attributes );

		return '<link ' . $attributes . '/>';
         
    }
}



/**
 * The xmlns attribute specifies the xml namespace for a document. 
 * 
 * @access public
 * @return string
 */
if( !function_exists('html_namespace')){
	function html_namespace(){
		return '<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">';
	}
}


/**
 * Heading
 *
 * Generates an HTML heading tag.  First param is the data.
 * Second param is the size of the heading tag.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	string
 */
if( !function_exists('html_h')){    
	function html_h($data = '', $h = '1', $attributes = ''){
		$attributes = ($attributes != '') ? ' '.$attributes : $attributes;
		return "<h".$h.$attributes.">".$data."</h".$h.">";
	}
}


/**
 * Create the html title 
 * 
 * @access public
 * @param mixed $title 
 * @return void
 */
if( !function_exists('html_title')){    
	function html_title( $title ){
		return "<title>" . ucwords( strtolower( $title ) ) . " | " . APPLICATION_LABEL . "</title>";
	}
}




/**
 * Unordered List
 *
 * Generates an HTML unordered list from an single or multi-dimensional array.
 *
 * @access	public
 * @param	array
 * @param	mixed
 * @return	string
 */
if( !function_exists('html_ul')){
	function html_ul( $list , $attributes = '' ){
		return html_list('ul', $list, $attributes);
	}
}



/**
 * Ordered List
 *
 * Generates an HTML ordered list from an single or multi-dimensional array.
 *
 * @access	public
 * @param	array
 * @param	mixed
 * @return	string
 */
if( !function_exists('html_ol')){
	function html_ol( $list , $attributes = '' ){
		return html_list( 'ol' , $list , $attributes );
	}
}



/**
 * Generates the list
 *
 * Generates an HTML ordered list from an single or multi-dimensional array.
 *
 * @access	private
 * @param	string
 * @param	mixed
 * @param	mixed
 * @param	integer
 * @return	string
 */
if( !function_exists('html_list')){
	function html_list($type = 'ul', $list, $attributes = '', $depth = 0){
		// If an array wasn't submitted there's nothing to do...
		if( !is_array($list)){
			return $list;
		}

		// Set the indentation based on the depth
		$out = str_repeat(" ", $depth);

		// Were any attributes submitted?  If so generate a string
		if(is_array($attributes)){
			$atts = '';
			foreach ($attributes as $key => $val){
				$atts .= ' ' . $key . '="' . $val . '"';
			}
			$attributes = $atts;
		}else if(is_string($attributes) AND strlen($attributes) > 0){
			$attributes = ' '. $attributes;
		}

		// Write the opening list tag
		$out .= "<".$type.$attributes.">\n";

		// Cycle through the list elements.  If an array is
		// encountered we will recursively call html_list()

		static $_last_list_item = '';
		foreach ($list as $key => $val){
			$_last_list_item = $key;

			$out .= str_repeat(" ", $depth + 2);
			$out .= "<li>";

			if( !is_array($val)){
				$out .= $val;
			}else{
				$out .= $_last_list_item."\n";
				$out .= html_list($type, $val, '', $depth + 4);
				$out .= str_repeat(" ", $depth + 2);
			}

			$out .= "</li>\n";
		}

		// Set the indentation for the closing tag
		$out .= str_repeat(" ", $depth);

		// Write the closing list tag
		$out .= "</".$type.">\n";

		return $out;
	}
}



/**
 * Generates HTML BR tags based on number supplied
 *
 * @access	public
 * @param	integer
 * @return	string
 */
if( !function_exists('html_br')){
	function html_br($num = 1){
		return str_repeat("<br />", $num);
	}
}



/**
 * Image
 *
 * Generates an <img /> element
 *
 * @access	public
 * @param	mixed
 * @return	string
 */
if( !function_exists('html_img')){
	function html_img( $src = '' , $index_page = true ){
		if( !is_array( $src ) ){
			$src = array('src' => $src);
		}

		// If there is no alt attribute defined, set it to an empty string
		if( !isset($src['alt'])){
			$src['alt'] = '';
		}

		$img = '<img';

		foreach( $src as $k => $v ){

            if( $k == 'src' AND strpos( $v, '://') === false){			 

                if( $index_page === true){
                    
                    $img .= ' src="'. APPLICATION_URL . "image" . SEP . $v .'"';
                }else{
                    $img .= ' src="./image'. SEP . $v .'"';                
                }
			}else{
				$img .= " $k=\"$v\"";
			}
		}

		$img .= '/>';

		return $img;
	}
}



/**
 * Doctype
 *
 * Generates a page document type declaration
 *
 * Valid options are xhtml-11, xhtml-strict, xhtml-trans, xhtml-frame,
 * html4-strict, html4-trans, and html4-frame.  Values are saved in the
 * doctypes config file.
 *
 * @access	public
 * @param	string	type	The doctype to be generated
 * @return	string
 */
if( !function_exists('html_doctype')){
	function html_doctype($type = 'html5'){
		GLOBAL $DOCTYPE;
		if(isset($DOCTYPE[$type])){
			return $DOCTYPE[$type];
		}else{
			return false;
		}
	}
}



/**
 * Link
 *
 * Generates link to a CSS file
 *
 * @access	public
 * @param	mixed	stylesheet hrefs or an array
 * @param	string	rel
 * @param	string	type
 * @param	string	title
 * @param	string	media
 * @param	boolean	should index_page be added to the css path
 * @return	string
 */
if( !function_exists('html_css')){

	function html_css($href = '' , $index_page = true ){
 
		$link = '';

        if(is_array($href)){            

            foreach ($href AS $v){
                $link .= html_css( $v , $index_page );
			}           

        }else{

            $link = '<link ';

		    if( $index_page === true ){
				$link .= 'href="'. APPLICATION_URL . 'css' . SEP . $href . '" ';
			}else{
                $link .= 'href="css'. SEP . $href.'" ';
			}	
            
            $link .= 'rel="stylesheet" type="text/css" ';
		    $link .= "/>";
        
        }
		return $link;
	}
}




/** 
 * Include js file
 *
 * @access	public
 * @param	mixed	$src stylesheet hrefs or an array
 * @param	boolean	$index_page should index_page be added to the js path
 * @return	string
 */
if( !function_exists('html_js')){

	function html_js( $src = '' , $index_page = true ){ 

        $link = "";
		
        if(is_array($src)){            
			foreach ($src as $v ){
                $link .= html_js( $v , $index_page );
			}

        }else{

            $link = '<script ';
			
            if($index_page === true){                
                $link .= 'src="'. APPLICATION_URL . "js" . SEP . $src.'" ';
            }else{
                $link .= 'src="js' . SEP . $src.'" ';
			
			}

			$link .= ' type="text/javascript" charset="utf-8" ';
 
			$link .= '/>';
            $link .= "</script> ";

        }
		return $link;
	}
}




/**
 * Generates meta tags from an array of key/values
 *
 * @access	public
 * @param	array
 * @return	string
 */
if( !function_exists('html_meta')){

    function html_meta($name = '', $content = '', $type = 'name', $newline = "\n"){

		// Since we allow the data to be passes as a string, a simple array
        // or a multidimensional one, we need to do a little prepping.

		if( !is_array($name)){
            $name = array(array(
                                'name'      => $name, 
                                'content'   => $content, 
                                'type'      => $type, 
                                'newline'   => $newline
                                ));

        }else{

			// Turn single array into multidimensional
			if( isset( $name['name'] ) ){
				$name = array($name);
            }

		}

		$str = '';
		foreach ($name as $meta){
			$type		= ( !isset($meta['type']) OR $meta['type'] == 'name') ? 'name' : 'http-equiv';
			$name		= ( !isset($meta['name']))		? ''	: $meta['name'];
			$content	= ( !isset($meta['content']))	? ''	: $meta['content'];
			$newline	= ( !isset($meta['newline']))	? "\n"	: $meta['newline'];

			$str .= '<meta '.$type.'="'.$name.'" content="'.$content.'" />'.$newline;
		}

		return $str;
	}
}




/**
 * Generates non-breaking space entities based on number supplied
 *
 * @access	public
 * @param	integer
 * @return	string
 */
if( !function_exists('html_nbsp')){
	function html_nbsp($num = 1){
		return str_repeat("&nbsp;", $num);
	}
}




/**
 * Anchor Link
 *
 * Creates an anchor based on the local URL.
 *
 * @access	public 
 * @param	mixed	any attributes
 * @return	string
 */
if( !function_exists('html_a')){
    function html_a( $attributes = ''){ 	

        GLOBAL $DEBUG;

        $label = $attributes['label']; 

        if( isset( $attributes['label'] )){
            unset( $attributes['label'] );
        }

        if( !isset( $attributes['href'] ) ){

            $attributes['href'] = "javascript:void(0);";

        }else if( $DEBUG === true ){

            $attributes['href'] = $attributes['href'] . "&debug=true";

        }

        $attributes = _parse_attributes($attributes);

		return '<a ' . $attributes . '>'. $label.'</a>';
	}
}




/**
 * Anchor Link - Pop-up version
 *
 * Creates an anchor based on the local URL. The link opens a new window 
 *
 * @access	public 
 * @param	mixed $attributes any attributes
 * @return	string
 */
if( !function_exists('html_popup')){
    
    function html_popup( $attributes ){

        $label  = ( isset( $attributes['label'] ) ) ? $attributes['label'] : "" ;
        $url    = ( isset( $attributes['url'] ) )   ? $attributes['url'] : "" ;

        unset( $attributes['url'] );
        unset( $attributes['label'] );
		
        $attributes = _parse_attributes( $attributes );

		return "<a href='javascript:void(0);' onclick=\" popup( '" . $url . "' ); \" $attributes >". $label ."</a>";
	}
}




/**
 * Mailto Link
 *
 * @access	public
 * @param	string	the email address
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
if( !function_exists('html_mailto')){
	function html_mailto($email, $title = '', $attributes = ''){
		$title = (string) $title;

		if($title == ""){
			$title = $email;
		}

		$attributes = _parse_attributes($attributes);

		return '<a href="mailto:'.$email.'"'.$attributes.'>'.$title.'</a>';
	}
}




/**
 * Encoded Mailto Link
 *
 * Create a spam-protected mailto link written in Javascript
 *
 * @access	public
 * @param	string	the email address
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
if( !function_exists('html_safe_mailto')){
	function html_safe_mailto($email, $title = '', $attributes = ''){
		$title = (string) $title;

		if($title == ""){
			$title = $email;
		}

		for ($i = 0; $i < 16; $i++){
			$x[] = substr('<a href="mailto:', $i, 1);
		}

		for ($i = 0; $i < strlen($email); $i++){
			$x[] = "|".ord(substr($email, $i, 1));
		}

		$x[] = '"';

		if($attributes != ''){
			if(is_array($attributes)){
				foreach ($attributes as $key => $val){
					$x[] =  ' '.$key.'="';
					for ($i = 0; $i < strlen($val); $i++){
						$x[] = "|".ord(substr($val, $i, 1));
					}
					$x[] = '"';
				}
			}else{
				for ($i = 0; $i < strlen($attributes); $i++){
					$x[] = substr($attributes, $i, 1);
				}
			}
		}

		$x[] = '>';

		$temp = array();
		for ($i = 0; $i < strlen($title); $i++){
			$ordinal = ord($title[$i]);

			if($ordinal < 128){
				$x[] = "|".$ordinal;
			}else{
				if(count($temp) == 0){
					$count = ($ordinal < 224) ? 2 : 3;
				}

				$temp[] = $ordinal;
				if(count($temp) == $count){
					$number = ($count == 3) ? (($temp['0'] % 16) * 4096) + (($temp['1'] % 64) * 64) + ($temp['2'] % 64) : (($temp['0'] % 32) * 64) + ($temp['1'] % 64);
					$x[] = "|".$number;
					$count = 1;
					$temp = array();
				}
			}
		}

		$x[] = '<'; $x[] = '/'; $x[] = 'a'; $x[] = '>';

		$x = array_reverse($x);
		ob_start();

	?><script type="text/javascript">
	//<![CDATA[
	var l=new Array();
	<?php
	$i = 0;
	foreach ($x as $val){ ?>l[<?php echo $i++; ?>]='<?php echo $val; ?>';<?php } ?>

	for (var i = l.length-1; i >= 0; i=i-1){
	if(l[i].substring(0, 1) == '|') document.write("&#"+unescape(l[i].substring(1))+";");
	else document.write(unescape(l[i]));}
	//]]>
	</script><?php

		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}




?>
