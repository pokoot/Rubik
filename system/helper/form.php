<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );

/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @access  public
 * @param   mixed $attributes
 * @return  string
 */
if( !function_exists('form_open')){
    function form_open( $attributes , $misc = '' ){

        GLOBAL $DEBUG;

        $debug_action = '';

        if( isset( $attributes['method'] ) ) {
            $attributes['method'] = "post";
        }

        if( !isset( $attributes['id'] ) ){
            $attributes['id'] = $attributes['name'];
        }



        if( !isset( $attributes['action'] ) ){

            $break = explode( '/' , $_SERVER["PHP_SELF"] );

            $action = $break[count($break) - 1] ;

            // hide index.php
            if( $action == "index.php" ){
                $action = "";
            }

            $action .= "?module=" . get( "module" , "login" );

            $attributes['action'] = $action ;


        }


        // ADD THE DEBUG FLAG
        if( $DEBUG ){
            $debug_action = "&debug=true";
        }

        $attributes['action'] .= $debug_action;



        $form = '<form ';

        $form .= _attributes_to_string($attributes, true);

        $form .= $misc;

        $form .= '>';

        return $form;
    }
}




/**
 * Form Close Tag
 *
 * @access  public
 * @param   string
 * @return  string
 */
if( !function_exists('form_close')){
    function form_close($extra = ''){
        return "</form>".$extra;
    }
}




/**
 * Hidden Input Field
 *
 * Generates hidden fields.  You can pass a simple key/value string or an associative
 * array with multiple values.
 *
 * @access  public
 * @param   mixed
 * @param   string
 * @return  string
 */
if( !function_exists('form_hidden')){

    function form_hidden( $attributes , $misc = '' ){

        $defaults = array(
            'type'  => 'hidden',
            'name'  => (( !is_array( $attributes ) ) ? $attributes : '' ) ,
            'id'    => (( !is_array( $attributes ) ) ? $attributes : '' ) ,
            'value' => (( !is_array( $attributes ) ) ? $attributes : '' )
        );

        return "<input "._parse_form_attributes( $attributes , $defaults ) ." $misc />";

    }

}




/**
 * Text Input Field
 *
 * @access  public
 * @param   mixed
 * @param   string
 * @param   string
 * @return  string
 */
if( !function_exists('form_input')){
    function form_input( $data , $misc = '' ){
        $defaults = array(
            'type'  => 'text',
            'name'  => (( !is_array($data)) ? $data : ''),
            'id'    => (( !is_array($data)) ? $data : ''),
            'value' => (( !is_array($data)) ? $data : '')
        );

        return "<input "._parse_form_attributes($data, $defaults) ." $misc />";
    }
}




/**
 * Password Field
 *
 * Identical to the input function but adds the "password" type
 *
 * @access  public
 * @param   mixed
 * @param   string
 * @param   string
 * @return  string
 */
if( !function_exists('form_password')){
    function form_password($data = '' , $misc = '' ){
        if( !is_array($data)){
            $data = array(
                'name'  => $data ,
                'id'    => $data
            );
        }

        $data['type'] = 'password';

        return form_input( $data , $misc );
    }
}




/**
 * Upload Field
 *
 * Identical to the input function but adds the "file" type
 *
 * @access  public
 * @param   mixed
 * @param   string
 * @param   string
 * @return  string
 */
if( !function_exists('form_upload')){
    function form_upload( $data ){

        // FILE
        $attributes = array(
            "name"      => $data["name"] ,
            "id"        => $data["id"] ,
            "type"      => "file" ,
            "size"      => 30 ,
            "onchange"  => " form_upload( '{$data["name"]}' ); "
        );

        $html_file = form_input( $attributes );

        // INPUT
        $attributes = array(
            "name"      => "temp_" . $data["name"] ,
            "id"        => "temp_" . $data["id"] ,
            "class"     => "w250"
        );


        $html_input = form_input( $attributes );


        // IMAGE
        $attributes = array(
            "src"   => "image.php?f=browse.png" ,
            "alt"   => "Browse"
        );

        $html_image = html_img( $attributes );


        $html = "
            <div class='upload_container'>
                $html_file
                <div class='form_upload'>
                    $html_input
                    $html_image
                </div>
            </div>
        ";

        return $html;
    }
}



/**
 * Todo See nicedit
 * What I want to achieve is a textarea not div if possible
 * html_js( "textarea" )'
 *
 *
 * @access public
 * @param mixed $data
 * @return void
*/
if( !function_exists('form_rich_textarea')){

    function form_rich_textarea( $data ){
        return form_textarea( $data );
    }
}


/**
 * Textarea field
 *
 * @access public
 * @param array $data
 * @return string
 */
