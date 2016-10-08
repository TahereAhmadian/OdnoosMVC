<?php
/**
 * Created by PhpStorm.
 * User: hedi
 * Date: 9/24/16
 * Time: 2:51 PM
 */
namespace Model\Access;
use Model\Mapper as M;
use Model\DataBase as D;

// limitation for password control
define('password_count_limit' , 5 );

class User
{
    protected $dataBase = null;

    public function __construct()
    {
        date_default_timezone_set('Asia/Tehran');
        $this->dataBase = new D\DataBase();
    }


     /*find a user based on a specific property like id
     *
     */
    public function get_user_by_id( $id )
    {
        //check id validity
        if( !$this->checkId( $id ) )
            return "Err get user by id: id is not valid";

        //create a new Instance from UserFullDataMapper
        $MapperInstance = new M\UserFullDataMapper( $this->dataBase );

        // create an array for user id
        $condition = array( 'UserId' => $id );

        // prepare input field fro find the user by it's Id
        $condition = $this->prepareCondition( $condition );
        //find and return user
        return $MapperInstance->find( $condition  );


    }

    /*
     *
     *find a user based on a specific property like id , property passed by an array
     * Usage:  $this->getUserByProperty( array('FirstName' , 'Foo') );
     *
     */
    public function get_users( $FirstName='' , $LastName='' , $Email='', $Telephone='', $StateId='' , $CityId='' ,$RegionId='' , $Gender='', $isLogin='' , $isDelete ='' , $isActive = '' )
    {
        // condition is an empty array at first
        $condition = array();

        // set values for search if parameter is set
        ($FirstName == '' ?  : $condition['FirstName'] = $FirstName) ;
        ($LastName == '' ?  : $condition['LastName'] = $LastName) ;
        ($Email == '' ?  : $condition['Email'] = $Email) ;
        ($Telephone == '' ?  : $condition['Telephone'] = $Telephone) ;
        ($StateId == '' ?  : $condition['StateId'] = $StateId) ;
        ($CityId == '' ?  : $condition['CityId'] = $CityId) ;
        ($RegionId == '' ?  : $condition['RegionId'] = $RegionId) ;
        ($Gender == '' ?  : $condition['Gender'] = $Gender) ;
        ($isLogin == '' ?  : $condition['IsLogin'] = $isLogin) ;
        ($isDelete == '' ?  : $condition['IsDelete'] = $isDelete) ;
        ($isActive == '' ?  : $condition['IsActive'] = $isActive) ;


        $fields='*';

        $MapperInstance = new M\UserFullDataMapper( $this->dataBase );

        // prepare condition string for where
        $condition = $this->prepareConditionAdvSearch( $condition );

        return $MapperInstance->find($condition ) ;
    }

    /*
 *
 *find a user based on a specific property like id , property passed by an array
     *
 *
 */
    public function search_users( $FirstName='' , $LastName='' , $Email='', $Telephone='', $Gender='', $AccountType='' , $ClubName='' , $FromDate='' , $ToDate='' )
    {
        // condition is an empty array at first
        $condition = array();

        // set values for search if parameter is set
        ($FirstName == '' ?  : $condition['FirstName'] = $FirstName) ;
        ($LastName == '' ?  : $condition['LastName'] = $LastName) ;
        ($Email == '' ?  : $condition['Email'] = $Email) ;
        ($Telephone == '' ?  : $condition['Telephone'] = $Telephone) ;
        ($Gender == '' ?  : $condition['Gender'] = $Gender) ;
        //($AccountType == '' ?  : $condition['AccountType'] = $AccountType) ;
        //($ClubName == '' ?  : $condition['ClubName'] = $ClubName) ;
        //($FromDate == '' ?  : $condition['FromDate'] = $FromDate) ;
        //($ToDate == '' ?  : $condition['ToDate'] = $ToDate) ;
        //TODO: this should be review

        $fields='*';

        $MapperInstance = new M\UserFullDataMapper( $this->dataBase );

        // prepare condition string for where
        $condition = $this->prepareConditionAdvSearch( $condition );

        return $MapperInstance->find($condition ) ;
    }




    /*
     * update user main data
     *
     */
    public function edit_user( $UserId , $FirstName = '' , $LastName = '' , $Email = '' , $Telephone='' )
    {
        // check user id
        if( !$this->checkId( $UserId ) )
        {
            return "Err edit User: user id is not valid";
        }

        // if no parameter sent , return
        if( $FirstName == '' && $LastName == '' && $Email == '' && $Telephone = '' )
        {
            return "msg edit user: you should specify at least one parameter";
        }

        // create data for update
        $data = array();
        ($FirstName == '' ?  : $data['FirstName'] = $FirstName );
        ($LastName == '' ?  : $data['LastName'] = $LastName );
        ($Email == '' ?  : $data['Email'] = $Email );
        ($Telephone == '' ?  : $data['Telephone'] = $Telephone );

        // create new instance from user mapper
        $MapperInstance = new M\UsersMapper( $this->dataBase );

        // create condition
        $where = "id=". $UserId;
        //update user data
        return $MapperInstance->update( $data , $where );
    }

