<?php  function form_html($atts){ 
$html_form=NULL; 
$admin_email = get_option( 'admin_email' ); 
$receiver_detail= shortcode_atts( array( 'om_pop_up' => 'on', 'om_form_color' => 'omWhite', 'om_admin_email' => $admin_email,'om_thank_message' => 'Your message has been successfully sent. We will contact you very soon!', ), $atts );
 if($receiver_detail['om_pop_up']=='on') : 
$html_form = '<div id="omContactUsCaller" onclick="openFormContainer();" class="'.$receiver_detail['om_form_color'].'">Contact Us</div>'; endif; 
$html_form .= "<div ";if($receiver_detail['om_pop_up']=='on') { $html_form .= 'id="omMainContaner"'; } $html_form .= ">"; 
$html_form .='<div id="omInnerContainer" class="'. $receiver_detail['om_form_color'].'">'; 
if($receiver_detail['om_pop_up']=='on') { 
$html_form .= '<div id="omCloseButton" onclick="closeFormContainer();"><img src="';  
$html_form .= plugins_url('/images/close.png', __FILE__); 
$html_form .= '" /></div><div class="omClear"></div>'; } 
$html_form .='<h1 id="omHeading">Contact Us</h1>
<div id="omMessageOutput"></div>
<form id="omFormStart">
<div id="omFormContaner">
<div><label class="omLable">First Name:<span class="om_compalsari">*</span></label><input type="text"  name="f_name" value="" placeholder="Your First Name Please" required/></div><br/>
<div><label class="omLable">Last Name:</label><input type="text"  name="l_name" value="" placeholder="Your Last Name Please" /></div><br/>
<div><label class="omLable">Email:<span class="om_compalsari">*</span></label><input type="email"  name="email" value="" placeholder="Your Email Please" required/></div><br/>
<div><label class="omLable">Phone No:</label><input type="text" name="phone" value="" placeholder="Your Phone Number Please" /></div><br/>
<div><label class="omLable">Detail:</label><textarea name="detail" id="om_detail_message"></textarea></div><br/>
<input type="hidden" value="'.$receiver_detail['om_admin_email'].'" id="om_admin_email" />
<input type="hidden" value="'.$receiver_detail['om_thank_message'].'" id="om_thank_message" />
</div>
<div id="omFormFooter">
<input type="reset" name="submit" value="Clear" />
<input type="button" name="submit" value="Submit" onclick="omFormSubmit()"/></div>
</form>
</div>
</div>'; return $html_form; 
} ?>