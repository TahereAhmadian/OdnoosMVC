<?php
namespace Model\Mapper; 
class RoleGroupMapper extends AbstractMapper
{ 

	protected $_entityTable = 'RoleGroup'; 
	protected $_entityClass = 'ModelRoleGroup'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'RoleId' => $data['RoleId']  , 
 			'GroupId' => $data['GroupId']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>