    /*
     * edit password user
     *
     */
    public function edit_user_password( $UserId , $Password )
    {
        //check user id
        if( !$this->checkId( $UserId ))
            return "msg edit password: user id is not valid";
        // check password to be set
        if( !isset( $Password ) )
        {
            return "msg password edit: password not set";
        }
        //create new instance from user mapper
        $UserMapper = new M\UsersMapper( $this->dataBase );
        //create data array
        $data = array();
        //TODO:  edit Password
        $data['password'] =  $Password;
        //create condition
        $condition = "id=".$UserId;
        // update user password
        return $UserMapper->update( $data , $condition );
    }

    /*
     *
     * insert new user to DB
     */
    public function register_user($userName , $firstName , $lastName , $password , $telephone , $Email=''  , $stateId = '' , $cityId  = '' , $regionId = '' , $address = '' , $gender = '' , $otherPhone = array()  )
    {
        $MapperInstance = new M\UsersMapper( $this->dataBase );

        $property = array( 'UserName'=>$userName , 'FirstName'=>$firstName , 'LastName'=> $lastName , 'Password'=> $password , 'Email'=>$Email , 'Telephone'=> $telephone , 'CreationDate'=>date('Y-m-d h:i:s'));

        $UserId = $MapperInstance->insert( $property );

        // if user registerEd to users table then do other codes
        if( $UserId > 0 )
        {

            // INSERT USER PROFILE
            $profileProperty = array();

            $profileMapper  = new M\UserProfileMapper( $this->dataBase);

            $profileProperty['CityId'] = $cityId ;
            $profileProperty['StateId'] = $stateId ;
            $profileProperty['RegionId'] = $regionId ;
            $profileProperty['Address'] = $address ;
            $profileProperty['Gender'] = $gender ;
            $profileProperty['UserId'] = $UserId;
            $profileProperty['CreationDate'] = date('Y-m-d h:i:s');

            $profileMapper->insert($profileProperty);


            // INSERT USER HISTORY

            $UserHistoryMapper = new M\UserHistoryMapper( $this->dataBase );

            $UserHistoryProperty = array();
            $UserHistoryProperty['UserId'] = $UserId;
            $UserHistoryProperty['LastLogin'] = date('Y-m-d h:i:s');
            $UserHistoryProperty['IsActive'] =  '0';
            $UserHistoryProperty['LostPasswordControl'] = '0';
            $UserHistoryProperty['IsDelete'] = '0';
            $UserHistoryProperty['StartSession'] = date('Y-m-d h:i:s');
            $UserHistoryProperty['IsLogin'] = '0';
            $UserHistoryProperty['CreateBy'] = $UserId;
            $UserHistoryProperty['CreationDate'] = date('Y-m-d h:i:s');
            var_dump( $UserHistoryProperty );

            $UserHistoryMapper->insert( $UserHistoryProperty );

            // insert other phones for this User
            if( sizeof( $otherPhone ) > 0 )
            {
                //create instance of tel mapper
                $TelsMapper = new M\TelsMapper( $this->dataBase );
                //for each phone number, iterate one time more
                foreach ( $otherPhone as $key => $phoneItem )
                {
                    $data = array();
                    $data['UserId'] = $UserId;
                    $data['Telephone'] = $phoneItem;
                    $data['CreationDate'] = date('Y-m-d h:i:s');

                    $TelsMapper->insert( $data );

                }

            }
        }

        return $UserId;
    }



    /*
     *
     *  delete user by by id
     *  we don't delete any user data, ,we just disable it
     */
    public function delete_User_By_Id( $id )
    {
        //check id validity
        if( !$this->checkId( $id ) )
            return "Err delete user by id: id is not valid";

        //create new instance of User History
        $MapperInstance = new M\UserHistoryMapper( $this->dataBase );

        // create an array for condition
        $condition = array();

        $condition['UserId'] = $id;

        //prepare condition
        $where = $this->prepareCondition( $condition );

        // parameter that should update
        $property = array( 'IsDelete' => '1' );

        return $MapperInstance->update( $property , $where );
    }


    /*
     *  activate user
     */
    public function activate_user( $UserId )
    {
        //check id validity
        if( !$this->checkId( $UserId ) )
            return "Err activate user: id is not valid";
        //create new instance of user history
        $MapperInstance = new M\UserHistoryMapper( $this->dataBase );

        // create an array for condition
        $condition = array();

        $condition['UserId'] = $UserId;

        //prepare condition
        $where = $this->prepareCondition( $condition );

        //User should be active
        $property = array( 'IsActive' => 1 );

        return $MapperInstance->update( $property , $where );
    }

    /*
     *  deactivate user, condition is array
     */
    public function deactivate_user( $UserId )
    {

        //check id validity
        if( !$this->checkId( $UserId ) )
            return "Err deactivate user: id is not valid";

        $MapperInstance = new M\UserHistoryMapper( $this->dataBase );

        $condition['UserId'] = $UserId;

        $where = $this->prepareCondition( $condition );

        $property = array( 'IsActive' => 0 );

        return $MapperInstance->update( $property , $where );
    }


    /*
     *  get actions for a specific user
     */
    public function get_actions_by_userid( $UserId )
    {

        // create new instance of user action mapper
        $UserActionsMapper = new M\UserActionsMapper( $this->dataBase );
        // set condition for find actions of this user
        $condition = "UserId=". $UserId;
        //find actions
        $ActionList = $UserActionsMapper->find( $condition );
        //return actions
        return $ActionList;
    }

