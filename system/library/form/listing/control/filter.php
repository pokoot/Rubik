<?php

namespace Library\Form\Listing\Control;

class Filter implements \Library\Form\Action {

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function validate(){
    }

    public function filter(){       
        // renders html
        return "filter";
    }
}


?>
