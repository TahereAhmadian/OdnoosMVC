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


class User
{
    protected $dataBase = null;

    public function __construct()
    {
        date_default_timezone_set('Asia/Tehran');
        $this->dataBase = new D\DataBase();
        var_dump($this->dataBase);
    }


     /*find a user based on a specific property like id
     *
     */
    public function get_user_by_id( $id )
    {
        $MapperInstance = new M\UsersMapper( $this->dataBase );

        echo "<pre>";
        print_r($MapperInstance->findById( $id ));
        echo"</pre>";
        return $MapperInstance->findById( $id );

    }

    /*
     *
     *find a user based on a specific property like id , property passed by an array
     * Usage:  $this->getUserByProperty( array('FirstName' , 'Foo') );
     *
     */
    //public function get_users( $id=-1 , $FirstName='' , $LastName='' , $Email='', $phone='', $state , $city='' ,$region='' , $gender='', $isLogin='')
    public function get_users( $property = array() )
    {
       // $property = array();

        $MapperInstance = new M\UsersMapper( $this->dataBase );

        // prepare condition string for where
        $condition = $this->prepareConditionAdvSearch( $property );

        echo "<pre>";
        print_r($MapperInstance->find($condition ));
        echo"</pre>";
        return $MapperInstance->find($condition) ;
    }




    /*
     * update user properties
     *      $property => array of fields that will change
     *      condition => array of fields that make condition
     */
    public function edit_user($property , $condition )
    {
            $MapperInstance = new M\UsersMapper( $this->dataBase );

            // convert condition from array to string { array('id'=>2)  CONVERT TO: 'id' = 2  }
            $where = $this->prepareCondition( $condition );
            echo "<pre>";
            print_r($MapperInstance->update( $property , $where ));
            echo"</pre>";

            return $MapperInstance->update( $property , $where );
    }

    /*
     *
     * insert new user to DB
     */
    public function register_user($property)
    {
            $MapperInstance = new M\UsersMapper( $this->dataBase );

            $MapperInstance->insert( $property );
    }

    /*
     *
     *  delete user
     *  we don't delete any user data, ,we just disable it
     */

    public function delete_User( $condition )
    {
            $MapperInstance = new M\UserHistoryMapper( $this->dataBase );

            $where = $this->prepareCondition( $condition );

            $property = array( 'IsDelete' => 1 );

            $MapperInstance->update( $property , $where );
    }

    /*
     *
     *  delete user by by id
     *  we don't delete any user data, ,we just disable it
     */
    public function delete_User_By_Id($id )
    {
        $condition = array( 'id' => $id );

        $this->delete_User( $condition );
    }

    /*
     *  activate user , condition is array
     */
    public function activate_user( $condition )
    {
        $MapperInstance = new M\UserHistoryMapper( $this->dataBase );

        $where = $this->prepareCondition( $condition );

        $property = array( 'IsActive' => 1 );

        $MapperInstance->update( $property , $where );
    }
    /*
     *  deactivate user, condition is array
     */
    public function deactivate_user( $condition )
    {
        $MapperInstance = new M\UserHistoryMapper( $this->dataBase );

        $where = $this->prepareCondition( $condition );

        $property = array( 'IsActive' => 0 );

        $MapperInstance->update( $property , $where );
    }


    /*
     * login for user
     * inputs: username and password
     */
    public function login_user( $username , $password )
    {

        $userData = $this->prepareCondition( array( "UserName"=>$username , "Password"=>$password ) );

        $MapperInstance = new M\UsersMapper( $this->dataBase );


        //$fields = ' id , UserName , FirstName , LastName , Email , Telephone , CreationDate ';

        return $MapperInstance->login( $userData );


    }

    /*
     * logout
     */
    public function user_logout( $username )
    {
        //TODO: logout code
    }

    /*
     * get user profile
     */
    public function get_user_profile( $userid )
    {
        //TODO: get user profile code
    }

    /*
     * get user role
     */
    public function get_user_roles( $userid )
    {
        //TODO: get user role code
    }

    /*
     * get user groups
     */
    public function get_user_groups( $userid )
    {
        //TODO: get user group
    }

    /*
     *
     *  merge tow array to one, key from 1st, value from 2dn
     */
    public function mergeArray( $propertyName , $propertyValue )
    {
        $output = array();

        if( $this->checkParamsLength( $propertyName , $propertyValue ) )
        {
            for( $i = 0 ; $i < sizeof( $propertyName) ; $i++ )
            {
                $output[$propertyName[$i]] = $propertyValue[$i];
            }
        }
        else{
            echo "Err mergeArray: arrays have not equal length";
        }

        return $output;

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
        //var_dump( $this->get_users(array('FirstName' => 'aram' , 'LastName'=>'h') ) );

       // $this->get_user_by_id(2 , 5);
      // $this->get_users();
        $a=array("FirstName"=>"qqq");
        $this->edit_user($a , "id=5");
        // $this->delete_User(array('UserId' => 2 ) );
        //$this->activate_user(array('UserId' => 2 ) );
      //  var_dump( $this->login_user( 'aram' , '123' ) );
        //$this->insertUser(array('id'=>null , 'FirstName'=>'dede' , 'LastName'=>'sads' , 'UserName'=>'sddvdsf' , 'Password'=>'sdsdfsdv' , 'Email'=>'sferte','Telephone'=>'egfsdgf', 'CreationDate'=>date('Y-m-d h:i:s')));

        //$this->mergeArray( array("asd", "sdfsdfs") , array("234","3245234"));
    }


}

?>