    /*
     * check a user have access to an action
     */
    public function check_user_access_to_action( $actionName , $ActionList  )
    {

        //create new instance from action mappers
        $actionMapper = new M\ActionsMapper( $this->dataBase );

        //find id of this actionName
        if( !$result = $actionMapper->find ( "ActionName='".$actionName."'" ) )
        {
          // echo "msg check user access: there is no action for your action name";
            return false;
        }

        $actionId = ($result[0] ? $result[0]['id'] : null );
        // if no id found return
        if( $actionId == null ) return false;


        //var_dump( $actionId );
        ($ActionList[0] == null ?  : $UserActions = $ActionList[0]['Actions'] );
        // make an array of action ids to find access to action
        $actions = explode(',' , $UserActions );
        //search in actions array
        foreach ( $actions as $action )
        {
            // if access exists , return true
            if( $actionId == $action )
                return true;
        }
        // there is no access to this action, return false
        return false;
    }


    /*
     * check if a username is valid in database
     */
    protected function check_username_exists( $UserName )
    {
        // create new instance of User mapper
        $UserMapper = new M\UsersMapper( $this->dataBase );

        // create condition
        $condition = array();

        $condition['UserName'] = $UserName;

        // prepare condition
        $condition = $this->prepareCondition( $condition );

        //check existence of username
        $User = $UserMapper->find( $condition );

        return ( $User ? $User[0]['id'] : 0 );
    }

    /*
     * check username and password if is valid, if is valid return id of user pass
     */
    public function check_username_password_valid( $UserName , $Password )
    {
        // create new instance of User mapper
        $UserMapper = new M\UsersMapper( $this->dataBase );

        // create condition
        $condition = array();

        $condition['UserName'] = $UserName;
        $condition['Password'] = $Password;

        // prepare condition
        $condition = $this->prepareCondition( $condition );

        //check existence of username and password
        $result = $UserMapper->find( $condition );
        //var_dump( $result );
        return  ($result ? $result[0]['id'] : 0 ) ;
    }

    /*
     *
     * check lostControlpassword , if it exceeds from limit , block the user
     */
    protected function check_user_lost_control_password ( $UserId )
    {
        //check id validity
        if( !$this->checkId( $UserId ) )
            return "Err check user lost password: id is not valid";

        $UserHistoryMapper = new M\UserHistoryMapper( $this->dataBase );

        // create condition for load
        $condition = array();
        $condition['UserId'] = $UserId;
        $condition = $this->prepareCondition( $condition );

        // load user history
        $userHistory = $UserHistoryMapper->find( $condition );

        //update user history

        /*
         *increment lost password control for user
         *limitation for password count
         */

        $data = array();
        // set new passwordControl value
        $data['LostPasswordControl'] = intval( $userHistory[0]['LostPasswordControl'] ) + 1 ;
        // check if user should be block (based on limitation) block him
        $data['IsActive'] = ( $data['LostPasswordControl'] < password_count_limit ? 1 : 0 );

        // update user history
        return $UserHistoryMapper->update( $data , $condition );

    }



    /*
     * login for user
     * inputs: username and password
     */
    public function login_user( $username , $password )
    {

        // check if the username registered on system
        if( !( $UId = $this->check_username_exists( $username ) ) )
        {
            //if username not registerd return message and exit
            return "Err login: This Username have not registered";
        }

        //check validity of username and password in the system
        if( !($UserId = intval( $this->check_username_password_valid( $username , $password ) ) )   )
        {
            // check password control
            $this->check_user_lost_control_password( $UId );

            return "Err login: Your username and password not correct";
        }

        // get action list for UserId
        if ( !$ActionList = $this->get_actions_by_userid( $UserId ) )
            return "msg login: no action list found for this user";

        // check (action list) access for login
        if( !$this->check_user_access_to_action( 'login' , $ActionList ) )
        {
            // no access to login
            return "Err login: You have not access to login in system";
        }

        // create a new instance from userFullData ( VIEW )
        $UserFullDataMapper = new M\UserFullDataMapper( $this->dataBase );

        //set condition for load user full data when he login
        $condition = $this->prepareCondition( array( 'UserId' => $UserId , 'IsDelete' => '0' ) );

        // load user full data from view
        $UserFullData = $UserFullDataMapper->find( $condition ) ;


        // account is not deleted , so check if user is deactivate or not
        if( $UserFullData )
        {

            // use account blocked
            if( $UserFullData[0]['IsActive'] == 0 )
            {
                return "msg login : your account has been blocked";
            }

            // user exists and is active, he can login
            else
            {

                //update user history for this user
                $UserHistoryMapper = new M\UserHistoryMapper( $this->dataBase );

                // crate condition for update user history
                $condition = array();
                $condition ["UserId"] = $UserId;

                // create array for user history
                $data = array();

                // reset lost password control
                $data['LostPasswordControl'] = 0;
                // set islogin to 1
                $data['isLogin'] = 1;
                //set Start session to login time
                $data['StartSession'] = date("Y-m-d h:i:s");
                //update last login to now
                $data['LastLogin'] = date("Y-m-d h:i:s");

                // prepare condition
                $condition = $this->prepareCondition( $condition );
                //update user history fields
                $update = $UserHistoryMapper->update( $data , $condition );


                //echo "OK: Your login was successful";

                // login is successful , return data
                return $UserFullData;
            }
        }
        // account is deleted
        else
        {

            return "msg login: your account has been deleted before";

        }

    }

