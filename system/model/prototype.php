<?php   

namespace Model;

if ( ! defined('BASE_PATH')) exit('No direct script access allowed.');

class Prototype extends \Library\Model{

    public $name = "Prototype";

    public function all(){
        print "<br/> holy cow ";
    }
    
}

?>
