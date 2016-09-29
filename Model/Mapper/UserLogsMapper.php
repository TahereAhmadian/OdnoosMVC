<?php
namespace Model\Mapper; 
class UserLogsMapper extends AbstractMapper
{ 

	protected $_entityTable = 'UserLogs'; 
	protected $_entityClass = 'ModelUserLogs'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'UserId' => $data['UserId']  , 
 			'ActionId' => $data['ActionId']  , 
 			'Description' => $data['Description']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>