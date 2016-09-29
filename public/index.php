<?php
use \Model\DataBase as D;
use \Model\Access as A;
use \Model\Mapper as M;

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



/*
 * test in database
*/

//$abstrctDB = new  Model\DataBase\DataBase();
//$abstrctDB->test();



/*
 * test in access level
 */
$access = new A\User();
$access->show();

?>