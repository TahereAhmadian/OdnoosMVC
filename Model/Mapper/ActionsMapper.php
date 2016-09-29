<?php
namespace Model\Mapper; 
class ActionsMapper extends AbstractMapper
{ 

	protected $_entityTable = 'Actions'; 
	protected $_entityClass = 'ModelActions'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'ActionName' => $data['ActionName']  , 
 			'Description' => $data['Description'] 
		 );
		 return $this->_entityData;
	}
}

?>