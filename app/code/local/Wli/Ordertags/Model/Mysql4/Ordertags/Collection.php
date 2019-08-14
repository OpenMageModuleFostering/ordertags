<?php
 
class Wli_Ordertags_Model_Mysql4_Ordertags_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('ordertags/ordertags');
    }
}