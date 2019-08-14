<?php
class Wli_Orderconditions_Helper_Data extends Mage_Core_Helper_Abstract
{
        public function getOrderTagList()
	{
            $orderTag=Mage::getModel('ordertags/ordertags');
            $orderTag=$orderTag->getCollection();
            $orderTag->getData();
	    $OrderTagNameArray = array();
	    $OrderTagNameArray['']  = 'Select Order Tag';
	
		foreach ($orderTag as $order)
		{
                        $OrderTagNameArray[$order->getOrdertagsId()]  = $order->getTitle();		
		}
		return $OrderTagNameArray;
	}
 


	public function getCountryList()
	{
		$_countries = Mage::getResourceModel('directory/country_collection')
		->loadData()
		->toOptionArray(false);
		$CountryList=array();
		foreach($_countries as $country)
		{
			$CountryList[$country['value']]  = $country['label'];
		}
		return $CountryList;
	}
}