<?php
namespace Model\Mapper; 
class GroupsMapper extends AbstractMapper
{ 

	protected $_entityTable = 'Groups'; 
	protected $_entityClass = 'ModelGroups'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'GroupName' => $data['GroupName']  , 
 			'Description' => $data['Description']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>