    /*
     * logout
     */
    public function logout_user($UserId )
    {
        //check user id
        if( !$this->checkId( $UserId ) )
            return "msg logout: User id is not valid";

        //create new instance from
        $UserHistoryMapper = new M\UserHistoryMapper( $this->dataBase );

        // create data for update
        $data = array();
        $data['IsLogin'] = '0';
        // create condition
        $condition = "UserId=".$UserId;
        // update logout
        return $UserHistoryMapper->update( $data , $condition );
    }

    /*
     * get user profile
     */
    public function get_user_profile( $UserId )
    {
        // check user id
        if( !$this->checkId( $UserId ) )
            return "Err get user profile: Id is not valid";

        // create a mapper to userprofile
        $UserProfileMapper = new M\UserProfileMapper(  $this->dataBase );
        //find profile by id
        return $UserProfileMapper->findById( $UserId );


    }

    /*
     * get user role
     */
    public function get_user_role( $UserId )
    {
        // check user id
        if( !$this->checkId( $UserId ) )
            return "Err get user role: Id is not valid";

        // create a new instance from GetUsersRolesMapper
        $GetUsersRoleMapper = new M\GetUsersRolesMapper( $this->dataBase );

        // create condition for find roles
        $condition = $this->prepareCondition( array( 'UserId' => $UserId ) );

        // find and return an array from UserRoles
        return $GetUsersRoleMapper->find( $condition );
    }

    /*
     * get user groups
     */
    public function get_user_group( $UserId )
    {
        // check user id
        if( !$this->checkId( $UserId ) )
            return "Err get user group: Id is not valid";

        // create a new instance from GetUsersGroupsMapper
        $GetUserGroupsMapper = new M\GetUsersGroupsMapper( $this->dataBase );

        // create condition for find groups
        $condition = $this->prepareCondition( array( 'UserId' => $UserId ) );

        // find and return an array from UserGroups
        return $GetUserGroupsMapper->find( $condition );
    }


    /*
     *  set User Profile
     */
    public function  set_user_profile ( $UserId , $Gender='' , $StateId='' , $CityId='' , $RegionId='' , $Address='' )
    {
        // check user id
        if( !$this->checkId( $UserId ) )
            return "Err set user profile: Id is not valid";

        // create a new instance from GetUsersGroupsMapper
        $UserProfileMapper = new M\UserProfileMapper( $this->dataBase );

        // create condition for insert profile
        $data = array();
        $data['UserId'] = $UserId;
        $data['Gender'] = $Gender;
        $data['stateId'] = $StateId;
        $data['CityId'] = $CityId;
        $data['RegionId'] = $RegionId;
        $data['Address'] = $Address;
        $data['CreationDate'] = date('Y-m-d h:i:s');

        // insert data to user profile
        return $UserProfileMapper->insert( $data );
    }

    /*
     * set user roles
     */
    public function set_user_role(  $UserId , $RoleId )
    {
        // check user id
        if( !$this->checkId( $UserId ) )
            return "Err get user role: user id is not valid";

        // check role id
        if( !$this->checkId( $RoleId ) )
            return "Err get user role: role id is not valid";

        //create new instance of UserRoleMapper
        $UserRole = new M\UserRoleMapper( $this->dataBase );

        // prepare data into array for insert
        $data = array();
        $data['UserId'] = $UserId;
        $data['RoleId'] = $RoleId;

        return $UserRole->insert( $data );

    }



    /*
     * edit user profile
     */
    public function edit_user_profile( $UserId , $Gender='' , $StateId='' , $CityId='' , $RegionId='' , $Address='' )
    {

        if( $Gender === '' && $StateId === '' && $CityId === '' && $RegionId === '' && $Address === '')
        {
            return "You should specify at least one parameter";
        }
        if( !$this->checkId( $UserId ) )
            return "Err edit_user_profile: User Id is not valid";

        // create a new instance from GetUsersGroupsMapper
        $UserProfileMapper = new M\UserProfileMapper( $this->dataBase );

        // find user profile id
        if( !($result = $UserProfileMapper->find( 'UserId = '.$UserId ) ) )
        {
            return "Err edit user profile: no Valid user for this id";
        }

        // set profile id
        $ProfileId = $result[0]['id'];


        // create condition for update profile
        $condition = array();

        // set parameters in array just if a valid data passed to function
        ($Gender === '' ?  : $condition['Gender'] = $Gender) ;
        ($StateId === '' ?  : $condition['StateId'] = $StateId) ;
        ($CityId === '' ?  : $condition['CityId'] = $CityId) ;
        ($RegionId === '' ?  : $condition['RegionId'] = $RegionId) ;
        ($Address === '' ?  : $condition['Address'] = $Address) ;

        // update data to user profile
        return $UserProfileMapper->update( $condition , 'Id ='.$ProfileId );
    }

