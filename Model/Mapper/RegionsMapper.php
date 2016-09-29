<?php
namespace Model\Mapper; 
class RegionsMapper extends AbstractMapper
{ 

	protected $_entityTable = 'Regions'; 
	protected $_entityClass = 'ModelRegions'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'RegionName' => $data['RegionName']  , 
 			'CityId' => $data['CityId']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>