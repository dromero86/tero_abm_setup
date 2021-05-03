<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

$App = core::getInstance(); 


$rs  = $this->db->show_tables(); 

foreach ($rs->result() as $row) 
{ 
    $o = function_one   ($row->TABLE_NAME);
    $l = function_list  ($row->TABLE_NAME);
    $r = function_row   ($row->TABLE_NAME);
    $d = function_delete($row->TABLE_NAME);
    $u = function_update($row->TABLE_NAME);
    $c = function_combo ($row->TABLE_NAME);

    $App->get("{$row->TABLE_NAME}-one"   , $o );
    $App->get("{$row->TABLE_NAME}-row"   , $r );
    $App->get("{$row->TABLE_NAME}-list"  , $l );
    $App->get("{$row->TABLE_NAME}-delete", $d );
    $App->get("{$row->TABLE_NAME}-update", $u );
    $App->get("{$row->TABLE_NAME}-combo" , $c );
} 