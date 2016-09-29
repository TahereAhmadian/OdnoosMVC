<?php
namespace Model\Mapper; 
class StatesMapper extends AbstractMapper
{ 

	protected $_entityTable = 'States'; 
	protected $_entityClass = 'ModelStates'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'StateName' => $data['StateName']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>