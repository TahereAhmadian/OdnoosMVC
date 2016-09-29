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
 			'UserName' => $data['UserName']  , 
 			'Password' => $data['Password']  ,
 			'FirstName' => $data['FirstName']  , 
 			'LastName' => $data['LastName']  , 
 			'Email' => $data['Email']  , 
 			'Telephone' => $data['Telephone']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}

	public function login( $where = '' , $fields = '*')
    {

       // return ( $this->find( $where ) ? true : false );
        return  $this->find( $where , $fields );

    }
}

?>