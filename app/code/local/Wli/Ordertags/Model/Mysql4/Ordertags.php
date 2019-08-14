<?php
 
class Wli_Ordertags_Model_Mysql4_Ordertags extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('ordertags/ordertags', 'ordertags_id');
    }
}