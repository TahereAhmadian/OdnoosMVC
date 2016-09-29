<?php
namespace Model\Mapper; 
class CitiesMapper extends AbstractMapper
{ 

	protected $_entityTable = 'Cities'; 
	protected $_entityClass = 'ModelCities'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'CityName' => $data['CityName']  , 
 			'StateId' => $data['StateId']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>