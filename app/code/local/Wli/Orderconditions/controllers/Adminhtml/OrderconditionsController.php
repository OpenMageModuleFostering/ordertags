<?php 
 
class Wli_Orderconditions_Adminhtml_OrderconditionsController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('orderconditions/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Condition Tag Manager'));
        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('orderconditions/adminhtml_orderconditions'));
        $this->renderLayout();
    }
 
    public function editAction()
    {
        $orderconditionsId     = $this->getRequest()->getParam('id');
        $orderconditionsModel  = Mage::getModel('orderconditions/orderconditions')->load($orderconditionsId);
        if ($orderconditionsModel->getId() || $orderconditionsId == 0) {
 
            Mage::register('orderconditions_data', $orderconditionsModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('orderconditions/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Tag Manager'));
            //$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Tag News'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('orderconditions/adminhtml_orderconditions_edit'))
                 ->_addLeft($this->getLayout()->createBlock('orderconditions/adminhtml_orderconditions_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('orderconditions')->__('Order Condition Tag does not exist'));
            $this->_redirect('*/*/');
        }
    }
   
    public function newAction()
    {
        $this->_forward('edit');
    }
   
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                 $orderconditionsModel = Mage::getModel('orderconditions/orderconditions');
                $orderconditionsModel//->setId($this->getRequest()->getParam('id'))
                ->setOrderStatusId($postData['order_status'])
                    ->setStatus($postData['status'])
                    ->setTagsId($postData['tags_id'])
                    ->setSortOrder($postData['sort_order'])
                    ->setConditionTypeId($postData['condition_type_id'])
                    ->setOrderSubTotal($postData['sub_total'])
                    ->setOrderGrandTotal($postData['grand_total'])
                     ->setBillingCountryId($postData['billing_country_id'])
                    ->setShippingCountryId($postData['shipping_country_id'])
                    ->setCreatedAt(date('Y-m-d H:i:s'))
                    ->setUpdateTime(date('Y-m-d H:i:s'))
                    ->save();
                
                 
               
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Order Condition Tag was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setOrderconditionsData(false);
 
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setOrderconditionsData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
   
    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $orderconditionsModel = Mage::getModel('orderconditions/orderconditions');
               
                $orderconditionsModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Order Condition Tag was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
    
    /*Order Tags Mass Delete Action Code Starts */
    
    public function massDeleteAction()
	{
		$ordertagIds = $this->getRequest()->getParam('orderconditions');
		if (!is_array($ordertagIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Order Condition Tag(s)'));
		} else {
			try {
				foreach ($ordertagIds as $ordertagId) {
					$this->_inventoryDelete($ordertagId);
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
						Mage::helper('adminhtml')->__(
								'Total of %d record(s) were successfully deleted', count($ordertagIds)
						)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}

	protected function _inventoryDelete($ordertagId)
	{
		$model = Mage::getModel('orderconditions/orderconditions')->load($ordertagId);
		$model->delete();
	}
    /* Order Tags Mass Delete Action Ends */
    /* Order Tags Mass Status Action Starts */
    public function massStatusAction()
    {
        $productIds = (array)$this->getRequest()->getParam('orderconditions');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $status     = (int)$this->getRequest()->getParam('status');
        
        try {
            foreach($productIds as $productId)
            {
                $statusData = Mage::getModel('orderconditions/orderconditions')->chagneTagsStatus($productId, $status);
            }
            $this->_getSession()->addSuccess(
                $this->__('Total of %d record(s) have been updated.', count($productIds))
            );
        }
        catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()
                ->addException($e, $this->__('An error occurred while updating the Order Condtion Tag(s) status.'));
        }

        $this->_redirect('*/*/', array('store'=> $storeId));
    }
    
    /*Function for the geting the Image form the order tags Table*/
    public function getOrderTagImageAction($value)
    {
        if($_GET['value']=="")
        {
            $html="Please Select the Order Tag Image from the Above Drop Down.";
            echo $html; exit;
        }
        else
        {
            $orderTag=Mage::getModel('ordertags/ordertags')->getCollection()        
            ->addFieldToFilter('ordertags_id',$_GET['value']);
            $orderTag->getData();
            foreach($orderTag as $order)
            {
                $img=$order->getIcon();
            }
            $imagePath=Mage::getBaseUrl('media').$img;
            $html="<img src='".$imagePath."'>";
            echo $html; exit;
        }
    }
    
    /*Function for getting the Text box for the Order Sub Total*/
    public function getSubTotalTextBoxAction($value)
    {
        if($_GET['value']=='1')
        {
            $html="<tr id='sub_total'>";
            $html.="<td class='label'><label for='title'>Order Sub Total<span class='required'>*</span></label></td>";
            $html.="<td class='value'>";
            $html.="<input id='order_sub_total' name='sub_total' value='' class='required-entry input-text required-entry' type='text'></td>";
            $html.="</tr>";
            echo $html; die;
        }
        else if($_GET['value']=='2')
        {
            $html="<tr id='grand_total'>";
            $html.="<td class='label'><label for='title'>Grand Total<span class='required'>*</span></label></td>";
            $html.="<td class='value'>";
            $html.="<input id='grand_total' name='grand_total' value='' class='required-entry input-text required-entry' type='text'></td>";
            $html.="</tr>";
            echo $html; die;
        }
        else if($_GET['value']=='3')
        {
            $html="<tr id='order_status'>";
            $html.="<td class='label'><label for='title'>Order Status<span class='required'>*</span></label></td>";
            $html.="<td class='value'>";
            $html.="<select id='order_status' name='order_status' class='select'>";
            $html.="<option value='canceled'>Cancelled</option><option value='closed'>Closed</option><option value='complete'>Complete</option><option value='suspected_fraud'>Suspected Fraud</option><option value='holded'>On Hold</option><option value='payment_review'>Payment Review</option><option value='pending'>Pending</option><option value='pending_payment'>Pending Payment</option><option value='pending_payPal'>Pending PayPal</option><option value='processing'>Processing</option>";
            $html.="</select></td>";
            $html.="</tr>";
            echo $html; die;
        }
        else if($_GET['value']=='4')
        {
             $_countries = Mage::getResourceModel('directory/country_collection')
		->loadData()
		->toOptionArray(false);
              
            $html="<tr id='shipping_countrytr'>";
            $html.="<td class='label'><label for='title'>Shipping Country<span class='required'>*</span></label></td>";
            $html.="<td class='value'>";
            $html.="<select id='shipping_country_id' name='shipping_country_id' class='select'>";
            foreach($_countries as $country)
            {
                $html.="<option value='".$country['value']."'>".$country['label']."</option>";
            }
            $html.="</select></td>";
            $html.="</tr>";
            echo $html; die;
        }
        else if($_GET['value']=='5')
        {
             $_countries = Mage::getResourceModel('directory/country_collection')
		->loadData()
		->toOptionArray(false);
               // echo "<pre>";
              //  print_r($_countries); die;
            $html="<tr id='billing_country'>";
            $html.="<td class='label'><label for='title'>Billing Country<span class='required'>*</span></label></td>";
            $html.="<td class='value'>";
            $html.="<select id='billing_country_id' name='billing_country_id' class='select'>";
            foreach($_countries as $country)
            {
                $html.="<option value='".$country['value']."'>".$country['label']."</option>";
            }
            $html.="</select></td>";
            $html.="</tr>";
            echo $html; die;
        }
    }
    
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('orderconditions/adminhtml_orderconditions_grid')->toHtml()
        );
    }
}


