<?php
use \Model\Access as A;
use \Model\Mapper as M;
use \control as C;

define('APPLICATION_PATH', realpath('../'));


$paths = array(
        APPLICATION_PATH,
        get_include_path()
);
set_include_path(implode(PATH_SEPARATOR, $paths));

function __autoload($className)
{
    $filename = str_replace('\\', '/' , $className) . '.php';
    require_once $filename;

}
$c=new C\index();
$c->callfunction();
//$access=new A\User();
//print_r($access->get_users());
echo "hi";
?>