<?php
 
class Wli_Orderconditions_Block_Adminhtml_Orderconditions extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_orderconditions';
        $this->_blockGroup = 'orderconditions';
        $this->_headerText = Mage::helper('orderconditions')->__('Order Tag Condition Manager');
        $this->_addButtonLabel = Mage::helper('orderconditions')->__('Add Tag Condition');
        parent::__construct();
    }
}   