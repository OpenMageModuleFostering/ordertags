<?php
 
class Wli_Ordertags_Block_Adminhtml_Ordertags extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_ordertags';
        $this->_blockGroup = 'ordertags';
        $this->_headerText = Mage::helper('ordertags')->__('Order Tag Manager');
        $this->_addButtonLabel = Mage::helper('ordertags')->__('Add Tag');
        parent::__construct();
    }
}   