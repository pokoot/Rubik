<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * This helper classes are used in
 * - helper.form.php
 * - helper.html.php
 */





/**
 * Parse out the attributes
 *
 * Some of the functions use this
 *
 * @access  private
 * @param   array
 * @param   bool
 * @return  string
 */
if( !function_exists('_parse_attributes')){
    function _parse_attributes($attributes, $javascript = false){
        if(is_string($attributes)){
            return ($attributes != '') ? ' '.$attributes : '';
        }

        $att = '';
        foreach ($attributes as $key => $val){
            if($javascript == true){
                $att .= $key . '=' . $val . ',';
            }else{
                $att .= ' ' . $key . '="' . $val . '"';
            }
        }

        if($javascript == true AND $att != ''){
            $att = substr($att, 0, -1);
        }

        return $att;
    }
}




/**
 * Parse the form attributes
 *
 * Helper function used by some of the form helpers
 *
 * @access  private
 * @param   array
 * @param   array
 * @return  string
 */
if( !function_exists('_parse_form_attributes')){
    function _parse_form_attributes($attributes, $default){
        if(is_array($attributes)){
            foreach ($default as $key => $val){
                if(isset($attributes[$key])){
                    $default[$key] = $attributes[$key];
                    unset($attributes[$key]);
                }
            }

            if(count($attributes) > 0){
                $default = array_merge($default, $attributes);
            }
        }

        $att = '';

        foreach ($default as $key => $val){
            if($key == 'value'){
                $val = form_prep($val, $default['name']);
            }

            $att .= $key . '="' . $val . '" ';
        }

        return $att;
    }
}



/**
 * Attributes To String
 *
 * Helper function used by some of the form helpers
 *
 * @access  private
 * @param   mixed
 * @param   bool
 * @return  string
 */
if( !function_exists('_attributes_to_string')){
    function _attributes_to_string($attributes, $formtag = false){
        if(is_string($attributes) AND strlen($attributes) > 0){
            if($formtag == true AND strpos($attributes, 'method=') === false){
                $attributes .= ' method="post"';
            }

            if($formtag == true AND strpos($attributes, 'accept-charset=') === false){
                $attributes .= ' accept-charset="'.strtolower( CHARSET ).'"';
            }

            return ' '.$attributes;
        }

        if(is_object($attributes) AND count($attributes) > 0){
            $attributes = (array)$attributes;
        }

        if(is_array($attributes) AND count($attributes) > 0){
            $atts = '';

            if( !isset($attributes['method']) AND $formtag === true){
                $atts .= ' method="post"';
            }

            if( !isset($attributes['accept-charset']) AND $formtag === true){
                $atts .= ' accept-charset="'.strtolower( CHARSET ).'"';
            }

            foreach ($attributes as $key => $val){
                $atts .= ' '.$key.'="'.$val.'"';
            }

            return $atts;
        }
    }
}



?>
