<?php
 
class Wli_Ordertags_Block_Adminhtml_Ordertags_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ordertagsGrid');
        // This is the primary key of the database
        $this->setDefaultSort('ordertags_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ordertags/ordertags')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('ordertags_id', array(
            'header'    => Mage::helper('ordertags')->__('ID'),
            'align'     =>'right',
            'width'     => '10px',
            'index'     => 'ordertags_id',
        ));
        
        /* code for Displaying the Icons*/
        
        $this->addColumn('icon', array(
            'header'    => Mage::helper('ordertags')->__('Icon'),
            'align'     =>'center',
            'width'     => '30px',
            'index'     => 'icon',
            'filter'    => false,
           'renderer' => 'Wli_Ordertags_Block_Adminhtml_Ordertags_Renderer_Ordertags'
        ));
 
 
        $this->addColumn('title', array(
            'header'    => Mage::helper('ordertags')->__('Title'),
            'align'     =>'left',
            'width'     => '150px',
            'index'     => 'title',
        ));
        
        /*
        $this->addColumn('content', array(
            'header'    => Mage::helper('ordertags')->__('Item Content'),
            'width'     => '150px',
            'index'     => 'content',
        ));
        */
 
        $this->addColumn('created_time', array(
            'header'    => Mage::helper('ordertags')->__('Creation Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'created_time',
        ));
 
        $this->addColumn('update_time', array(
            'header'    => Mage::helper('ordertags')->__('Update Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'update_time',
        ));   
 
 
        $this->addColumn('status', array(
 
            'header'    => Mage::helper('ordertags')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));
 
        return parent::_prepareColumns();
    }
    protected function _prepareMassaction()
	{
		$this->setMassactionIdField('ordertags_id');
		$this->getMassactionBlock()->setFormFieldName('ordertags');

		$this->getMassactionBlock()->addItem(
				'delete',
				array(
						'label'   => Mage::helper('ordertags')->__('Delete'),
						'url'     => $this->getUrl('*/*/massDelete'),
						'confirm' => Mage::helper('ordertags')->__('Are you sure?'),
				)
		);
                
                $statuses = Array("1"=>"Active","0"=>"Inactive");

                // array_unshift($statuses, array('label'=>'', 'value'=>''));
                 $this->getMassactionBlock()->addItem('status', array(
                'label'=> Mage::helper('ordertags')->__('Change status'),
                'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                            'visibility' => array(
                                'name' => 'status',
                                'type' => 'select',
                                'class' => 'required-entry',
                                'label' => Mage::helper('ordertags')->__('Status'),
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