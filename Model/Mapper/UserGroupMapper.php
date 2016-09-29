<?php
namespace Model\Mapper; 
class UserGroupMapper extends AbstractMapper
{ 

	protected $_entityTable = 'UserGroup'; 
	protected $_entityClass = 'ModelUserGroup'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'UserId' => $data['UserId']  , 
 			'GroupId' => $data['GroupId']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>