if( !function_exists('form_textarea')){

    function form_textarea( $data , $misc = '' ){

        $defaults = array(
            'name'  => (( !is_array($data)) ? $data : '') ,
            'id'    => (( !is_array($data)) ? $data : '') ,
            'cols'  => '59',
            'rows'  => '6'
        );

        // COUNTER

        if( isset( $data["counter"] ) && $data["counter"] == true  ){

            $limit = ( isset( $data["limit"] )  ) ? $data["limit"] : 5000;

            // The prefix "counter__" should be used to avoid conflict on naming conventions

            $data['onkeydown']  = " form_counter( '{$data['name']}' , 'counter__{$data['name']}' , $limit ); ";
            $data['onkeyup']    = " form_counter( '{$data['name']}' , 'counter__{$data['name']}' , $limit ); ";

            $counter_html = "
                                <div class='w200' >
                                    <label id='counter__{$data["name"]}' >
                                        $limit Characters Left
                                    </label>
                                    <input type='hidden' id='counter_limit__{$data['name']}' value='$limit'>
                                </div>";

        }else{
            $counter_html = "";
        }

        $val = trim( $data['value'] );

        if( isset( $val ) ){
            unset( $data['value']);
        }

        $html = "
                <div class='form_textarea'>
                    <textarea ". _parse_form_attributes( $data , $defaults ) ." $misc >" . form_prep( $val, $data['name'] ) ."</textarea>
                    $counter_html
                </div>";

        return $html;
    }
}




/**
 * Multi-select menu
 *
 * @access  public
 * @param   array
 * @return  type
 */
if( !function_exists('form_multiselect')){
    function form_multiselect( $data , $misc = '' ){
        $data["multiple"] = "multiple";
        return form_select( $data , $misc = '' );
    }
}




/**
 * Drop-down Menu
 *
 * @access  public
 * @param   array
 */
if( !function_exists('form_select')){
    function form_select( $data , $misc = '' ){

        $name       = $data["name"];
        $id         = $data["id"];
        $options    = $data["options"];
        $selected   = $data["selected"];

        $defaults = array(
            'name'  => (( !is_array($data)) ? $data : ''),
            'id'    => (( !is_array($data)) ? $data : '')
        );


        unset( $data["options"] );

        unset( $data["selected"] );


        $form = '<select ' . _parse_form_attributes( $data , $defaults) . " $misc >\n";

        if( $options ){

            foreach( $options as $key => $val){

                $key = (string) $key;

                if(is_array($val) && !empty($val)){

                    $form .= '<optgroup label="'.$key.'">'."\n";

                    foreach ( $val as $optgroup_key => $optgroup_val ){

                        if( is_array( $selected ) ){
                            $sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';
                        }else{
                            $sel = ( $optgroup_key == $selected ) ? ' selected="selected" ' : "";
                        }

                        $form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
                    }

                    $form .= '</optgroup>'."\n";
                }else{

                    if( is_array( $selected ) ){
                        $sel = (in_array($key, $selected)) ? ' selected="selected"' : '';
                    }else{
                        $sel = ( $key == $selected ) ? ' selected="selected" ' : "";
                    }

                    $form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
                }
            }

        }

        $form .= "</select>";

        return $form;
    }
}




/**
 * Checkbox Field
 *
 * @access  public
 * @param   array
 * @return  string
 */
if( !function_exists('form_checkbox')){
    function form_checkbox( $data , $misc = '' ){

        $defaults = array(
            "type"      => "checkbox" ,
            "id"        => ( ( !is_array($data)) ? $data : "") ,
            "name"      => ( ( !is_array($data)) ? $data : "") ,
            "value"     => ( ( !is_array($data)) ? $data : "" )
        );



        if( isset( $data['label'] ) ){

            $attributes = array(
                "label" => $data["label"] ,
                "id"    => $data["id"] ,
            );

            $label = form_label( $attributes );

        }else{
            $label = "";
        }

        unset( $data['label'] );


        return "<input " . _parse_form_attributes( $data , $defaults ) . " $misc />$label";
    }
}




/**
 * Radio Button
 *
 * @access  public
 * @param   mixed
 * @param   string
 * @param   bool
 * @param   string
 * @return  string
 */
if( !function_exists( "form_radio" )){
    function form_radio( $data , $misc = '' ){
        $data['type'] = 'radio';
        return form_checkbox( $data , $misc = '' );
    }
}




/**
 * Submit Button
 *
 * @access  public
 * @param   mixed
 * @param   string
 * @param   string
 * @return  string
 */
if( !function_exists('form_submit')){
    function form_submit( $data , $misc  = '' ){
        $defaults = array(
            'type'  => 'submit',
            'name'  => (( !is_array($data)) ? $data : ''),
            'id'    => (( !is_array($data)) ? $data : ''),
            'value' => (( !is_array($data)) ? $data : ''),
        );

        return "<input "._parse_form_attributes($data, $defaults) . " $misc />";
    }
}




