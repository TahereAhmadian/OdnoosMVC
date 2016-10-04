<?php
namespace Model\Mapper; 
class GetUsersGroupsMapper extends AbstractMapper
{ 

	protected $_entityTable = 'GetUsersGroups'; 
	protected $_entityClass = 'ModelGetUsersGroups'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'UserId' => $data['UserId']  , 
 			'UserName' => $data['UserName']  , 
 			'FirstName' => $data['FirstName']  , 
 			'LastName' => $data['LastName']  , 
 			'GroupId' => $data['GroupId']  , 
 			'GroupName' => $data['GroupName']  , 
 			'Description' => $data['Description']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>