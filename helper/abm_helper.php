<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');


function function_list  ($table)
{
    return function($rid="") use ($table)
    {   
        die( QUERYJS($this,  "SELECT * FROM {$table}") );
    };
}

function function_row  ($table)
{
    return function($id, $rid="") use ($table)
    {   
        $id = (int)$id;

        if($id<1) die("id invalid");

        die( QUERYSON ($this,  "SELECT * FROM {$table} WHERE id = {$id}") );
    };
}

function function_delete($table)
{
    return function($id, $rid="") use ($table)
    {
        $id = (int)$id;

        if($id > 0)
        {
            $this->db->query( DELETE($table, $id) );

            die('{"status":"OK"}'); 
        }
        else
        {
            die('{"status":"FAIL"}');
        }
    };
}

function function_update($table) 
{
    return function($rid="") use ($table)
    {
        if( $this->input->has_post() )
        { 
            $post = $this->input->post(); 

            if( isset($post->pass ) ) if($post->pass =="") unset($post->pass);   

            if( isset($post->id))
            {
                //update
                $id = $post->id; unset($post->id);

                $this->db->query( UPDATE( $table, $post, $id ) );

                die('{"result": "ok", "type":"update", "id":"'.$id.'"}');
            }
            else
            {  
                $sql =  INSERT( $table, $post );

                $sql = str_replace("(''", "('", $sql );
                $sql = str_replace("'')", "')", $sql );

                //insert 
                $this->db->query( $sql );

                $id = $this->db->last_id();

                die('{"result": "ok", "type":"insert", "id":"'.$id.'"}');
            }
        }
        else
        {
            die('{"result": "error", "message":"el post no contiene datos"}');
        }
    };
}

function function_one   ($table)
{
    return function($rid="") use ($table)
    { 
        $rs = $this->db->show_column($table);

        $output = new stdclass;

        foreach ($rs->result() as $row) 
        { 
            switch ($row->DATA_TYPE) {
                case 'int'    : 
                case 'tinyint': $output->{$row->COLUMN_NAME}=0;  break;  
                default       : $output->{$row->COLUMN_NAME}=""; break;
            }           
        }

        die(json_encode($output));
    };
}

function function_combo ($table)
{
    return function( $rid="" ) use ($table)
    {  
        if(isset($_GET["filter"]))
        { 
            $data = QUERYJS($this, "SELECT id, nombre AS 'value' FROM {$table} WHERE nombre LIKE '%".$_GET["filter"]["value"]."%' ORDER BY nombre ASC "  );
        }
        else
            $data = QUERYJS($this, "SELECT id, nombre AS 'value' FROM {$table} ORDER BY nombre ASC "  );

        die( $data );
    };
}