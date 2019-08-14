<?php 
class Wli_Ordertags_Block_Adminhtml_Ordertags_Renderer_Getordertags extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	
    	$Orderdata = $row->getData();
    	$baseTotal = $Orderdata['base_grand_total'];
    	$grandTotal = $Orderdata['grand_total'];
    	$orderId = $Orderdata['increment_id'];
    	
    	$orderStatus = $Orderdata['status'];
    	$orderTagImages = Mage::helper('ordertags')->getOrderTags($baseTotal,$grandTotal,$orderId, $orderStatus);
    	return $orderTagImages;
    } 
    
    
   
}