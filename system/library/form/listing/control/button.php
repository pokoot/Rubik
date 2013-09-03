<?php

namespace Library\Form\Listing\Control;

class Button implements \Library\Form\Action {

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function validate(){
    }

    public function button(){        
        // renders html
        return "search";
    }
}


?>