    /*
     * set role
     */
    public function set_role($RoleName , $RoleDescription )
    {
        // create new instance from RoleMapper
        $RoleMapper = new M\RolesMapper( $this->dataBase );

        // create an array for data that inserted to roles
        $data = array();
        // add data fro setting role
        $data['Name'] = $RoleName;
        $data['Description'] = $RoleDescription;

        // insert role to table
        return $RoleMapper->insert( $data );

    }

    /*
     * get role
     */
    public function get_role( $RoleId )
    {
        // check role id
        if( !$this->checkId( $RoleId ) )
            return "Err get role: role id is not valid";

        // create new instance from RoleMapper
        $RoleMapper = new M\RolesMapper( $this->dataBase );

        // find role by id
        return $RoleMapper->findById( $RoleId );

    }

    /*
     * edit role
     */
    public function edit_role( $RoleId , $RoleName = '' , $RoleDescription = '')
    {
        if( $RoleName === '' && $RoleDescription === '')
        {
            return "You should specify at least one parameter";
        }
        //check role id validity
        if( !$this->checkId( $RoleId ) )
            return "Err edit_role: Role Id is not valid";

        // create new instance from RoleMapper
        $RoleMapper = new M\RolesMapper( $this->dataBase );

        // create array of condition
        $condition = array();
        ($RoleName == '' ?  : $condition['Name'] = $RoleName) ;
        ($RoleDescription == '' ?  : $condition['Description'] = $RoleDescription) ;

        //update
        return $RoleMapper->update( $condition , 'id='.$RoleId );


    }

    /*
     *  set action
     */

    public function set_action( $ActionName , $ActionDescription )
    {
        // create new instance from ActionMapper
        $ActionMapper = new M\ActionsMapper( $this->dataBase );

        // create an array for data that inserted to roles
        $data = array();
        // add data fro setting Action
        $data['ActionName'] = $ActionName;
        $data['Description'] = $ActionDescription;

        // insert Action to table
        return $ActionMapper->insert( $data );
    }

    /*
     *  get action
     */

    public function get_action( $ActionId )
    {
        // check action id
        if( !$this->checkId( $ActionId ) )
            return "Err get action: action id is not valid";

        // create new instance from action mapper
        $ActionMapper = new M\ActionsMapper( $this->dataBase );

        // find action by id
        return $ActionMapper->findById( $ActionId );

    }

    /*
     * edit action
     */
    public function edit_action( $ActionId , $ActionName='' , $ActionDescription ='')
    {
        if( $ActionName === ''  && $ActionDescription === '' )
            return 'Edit Action: You should specify at least One parameter';

        //Check action id validity
        if( !$this->checkId( $ActionId ) )
            return "Err edit_action: action Id is not valid";

        // create new instance from RoleMapper
        $ActionMapper = new M\ActionsMapper( $this->dataBase );

        // create array of condition
        $condition = array();
        ($ActionName == '' ?  : $condition['ActionName'] = $ActionName) ;
        ($ActionDescription == '' ?  : $condition['Description'] = $ActionDescription) ;

        //update
        return $ActionMapper->update( $condition , 'id='.$ActionId );
    }


    /*
     * delete action
     */
    public function delete_action( $ActionId)
    {

        if( !$this->checkId( $ActionId ))
            return "Err delete action: action id is not valid";
        //create new instance of action mapper
        $ActionMapper = new M\ActionsMapper( $this->dataBase );
        //prepare condition
        $conition = 'id='.$ActionId;
        //delete action
        return $ActionMapper->delete( $conition );

    }

    /*
     * set role action
     */
    public function set_role_action( $RoleId , $ActionId )
    {
        if( $ActionId == '' )
            return;
        if( !$this->checkId( $ActionId ))
            return "Err set role action: action id is not valid";


        $RoleActionMapper = new  M\RoleActionMapper( $this->dataBase );

        // prepare data
        $data = array();
        $data['RoleId'] = $RoleId;
        $data['ActionId'] = $ActionId;
        $data['CreationDate']  = date('Y-m-d h:i:s');
        //insert role action
        return $RoleActionMapper->insert( $data );



    }

    /*
     *  get role action
     */
    public function get_role_action( $RoleId )
    {
        //if role id is not set truly , return
        if ( !$this->checkId( $RoleId ) )
            return "msg get role action: role id is not valid";

        //create new instance of role action mapper
        $RoleActionMapper = new M\RoleActionMapper( $this->dataBase );
        //set condition
        $condition = "RoleId=". $RoleId;
        //find actions by roleid
        return $RoleActionMapper->find( $condition );
    }


    /*
     * set user role
     */
    public function delete_user_role( $UserId , $RoleId )
    {
        // create new instance from userRoleMapper
        $UserRoleMapper = new M\UserRoleMapper( $this->dataBase );
        //create array fro condition
        $condition = array();
        $condition['UserId'] = $UserId;
        $condition['RoleId'] = $RoleId;
        // prepare condition for delete
        $condition = $this->prepareCondition( $condition );
        // delete UserRole from UserRoles
        return $UserRoleMapper->delete( $condition );
    }


    /*
     * delete role
     */
    public function delete_role( $RoleId )
    {
        if( !$this->checkId( $RoleId ))
            return "Err delete role: role id is not valid";
        //create new instance of role mapper
        $RoleMapper = new M\RolesMapper( $this->dataBase );
        //prepare condition
        $conition = 'id='.$RoleId;
        //delete role
        return $RoleMapper->delete( $conition );

    }

