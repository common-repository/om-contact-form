<?php
/* Plugin Name: Om Contact Form
 * Plugin URI: http://sanditsolution.com/
 * Description:Om contact form, Quick contact to admin . 
 * Version: 1.0.05
 * Author:Siddharth Singh
 * Author URI:http://sanditsolution.com/about
 * License: GPLv2 or later
 *License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
 
global $om_contact_form_db_version;
$om_contact_form_db_version = "1.0";
function om_contact_form_db_install() {
   global $wpdb;
   global $om_contact_form_db_version;
   $charset_collate = $wpdb->get_charset_collate();
   
   $table_name = $wpdb->prefix . "om_contact_form";
	$sql="CREATE TABLE $table_name (
  `om_contact_form_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `message` text COLLATE latin1_general_ci,
  `no_of_reply` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`om_contact_form_id`),
  UNIQUE KEY `om_contact_form_id_UNIQUE` (`om_contact_form_id`)
)$charset_collate;";	
   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
   add_option( "om_contact_form_db_version", $om_contact_form_db_version );
}

register_activation_hook( __FILE__, 'om_contact_form_db_install' );

add_filter( 'plugin_action_links', 'om_contact_form_add_action_plugin', 10, 5 ); 
function om_contact_form_add_action_plugin( $actions, $plugin_file ){static $plugin; if(!isset($plugin))$plugin = plugin_basename(__FILE__); 
if ($plugin == $plugin_file) { $more_product = array('more product' => '<a href="http://www.sanditsolution.com/shops/">' . __('More Product', 'General') . '</a>');$site_link = array('support' => '<a href="http://www.sanditsolution.com/contact.html" target="_blank">Support</a>');
$became_client = array('became client' => '<a href="http://doc.sanditsolution.com/register/" target="_blank">Became Client</a>');
$actions = array_merge($more_product, $actions);$actions = array_merge($site_link, $actions);$actions = array_merge($became_client, $actions);
}return $actions;}

include_once dirname( __FILE__ ) . '/shortcode.php'; 
include_once dirname( __FILE__ ) . '/including_js_css.php';
include_once dirname( __FILE__ ) . '/mail_function.php';
if ( is_admin() ) :
require_once dirname( __FILE__ ) . '/admin-menu/admin_main_menu.php';
require_once dirname( __FILE__ ) . '/admin-menu/admin_sub_menu.php';
endif;

function om_contact_form_db_uninstall() {
        global $wpdb;
        $table = $wpdb->prefix."om_contact_form";
        //Delete any options thats stored also?
	    delete_option('om_contact_form_db_version');
	    $wpdb->query("DROP TABLE IF EXISTS $table");
} register_deactivation_hook( __FILE__, 'om_contact_form_db_uninstall' ); ?>