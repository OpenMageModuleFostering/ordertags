<?php
 
class Wli_Ordertags_Block_Adminhtml_Ordertags_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('ordertags_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('ordertags')->__('Order Tags Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('ordertags')->__('Tag Information'),
            'content'   => $this->getLayout()->createBlock('ordertags/adminhtml_ordertags_edit_tab_form')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}