    /*
     * set group
     */
    public function set_group( $GroupName , $GroupDescription )
    {
        // create new instance from groupMapper
        $RoleMapper = new M\GroupsMapper( $this->dataBase );

        // create an array for data that inserted to group
        $data = array();
        // add data fro setting group
        $data['GroupName'] = $GroupName;
        $data['Description'] = $GroupDescription;

        // insert group to table
        return $RoleMapper->insert( $data );

    }

    /*
     * get group by id
     */
    public function get_group_by_id( $GroupId = '' )
    {

        if( !$this->checkId( $GroupId ) )
            return "Err get group: group id is not valid";
        // create new instance from groupsMapper
        $groupMapper = new M\GroupsMapper( $this->dataBase );

        // find group
        return $groupMapper->findById( $GroupId );
    }

    /*
     * get group by name
     */
    public function get_group_by_name( $GroupName ='' )
    {

        // create new instance from groupsMapper
        $groupMapper = new M\GroupsMapper( $this->dataBase );

        //craete array of condition
        $condition = array();
        ( $GroupName == '' ? : $condition['GroupName'] = $GroupName );
        //prepare condition to find
        $condition = $this->prepareConditionAdvSearch( $condition );
        // find group names
        return $groupMapper->find( $condition );
    }

    /*
     * edit group
     */
    public function edit_group( $GroupId , $GroupName='' , $GroupDescription ='')
    {

        if( $GroupName == '' && $GroupDescription == '' )
            return "Edit Group: You should specify at least one of the parameters";

        //Check action id validity
        if( !$this->checkId( $GroupId ) )
            return "Err edit_group: group Id is not valid ";

        // create an instance from group
        $GroupMapper = new M\GroupsMapper( $this->dataBase );

        // create array of condition
        $condition = array();
        ( $GroupName == '' ?  : $condition['GroupName'] = $GroupName  ) ;
        ( $GroupDescription == '' ?  : $condition['Description'] = $GroupDescription ) ;

        //update
        return $GroupMapper->update( $condition , 'id='.$GroupId );

    }

    /*
     * delete group
     */
    public function delete_group( $GroupId )
    {
        if( !$this->checkId( $GroupId ) )
            return "Err delete group: group id is not valid";
        // create instance of group mapper
        $GroupMapper = new M\GroupsMapper( $this->dataBase );
        // prepare condition
        $condition = 'id='.$GroupId;
        //delete group
        return $GroupMapper->delete( $condition );
    }

    /*
     *
     * set state
     */
    public function set_state( $StateName )
    {
        // create new instance from StateMapper
        $StateMapper = new M\StatesMapper( $this->dataBase );

        // crate array of data
        $data = array();
        $data['StateName'] = $StateName;
        $data['CreationDate'] = date('Y-m-d h:i:s');

        // insert state to DB
        return $StateMapper->insert( $data );

    }

    /*
     *
     * get state by id
     */
    public function get_state_By_Id( $StateId )
    {
        // create new instance from StateMapper
        $StateMapper = new M\StatesMapper( $this->dataBase );

        //find state by id
        return $StateMapper->findById( $StateId );

    }

    /*
     * delete state
     */
    public function delete_state( $id )
    {
        $StateMapper = new M\StatesMapper( $this->dataBase );

        $condition = array();
        $condition['id'] = $id;

        $condition = $this->prepareCondition( $condition );

        return $StateMapper->delete( $condition );
    }

    /*
     *
     * get state id by name
     */
    public function get_state_By_Name( $StateName )
    {
        // create new instance from StateMapper
        $StateMapper = new M\StatesMapper( $this->dataBase );

        // create array for condition
        $condition = array();
        $condition['StateName'] = $StateName;

        // prepare condition for find state
        $condition = $this->prepareConditionAdvSearch( $condition );

        //find state by name
        return $StateMapper->find($condition);
    }


    /*
     *
     * set City
     */
    public function set_city( $CityName , $StateId )
    {
        // create new instance from city Mapper
        $CityMapper = new M\CitiesMapper( $this->dataBase );

        // crate array of data
        $data = array();
        $data['CityName'] = $CityName;
        $data['StateId'] = $StateId;
        $data['CreationDate'] = date('Y-m-d h:i:s');

        // insert city to DB
        return $CityMapper->insert( $data );

    }

    /*
     *
     * get City by id
     */
    public function get_city_by_id( $CityId )
    {
        // create new instance from StateMapper
        $CityMapper = new M\CitiesMapper( $this->dataBase );

        // insert state to DB
        return $CityMapper->findById( $CityId );

    }

    /*
 *
 * get City by name
 */
    public function get_city_by_name( $CityName )
    {
        // create new instance from StateMapper
        $CityMapper = new M\CitiesMapper( $this->dataBase );

        $condition = array();
        $condition['CityName'] = $CityName;

        $condition = $this->prepareConditionAdvSearch( $condition );
        // insert state to DB
        return $CityMapper->find( $condition );

    }

