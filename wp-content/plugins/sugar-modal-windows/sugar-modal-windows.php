<?php
/*
Plugin Name: Sugar Modal Windows
Plugin URI: http://pippinsplugins.com/sugar-modal-windows-plugin/
Description: Easily create modals windows that can be placed anywhere in your website
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
Version: 1.2.1
*/

// plugin root folder
$smw_base_dir = WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__), "" ,plugin_basename(__FILE__));

/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function smw_textdomain() {
	load_plugin_textdomain( 'sugar_modal', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('init', 'smw_textdomain');


/*****************************
* includes *******************
*****************************/
include( dirname(__FILE__) . '/includes/scripts.php');
include( dirname(__FILE__) . '/includes/misc-functions.php');
include( dirname(__FILE__) . '/includes/post-types.php');

if(is_admin()) {
	include( dirname(__FILE__) . '/includes/metabox.php');
	include( dirname(__FILE__) . '/includes/tiny-mce-button.php');
	include( dirname(__FILE__) . '/includes/help-page.php');
} else {
	include( dirname(__FILE__) . '/includes/shortcodes.php');
}

function smw_menu_page() {
	add_submenu_page('edit.php?post_type=modals', 'Help', 'Help','edit_posts', __FILE__, 'smw_help_page');
}
add_action('admin_menu', 'smw_menu_page');
