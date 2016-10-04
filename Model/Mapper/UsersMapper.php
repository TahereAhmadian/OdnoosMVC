<?php
namespace Model\Mapper; 
class UsersMapper extends AbstractMapper
{ 

	protected $_entityTable = 'Users'; 
	protected $_entityClass = 'ModelUsers'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'UserName' => ( isset($data['UserName']) ) ? $data['UserName'] : null  ,
 			'Password' => ( isset($data['Password']) ) ? $data['Password'] : null  ,
 			'FirstName' => ( isset($data['FirstName']) ) ? $data['FirstName'] : null  ,
 			'LastName' => ( isset($data['LastName']) ) ? $data['LastName'] : null  ,
 			'Email' => ( isset($data['Email']) ) ? $data['Email'] : null  ,
 			'Telephone' => ( isset($data['Telephone']) ) ? $data['Telephone'] : null  ,
 			'CreationDate' =>  ( isset($data['CreationDate']) ) ? $data['CreationDate'] : null
		 );
		 return $this->_entityData;
	}
/*
	public function login( $where = '' , $fields = '*')
    {

        //return ( $this->find( $where ) ? true : false )
        //echo $fields;
        if( $userExist = $this->find( $where , $fields ) )
        {
            $UserId = intVal($userExist[0]['id']);
            return $UserId;

        }
        return 0;

    }*/
}

?>