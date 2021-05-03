<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Tero Framework 
 *
 * @link      https://github.com/dromero86/tero
 * @copyright Copyright (c) 2014-2021 Daniel Romero
 * @license   https://github.com/dromero86/tero/blob/master/LICENSE (MIT License)
 */    
$App = core::getInstance();  
 
$App->get("crunch-css", function ()
{
    $this->crunch->build();
});

$App->get("databot", function($rid="")
{   
	$this->schema->load();
    $this->schema->start_server(); 
});