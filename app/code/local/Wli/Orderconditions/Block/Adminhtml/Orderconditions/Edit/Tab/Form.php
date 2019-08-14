<?php
 
class Wli_Orderconditions_Block_Adminhtml_Orderconditions_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
   
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('orderconditions_form', array('legend'=>Mage::helper('orderconditions')->__('Order Tag Condition Details')));
        $url = Mage::helper("adminhtml")->getUrl("orderconditions/adminhtml_orderconditions/getOrderTagImage/");
        $urlSubtotal = Mage::helper("adminhtml")->getUrl("orderconditions/adminhtml_orderconditions/getSubTotalTextBox/");
        $orderTagArray = Mage::helper('orderconditions')->getOrderTagList();
        
        $countryArray = Mage::helper('orderconditions')->getCountryList();
        
        $data = Mage::registry('orderconditions_data')->getData();
        
        $fieldset->addField('orderconditions_id', 'hidden', array(
        		'label'     => Mage::helper('orderconditions')->__('orderconditions_id'),
        		'id'      => 'orderconditions_id',
        		'required'  => false,
        		'name'      => 'orderconditions_id',
        ));
        
        
        $conditionType=$data['condition_type_id'];
        $fieldset->addField('tags_id', 'select', array(
          'label'     => Mage::helper('orderconditions')->__('Order Tag'),
          'class'     => 'required-entry',
          'values'    => $orderTagArray,
          'name'      => 'tags_id',
          'required'  => true,
          'onchange'	=> 'getValueAlert('."'".$url."'".',this.value)',
          ));
        
        $fieldset->addField('note3', 'note', array(
            'label'     => Mage::helper('orderconditions')->__(''),
            'text'     => '',
      			 
      	));
        
        $fieldset->addField('condition_type_id', 'select', array(
          'label'     => Mage::helper('orderconditions')->__('Order Tag Condition'),
          'class'     => 'required-entry',
          'values'    =>  array(''=>'Please Select Condition','1' => 'Order Subtotal','2' => 'Order Grand Total', '3' => 'Order Status', '4'=> 'Shipping Country', '5' => 'Billing Country'),
          'name'      => 'condition_type_id',
          'required'  => true,
          'onchange'	=> 'getSubTotal('."'".$urlSubtotal."'".','."'".$conditionType."'".',this.value)',
          ));
        
       if($conditionType==1)
        {
            $fieldset->addField('order_sub_total', 'text', array(
          'label'     => Mage::helper('orderconditions')->__('Order Sub Total'),
          'class'     => 'required-entry',
          'id'        =>'order_sub_total',
          'values'    => order_sub_total,
          'name'      => 'sub_total',
          'required'  => true,
            ));
        }
        else if($conditionType==2)
        {
             $fieldset->addField('order_grand_total', 'text', array(
                'label'     => Mage::helper('orderconditions')->__('Order Grand Total'),
                'class'     => 'required-entry',
                'values'    => order_grand_total,
                'name'      => 'grand_total',
                'required'  => true,
            ));
        }
        else if($conditionType==3)
        {
           $fieldset->addField('order_status', 'select', array(
            'label'     => Mage::helper('orderconditions')->__('Order Status'),
            'name'      => 'order_status',
            'required'  => true,
            'class'     => 'required-entry',
            'values'    => array(
                array(
                    'value'     => 'Canceled',
                    'label'     => Mage::helper('orderconditions')->__('Cancelled'),
                ),
 
                array(
                    'value'     => 'Closed',
                    'label'     => Mage::helper('orderconditions')->__('Closed'),
                ),
                
                array(
                    'value'     => 'Complete',
                    'label'     => Mage::helper('orderconditions')->__('Complete'),
                ),
                
                array(
                    'value'     => 'Suspected Fraud',
                    'label'     => Mage::helper('orderconditions')->__('Suspected Fraud'),
                ),
                
                array(
                    'value'     => 'On Hold',
                    'label'     => Mage::helper('orderconditions')->__('On Hold'),
                ),
                
                array(
                    'value'     => 'Payment Review',
                    'label'     => Mage::helper('orderconditions')->__('Payment Review'),
                ),
                
                array(
                    'value'     => 'Pending',
                    'label'     => Mage::helper('orderconditions')->__('Pending'),
                ),
                
                array(
                    'value'     => 'Pending Payment',
                    'label'     => Mage::helper('orderconditions')->__('Pending Payment'),
                ),
                
                array(
                    'value'     => 'Pending PayPal',
                    'label'     => Mage::helper('orderconditions')->__('Pending PayPal'),
                ),
                
                array(
                    'value'     => 'Processing',
                    'label'     => Mage::helper('orderconditions')->__('Processing'),
                ),
            ),
        ));
        }
        else if($conditionType==4)
        {
            $fieldset->addField('shipping_country_id', 'select', array(
            'label'     => Mage::helper('orderconditions')->__('Shipping Country'),
            'name'      => 'shipping_country_id',
            'required'  => true,
            'values'    =>$countryArray,
            'class'     => 'required-entry',
           
        ));
            
        }
        else if($conditionType==5)
        {
        	$fieldset->addField('billing_country_id', 'select', array(
        			'label'     => Mage::helper('orderconditions')->__('Shipping Country'),
        			'name'      => 'billing_country_id',
        			'required'  => true,
        			'values'    =>$countryArray,
        			'class'     => 'required-entry',
        			 
        	));
            
        }
        $fieldset->addField('note4', 'note', array(
            'label'     => Mage::helper('orderconditions')->__(''),
            'text'     => '',
      			 
      	));

        $fieldset->addField('sort_order', 'text', array(
            'label'     => Mage::helper('orderconditions')->__('Sort Order'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'sort_order',
        ));
        
               
         $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('orderconditions')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('orderconditions')->__('Active'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('orderconditions')->__('Inactive'),
                ),
            ),
        ));
         
       
        if ( Mage::getSingleton('adminhtml/session')->getOrderconditionsData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getOrderconditionsData());
            Mage::getSingleton('adminhtml/session')->setOrderconditionsData(null);
        } elseif ( Mage::registry('orderconditions_data') ) {
            $form->setValues(Mage::registry('orderconditions_data')->getData());
        }
        return parent::_prepareForm();
    }
}