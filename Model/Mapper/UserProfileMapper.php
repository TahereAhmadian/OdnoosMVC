<?php
namespace Model\Mapper;

class UserProfileMapper extends AbstractMapper
{ 

	protected $_entityTable = 'UserProfile'; 
	protected $_entityClass = 'ModelUserProfile'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'UserId' => $data['UserId']  , 
 			'Gender' => $data['Gender']  , 
 			'StateId' => $data['StateId']  , 
 			'CityId' => $data['CityId']  , 
 			'RegionId' => $data['RegionId']  , 
 			'Address' => $data['Address']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>