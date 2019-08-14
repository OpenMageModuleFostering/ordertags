<?php
 
class Wli_Orderconditions_Model_Orderconditions extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('orderconditions/orderconditions');
    }
    
    /**
	 * @param array $fieldArray, string $tableName.
	 * @param $fieldArray key === table column
	 * insert data into $tableName.
	 */
	public function chagneTagsStatus($prdouctId,$status)
	{		
		$query_append = "UPDATE `".Mage::getConfig()->getTablePrefix()."orderconditions` SET `status` = '".$status."' WHERE `orderconditions_id` = '".$prdouctId."' ";
		//echo $query_append; exit;
	
		$this->executeSql($query_append);
	}

	
	
        /**
	* @param string $query
	* excute query in database table
	*/
	public function executeSql($query)
	{
		// fetch write database connection that is used in Mage_Core module
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');

		// now $write is an instance of Zend_Db_Adapter_Abstract
		$write->query("$query");
	}
}