<?php

namespace Library\Form\Listing\Control;

class Grid{

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function grid(){       
        // renders html        
        
        $object = new \Library\Form\Listing\Control\Grid\Text( $this->yaml );
        $object->render();

        return "grid";
    }
}


?>