/**
 * Reset Button
 *
 * @access  public
 * @param   mixed
 * @param   string
 * @param   string
 * @return  string
 */
if( !function_exists('form_reset')){
    function form_reset($data , $misc = '' ){
        $defaults = array(
            'type'  => 'reset',
            'name'  => (( !is_array($data)) ? $data : ''),
            'id'    => (( !is_array($data)) ? $data : ''),
            'value' => (( !is_array($data)) ? $data : ''),
        );
        return "<input "._parse_form_attributes($data, $defaults). " $misc />";
    }
}




/**
 * Form Label Tag
 *
 * @access  public
 * @param   string  The text to appear onscreen
 * @param   string  The id the label applies to
 * @param   string  Additional attributes
 * @return  string
 */
if( !function_exists('form_label')){
    function form_label( $data , $misc = '' ){

        $label = $data["label"];

        $defaults = array(
            'for' => (( !is_array($data)) ? $data : $data["id"] ),
        );

        unset( $data["label"] );
        unset( $data["id"] );

        return "<label "._parse_form_attributes( $data , $defaults). " $misc />" . $label . "</label>";
    }
}




/**
 * Fieldset Tag
 *
 * Used to produce <fieldset><legend>text</legend>.  To close fieldset
 * use form_fieldset_close()
 *
 * @access  public
 * @param   string  The legend text
 * @param   string  Additional attributes
 * @return  string
 */
if( !function_exists('form_fieldset')){
    function form_fieldset( $attributes , $misc = '' ){

        $legend = $attributes["legend"];

        unset( $attributes["legend"] );

        $fieldset = "<fieldset";
        $fieldset .= _attributes_to_string($attributes, false);
        $fieldset .= " $misc >\n";

        if( $legend != ''){
            $fieldset .= "<legend>$legend</legend>\n";
        }

        return $fieldset;
    }
}




/**
 * Fieldset Close Tag
 *
 * @access  public
 * @param   string
 * @return  string
 */
if( !function_exists('form_fieldset_close')){
    function form_fieldset_close(){
        return "</fieldset>";
    }
}




/**
 * Form Prep
 *
 * Formats text so that it can be safely placed in a form field in the event it has HTML tags.
 *
 * @access  public
 * @param   string
 * @return  string
 */
if( !function_exists('form_prep')){
    function form_prep($str = '', $field_name = ''){
        static $prepped_fields = array();

        // if the field name is an array we do this recursively
        if(is_array($str)){
            foreach ($str as $key => $val){
                $str[$key] = form_prep($val);
            }
            return $str;
        }

        if( $str === ''){
            return '';
        }

        // we've already prepped a field with this name
        // @todo need to figure out a way to namespace this so
        // that we know the *exact* field and not just one with
        // the same name
        if(isset($prepped_fields[$field_name])){
            return $str;
        }

        $str = htmlspecialchars($str);

        // In case htmlspecialchars misses these.
        $str = str_replace(array("'", '"'), array("&#39;", "&quot;"), $str);

        if($field_name != ''){
            $prepped_fields[$field_name] = $field_name;
        }

        return $str;
    }
}




/**
 * Form Value
 *
 * Grabs a value from the POST array for the specified field so you can
 * re-populate an input field or textarea.  If Form Validation
 * is active it retrieves the info from the validation class
 *
 * @access  public
 * @param   string
 * @return  mixed
 */
/*
if( !function_exists('set_value')){
    function set_value($field = '', $default = ''){
        if( !isset($_POST[$field])){
            return $default;
        }
        return form_prep($_POST[$field], $field);
    }
}
 */



/**
 * Set Select
 *
 * Let's you set the selected value of a <select> menu via data in the POST array.
 * If Form Validation is active it retrieves the info from the validation class
 *
 * @access  public
 * @param   string
 * @param   string
 * @param   bool
 * @return  string
 */
/*
if( !function_exists('set_select')){
    function set_select($field = '', $value = '', $default = false){

        if( !isset($_POST[$field])){
            if(count($_POST) === 0 AND $default == true){
                return ' selected="selected"';
            }
            return '';
        }

        $field = $_POST[$field];

        if(is_array($field)){
            if( !in_array($value, $field)){
                return '';
            }
        }else{
            if(($field == '' OR $value == '') OR ($field != $value)){
                return '';
            }
        }

        return ' selected="selected"';

    }
}
 */



/**
 * Set Checkbox
 *
 * Let's you set the selected value of a checkbox via the value in the POST array.
 * If Form Validation is active it retrieves the info from the validation class
 *
 * @access  public
 * @param   string
 * @param   string
 * @param   bool
 * @return  string
 */
