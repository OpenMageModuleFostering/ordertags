<?php
 
class Wli_Ordertags_Block_Adminhtml_Ordertags_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('ordertags_form', array('legend'=>Mage::helper('ordertags')->__('Order Tag Details')));
       
        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('ordertags')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));
        
         $fieldset->addField('icon', 'image', array(
            'label'     => Mage::helper('ordertags')->__('Upload Icon'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'icon',
        ));
        $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'     => Mage::helper('ordertags')->__('Description'),
            'style'     => 'width:98%; height:50px;',
            'required'  => false,
        ));
        
       
         $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('ordertags')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('ordertags')->__('Active'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('ordertags')->__('Inactive'),
                ),
            ),
        ));
       
       
        if ( Mage::getSingleton('adminhtml/session')->getOrdertagsData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getOrdertagsData());
            Mage::getSingleton('adminhtml/session')->setOrdertagsData(null);
        } elseif ( Mage::registry('ordertags_data') ) {
            $form->setValues(Mage::registry('ordertags_data')->getData());
        }
        return parent::_prepareForm();
    }
}