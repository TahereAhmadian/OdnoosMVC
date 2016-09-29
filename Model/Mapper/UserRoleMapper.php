<?php
namespace Model\Mapper; 
class UserRoleMapper extends AbstractMapper
{ 

	protected $_entityTable = 'UserRole'; 
	protected $_entityClass = 'ModelUserRole'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'UserId' => $data['UserId']  , 
 			'RoleId' => $data['RoleId']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>