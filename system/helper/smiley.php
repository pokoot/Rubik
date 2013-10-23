<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );



/**
 * Smiley Javascript
 *
 * Returns the javascript required for the smiley insertion.  Optionally takes
 * an array of aliases to loosely couple the smiley array to the view.
 *
 * @access  public
 * @param   mixed   alias name or array of alias->field_id pairs
 * @param   string  field_id if alias name was passed in
 * @return  array
 */
if( !function_exists('smiley_js')){
    function smiley_js($alias = '', $field_id = '', $inline = true){
        static $do_setup = true;

        $r = '';

        if($alias != '' && ! is_array($alias)){
            $alias = array($alias => $field_id);
        }

        if($do_setup === true){
                $do_setup = false;

                $m = array();

                if(is_array($alias)){
                    foreach ($alias as $name => $id){
                        $m[] = '"'.$name.'" : "'.$id.'"';
                    }
                }

                $m = '{'.implode(',', $m).'}';

                $r .= <<<EOF
                var smiley_map = {$m};

                function insert_smiley(smiley, field_id) {
                    var el = document.getElementById(field_id), newStart;

                    if( ! el && smiley_map[field_id]) {
                        el = document.getElementById(smiley_map[field_id]);

                        if( ! el)
                            return false;
                    }

                    el.focus();
                    smiley = " " + smiley;

                    if('selectionStart' in el) {
                        newStart = el.selectionStart + smiley.length;

                        el.value = el.value.substr(0, el.selectionStart) +
                                        smiley +
                                        el.value.substr(el.selectionEnd, el.value.length);
                        el.setSelectionRange(newStart, newStart);
                    }
                    else if(document.selection) {
                        document.selection.createRange().text = smiley;
                    }
                }
EOF;
        }else{
            if(is_array($alias)){
                foreach ($alias as $name => $id){
                    $r .= 'smiley_map["'.$name.'"] = "'.$id.'";'."\n";
                }
            }
        }

        if($inline){
            return '<script type="text/javascript" charset="utf-8">/*<![CDATA[ */'.$r.'// ]]></script>';
        }else{
            return $r;
        }
    }
}


/**
 * Get Clickable Smileys
 *
 * Returns an array of image tag links that can be clicked to be inserted
 * into a form field.
 *
 * @access  public
 * @param   string  the URL to the folder containing the smiley images
 * @return  array
 */
if( !function_exists('smiley_get_clickable')){
    function smiley_get_clickable($image_url, $alias = '' ){

        GLOBAL $SMILEY;
        // Add a trailing slash to the file path if needed
        $image_url = rtrim($image_url, '/').'/';

        $used = array();
        foreach ($SMILEY as $key => $val){
            // Keep duplicates from being used, which can happen if the
            // mapping array contains multiple identical replacements.  For example:
            // :-) and :) might be replaced with the same image so both smileys
            // will be in the array.
            if(isset($used[$SMILEY[$key][0]])){
                continue;
            }

            $link[] = "<a href=\"javascript:void(0);\" onclick=\"insert_smiley('".$key."', '".$alias."')\"><img src=\"".$image_url.$SMILEY[$key][0]."\" width=\"".$SMILEY[$key][1]."\" height=\"".$SMILEY[$key][2]."\" alt=\"".$SMILEY[$key][3]."\" style=\"border:0;\" /></a>";

            $used[$SMILEY[$key][0]] = true;
        }

        return $link;
    }
}


/**
 * Parse Smileys
 *
 * Takes a string as input and swaps any contained smileys for the actual image
 *
 * @access  public
 * @param   string  the text to be parsed
 * @param   string  the URL to the folder containing the smiley images
 * @return  string
 */
if( !function_exists('smiley_parse')){
    function smiley_parse($str = '', $image_url = '', $smileys = NULL){
        GLOBAL $SMILEY;
        if($image_url == ''){
            return $str;
        }

        // Add a trailing slash to the file path if needed
        $image_url = preg_replace("/(.+?)\/*$/", "\\1/",  $image_url);

        foreach ($SMILEY as $key => $val){
            $str = str_replace($key, "<img src=\"".$image_url.$SMILEY[$key][0]."\" width=\"".$SMILEY[$key][1]."\" height=\"".$SMILEY[$key][2]."\" alt=\"".$SMILEY[$key][3]."\" style=\"border:0;\" />", $str);
        }

        return $str;
    }
}


/**
 * JS Insert Smiley
 *
 * Generates the javascript function needed to insert smileys into a form field
 *
 * DEPRECATED as of version 1.7.2, use smiley_js instead
 *
 * @access  public
 * @param   string  form name
 * @param   string  field name
 * @return  string
 */
if( !function_exists('smiley_insert_js')){
    function smiley_insert_js($form_name = '', $form_field = ''){
        return <<<EOF
<script type="text/javascript">
    function insert_smiley(smiley)
    {
        document.{$form_name}.{$form_field}.value += " " + smiley;
    }
</script>
EOF;
    }
}



?>
