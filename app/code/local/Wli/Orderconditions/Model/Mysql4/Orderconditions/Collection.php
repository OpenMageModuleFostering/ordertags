<?php
 
class Wli_Orderconditions_Model_Mysql4_Orderconditions_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('orderconditions/orderconditions');
    }
}