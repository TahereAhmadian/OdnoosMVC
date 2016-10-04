<?php
namespace Model\Mapper; 
class RoleActionMapper extends AbstractMapper
{ 

	protected $_entityTable = 'RoleAction'; 
	protected $_entityClass = 'ModelRoleAction'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'RoleId' => $data['RoleId']  , 
 			'ActionId' => $data['ActionId']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>