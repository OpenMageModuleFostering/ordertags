<?php 
class Wli_Ordertags_Block_Adminhtml_Ordertags_Renderer_Ordertags extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    } 
    protected function _getValue(Varien_Object $row)
    {
        $imageData = $row->getData();
        if(!empty($imageData['icon']))
        {
            $url = Mage::getBaseUrl('media') . '' . $imageData['icon']; 
            $out = "<img src=". $url ." width='30px'/>";
        }
        else
        {
            $out=''; 
        }
        
        
        return $out;
    }
}