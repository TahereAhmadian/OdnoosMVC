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
             $essentialArray=array("username"=>true , "password"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("username"=>$_REQUEST['username'],"password"=>$_REQUEST['password']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     $access = new A\User();
                     /*
                      * call appropriate access level function(login_user)
                      */
                     $response = $access->login_user($validParam["username"] , $validParam["password"]);
                    //print_r($response);
                     $sent_param=array();//array that should be sent to view layer
                     if(is_array($response)){
                         foreach ($response as $key => $val){
                             $sent_param=array($key=>$val);
                         }
                         echo"**********************************************************";
                        // print_r($sent_param);
                         /*
                          * set session for user and return allowed actions
                          */
                         if(!isset($_SESSION)){
                             session_start();
                             $_SESSION['actions']=$access->get_actions_by_userid($sent_param[0]['UserId']);
                         }
                         $msg->get_data($sent_param[0]);//user information that must be returned
                         //var_dump($_SESSION['actions']);
                     }
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
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     $access = new A\User();
                     /*
                      * check user is allowed
                      */
                     if($allowed = $access->check_user_access_to_action("get_user_profile" ,$_SESSION['actions'] )){
                         //call appropriate access level function(get_user_profile)
                         $response = $access->get_user_profile($validParam["id"]);
                         $msg->get_data($response);//user profile information that must be returned
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
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
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 /*
                  * Initialize optional parameters
                  */
                 $_REQUEST["email"]= ( isset( $_REQUEST["email"] ) ? $_REQUEST["email"] : "" );
                 $_REQUEST["state"]= ( isset( $_REQUEST["state"] ) ? $_REQUEST["state"] : "" );
                 $_REQUEST["city"]= ( isset( $_REQUEST["city"] ) ? $_REQUEST["city"] : "" );
                 $_REQUEST["region"]= ( isset( $_REQUEST["region"] ) ? $_REQUEST["region"] : "" );
                 $_REQUEST["address"]= ( isset( $_REQUEST["address"] ) ? $_REQUEST["address"] : "" );
                 $_REQUEST["gender"]= ( isset( $_REQUEST["gender"] ) ? $_REQUEST["gender"] : "" );

                 $validParam=array("id"=>$_REQUEST['id'],"gender"=>$_REQUEST['gender'],"state"=>$_REQUEST['state'],"city"=>$_REQUEST['city'],"reigon"=>$_REQUEST['region'],"address"=>$_REQUEST['address']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     $access = new A\User();
                     /*
                    * check user is allowed
                    */
                     if($allowed = $access->check_user_access_to_action("set_user_profile" ,$_SESSION['actions'] )){

                         //call appropriate access level function(set_user_profile)
                         if($response = $access->set_user_profile($validParam["id"],$validParam["gender"],$validParam["state"],$validParam["city"],$validParam["reigon"],$validParam["address"])){
                             $msg->show("set user profile information was successful.");
                         }
                         else{
                             $msg->show("set user profile information was unsuccessful!");
                         }
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
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

             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     $access = new A\User();
                     /*
                    * check user is allowed
                    */
                     if($allowed = $access->check_user_access_to_action("get_user_by_id" ,$_SESSION['actions'] )){
                         //call appropriate access level function(get_user_by_id)
                         $response = $access->get_user_by_id($validParam["id"]);
                         $msg->get_data($response);//user profile information that must be returned
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is get_user_role
        */
         case 'get_user_role' :
             //TODO: check access codes
             $essentialArray=array("id"=>true );//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     $access = new A\User();
                     /*
                    * check user is allowed
                    */
                     if($allowed = $access->check_user_access_to_action("get_user_role" ,$_SESSION['actions'] )){
                         //call appropriate access level function(get_user_role)
                         $response = $access->get_user_role($validParam["id"]);
                         $msg->get_data($response);//user profile information that must be returned
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
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
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     $access = new A\User();
                     /*
                    * check user is allowed
                    */
                     if($allowed = $access->check_user_access_to_action("get_user_group" ,$_SESSION['actions'] )){
                         //call appropriate access level function(get_user_group)
                         $response = $access->get_user_group($validParam["id"]);
                         $msg->get_data($response);//user profile information that must be returned
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is site_user_register
        */
         case 'site_user_register' ://username is mobilenumber
             //TODO: check access codes
             $essentialArray=array("firstname"=>true ,"lastname"=>true,"password"=>true,"mobilenumber"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 /*
                  * initializing optional parameters
                  */
                 $_REQUEST["email"]= ( isset( $_REQUEST["email"] ) ? $_REQUEST["email"] : "" );

                 $validParam=array("firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"password"=>$_REQUEST['password'],"mobilenumber"=>$_REQUEST['mobilenumber'],"email"=>$_REQUEST['email']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     $access = new A\User();
                     /*
                   * check user is allowed
                   */
                     if($allowed = $access->check_user_access_to_action("site_user_register" ,$_SESSION['actions'] )){
                         //call appropriate access level function(register_user)
                         $userId=$access->register_user($validParam["mobilenumber"],$validParam["firstname"],$validParam["lastname"],$validParam["password"],$validParam["mobilenumber"],$validParam["email"]);
                         if($userId){
                             $msg->show("user registration was successful.");
                         }
                         else{
                             $msg->show("user registration was unsuccessful!");
                         }
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is admin_user_register
        */
         case 'admin_user_register' ://username is mobilenumber
             //TODO: check access codes
             $essentialArray=array("firstname"=>true ,"lastname"=>true,"password"=>true,"mobilenumber"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 /*
                  * initializing optinal parameters
                  */
                 $_REQUEST["email"]= ( isset( $_REQUEST["email"] ) ? $_REQUEST["email"] : "" );
                 $_REQUEST["state"]= ( isset( $_REQUEST["state"] ) ? $_REQUEST["state"] : "" );
                 $_REQUEST["city"]= ( isset( $_REQUEST["city"] ) ? $_REQUEST["city"] : "" );
                 $_REQUEST["region"]= ( isset( $_REQUEST["region"] ) ? $_REQUEST["region"] : "" );
                 $_REQUEST["address"]= ( isset( $_REQUEST["address"] ) ? $_REQUEST["address"] : "" );
                 $_REQUEST["gender"]= ( isset( $_REQUEST["gender"] ) ? $_REQUEST["gender"] : "" );



                 $validParam=array("firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"password"=>$_REQUEST['password'],"mobilenumber"=>$_REQUEST['mobilenumber'],"email"=>$_REQUEST['email'],"gender"=>$_REQUEST['gender'],"address"=>$_REQUEST['address'],"region"=>$_REQUEST['region'],"city"=>$_REQUEST['city'],"state"=>$_REQUEST['state']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     //call appropriate access level function(register_user)
                     $access = new A\User();
                     /*
                   * check user is allowed
                   */
                     if($allowed = $access->check_user_access_to_action("admin_user_register" ,$_SESSION['actions'] )){
                         //call appropriate access level function(register_user)
                         $userId=$access->register_user($validParam["mobilenumber"],$validParam["firstname"],$validParam["lastname"],$validParam["password"], $validParam["mobilenumber"],$validParam["email"],$validParam["state"],$validParam["city"],$validParam["region"],$validParam["address"],$validParam["gender"]);
                         if($userId){
                             $msg->show("user registration was successful.");
                         }
                         else{
                             $msg->show("user registration was unsuccessful!");
                         }
                     }
                     else{

                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
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
             if(!isset($_SESSION)) {
                 session_start();
             }
             $access = new A\User();
             /*
             * check user is allowed
             */
             if($allowed = $access->check_user_access_to_action("get_users" ,$_SESSION['actions'] )){
                 //call appropriate access level function(register_user)
                 $response = $access->get_users();
                 //print_r($response);
                 $sent_param=array();//array that should be sent to view layer other parameters has been sifted
                 foreach ($response as $key=>$val){
                     $sent_param[]=array("FirstName"=>$val['FirstName'],"LastName"=>$val['LastName'],"Email"=>$val['Email'],"CreationDate"=>$val['CreationDate'],"Gender"=>$val['Gender']);
                 }
                 echo"********************************************************** </br>";
                 //print_r($sent_param);

                 $msg->get_data($sent_param);//user profile information that must be returned

             }
             else{
                 $msg->show("you are not allowed for this action!");
             }
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
         case 'user_active' :
             //TODO: check access codes
             $essentialArray=array("id"=>true ,"activecode"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id'],"activecode"=>$_REQUEST['activecode']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }

                     $access = new A\User();
                     /*
                     * check user is allowed
                     */
                     if($allowed = $access->check_user_access_to_action("admin_user_active" ,$_SESSION['actions'] )){
                         //call appropriate access level function(activate_user)
                         //TODO: please correct bellow code
                         /*if($access->activate_user2($validParam["id"],($validParam["activecode"])){
                             $msg->show("user activation was successful.");
                         }
                         else{
                             $msg->show("The user is already active!");
                         }*/
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         /*
         * if act is user_active2 (adminstrator activation)
        */
         case 'admin_user_active' :
             //TODO: check access codes
             $essentialArray=array("id"=>true);//array that show which one of the parameters is essential
             if($check->checkEssential($essentialArray , $_REQUEST)){
                 $validParam=array("id"=>$_REQUEST['id']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     $access = new A\User();
                     /*
                     * check user is allowed
                     */
                     if($allowed = $access->check_user_access_to_action("admin_user_active" ,$_SESSION['actions'] )){
                         //call appropriate access level function(activate_user)
                         if($access->activate_user($validParam["id"])){
                             $msg->show("user activation was successful.");
                         }
                         else{
                             $msg->show("The user is already active!");
                         }
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
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
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     //call appropriate access level function(deactivate_user)
                     $access = new A\User();
                     /*
                     * check user is allowed
                     */
                     if($allowed = $access->check_user_access_to_action("user_deactive" ,$_SESSION['actions'] )){
                         //call appropriate access level function(deactivate_user)
                         if($access->deactivate_user($validParam["id"])==1)
                         {
                             $msg->show("user deactivation was successful.");
                         }
                         else{
                             $msg->show("user deactivation was unsuccessful!");
                         }
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
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
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     //call appropriate access level function(delete_user_by_id)
                     $access = new A\User();
                     /*
                    * check user is allowed
                    */
                     if($allowed = $access->check_user_access_to_action("delete_user" ,$_SESSION['actions'] )){
                         //call appropriate access level function(deactivate_user)
                         if( $access->delete_User_By_Id($validParam["id"]) ){
                             $msg->show("user deletion was successful.");
                         }
                         else{
                             $msg->show("user is not exists!");
                         }
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
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
                 /*
                  * initializing optinal parameters
                  */
                 $_REQUEST["firstname"]= ( isset( $_REQUEST["firstname"] ) ? $_REQUEST["firstname"] : "" );
                 $_REQUEST["lastname"]= ( isset( $_REQUEST["lastname"] ) ? $_REQUEST["lastname"] : "" );
                 $_REQUEST["email"]= ( isset( $_REQUEST["email"] ) ? $_REQUEST["email"] : "" );
                 $_REQUEST["mobilenumber"]= ( isset( $_REQUEST["mobilenumber"] ) ? $_REQUEST["mobilenumber"] : "" );


                 $validParam=array("id"=>$_REQUEST['id'],"firstname"=>$_REQUEST['firstname'],"lastname"=>$_REQUEST['lastname'],"email"=>$_REQUEST['email'],"mobilenumber"=>$_REQUEST['mobilenumber']);//inputs that should be check for data validity
                 if($valid->GeneralValidation($validParam,$msg))
                 {
                     if(!isset($_SESSION)) {
                         session_start();
                     }
                     $access = new A\User();
                     /*
                   * check user is allowed
                   */
                     if($allowed = $access->check_user_access_to_action("delete_user" ,$_SESSION['actions'] )){

                         //call appropriate access level function(deactivate_user)
                         if( $access->edit_user($validParam["id"],$validParam["firstname"],$validParam["lastname"],$validParam["email"],$validParam["mobilenumber"]) ){
                             $msg->show("edit user essential information was successful.");
                         }
                         else{
                             $msg->show("edit user essential information was unsuccessful!");
                         }
                     }
                     else{
                         $msg->show("you are not allowed for this action!");
                     }
                 }
                 else{
                     $msg->show("all of input parameters are not valid!");
                 }
             }
             else{
                 $msg->show("essential parameters not set, please check!");
             }
             break;
         case 'edit_password' :
             //TODO: check access codes
            // echo $_REQUEST['password'];
             $essentialArray=array("id"=>true,"password"=>true,"confirmPassword"=>true);//array that show which one of the parameters is essential
             if ($check->checkEssential($essentialArray , $_REQUEST)) {
                 if($_REQUEST["password"]==$_REQUEST["confirmPassword"]) {
                     $validParam = array("id" => $_REQUEST['id'], "password" => $_REQUEST['password']);//inputs that should be check for data validity
                     if ($valid->GeneralValidation($validParam, $msg)) {
                         if(!isset($_SESSION)) {
                             session_start();
                         }
                         $access = new A\User();
                         /*
                       * check user is allowed
                       */
                         if($allowed = $access->check_user_access_to_action("edit_password" ,$_SESSION['actions'] )){
                             //call appropriate access level function(edit_user_password)
                             if ($access->edit_user_password($validParam["id"], $validParam["password"])) {
                                 $msg->show("edit password was successful.");
                             } else {
                                 $msg->show("edit password was unsuccessful!");
                             }
                         }
                         else{
                             $msg->show("you are not allowed for this action!");
                         }
                     }
                     else{
                         $msg->show("all of input parameters are not valid!");
                     }
                 }
                 else{
                     $msg->show("password and confirm password must be equal!");
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