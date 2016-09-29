<?php
namespace Model\Mapper; 
class RolesMapper extends AbstractMapper
{ 

	protected $_entityTable = 'Roles'; 
	protected $_entityClass = 'ModelRoles'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'Name' => $data['Name']  , 
 			'Description' => $data['Description']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>