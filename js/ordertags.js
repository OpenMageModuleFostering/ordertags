
jQuery.noConflict();

jQuery( document ).ready(function() {
	
	var OrderConditionId= jQuery("#orderconditions_id").val();
	if(OrderConditionId!='')
		{
			jQuery('#condition_type_id').prop('disabled', 'disabled');
			jQuery('#tags_id').prop('disabled', 'disabled');
		}

	});

/*Function Displaying the images for the Tags*/
function getValueAlert(rUrl,val)
{
   
   new Ajax.Request(rUrl,
    {
	     method:'get',
	     parameters: {value: ''+val},
	     onSuccess: function(transport)
             {
	    	//alert(transport.responseText);
                
			var response = transport.responseText || "";
                        jQuery("#note3").html(response);
                        
			if(response=='')
			{
				jQuery("#note3").html('Image Not Found Please Try Again Later.');
			}
			
		
	    }
    });
	
}

/*Function Displaying the Text box for the Order SubTotal */

function getSubTotal(rUrl,cond_id,val)
{
   
   new Ajax.Request(rUrl,
    {
	     method:'get',
	     parameters: {value: ''+val},
	     onSuccess: function(transport)
             {
               var response = transport.responseText || "";
               //  alert(response);       
               jQuery('#condition_type_id').parent().parent().after(response);
                        
               if(response=='')
               {
                        
                       jQuery("#note4").html('Input Field Not Found Please Try Again Later.');
               }
               else
               {
                  
                  if (cond_id=="")
                  {
                      orderCondition=jQuery("#condition_type_id").val();
                     if (orderCondition==1)
                     {
                        jQuery("#grand_total").remove();
                        jQuery("#order_status").remove();
                        jQuery("#shipping_country").remove();
                        jQuery("#billing_country").remove();
                        jQuery("#shipping_countrytr").remove();
                     }
                     else if (orderCondition==2)
                     {
                        jQuery("#sub_total").remove();
                        jQuery("#order_status").remove();
                        jQuery("#shipping_country").remove();
                        jQuery("#billing_country").remove();
                        jQuery("#shipping_countrytr").remove();
                     }
                     else if (orderCondition==3)
                     {
                        jQuery("#sub_total").remove();
                        jQuery("#grand_total").remove();
                        jQuery("#shipping_country").remove();
                        jQuery("#shipping_countrytr").remove();
                        jQuery("#billing_country").remove();
                     }
                     else if (orderCondition==4)
                     {
                        jQuery("#grand_total").remove();
                        jQuery("#order_status").remove();
                        jQuery("#sub_total").remove();
                        jQuery("#billing_country").remove();
                     }
                     else if(orderCondition==5)
                     {
                        jQuery("#sub_total").remove();
                        jQuery("#order_status").remove();
                        jQuery("#shipping_country").remove();
                        jQuery("#shipping_countrytr").remove();
                        jQuery("#grand_total").remove();
                     }
                  }
                  else
                  {
                     
                     
                     if (cond_id==1 && val==2)
                     {
                     
                              jQuery("#grand_total").show();
                              jQuery("#order_status").remove();
                              jQuery("#order_sub_total").remove();
                              jQuery("#billing_country").remove();
                              jQuery("#shipping_country").remove();
                     }
                  }
                    
              
               }
                  
                 
                  
            }
         
               
       
    });
	
}
