/*
*Developed and Maintaining by:Siddharth Singh, v 01.00
*Detail:admin js for showing result in pagination
*Author URI: http://fileworld.in/
*Email:siddharthsingh91@gmail.com
*/
jQuery(document).ready(function() {
/********************************************
****Js for initialization of contact table***
*********************************************/	
jQuery("#results").prepend('<div class="loading-indication"><p class="om_loading_admin"></p><p class="om_loading_sending">Loading...</p></div><div class="om_clear"></div>');
jQuery("#results").load(om_admin_pagination_call.ajaxurl,
{'action': 'om_admin_pagination_responce','page':0}, 
function() {jQuery("#1-page").addClass('active');}); 
	jQuery(".om_paginate_click").click(function (e){
	jQuery("#results").prepend('<div class="loading-indication"><p class="om_loading_admin"></p><p class="om_loading_sending">Loading...</p></div><div class="om_clear"></div>');
	var clicked_id = jQuery(this).attr("id").split("-"); 
	var page_num = parseInt(clicked_id[0]); 
	jQuery('.paginate_click').removeClass('active'); 
	jQuery("#results").load(om_admin_pagination_call.ajaxurl,{'action': 'om_admin_pagination_responce','page': (page_num-1)}, 
	function(){//do someting with pagination heare
			});	
			jQuery('.om_paginate > li > a').removeClass('om_active_page');
			jQuery(this).addClass('om_active_page'); return false; 
    });
});



/**************************************
****js for opening reply pop up********
***************************************/	
function om_contact_reply(om_contact_id){
jQuery("#om_message_Comtaner").show();
jQuery("#omFormStart").show();
jQuery('.om_thank_message').hide();
jQuery('#omFormStart input[name="om_reply_subject"]').val('');
jQuery('#om_reply_message').val('');	
jQuery("#om_contact_id").val(om_contact_id);
console.log(om_contact_id)
}


/***************************************
****js for closeing reply pop up********
***************************************/	
function hideError(){
	jQuery("#om_message_Comtaner").hide();	
}	


function om_reply_submit(){
	contactReply=new Object();
	contactReply.email=jQuery('#omFormStart input[name="om_admin_email"]').val();
	contactReply.subject=jQuery('#omFormStart input[name="om_reply_subject"]').val();
	contactReply.message=jQuery('#om_reply_message').val();	
	contactReply.contact_id=jQuery('#omFormStart input[name="om_contact_id"]').val();	
	jQuery.ajax({
		beforeSend:function(){jQuery('#omMessageOutput').html('<p class="om_loading_admin"></p><p class="om_loading_sending">Sending...</p>');},		
		type:'POST',
		url: om_admin_pagination_call.ajaxurl,
		data:{'contactReply': contactReply,'action': 'om_reply_responce'}
		}).success(function(resultData){
		  if(jQuery.trim(resultData) != "error"){
			  jQuery("#omFormStart").hide();
			  jQuery('#omMessageOutput').html('<p class="om_thank_message">'+resultData+'</p>');
		  }else{
				jQuery('#omMessageOutput').html('<p class="om_error">!Something went wrong try again later</p>'); return false;	
					}
		  }).error(function(){
				jQuery('#omMessageOutput').html('<p class="om_error">Something went wrong try again later</p>');
				return false;
				})
}


/********************************************
****below js for date picker*****************
*********************************************/
jQuery(document).ready(function() {
    jQuery('.om_date_field').datepicker({
        dateFormat : 'dd-mm-yy'
    });
});


		