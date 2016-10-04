<?php
namespace Model\Mapper; 
class GetUsersRolesMapper extends AbstractMapper
{ 

	protected $_entityTable = 'GetUsersRoles'; 
	protected $_entityClass = 'ModelGetUsersRoles'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'UserId' => $data['UserId']  , 
 			'UserName' => $data['UserName']  , 
 			'FirstName' => $data['FirstName']  , 
 			'LastName' => $data['LastName']  , 
 			'RoleId' => $data['RoleId']  , 
 			'RoleName' => $data['RoleName']  , 
 			'Description' => $data['Description']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>