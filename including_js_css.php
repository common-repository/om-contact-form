<?php /**********************************
*****working on js and css*********
***********************************/
function register_script() {
	wp_register_script( 'om_form_jquery', plugins_url('/js/om_script.js', __FILE__), array('jquery'), '1.0.0', true );	
	wp_register_style( 'om_form_style', plugins_url('/css/om_style.css', __FILE__),array(), '1.0.1', 'all');     
	wp_enqueue_script( 'om_form_jquery' );
	wp_localize_script( 'om_form_jquery', 'om_from_ajax_script', array( "ajaxurl" => admin_url( "admin-ajax.php" ) ) );
    wp_enqueue_style( 'om_form_style' );
}
add_action('wp_enqueue_scripts', "register_script");



function my_admin_theme_style() {
wp_enqueue_script( 'om_admin_script', plugins_url('/js/om_admin_script.js', __FILE__), array('jquery'), '1.0.0', true );
wp_localize_script( 'om_admin_script', 'om_admin_pagination_call', array( "ajaxurl" => admin_url( "admin-ajax.php" ) ) );	
wp_enqueue_style('om_admin_theme', plugins_url('/css/om_admin_style.css', __FILE__),array(), '1.0.0', 'all');


wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', plugins_url('/css/jquery-ui.css', __FILE__),array(), '1.0.0', 'all');
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style'); ?>