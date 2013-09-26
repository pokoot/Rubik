<?php

namespace Library\Form\Listing;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Query implements \Library\Form\Action{

    private $display;
    private $total;
    private $select;
    private $from;
    private $where;
    private $group;
    private $order;

    public $config;

    public function __construct( $config ){

        $this->config = $config;

        $this->display  = element( "display" , $config );
        $this->total    = element( "total" , $config );
        $this->select   = element( "select" , $config );
        $this->from     = element( "from" , $config );
        $this->where    = element( "where" , $config );
        $this->group    = element( "group" , $config );
        $this->order    = element( "order" , $config );
    }

    public function validate(){
    }

    public function query(){        
    }
    
}

?>
