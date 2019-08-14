<?php
 
class Wli_Orderconditions_Model_Mysql4_Orderconditions extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('orderconditions/orderconditions', 'orderconditions_id');
    }
}