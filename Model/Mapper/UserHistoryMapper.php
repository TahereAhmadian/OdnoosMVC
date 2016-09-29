<?php
namespace Model\Mapper; 
class UserHistoryMapper extends AbstractMapper
{ 

	protected $_entityTable = 'UserHistory'; 
	protected $_entityClass = 'ModelUserHistory'; 
	protected $_entityData = null; 
	protected function _createEntity(array $data) 
	{ 
		 $this->_entityData = array( 
			'id' => $data['id']  , 
 			'UserId' => $data['UserId']  , 
 			'LastLogin' => $data['LastLogin']  , 
 			'IsActive' => $data['IsActive']  , 
 			'LostPasswordControl' => $data['LostPasswordControl']  , 
 			'IsDelete' => $data['IsDelete']  , 
 			'StartSession' => $data['StartSession']  , 
 			'IsLogin' => $data['IsLogin']  , 
 			'CreateBy' => $data['CreateBy']  , 
 			'CreationDate' => $data['CreationDate'] 
		 );
		 return $this->_entityData;
	}
}

?>