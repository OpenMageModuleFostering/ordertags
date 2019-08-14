<?php
 
class Wli_Ordertags_Adminhtml_OrdertagsController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ordertags/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Tag Manager'), Mage::helper('adminhtml')->__('Tag Manager'));
        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('ordertags/adminhtml_ordertags'));
        $this->renderLayout();
    }
 
    public function editAction()
    {
        $ordertagsId     = $this->getRequest()->getParam('id');
        $ordertagsModel  = Mage::getModel('ordertags/ordertags')->load($ordertagsId);
 
        if ($ordertagsModel->getId() || $ordertagsId == 0) {
 
            Mage::register('ordertags_data', $ordertagsModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('ordertags/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Tag Manager'));
                      
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('ordertags/adminhtml_ordertags_edit'))
                 ->_addLeft($this->getLayout()->createBlock('ordertags/adminhtml_ordertags_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ordertags')->__('Order Tag does not exist'));
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
                $ordertagsModel = Mage::getModel('ordertags/ordertags');
                    /* Order tag icon upload starts here*/
               if(isset($_FILES['icon']['name']) && $_FILES['icon']['name'] != '')
               {
                    try
                    {
                            $fileName       = $_FILES['icon']['name'];
                            $fileExt        = strtolower(substr(strrchr($fileName, "."), 1));
                            $fileNamewoe    = rtrim($fileName, $fileExt);
                            $fileName       = str_replace(' ', '', $fileNamewoe) . '' . $fileExt;
                            $uploader       = new Varien_File_Uploader('icon');
                            $uploader->setAllowedExtensions(array('png', 'jpg')); //allowed extensions
                            $uploader->setAllowRenameFiles(false);
                            $uploader->setFilesDispersion(false);
                            $path = Mage::getBaseDir('media') . DS;
                            
                                if(!is_dir($path))
                                {
                                    mkdir($path, 0777, true);
                                }      
                                $uploader->save($path . DS, $fileName );

                    }
                    catch (Exception $e)
                    {
                        echo $e->getMessage();
                    }
                }
                    /* Order Tag icon upload code ends here */
                $ordertagsModel->setId($this->getRequest()->getParam('id'))
                    ->setTitle($postData['title'])
                    ->setContent($postData['content'])
                    ->setStatus($postData['status'])
                    ->setCreatedTime(date('Y-m-d H:i:s'))
                    ->setUpdateTime(date('Y-m-d H:i:s'))
                    ->setIcon($fileName)
                    ->save();
               
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Order Tag was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setOrdertagsData(false);
 
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setOrdertagsData($this->getRequest()->getPost());
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
                $ordertagsModel = Mage::getModel('ordertags/ordertags');
               
                
                $ordertagsModel->load($this->getRequest()->getParam('id'));
                $fileName=$ordertagsModel->getIcon();
                $orignalImg = Mage::getBaseDir('media') . DS . $fileName;
                
                	
                if(file_exists($orignalImg)) {
                	unlink($orignalImg);
                }
                
                $ordertagsModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Order Tag was successfully deleted'));
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
		$ordertagIds = $this->getRequest()->getParam('ordertags');
		if (!is_array($ordertagIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Order Tag(s)'));
		} else {
			try {
				foreach ($ordertagIds as $ordertagId) {
					$this->_ordertagsDelete($ordertagId);
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

	protected function _ordertagsDelete($ordertagId)
	{
		$ordertagsModel = Mage::getModel('ordertags/ordertags');
		$ordertagsModel->load($ordertagId);
		$fileName=$ordertagsModel->getIcon();
		$orignalImg = Mage::getBaseDir('media') . DS . $fileName;
		
		 
		if(file_exists($orignalImg)) {
			unlink($orignalImg);
		}
		
		$model = Mage::getModel('ordertags/ordertags')->load($ordertagId);
		$model->delete();
	}
    /* Order Tags Mass Delete Action Ends */
    /* Order Tags Mass Status Action Starts */
    public function massStatusAction()
    {
        $productIds = (array)$this->getRequest()->getParam('ordertags');
         
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $status     = (int)$this->getRequest()->getParam('status');
        
        try {
           // $this->_validateMassStatus($productIds, $status);
            /*Mage::getSingleton('catalog/product_action')
                ->updateAttributes($productIds, array('status' => $status), $storeId);*/
            foreach($productIds as $productId)
            {
                $statusData = Mage::getModel('ordertags/ordertags')->chagneTagsStatus($productId, $status);
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
                ->addException($e, $this->__('An error occurred while updating the product(s) status.'));
        }

        $this->_redirect('*/*/', array('store'=> $storeId));
    }
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('ordertags/adminhtml_ordertags_grid')->toHtml()
        );
    }
}


