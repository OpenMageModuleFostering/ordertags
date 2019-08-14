<?php
 
class Wli_Orderconditions_Block_Adminhtml_Orderconditions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderconditionsGrid');
        // This is the primary key of the database
        $this->setDefaultSort('orderconditions_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('orderconditions/orderconditions')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('orderconditions_id', array(
            'header'    => Mage::helper('orderconditions')->__('Order Conditions ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'orderconditions_id',
        ));
        
	$this->addColumn('tags_id', array(
            'header'    => Mage::helper('orderconditions')->__('Tags Type'),
            'align'     =>'left',
            'width'     => '150px',
	    'filter'    => false,
	    'type'	=>'text',
            'index'     => 'tags_id',
	    'renderer' => 'Wli_Orderconditions_Block_Adminhtml_Orderconditions_Renderer_OrdertagName'
    	));
	
        
        $this->addColumn('sort_order', array(
            'header'    => Mage::helper('orderconditions')->__('Sort Order'),
            'width'     => '150px',
            'index'     => 'sort_order',
        ));
	
        $this->addColumn('condition_type_id', array(
            'header'    => Mage::helper('orderconditions')->__('Condition Type'),
            'width'     => '150px',
	    'type'	=> 'options',
            'index'     => 'condition_type_id',
	    'options'	=> array(
		1 => 'Order Sub Total',
		2 => 'Order Grand Total',
		3 => 'Order Status',
		4 => 'Shipping Country',
		5 => 'Billing Country',
	    )
        ));
	
        $this->addColumn('order_sub_total', array(
            'header'    => Mage::helper('orderconditions')->__('Order Sub Total'),
            'width'     => '150px',
            'index'     => 'order_sub_total',
        ));
	
        $this->addColumn('order_grand_total', array(
            'header'    => Mage::helper('orderconditions')->__('Grand Total'),
            'width'     => '150px',
            'index'     => 'order_grand_total',
        ));
	
        $this->addColumn('order_status_id', array(
            'header'    => Mage::helper('orderconditions')->__('Order Status'),
            'width'     => '150px',
            'index'     => 'order_status_id',
	    
        ));
	
	$this->addColumn('billing_country_id', array(
            'header'    => Mage::helper('orderconditions')->__('Billing Country'),
            'width'     => '150px',
            'index'     => 'billing_country_id',
        ));
	
	$this->addColumn('shipping_country_id', array(
            'header'    => Mage::helper('orderconditions')->__('Shipping Country'),
            'width'     => '150px',
            'index'     => 'shipping_country_id',
        ));
    
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('orderconditions')->__('Creation Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'created_at',
        ));
 
        $this->addColumn('update_time', array(
            'header'    => Mage::helper('orderconditions')->__('Update Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'update_time',
        ));   
 
 
        /*$this->addColumn('status', array(
 
            'header'    => Mage::helper('orderconditions')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));*/
 
        return parent::_prepareColumns();
    }
    protected function _prepareMassaction()
	{
		$this->setMassactionIdField('orderconditions_id');
		$this->getMassactionBlock()->setFormFieldName('orderconditions');

		$this->getMassactionBlock()->addItem(
				'delete',
				array(
						'label'   => Mage::helper('orderconditions')->__('Delete'),
						'url'     => $this->getUrl('*/*/massDelete'),
						'confirm' => Mage::helper('orderconditions')->__('Are you sure?'),
				)
		);
                
                $statuses = Array("1"=>"Active","0"=>"Inactive");

                // array_unshift($statuses, array('label'=>'', 'value'=>''));
                 $this->getMassactionBlock()->addItem('status', array(
                'label'=> Mage::helper('orderconditions')->__('Change status'),
                'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                            'visibility' => array(
                                'name' => 'status',
                                'type' => 'select',
                                'class' => 'required-entry',
                                'label' => Mage::helper('orderconditions')->__('Status'),
                                'values' => $statuses
                                )
                        )
        ));
		return $this;
            
	}

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
 
    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }
   
}