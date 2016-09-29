<?php
/**
 * Created by PhpStorm.
 * User: t.ahmadian
 * Date: 9/28/2016
 * Time: 11:03 AM
 */

//_______________include file
use \Model\DataBase as D;
use \Model\Access as A;
use \Model\Mapper as M;
use \control as Control;

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



//_____________init message
$msg = new Control\generate_message();
$pm = new Control\generate_message();
$valid = new Control\DataValidation();


//______________check_action


 if(isset($_REQUEST['act']) && $_REQUEST['act']!= "" && $_REQUEST['act'] != null) {



     /*
      * *************************************************************************************************
      for this function must use from an array to check GeneralValidation output**************************
     ****************************************************************************************************
     */



     switch ($_REQUEST['act']) {
         case 'login' :
             $essentialArray=array("username"=>true , "password"=>true);
             if(checkEssential($essentialArray)){
                 $validParam=array("username"=>$_REQUEST['username'],"password"=>$_REQUEST['password']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: login code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
            break;
         case 'get_user_profile' :
             $essentialArray=array("id"=>true );
             if(checkEssential($essentialArray)){
                 $validParam=array("id"=>$_REQUEST['id']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: get_user_profile code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         case 'get_user_role' :
             $essentialArray=array("id"=>true );
             if(checkEssential($essentialArray)){
                 $validParam=array("id"=>$_REQUEST['id']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: get_user_role code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         case 'get_user_group' :
             $essentialArray=array("id"=>true );
             if(checkEssential($essentialArray)){
                 $validParam=array("id"=>$_REQUEST['id']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: get_user_group code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         case 'site_user_register' :
             $essentialArray=array("firstname"=>true ,"lastname"=>true,"password"=>true,"mobilenumber"=>true);
             if(checkEssential($essentialArray)){
                 $validParam=array("firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"password"=>$_REQUEST['password'],"mobilenumber"=>$_REQUEST['mobilenumber'],"email"=>$_REQUEST['email']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: site_user_register code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         case 'admin_user_register' :
             $essentialArray=array("firstname"=>true ,"lastname"=>true,"password"=>true,"mobilenumber"=>true);
             if(checkEssential($essentialArray)){
                 $validParam=array("firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"password"=>$_REQUEST['password'],"mobilenumber"=>$_REQUEST['mobilenumber'],"email"=>$_REQUEST['email'],"gender"=>$_REQUEST['gender'],"address"=>$_REQUEST['address'],"region"=>$_REQUEST['region'],"city"=>$_REQUEST['city'],"state"=>$_REQUEST['state']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: admin_user_register code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;

         case 'get_users' :
             //TODO: get_users_code

             break;

         case 'user_active1' :
             $essentialArray=array("id"=>true ,"activecode"=>true);
             if(checkEssential($essentialArray)){
                 $validParam=array("id"=>$_REQUEST['id'],"activecode"=>$_REQUEST['activecode']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: user_active1 code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         case 'user_active2' :
             $essentialArray=array("id"=>true);
             if(checkEssential($essentialArray)){
                 $validParam=array("id"=>$_REQUEST['id']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: user_active2 code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;

         case 'delete_user' :
             $essentialArray=array("id"=>true );
             if(checkEssential($essentialArray)){
                 $validParam=array("id"=>$_REQUEST['id']);
                 $valid->GeneralValidation($validParam,$pm);
                 //TODO: delete_user code
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;


         default:
             $msg->show("invalid data");
     }

 }else{
     $msg->show("Erorr 404 <br> action not set");
 }

 function checkRequest ( $req )
 {
     /*if(isset( $req ) && $req != "" && $req != null ){
         return true;
     }
     else{
         return false;
     }*/

     return ( (isset( $req ) && $req != "" && $req != null ) ? true : false );
 }
 function checkEssential($array){
     $flag=true;
     global $msg;
     foreach($array as $key=>$val){
         if(checkRequest($_REQUEST[$key])==false){
             $essentialArray[$key]=false;
             $msg->show($_REQUEST[$key] ." lost" );
             $flag=false;
         }
     }
     if($flag==false)
         return false;
     return true;
 }
 function showmsg(){

 }