<?php
add_action( 'wp_ajax_om_responce', 'om_contact_form_submit' );
add_action( 'wp_ajax_nopriv_om_responce', 'om_contact_form_submit' );
function om_contact_form_submit(){
$detail =(object) $_POST['contactDetail'];
ob_start();?>
<table border="1" cellpadding="8" cellspacing="8" width="400" style="margin-left:auto; margin-right:auto;">
<thead><tr><td colspan="2" bgcolor="#999999" style="color:#FFFFFF;"><h1>New user contact you</h1></td></tr></thead>
<tbody>
<tr><th width="120">First Name:</th><td><?=ucfirst($detail->f_name);?></td></tr>
<tr><th width="120">Last Name:</th><td><?=ucfirst($detail->l_name);?></td></tr>
<tr><th width="120">Email:</th><td><?=ucfirst($detail->email);?></td></tr>
<tr><th width="120">Phone:</th><td><?=ucfirst($detail->phone);?></td></tr>
<tr><th width="120">Detail:</th><td><?=ucfirst($detail->detail);?></td></tr>
</tbody>
<tfoot><tr><td colspan="2" bgcolor="#999999" style="color:#FFFFFF;"><?="&copy; copyright 2014" ?></td></tr></tfoot>
</table>
<?php
$om_message = ob_get_clean();
$siteUrl=get_site_url();
$finalUrlValue=str_replace("http://","",$siteUrl);
$om_admin_email=$detail->om_admin_email;
$subject='[New user contact you] on '.$finalUrlValue;
$headers  = "From: ".$om_admin_email."\r\n";
$headers .= "Reply-To:".$om_admin_email."\r\n";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$finalUrlValue.' <'.$finalUrlValue.'>' . "\r\n";
if(wp_mail( $om_admin_email, $subject, $om_message, $headers)){

$om_user_name=$detail->f_name." ".$detail->l_name;
$om_user_email=$detail->email;
$om_user_phone_no=$detail->phone;
$om_message=$detail->detail;
global $wpdb;
$table_name = $wpdb->prefix . "om_contact_form";
$rows_affected = $wpdb->insert( $table_name, array( 'name' => $om_user_name, 'email' =>$om_user_email, 'phone' => $om_user_phone_no,'date'=>current_time('mysql') , 'message'=>$om_message) );	
echo ($rows_affected) ? 'success' : 'error' ;
} die();}?>