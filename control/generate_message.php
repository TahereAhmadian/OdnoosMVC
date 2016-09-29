<?php
namespace control;
/**
 * Created by PhpStorm.
 * User: t.ahmadian
 * Date: 9/28/2016
 * Time: 11:37 AM
 */
class generate_message
{

    public function show($text=null , $title=null  , $btn=null){

        $msg = array("act"=>"message","text"=>$text , "title" => $title , "btn"=>$btn);

        echo json_encode($msg);
    }
}

class button_message{

    public $ok = "ok";
    public $cancel = "cancel";
    public $yes = "yes";
    public $no = "no";
}