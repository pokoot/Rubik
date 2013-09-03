<?php

namespace Library\Form\Listing\Control;

class Search implements \Library\Form\Action {

    private $search;

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function validate(){
    }

    public function search(){        
        return "search";
    }
}


?>