/*
if( !function_exists('set_checkbox')){
    function set_checkbox($field = '', $value = '', $default = false){

        if( !isset($_POST[$field])){
            if(count($_POST) === 0 AND $default == true){
                return ' checked="checked"';
            }
            return '';
        }

        $field = $_POST[$field];

        if(is_array($field)){
            if( !in_array($value, $field)){
                return '';
            }
        }else{
            if(($field == '' OR $value == '') OR ($field != $value)){
                return '';
            }
        }
        return ' checked="checked"';
    }
}
 */




/**
 * Set Radio
 *
 * Let's you set the selected value of a radio field via info in the POST array.
 * If Form Validation is active it retrieves the info from the validation class
 *
 * @access  public
 * @param   string
 * @param   string
 * @param   bool
 * @return  string
 */
/*
if( !function_exists('set_radio')){
    function set_radio($field = '', $value = '', $default = false){
        if( !isset($_POST[$field])){
            if(count($_POST) === 0 AND $default == true){
                return ' checked="checked"';
            }
            return '';
        }

        $field = $_POST[$field];

        if(is_array($field)){
            if( !in_array($value, $field)){
                return '';
            }
        }else{
            if(($field == '' OR $value == '') OR ($field != $value)){
                return '';
            }
        }

        return ' checked="checked"';
    }
}
 */




/**
 * Renders 1 html calendar
 *
 * @access public
 * @param array $data
 * @return string
 */
if( !function_exists('form_calendar')){

    function form_calendar( $attributes ){

        if( isset( $attributes['show_time'] ) && $attributes['show_time'] == true ){

            $show_time = true;

            if( isset( $attributes['day_first'] ) && $attributes['day_first'] == false ){
                $format = '%m-%d-%Y %I:%M %p';
            }else{
                $format = '%d-%m-%Y %I:%M %p';
            }

        // DEFAULT
        }else{

            $show_time  = false;

            if( isset( $attributes['day_first'] ) && $attributes['day_first'] == false ){
                $format = '%m-%d-%Y';
            }else{
                $format = '%d-%m-%Y';
            }

        }


        $img_properties = array(
            "src"   => "image.php?f=calendar.png" ,
            "id"    => "calendar_{$attributes['name']}" ,
            "name"  => "calendar_{$attributes['name']}"
        );

        $image = html_img( $img_properties , true );


        $show_time_flag = ( $show_time == true ) ? 'true' : 'false' ;

        $js = "
                <script type='text/javascript'>
                    Calendar.setup({
                        inputField      : '{$attributes['name']}',
                        ifFormat        : '{$format}',
                        showsTime       :  {$show_time_flag} ,
                        timeFormat      : '12' ,
                        button          : 'calendar_{$attributes['name']}',
                        align           : 'B2',
                        singleClick     : true
                    });
                </script>
               ";


        $input_properties = array(
            'name'        => $attributes['name'] ,
            'id'          => $attributes['name'] ,
            'value'       => isset( $attributes['value'] ) ? $attributes['value'] : ""  ,
            'maxlength'   => ( $show_time == true ) ? '16' : '10' ,
            'readonly'    => 'readonly'
        );

        if( !empty( $attributes["disabled"] ) ){
            $input_properties["disabled"] = "disabled";
        }

        if( empty( $attributes['class'] ) ){
            $input_properties["class"] = "form_calendar";
        }else{
            $input_properties["class"] = $attributes['class'];
        }

        $input = form_input( $input_properties );


        $attributes = array(
            "label" => $image
        );

        return $input . html_a( $attributes ) . $js;
    }
}




/**
 * Renders 1 css button base on button.css
 *
 * @access public
 * @param array $data
 * @return string
 */
if( !function_exists('form_button') ){

    function form_button( $attributes ){

        $label = isset( $attributes['label'] ) ? $attributes['label'] : "" ;
        $color = isset( $attributes['color'] ) ? strtolower( $attributes['color'] ) : "gray" ;
        $class = isset( $attributes['class'] ) ? strtolower( $attributes['class'] ) : "" ;
        $image = isset( $attributes['image'] ) ? $attributes['image'] : "" ;

        $label = __( $label , false );

        if( $image ){

            $image_attributes = array(
                        "src"       => $image ,
                        "height"    => "14" ,
                        "width"     => "14"
            );
            $image = html_img( $image_attributes );
        }


        unset( $attributes['label'] );
        unset( $attributes['color'] );
        unset( $attributes['image'] );
        unset( $attributes['class'] );

        $render = ( $label ) ? $label : $image;

        $attributes = _parse_attributes( $attributes );

        $print = "<span class='button button_" . $color . " " . $class . "' "  . $attributes ." >" . $render . "</span>";

        return $print;
    }

}


?>
