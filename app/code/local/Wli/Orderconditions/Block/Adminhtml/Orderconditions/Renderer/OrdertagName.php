<?php 
class Wli_Orderconditions_Block_Adminhtml_Orderconditions_Renderer_OrdertagName extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected function _getValue(Varien_Object $row)
    {
        
        $orderCollection=Mage::getModel('ordertags/ordertags')->getCollection();
        $orderCollection->addFieldtoFilter("ordertags_id",array('eq' => $row['tags_id']));
        $orderTagData= $orderCollection->getData();
        echo $orderTagData[0]['title'];
    }
}
?>