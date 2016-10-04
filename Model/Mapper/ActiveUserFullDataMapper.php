<?php
namespace Model\Mapper; 
class ActiveUserFullDataMapper extends AbstractMapper
{ 

	protected $_entityTable = 'ActiveUserFullData'; 
	protected $_entityClass = 'ModelActiveUserFullData'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'UserId' => $data['UserId']  , 
 			'UserName' => $data['UserName']  , 
 			'FirstName' => $data['FirstName']  , 
 			'LastName' => $data['LastName']  , 
 			'Email' => $data['Email']  , 
 			'CreationDate' => $data['CreationDate']  , 
 			'UserProfileId' => $data['UserProfileId']  , 
 			'Gender' => $data['Gender']  , 
 			'StateId' => $data['StateId']  , 
 			'CityId' => $data['CityId']  , 
 			'RegionId' => $data['RegionId']  , 
 			'Address' => $data['Address']  , 
 			'UserHistoryId' => $data['UserHistoryId']  , 
 			'LastLogin' => $data['LastLogin']  , 
 			'IsActive' => $data['IsActive']  , 
 			'LostPasswordControl' => $data['LostPasswordControl']  , 
 			'IsDelete' => $data['IsDelete']  , 
 			'StartSession' => $data['StartSession']  , 
 			'IsLogin' => $data['IsLogin']  , 
 			'CreateBy' => $data['CreateBy'] 
		 );
		 return $this->_entityData;
	}
}

?>