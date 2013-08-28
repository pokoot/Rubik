<?php  

if ( ! defined("BASE_PATH")) exit("No direct script access allowed");

/**
 * A - Add
 * E - Edit
 * D - Delete
 * S - Save 
 * 
 * @package 
 * @version $id$
 * @author Harold Kim Cantil 
 * @license http://pokoot.com/license.txt
 */
interface Aeds{
    function add();
    function edit();
    function delete();
    function save();
}

?>