    /*
     * edit city
     */
    public function edit_city( $CityId , $CityName = '' , $StateId = '' )
    {
        if( $StateId == '' && $CityName == '' )
            return "Err edit_city: You should specify at least one parameter";

        //Check city id validity
        if( !$this->checkId( $CityId ) )
            return "Err edit_City: City Id is not valid";

        // check stateId validity
        if( !$this->checkId( $StateId ) )
            return "Err edit_City: State Id is not valid";
        // create new instance of city mapper
        $CityMapper = new M\CitiesMapper( $this->dataBase );
        // create array for data
        $data = array();
        ( $CityName =='' ?  : $data['CityName'] = $CityName );
        ( $StateId =='' ?  : $data['StateId'] = $StateId );
        //create condition for update data
        $condition = 'id='.$CityId;
        //update City
        return $CityMapper->update( $data , $condition );

    }

    /*
     * delete city
     */
    public function delete_city( $CityId )
    {
        // check stateId validity
        if( !$this->checkId( $CityId ) )
            return "Err delete_City: city Id is not valid";

        $CityMapper = new M\CitiesMapper( $this->dataBase );
        // create condition for deleting city
        $condition = 'id='.$CityId;
        return $CityMapper->delete( $condition );
    }


    /*
     *
     * set City
     */
    public function set_region( $RegionName , $CityId )
    {
        // create new instance from Region Mapper
        $RegionMapper = new M\RegionsMapper( $this->dataBase );

        // crate array of data
        $data = array();
        $data['RegionName'] = $RegionName;
        $data['CityId'] = $CityId;
        $data['CreationDate'] = date('Y-m-d h:i:s');

        // insert Region to DB
        return $RegionMapper->insert( $data );

    }

    /*
     *
     * get Region by id
     */
    public function get_region_by_id( $RegionId )
    {
        if( !$this->checkId( $RegionId ) )
            return "Err get region by id: region id is not valid";
        // create new instance from Region Mapper
        $RegionMapper = new M\RegionsMapper( $this->dataBase );

        // insert state to DB
        return $RegionMapper->findById( $RegionId );

    }

    /*
 *
 * get Region by name
 */
    public function get_region_by_name( $RegionName )
    {
        // create new instance from StateMapper
        $RegionMapper = new M\RegionsMapper( $this->dataBase );

        $condition = array();
        $condition['RegionName'] = $RegionName;

        $condition = $this->prepareConditionAdvSearch( $condition );
        // insert state to DB
        return $RegionMapper->find( $condition );

    }

    /*
     * edit Region
     */
    public function edit_region( $RegionId , $RegionName = '' , $CityId = '' )
    {
        if( $CityId == '' && $RegionName == '' )
            return "Err edit_region: You should specify at least one parameter";

        //Check region id validity
        if( !$this->checkId( $RegionId ) )
            return "Err edit_region: region Id is not valid";

        // check region Id validity
        if( !$this->checkId( $CityId ) )
            return "Err edit_Region: City Id is not valid";
        // create new instance of city mapper
        $RegionMapper = new M\RegionsMapper( $this->dataBase );
        // create array for data
        $data = array();
        ( $RegionName =='' ?  : $data['RegionName'] = $RegionName );
        ( $CityId =='' ?  : $data['CityId'] = $CityId );
        //create condition for update data
        $condition = 'id='.$RegionId;
        //update City
        return $RegionMapper->update( $data , $condition );

    }

    /*
     * delete region
     */
    public function delete_region( $RegionId )
    {
        // check  REgion Id validity
        if( !$this->checkId( $RegionId ) )
            return "Err delete_Region: region Id is not valid";

        $RegionMapper = new M\RegionsMapper( $this->dataBase );
        // create condition for deleting city
        $condition = 'id='.$RegionId;
        return $RegionMapper->delete( $condition );
    }

    /*
     * set role group
     */
    public function set_role_group( $RoleId , $GroupId )
    {
        if( !$this->checkId( $RoleId) )
            return "Err set role group: role id is not valid";
        if( !$this->checkId( $GroupId ) )
            return "Err set role group: group id is not valid";
        //create new instance of role group mapper
        $RoleGroupMapper = new M\RoleGroupMapper( $this->dataBase );
        // create array for data
        $data = array();
        $data['RoleId'] = $RoleId;
        $data['GroupId'] = $GroupId;
        $data['CreationDate'] = date('Y-m-d h:i:s');
        //insert to role group
        return $RoleGroupMapper->insert( $data );

    }

    /*
     * delete role group
     */
    public function delete_role_group( $RoleId , $GroupId )
    {
        if( !$this->checkId( $RoleId) )
            return "Err delete role group: role id is not valid";
        if( !$this->checkId( $GroupId ) )
            return "Err delete role group: group id is not valid";
        //create new instance of role group mapper
        $RoleGroupMapper = new M\RoleGroupMapper( $this->dataBase );
        // create condition
        $data = array();
        $data['RoleId'] = $RoleId;
        $data['GroupId'] = $GroupId;

        $condition = $this->prepareCondition( $data );
        //delete role group
        return $RoleGroupMapper->delete( $condition );

    }

