<?php
namespace Model\Mapper; 
class UserActionsMapper extends AbstractMapper
{ 

	protected $_entityTable = 'UserActions'; 
	protected $_entityClass = 'ModelUserActions'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'UserId' => $data['UserId']  , 
 			'Actions' => $data['Actions'] 
		 );
		 return $this->_entityData;
	}
}

?>