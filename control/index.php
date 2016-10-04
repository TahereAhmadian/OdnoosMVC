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



//_____________init message
$msg = new C\generate_message();
$valid = new C\DataValidation();
$check = new C\check_input();


//______________check_action


 if(isset($_REQUEST['act']) && $_REQUEST['act']!= "" && $_REQUEST['act'] != null) {



     /*
      * *************************************************************************************************
      for this function must use from an array to check GeneralValidation output**************************
     ****************************************************************************************************
     */



     switch ($_REQUEST['act']) {
         /*
          * if act is login
         */
         case 'login' :
             //TODO: check access codes
             $essentialArray=array("username"=>true , "password"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("username"=>$_REQUEST['username'],"password"=>$_REQUEST['password']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(login_user)
                     $access = new A\User();
                     var_dump($access->login_user($validParam["username"] , $validParam["password"]));
                     //http://odnoosmvc.local/control/?act=login&username=aramy&password=123456789
                     //TODO: login code
                 }

             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
            break;
         /*
         * if act is get_user_profile
        */
         case 'get_user_profile' :
             //TODO: check access codes
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(get_user_profile)
                     $access = new A\User();
                     var_dump($access->get_user_profile($validParam["id"]));
                     //http://odnoosmvc.local/control/?act=get_user_profile&id=2
                     //TODO: get_user_profile code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is get_user_profile
        */
         case 'set_user_profile' :
             //TODO: check access codes
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id'],"gender"=>$_REQUEST['gender'],"state"=>$_REQUEST['state'],"city"=>$_REQUEST['city'],"reigon"=>$_REQUEST['region'],"address"=>$_REQUEST['address']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(set_user_profile)
                     $access = new A\User();
                     var_dump($access->set_user_profile($validParam["id"],$validParam["gender"],$validParam["state"],$validParam["city"],$validParam["reigon"],$validParam["address"]));
                     //http://odnoosmvc.local/control/?act=set_user_profile&id=2
                     //TODO: get_user_profile code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is get_user_by_id
        */
         case 'get_user_by_id' :
             //TODO: check access codes
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(get_user_by_id)
                     $access = new A\User();
                     var_dump($access->get_user_by_id($validParam["id"]));
                     //view-source:http://odnoosmvc.local/control/?act=get_user_by_id&id=2
                     //TODO: get_user_by_id code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is get_user_roles
        */
         case 'get_user_roles' :
             //TODO: check access codes
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(get_user_roles)
                     $access = new A\User();
                     var_dump($access->get_user_roles($validParam["id"]));
                     //http://odnoosmvc.local/control/?act=get_user_roles&id=2
                     //TODO: get_user_role code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is get_user_groups
        */
         case 'get_user_group' :
             //TODO: check access codes
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(get_user_groups)
                     $access = new A\User();
                     var_dump($access->get_user_groups($validParam["id"]));
                     //http://odnoosmvc.local/control/?act=get_user_groups&id=2
                     //TODO: get_user_group code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is site_user_register
        */
         case 'site_user_register' :
             //TODO: check access codes
             $essentialArray=array("firstname"=>true ,"lastname"=>true,"password"=>true,"mobilenumber"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"password"=>$_REQUEST['password'],"mobilenumber"=>$_REQUEST['mobilenumber'],"email"=>$_REQUEST['email']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(register_user)
                     $access = new A\User();
                     var_dump($access->register_user("ahmad",$validParam["firstname"],$validParam["lastname"],$validParam["password"],$validParam["mobilenumber"],$validParam["email"]));
                     //TODO: site_user_register code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is admin_user_register
        */
         case 'admin_user_register' :
             //TODO: check access codes
             $essentialArray=array("firstname"=>true ,"lastname"=>true,"password"=>true,"mobilenumber"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"password"=>$_REQUEST['password'],"mobilenumber"=>$_REQUEST['mobilenumber'],"email"=>$_REQUEST['email'],"gender"=>$_REQUEST['gender'],"address"=>$_REQUEST['address'],"region"=>$_REQUEST['region'],"city"=>$_REQUEST['city'],"state"=>$_REQUEST['state']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(register_user)
                     $access = new A\User();
                     var_dump($access->register_user("amir",$validParam["firstname"],$validParam["lastname"],$validParam["password"],$validParam["mobilenumber"],$validParam["email"]),$validParam["state"],$validParam["city"],$validParam["region"],$validParam["address"],$validParam["gender"]);
                     //TODO: admin_user_register code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is get_users
        */
         case 'get_users' ://no input is necessary
             //TODO: check access codes
             //call appropriate access level function(get_users)
             $access = new A\User();
             $response = $access->get_users();
             print_r($response);
             $sent_param=array();//array that should be sent to view layer other parameters has been sifted
             foreach ($response as $key=>$val){
                 $sent_param[]=array("FirstName"=>$val['FirstName'],"LastName"=>$val['LastName'],"Email"=>$val['Email'],"CreationDate"=>$val['CreationDate'],"Gender"=>$val['Gender']);
             }
             echo"**********************************************************";
             print_r($sent_param);

             //TODO: get_users_code

             break;
         case 'search_users' :
             //TODO: check access codes
             //TODO: parameters not complete!
                 $validParam=array("firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"email"=>$_REQUEST['email'],"mobilenumber"=>$_REQUEST['mobilenumber'],"gender"=>$_REQUEST['gender']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(search_user)

                     //TODO: search_user code
                 }

             break;
         /*
         * if act is user_active1 (user activation)
        */
         case 'user_active1' :
             //TODO: check access codes
             $essentialArray=array("id"=>true ,"activecode"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id'],"activecode"=>$_REQUEST['activecode']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function()

                     //TODO: user_active1 code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is user_active2 (adminstrator activation)
        */
         case 'user_active2' :
             //TODO: check access codes
             $essentialArray=array("id"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(activate_user)
                     $access = new A\User();
                     if($access->activate_user($validParam["id"])){
                         $msg->show("user activation was successful.");
                     }
                     else{
                         $msg->show("The user is already active!");
                     }
                     //http://odnoosmvc.local/control/?act=user_active2&id=7
                     //TODO: user_active2 code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is user_deactive
        */
         case 'user_deactive' :
             //TODO: check access codes
             $essentialArray=array("id"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(deactivate_user)
                     $access = new A\User();
                     if($access->deactivate_user($validParam["id"])==1)
                     {
                         $msg->show("user deactivation was successful.");
                     }
                     else{
                         $msg->show("user deactivation was not successful!");
                     }
                     //http://odnoosmvc.local/control/?act=user_deactive&id=7
                     //TODO: user_active2 code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is delete_user
        */
         case 'delete_user' :
             //TODO: check access codes
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     //call appropriate access level function(delete_user_by_id)
                     $access = new A\User();
                     if( $access->delete_User_By_Id($validParam["id"])==1 ){
                         $msg->show("user deletion was successful.");
                     }
                     else{
                         $msg->show("user is not exists!");
                     }
                     //http://odnoosmvc.local/control/?act=delete_user&id=7
                     //TODO: delete_user code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         case 'edit_user' :
             //TODO: check access codes
             $essentialArray=array("id"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id'],"firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"email"=>$_REQUEST['email'],"mobilenumber"=>$_REQUEST['mobilenumber']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     $access = new A\User();
                     if( $access->edit_user($validParam["id"],$validParam["firstname"],$validParam["lastname"],$validParam["email"],$validParam["mobilenumber"]) ){
                         $msg->show("edit user essential information was successful.");
                     }
                     else{
                         $msg->show("edit user essential information was unsuccessful!");
                     }
                     //TODO: edit_user code
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;

         /*
         * if act is not defined
        */
         default:
             $msg->show("invalid data");
     }

 }else{
     $msg->show("Erorr 404 <br> action not set");
 }

/* function checkRequest ( $req )
 {


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
 }*/
 function showmsg(){

 }