    /*
     * set user group
     */
    public function set_user_group( $UserId , $GroupId )
    {
        if( !$this->checkId( $UserId) )
            return "Err set user group: user id is not valid";
        if( !$this->checkId( $GroupId ) )
            return "Err set role group: group id is not valid";
        //create new instance of user group mapper
        $UserGroupMapper = new M\UserGroupMapper( $this->dataBase );
        // create array for data
        $data = array();
        $data['UserId'] = $UserId;
        $data['GroupId'] = $GroupId;
        $data['CreationDate'] = date('Y-m-d h:i:s');
        //insert to role group
        return $UserGroupMapper->insert( $data );

    }

    /*
     * delete user group
     */
    public function delete_user_group( $UserId , $GroupId )
    {
        if( !$this->checkId( $UserId) )
            return "Err set user group: user id is not valid";
        if( !$this->checkId( $GroupId ) )
            return "Err set role group: group id is not valid";
        //create new instance of user group mapper
        $UserGroupMapper = new M\UserGroupMapper( $this->dataBase );
        // create condition
        $data = array();
        $data['UserId'] = $UserId;
        $data['GroupId'] = $GroupId;

        $condition = $this->prepareCondition( $data );
        //delete user group
        return $UserGroupMapper->delete( $condition );

    }

    /*
     * check validity of integer id to be inserted an be numeric
     */
    public function checkId( $id )
    {
        return (( is_numeric( $id ) || $id === '' )? true : false);
    }
    /*
     *
     * create string for condition from array => this use for condition phrase
     */
    public function prepareCondition( $conditionArray )
    {
        $conditionString = "";
        $i = 0;
        foreach ( $conditionArray as $key => $value )
        {
            $conditionString .= $key ."=" . "'$value'";
            if( $i < ( sizeof($conditionArray) - 1 )  )
            {
                $conditionString .=" and ";
            }
            $i++;
        }
        return $conditionString;
    }

    /*
     *
     * create string for condition from array => this use for condition phrase
     */
    public function prepareConditionAdvSearch( $conditionArray )
    {
        $conditionString = "";
        $i = 0;
        foreach ( $conditionArray as $key => $value )
        {
            $conditionString .= $key ." like " . "'%$value%'";
            if( $i < ( sizeof($conditionArray) - 1 )  )
            {
                $conditionString .=" and ";
            }
            $i++;
        }
        return $conditionString;
    }

    /*
     * test the functions
     */

    public function show()
    {
        //var_dump( $this->get_users()  );
        //var_dump( $this->get_user_by_id( 4 ));

        // $this->delete_User(array('UserId' => 2 ) );
        //$this->activate_user(array('UserId' => 2 ) );
        //var_dump( $this->activate_user( '2' ) );
        //var_dump( $this->login_user( 'aram' , '123' ) );
        //$this->insertUser(array('id'=>null , 'FirstName'=>'dede' , 'LastName'=>'sads' , 'UserName'=>'sddvdsf' , 'Password'=>'sdsdfsdv' , 'Email'=>'sferte','Telephone'=>'egfsdgf', 'CreationDate'=>date('Y-m-d h:i:s')));

        //$this->mergeArray( array("asd", "sdfsdfs") , array("234","3245234"));
        //$id =  $this->register_user( 'aramsa' , 'arsssam', 'rrrrrrr' , 'ttt' ,'4234234234' ,'345345345' , array( '0952258','08542145','0854512') );
        var_dump( $this->register_user('adddddxxd','asdxxddas','qedddqwxxeqwe','098766','09876','qweqwe','1','2','3','add','1', array( '0952258','08542145','0854512')  ) );
        //var_dump( $this->delete_User_By_Id('4') );
        //$email = 'sd';        $this->register_user('asgfbhdad', 'asdasd' , 'asdasd' , '42525' , 'ftrgedfrth' , $email , '2');

        //var_dump( $this->login_user( 'aram' , '123' ) );
        //var_dump( $this->logout_user( 2 )) ;
        //var_dump( $this->login_user( 'aramii' , '123' ) );
        //var_dump( $this->login_user( 'aramy' , '123' ) );
        //var_dump( $this->edit_user_profile( 4, 0 ,'','','',''));
        //var_dump( $this>$this->set_user_profile('1', '', '2','3','5','address') );
        //var_dump( $this->set_user_groups( '4' , '1'));
        //var_dump( $this->set_user_roles( '4' , '1'));
        //var_dump( $this->get_user_roles( '4' ));
        //var_dump( $this->set_role( 'Role5' , 'Role5 Desc') );
        //$this->set_user_roles( '4' , '5' );
        //var_dump( $this->edit_role('4' , 'Role4' , ''));
        //var_dump( $this->get_group( 'gr' ));
        //$actid =  $this->set_action('action5' , 'action5 ');
        //var_dump($this->set_role_action('3' , '' ));
        //var_dump( $this->edit_group( '2' , 'sdfsdf', 'sdfsdfsdf' ));
        //$this->set_state('تهران');
        //$this->set_city( 'تهران' , '1');
        //var_dump( $this->get_city_by_id( '1' ) );
        //var_dump( $this->get_city_by_name('تهر'));
        //var_dump( $this->edit_city('1' , 'تهران' , '' ) );
       //var_dump( $this->delete_city( '1' ) );
       //var_dump( $this->set_role_group( '1' , '3'));
       //var_dump( $this->delete_role_group( '1' , '3'));
       // var_dump( $this->edit_user_password('2' , '097718'));





    }


}

?>