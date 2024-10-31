/*
*Developed and Maintaining by:Siddharth Singh, v 01.00
*Detail:Use for Om contact form
*Author URI: http://fileworld.in/
*Email:siddharthsingh91@gmail.com
*/

/********************************
****js function on page load*****
*********************************/
jQuery(function(){
jQuery('#omFormStart input[name="phone"]').keyup(function () {this.value = this.value.replace(/[^0-9\.]/g,'');});	
	})
	

/***********************
****js for ie8 only****
***********************/
var isIE8 = jQuery.browser.msie && +jQuery.browser.version === 8;
if ( isIE8 ) {
jQuery('#omContactUsCaller').css({'left':'-4px'});
}
/***********************
****js for ie8 end******
***********************/


/********************
**js for close form**
********************/
function closeFormContainer(){
jQuery("#omMainContaner").fadeOut()
}


/********************
**js for open form***
********************/
function openFormContainer(){
jQuery("#omMainContaner").fadeIn('500');
/************************************************************
****below js restrict user, Input only number in text box****
************************************************************/	
jQuery('#omFormStart input[name="phone"]').keyup(function () {this.value = this.value.replace(/[^0-9\.]/g,'');}); 
}


	
/******************
****js for form****
*******************/	
function omFormSubmit(){		
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	contactDetail=new Object();
	contactDetail.f_name=jQuery('#omFormStart input[name="f_name"]').val();
	contactDetail.l_name=jQuery('#omFormStart input[name="l_name"]').val();
	contactDetail.email=jQuery('#omFormStart input[name="email"]').val();	
	contactDetail.phone=jQuery('#omFormStart input[name="phone"]').val();
	contactDetail.detail=jQuery('#om_detail_message').val();
	contactDetail.om_admin_email=jQuery('#om_admin_email').val();
	contactDetail.om_thank_message=jQuery('#om_thank_message').val();
	
   if(contactDetail.f_name==""){jQuery('#omMessageOutput').html('<p class="om_error">*Please enter your first name</p>'); return false;}
   else if(contactDetail.email==""){jQuery('#omMessageOutput').html('<p class="om_error">*Please enter your email address</p>'); return false;}
   else if( !emailReg.test( contactDetail.email ) ) {jQuery('#omMessageOutput').html('<p class="om_error">Please enter valid email address</p>');
    return false;
   } else {
	jQuery.ajax({
		beforeSend:function(){
			jQuery('#omMessageOutput').html('<p class="om_loading"></p>');
			},		
		type:'POST',
		url: om_from_ajax_script.ajaxurl,
		data:{'contactDetail': contactDetail, 'action': 'om_responce'}
		}).success(function(resultData){
		  if(jQuery.trim(resultData) == "success"){
		  jQuery('#omFormStart').hide();
    	  jQuery('#omMessageOutput').html('<p class="om_thank_message">'+contactDetail.om_thank_message+'</p>'); return false;
				}else{
				jQuery('#omMessageOutput').html('<p class="om_error">!Something went wrong try again later</p>'); return false;	
					}
			}).error(function(){
				jQuery('#omMessageOutput').html('<p class="om_error">Something went wrong try again later</p>'); return false;
				})
	return false;
	}}	