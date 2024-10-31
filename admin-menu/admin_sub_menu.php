<?php ob_start(); add_action('admin_menu', 'register_my_custom_submenu_page'); function register_my_custom_submenu_page() {
add_submenu_page('om-contact-form-page','Om Contact Form','Contact Report', 'manage_options','om-contact-form-submenu-page','admin_sub_menu_function' );}
function admin_sub_menu_function(){ ?><div class="om_form_import_as_csv">
<h1>Export Your Report</h1><form method="POST">
<label>Start Date:</label><input type="text" class="om_date_field" name="om_start_date" value="" required="required"/>
<label>End Date:</label><input type="text" class="om_date_field" name="om_end_date" value="" required="required"/>
<div class="om_clear margin_twelve_top"></div>
<input type="reset" name="submit" value="Clear" />
<input type="submit" name="om_download_csv" value="Download your contact report"/>
</form></div><?php
if(isset($_POST['om_download_csv']))
{
if(isset($_POST['om_start_date'])!=""){ $om_start_date=date('Y-m-d',strtotime($_POST['om_start_date']));}else{$om_start_date='1970-01-01';}
if(isset($_POST['om_end_date'])!=""){$om_end_date=date('Y-m-d',strtotime($_POST['om_end_date']));}else{$om_start_date='2050-01-01';}
global $wpdb;
$table_name = $wpdb->prefix."om_contact_form";
ob_clean();
$om_fetch_rows_csv= $wpdb->get_results("SELECT * FROM `$table_name` WHERE  date >= '$om_start_date'  AND date < '$om_end_date'", ARRAY_N);
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"report.csv\";" );
header("Content-Transfer-Encoding: binary");
$om_output = fopen('php://output', 'w');
fputcsv($om_output, array('No', 'Name','Email','Phone','Date','Message','No Of Reply'));
foreach($om_fetch_rows_csv as $om_row_data){ 
fputcsv($om_output, $om_row_data);}
fclose($om_output); 
die();}} ?>