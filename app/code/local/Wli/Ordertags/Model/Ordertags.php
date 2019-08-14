<?php
 
class Wli_Ordertags_Model_Ordertags extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ordertags/ordertags');
    }
    
    /**
	 * @param array $fieldArray, string $tableName.
	 * @param $fieldArray key === table column
	 * insert data into $tableName.
	 */
	public function chagneTagsStatus($prdouctId,$status)
	{		
		$query_append = "UPDATE `".Mage::getConfig()->getTablePrefix()."ordertags` SET `status` = '".$status."' WHERE `ordertags_id` = '".$prdouctId."' ";
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