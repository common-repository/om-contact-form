<?php
function contact_us_admin_menu_regs(){
 add_menu_page(
 'Om Contact Form',
 'Om Contact', 
 'manage_options',
 'om-contact-form-page',
 'admin_pagination_function', 
 plugins_url( '/../images/om-contact.png', __FILE__),'3'); }	
add_action('admin_menu','contact_us_admin_menu_regs');


function admin_pagination_function(){ 
/**********************************************
*********php function to show pagination no****
***********************************************/
global $current_user;
?> 
<div id="om_message_Comtaner">
  <div id="om_show_message">
    <p id="om_cross" onClick="hideError()"><img src="<?php echo plugins_url('../images/close.png', __FILE__);?>" /></p>
	 <div id="omMessageOutput"></div>
     <div class="om_clear"></div>
     <div id="om_conatnt_reply">
		<form id="omFormStart">
		<div id="omFormContaner">
		<div><label class="omLable">Your Email:<span class="om_compalsari">*</span></label>
		<input type="email"  name="om_admin_email" value="<?=$current_user->user_email?>" placeholder="Your Email" required="required"/></div>
		<br/>
		<div><label class="omLable">Subject:<span class="om_compalsari">*</span></label>
		<input type="text"  name="om_reply_subject" value="" placeholder="Your Subject" required="required"/></div>
		<br/>
		<div><label class="omLable">Message:</label>
		<textarea name="om_reply_message" id="om_reply_message" required="required"></textarea></div>
		<br/>
		</div>
		<div id="omFormFooter">
		<input type="hidden" name="om_contact_id" value="" id="om_contact_id"/>
		<input type="reset" name="submit" value="Clear" />
		<input type="button" name="submit" value="Submit" onclick="om_reply_submit()"/></div>
		</form>
	</div>
    <p style="om_clear:both;"></p>
  </div>
</div>
<?php global $wpdb;$table_name = $wpdb->prefix . "om_contact_form";
$om_total_Row_count = $wpdb->get_var( "SELECT COUNT(*) FROM `$table_name`" );
$item_per_page=10;$om_no_pages=ceil($om_total_Row_count/$item_per_page);
$pagination = ''; 
if($om_no_pages > 1)
{$pagination .= '<ul class="om_paginate">';
for($i = 1; $i<=$om_no_pages; $i++)
{if($i==1) {$pagination.= '<li><a href="#" class="om_paginate_click" id="'.$i.'-page">'."<<".'</a></li>'; }
else if($i==$om_no_pages){ $pagination.='<li><a href="#" class="om_paginate_click" id="'.$i.'-page">>></a></li>';}
else{ $pagination .= '<li><a href="#" class="om_paginate_click" id="'.$i.'-page">'.$i.'</a></li>';}}
$pagination .= '</ul>';}
echo '<div id="results"></div>';
echo $pagination;  } 
/**********************************************
*********php for calling table through ajax****
***********************************************/
add_action( 'wp_ajax_om_admin_pagination_responce', 'om_ajax_pagination_response');
function om_ajax_pagination_response(){
global $wpdb;
$table_name = $wpdb->prefix . "om_contact_form";
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
if(!is_numeric($page_number)){die('Invalid page number!');}
$item_per_page=10;
$om_data_position = ($page_number * $item_per_page);
$om_pagination_results = $wpdb->get_results( "SELECT * FROM `$table_name` ORDER BY `om_contact_form_id` DESC LIMIT $om_data_position, $item_per_page" );
if($om_pagination_results) :
?>
<table id="om_table">
<caption><h2>Om Contact Table</h2></caption>
    <thead>
        <tr>
           <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date</th>
            <th>Message</th>
            <th>No Of Reply</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
   <?php  foreach($om_pagination_results as $om_data ) {
	   $om_comment_date=date('d M Y, h:i A',strtotime($om_data->date));
	   ?>
    <tr>
        <td><?=$om_data->om_contact_form_id;?></td>
        <td><?=$om_data->name;?></td>
        <td><?=$om_data->email;?></td>
        <td><?=$om_data->phone;?></td>
        <td><?=$om_comment_date;?></td>
        <td><?=$om_data->message;?></td>
        <td><?=$om_data->no_of_reply;?></td>
        <td><input type="button" value="Reply" name="reply" class="om_reply_button" onclick="om_contact_reply(<?=$om_data->om_contact_form_id;?>)"/></td>    
     </tr> 
   <?php } ?>
    </tbody>
<tfoot></tfoot>
</table>
<?php die(); else : ?> 
<h1>No contact form data found</h1>
<?php die(); endif;} 
/*********************************************
*****working on ajax reply response***********
**********************************************/
add_action( 'wp_ajax_om_reply_responce', 'om_ajax_reply_responce');
function om_ajax_reply_responce(){
$detail_reply =(object) $_POST['contactReply'];
$siteUrl=get_site_url();
$finalUrlValue_reply=str_replace("http://","",$siteUrl);
$contact_id=$detail_reply->contact_id;
$om_email_admin=$detail_reply->email;
$om_message=$detail_reply->message;
$om_subject=$detail_reply->subject;

/*************************************
***fetching data from database********
***************************************/
global $wpdb;
$table_name = $wpdb->prefix."om_contact_form";
$get_id_detail= $wpdb->get_row("SELECT * FROM `$table_name` where om_contact_form_id='$contact_id'");
$om_reciver_name=$get_id_detail->name;
$om_reciver_email=$get_id_detail->email;
$no_of_reply=$get_id_detail->no_of_reply;
/******************************************
***fetching data from database end*********
*******************************************/	


/***********************************************
*****working on reply email message start*******
************************************************/
ob_start(); ?>
<table border="1" cellpadding="8" cellspacing="8" width="400" style="margin-left:auto; margin-right:auto;">
<thead><tr><td colspan="2" bgcolor="#999999" style="color:#FFFFFF;"><h1><?=$finalUrlValue_reply?></h1></td></tr></thead>
<tbody>
<tr><th width="120">Message:</th><td><?=ucfirst($detail_reply->message);?></td></tr>
</tbody>
<tfoot><tr><td colspan="2" bgcolor="#999999" style="color:#FFFFFF;"><?="&copy; copyright 2014" ?></td></tr></tfoot>
</table>
<?php
$om_reply_message = ob_get_clean();
$headers  = "From: ".$om_email_admin."\r\n";
$headers .= "Reply-To:".$om_email_admin."\r\n";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$finalUrlValue_reply.' <'.$om_email_admin.'>' . "\r\n";
if(wp_mail( $om_reciver_email, $om_subject, $om_reply_message, $headers)){
/***********************************************
*****working on reply email message end*********
************************************************/




/***************************************
***updating data from database start****
***************************************/
$no_of_reply=$no_of_reply+1;
$rows_updated=$wpdb->query("UPDATE `$table_name` SET `no_of_reply` = '$no_of_reply'	WHERE om_contact_form_id='$contact_id'");
/**************************************
***updating data from database end*****
***************************************/
echo ($rows_updated) ? 'Your Reply sent successfully to '.$om_reciver_name : 'error' ;
} die(); }
?>