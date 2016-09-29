<?php
namespace Model\Mapper; 
class TelsMapper extends AbstractMapper
{ 

	protected $_entityTable = 'Tels'; 
	protected $_entityClass = 'ModelTels'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'UserId' => $data['UserId']  , 
 			'Telephone' => $data['Telephone']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>