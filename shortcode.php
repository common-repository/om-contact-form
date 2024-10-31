<?php function custom_form_by_fileword($atts){ 
include_once ('include/html.php');
return form_html($atts);
 } add_shortcode( 'om_contact_form', 'custom_form_by_fileword' ); ?>