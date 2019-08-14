<?php
 
class Wli_Orderconditions_Block_Adminhtml_Orderconditions_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderconditions_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('orderconditions')->__('Order Tags Conditions Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('orderconditions')->__('Condition Tag Information'),
            'content'   => $this->getLayout()->createBlock('orderconditions/adminhtml_orderconditions_edit_tab_form')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}