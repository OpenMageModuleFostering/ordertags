<?php
 
class Wli_Ordertags_Block_Adminhtml_Ordertags_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'ordertags';
        $this->_controller = 'adminhtml_ordertags';
 
        $this->_updateButton('save', 'label', Mage::helper('ordertags')->__('Save Order Tag'));
        $this->_updateButton('delete', 'label', Mage::helper('ordertags')->__('Delete Order Tag'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('ordertags_data') && Mage::registry('ordertags_data')->getId() ) {
            return Mage::helper('ordertags')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('ordertags_data')->getTitle()));
        } else {
            return Mage::helper('ordertags')->__('Add New Order Tag');
        }
    }
}