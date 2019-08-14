<?php
 
class Wli_Ordertags_Helper_Data extends Mage_Core_Helper_Abstract
{
 	public function getOrderTags($baseTotal,$grandTotal, $orderId,$orderStatus)
 	{
 		
 		// Get Shipping Country & Billing Country of the Order starts here
 		$orderCollection=Mage::getModel('sales/order')->loadByIncrementId(''.$orderId.'');
 		$shippingId = $orderCollection->getShippingAddress()->getId();
 		$address = Mage::getModel('sales/order_address')->load($shippingId);
 		$shippingCountry= $address->getCountryId();
 		
 		$billingId = $orderCollection->getBillingAddress()->getId();
 		$billingAddress = Mage::getModel('sales/order_address')->load($billingId);
 		$billingCountry= $billingAddress->getCountryId();
 		//Get Shipping Country & Billing Country of the Order ends here
	
 		$orderConditionsCollection= Mage::getModel('orderconditions/orderconditions')->getCollection()
 		->addFieldToFilter(
 				array('order_sub_total', 'order_grand_total','billing_country_id','shipping_country_id','order_status_id'),
 				array(
 						array('gt'=>$baseTotal),
 						array('gt'=>$grandTotal),
 						array('eq'=>$shippingCountry),
 						array('eq'=>$billingCountry),
 						array('eq'=>$orderStatus)
 				)
 		);
 		
 		if(count($orderConditionsCollection)>0)
 		{
 			$tagArray=array();
 			$allTagImages='';
 			foreach($orderConditionsCollection as $ordModel)
 			{
 				$orderTagsCollection=Mage::getModel('ordertags/ordertags')->load($ordModel->getTagsId());
 				$tagArray[]=$ordModel->getTagsId();
 				$url = Mage::getBaseUrl('media') . '' . $orderTagsCollection->getIcon();
 				$allTagImages .= "<img src=". $url ." width='30px'/>";
 			}
 		}
 		return $allTagImages;
 	}
}