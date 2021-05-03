<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$App = core::getInstance();

$App->AuthTable = "usuarios";


$App->get('index', function ()
{
    $this->data->set("rand",rand(111,999) );
    $this->parser->parse(BASEPATH."sdk/index.html", $this->data->get());
});

/**
 * Login
 * 
 */
#request-login#
$App->get('auth-login', function () {

    if( !$this->input->has_post() ) die('{"status":false, "message":"URL invalida"}');

    $post = $this->input->post();

    if(!$post->user || !$post->pass) die('{"status":false, "message":"Debe completar los campos"}');

    $rs = $this->db->query 
    (" 
        SELECT 
            id 
        FROM 
            {$this->AuthTable} 
        WHERE 
            user = '{$post->user}' AND 
            pass = MD5('{$post->pass}')  
        LIMIT 1 ");

    foreach($rs->result() as $row)
    { 
        $this->session->send( $row->id );

        die('{"status":true}');
    }

    die('{"status":false, "message":"Usuario y/o password invalido"}');
});
#/request-login#

/**
 * Logout
 * 
 */
#request-logout#
$App->get('auth-logout', function ($rid="")
{
    $this->session->close();

    die('{"status":false}');
});
#/request-logout#

/**
 * Online
 * 
 */
#request-online#
$App->get("auth-online", function ($rid="")
{
    $how = $this->session->recv() == FALSE ? 'false' : 'true' ;
    
    die('{"status":'.$how.($how=='false'?',"message":"Termino el tiempo de session"':'').'}');
});