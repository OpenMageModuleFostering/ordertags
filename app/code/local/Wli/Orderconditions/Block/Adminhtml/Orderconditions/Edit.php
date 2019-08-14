<?php
 
class Wli_Orderconditions_Block_Adminhtml_Orderconditions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'orderconditions';
        $this->_controller = 'adminhtml_orderconditions';
 
        $this->_updateButton('save', 'label', Mage::helper('orderconditions')->__('Save Order Tag Condition'));
        $this->_updateButton('delete', 'label', Mage::helper('orderconditions')->__('Delete Order Tag Condition'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('orderconditions_data') && Mage::registry('orderconditions_data')->getId() ) {
            return Mage::helper('orderconditions')->__("Edit Item %s", $this->htmlEscape(Mage::registry('orderconditions_data')->getTitle()));
        } else {
            return Mage::helper('orderconditions')->__('Add New Order Tag Condition');
        }
    }
}