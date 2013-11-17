<?php
/*
=== FourSquareAPI ===

Plugin Name: FourSquareAPI
Plugin URI: http://nzguru.net/cool-stuff/foursquareapi-plugin-for-wordpress
Description: The 1st plugin to integrate the foursquare&reg; API into Wordpress to show your checkins and badges
Author URI: http://nzguru.net
Author: the Guru
Version: 2.0.6
License: GPL2
	Copyright 2011  the Guru  (email : admin[at]nzguru.net)
	
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/** code required to handle the foursquare OAuth callback .. ugly, but the best I can do for now */
if( array_key_exists( 'code', $_GET ) && !function_exists( 'get_bloginfo' ) ) {
	require_once( '../../../wp-config.php' );
	$foursquare = new FourSquareAPI_API( get_option( 'FourSquareAPI_client_id' ), get_option( 'FourSquareAPI_client_secret' ), plugins_url() . '/' . dirname( plugin_basename( __FILE__ ) ) . '/FourSquareAPI.php' );
	$token = $foursquare->get_token( $_GET['code'] );
	update_option( 'FourSquareAPI_oauth_token', $token );
	wp_redirect( get_bloginfo( 'wpurl' ) . '/wp-admin/options-general.php?page=FourSquareAPI.php' );
}

class FourSquareAPIException extends Exception {}

class FourSquareAPI {
	function __construct() {
		if( '' == get_option( 'FourSquareAPI_oauth_token' ) ) {
			$message = sprintf( __( 'foursquare&reg; requires authentication by OAuth. You will need to <a href="%s">update your settings</a> to complete installation of FourSquareAPI.', 'FourSquareAPI'), admin_url( 'options-general.php?page=FourSquareAPI.php' ) );
			add_action( 'admin_notices', create_function( '', "if ( ! current_user_can( 'manage_options' ) ) { return; } else { _e( '<div class=\"error\"><p>$message</p></div>' );}" ) );
		}
		add_action( 'admin_menu', array( $this, 'insert_admin_menu_link' ) );
#		add_action( 'init', array( $this, 'route_actions' ), 2 );
		add_action( 'init', array( $this, 'set_language' ), 1 );
		add_action( 'wp_print_styles', array( $this, 'styles' ) );
		add_action( 'wp_print_scripts', array( $this, 'scripts' ) );
		add_action( 'widgets_init', array( $this, 'initialize_widget' ) );
		add_filter( 'plugin_action_links', array( $this, 'insert_settings_link' ), 10, 2 ); 
		add_shortcode( 'foursquare_venues', array( 'FourSquareAPIVenuesShortcode', 'venues_shortcode' ) );
		add_shortcode( 'foursquare_badges', array( 'FourSquareAPIBadgesShortcode', 'badges_shortcode' ) );
		$this->errors = new WP_Error();
	}

	function insert_admin_menu_link() {
		$page = add_submenu_page( 'options-general.php', __( 'FourSquareAPI Settings', 'FourSquareAPI' ), __( 'FourSquareAPI', 'FourSquareAPI' ), 'edit_plugins', 'FourSquareAPI', array( $this, 'config_page_html' ) );
#		add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_scripts' ) );
#		add_action( 'admin_print_styles-' . $page, array( $this, 'admin_styles' ) );
		add_action( 'admin_init', array( $this, 'register_admin_settings' ) );
	}

	function insert_settings_link( $links, $file ) {
		static $this_plugin;
		if( !$this_plugin )
			$this_plugin = plugin_basename( __FILE__ );
		if( $file == $this_plugin ) {
			$settings_link = '<a href="options-general.php?page=FourSquareAPI">' . __( 'Settings', 'FourSquareAPI' ) . '</a>'; 
			array_unshift( $links, $settings_link ); 
		}
		return $links; 
	}
	
	function admin_scripts() {
#		// wp_enqueue_script allows us to include JavaScript files.
#		wp_enqueue_script(
#			'FourSquareAPI_Admin', // This is a unique identifier for this .js file. This is how WordPress can tell if a .js file has already been loaded.
#			WP_PLUGIN_URL.'/FourSquareAPI/js/admin.js', // This is the path to the .js file
#			array( 'jquery' ) // This is an array of JavaScript files that this .js file depends on. If these files are not loaded, then WordPress will make sure to load them before your .js file. My file depends on jquery, so by entering the identifier "jquery" here, it will automatically be included. There's no need for me to include the jquery files in my plugin, because WordPress already includes the library. For a complete list of scripts available in WordPress can be found here: http://codex.wordpress.org/Function_Reference/wp_enqueue_script
#		);
#		
#		// wp_localize_script allows us to pass some variables that need to be generated with PHP into our JavaScript. For example, any text we use in our Javascript file needs to be run through our gettext function so that it can be internationalized (see chapter 4.0). Also for security purposes, when we use AJAX we need to provide our .js file with a security code, called an "nonce", to ensure that the AJAX request is coming from a valid source. We pass this variable to our JS file using the wp_localize_script function as well.
#		wp_localize_script(
#			'FourSquareAPI_Admin', // This is the unique identifier of the Javascript file that that we are localizing. This should match the unique identifier above in wp_enqueue_script
#			'FourSquareAPI', // This is the name of the object that is going to store all the variables that we set in the next parameter. So in our Javascript file, the first setting below can be accessed using FourSquareAPI.DeleteFindAndReplaceWord
#			array( // This is an array of variables that we want to send to our Javascript file. The first two are nonce security keys that we'll use in our AJAX functions to make sure the request are legit.
#				// This is an error message that we use in our JavaScript file, notice that it's wrapped in the  __() function, so that if we translate our plugin into another langauge, this error message will also be translated.
#				'AjaxError' => __('An error occurred. Please try your action again. If the problem persists please contact the plugin developer.','FourSquareAPI')
#			)
#		);
	}
	
	function admin_styles() {
#		// wp_enqueue_style lets us add CSS files to our plugin the same way we do with JavaScript files
#		wp_enqueue_style(
#			'FourSquareAPI_Admin', // Unique identifier
#			WP_PLUGIN_URL . '/FourSquareAPI/css/admin.css' // Path to the CSS file
#			// Another parameter could be added here to list dependant CSS files (e.g. a CSS Framework)
#		);
	}
	
	function styles() {
		wp_register_style( 'FourSquareAPI_CSS', WP_PLUGIN_URL . '/foursquareapi/css/FourSquareAPI.css' );
		wp_enqueue_style( 'FourSquareAPI_CSS' );
	}
	
	function scripts() {
	  wp_deregister_script( 'googlemaps' );
		wp_register_script( 'googlemaps', 'http://maps.googleapis.com/maps/api/js?sensor=false' );
	  wp_enqueue_script( 'googlemaps' );
	  wp_enqueue_script( 'jquery' );
	  wp_deregister_script( 'mobilyslider' );
		wp_register_script( 'mobilyslider', WP_PLUGIN_URL . '/foursquareapi/js/mobilyslider.js', 'jquery' );
	  wp_enqueue_script( 'mobilyslider' );
	}
	
	function register_admin_settings() {
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_client_id' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_client_secret' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_oauth_token' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_venuehistory_api_calls' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_venuehistory_cache' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_venuehistory_cache_time' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_venuehistory_cache_life' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_checkins_api_calls' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_checkins_cache' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_checkins_cache_time' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_checkins_cache_life' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_mayorships_api_calls' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_mayorships_cache' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_mayorships_cache_time' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_mayorships_cache_life' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_badges_api_calls' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_badges_cache' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_badges_cache_time' );
		register_setting( 'FourSquareAPISettings', 'FourSquareAPI_badges_cache_life' );
	}
	
	function config_page_html() {
		$content = '';
		ob_start(); // This function begins output buffering, this means that any echo or output that is generated after this function will be captured by php instead of being sent directly to the user.
			require_once( 'html/config.php' ); // This function includes my configuration page html. Open the file html/config.php to see how to format a configuration page to save options.
			$content = ob_get_contents(); // This function takes all the html retreived from html/config.php and stores it in the variable $content
		ob_end_clean(); // This function ends the output buffering
		echo $content; // Now I simply echo the content out to the user
	}

	function route_actions() {
#		if( !isset( $_REQUEST['FourSquareAPI_Action'] ) ) return false;
#		$action = $_REQUEST['FourSquareAPI_Action'];
#		if( $action ) { // This code verifies the nonce value that was sent with the action. This is  avery important check that ensures that a malicious user cannot use your plugin to compromise the WordPress installation. Without this check, your plugin introduces a serious security vulnerability to whomever uses the plugin.
#			check_admin_referer( $action );
#		}
#		// Pass the action name to our function that executes the actions
#		$result = $this->do_action( $action );
#		// If it was an Ajax call, then pass our action to the function that will generate the updated html
#		if( $this->is_ajax() ) {
#			$this->ajax_response( $action );
#		}
	}
	
	function do_action( $action ) {
#		$result = false;
#		switch( $action ) { // Check which action was requested, and send the required POST variables to the function to make it happen
#			case 'AddFindAndReplaceWord':
#				$result = $this->AddFindAndReplaceWord($_POST['FourSquareAPI_Find'], $_POST['FourSquareAPI_Replace']);
#			break;
#			case 'DeleteFindAndReplaceWord':
#				$result = $this->DeleteFindAndReplaceWord($_POST['FourSquareAPI_Id']);
#			break;
#			case 'AddFactCheck':
#				$result = $this->AddFactCheck($_POST['FourSquareAPI_PostId'], $_POST['FourSquareAPI_Fact'], $_POST['FourSquareAPI_Comment'], $_POST['FourSquareAPI_Source']);
#			break;
#		}
#		return $result;
	}
	
	function ajax_response( $action ) {
#		// This object will contain all the data we need to pass to our JavaScript file to update the page. This PHP variable will be converted into JavaScript Object Notation (JSON) so that our JavaScript file can use this variable.
#		$data = array();
#		/* If errors were triggered get them and add them to the error element of data array*/
#		if( $this->errors->get_error_message() ) {
#			$data['error'] = $this->errors->get_error_message();
#		}
#		elseif( $this->success ) { // If no errors were found, and a success message was set, add it to the success element of the data array
#			$data['success'] = $this->success;
#		}
#		// Check which action was requested, and send the required POST variable to the function in order to get the updated HTML elements that we need to update
#		switch( $action ) {
#			case 'AddFindAndReplaceWord':
#				$data['html'] = $this->RuleListHtml();
#			break;
#			case 'DeleteFindAndReplaceWord':
#				$data['html'] = $this->RuleListHtml();
#			break;
#			case 'AddFactCheck':
#				$data['html'] = $this->FactCheckListHtml($_POST['FourSquareAPI_PostId']);
#			break;
#		}
#		/* Die here to stop WordPress from returning a page, instead we want it to just return the $data variable in JSON format, so our jQuery function can use it. See js/admin.js or js/fact_check.js to see how we use this variable to update the page. */
#		die( json_encode( $data ) );
	}
	
	function is_ajax() {
#		if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'XMLHttpRequest' == $_SERVER['HTTP_X_REQUESTED_WITH'] ) {
#			return true;
#		}
#		return false;
	}

	function set_language() {
		load_plugin_textdomain( 'FourSquareAPI', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}
	
	function initialize_widget() {
		register_widget( 'FourSquareAPIVenuesWidget' );
		register_widget( 'FourSquareAPIBadgesWidget' );
	}

}

class FourSquareAPIVenuesShortcode {
	function __construct() {
		add_action( 'init', array( __CLASS__, 'register_script' ) );
	}

	function register_script() {
	  wp_deregister_script( 'googlemaps' );
		wp_register_script( 'googlemaps', 'http://maps.googleapis.com/maps/api/js?sensor=false' );
		wp_enqueue_script( 'googlemaps' );
	  wp_enqueue_script( 'jquery' );
	  wp_deregister_script( 'mobilyslider' );
		wp_register_script( 'mobilyslider', WP_PLUGIN_URL . '/foursquareapi/js/mobilyslider.js', 'jquery' );
	  wp_enqueue_script( 'mobilyslider' );
		wp_register_style( 'FourSquareAPI_CSS',  WP_PLUGIN_URL . '/foursquareapi/css/FourSquareAPI.css'  );
		wp_enqueue_style( 'FourSquareAPI_CSS' );
	}
 
	function venues_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'type'       => 'venuehistory',
			'width'      => 300,
			'map_height' => 0,
			'map_zoom'   => 16,
			'address'    => 0,
			'stats'      => 0,
			'limit'      => 0,
			'list'       => 0,
			'private'    => 0,
			'autoscroll' => 0,
			'id'         => 1
		), $atts );
		return display_foursquare_venues( $atts );
	}

}

class FourSquareAPIBadgesShortcode {
	function __construct() {
		add_action( 'init', array( __CLASS__, 'register_script' ) );
	}

	function register_script() {
	  wp_deregister_script( 'googlemaps' );
		wp_register_script( 'googlemaps', 'http://maps.googleapis.com/maps/api/js?sensor=false' );
		wp_enqueue_script( 'googlemaps' );
	  wp_enqueue_script( 'jquery' );
	  wp_deregister_script( 'mobilyslider' );
		wp_register_script( 'mobilyslider', WP_PLUGIN_URL . '/foursquareapi/js/mobilyslider.js', 'jquery' );
	  wp_enqueue_script( 'mobilyslider' );
		wp_register_style( 'FourSquareAPI_CSS',  WP_PLUGIN_URL . '/foursquareapi/css/FourSquareAPI.css'  );
		wp_enqueue_style( 'FourSquareAPI_CSS' );
	}
 
	function badges_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'type'        => 'badges',
			'width'       => 300,
			'map_height'  => 0,
			'map_zoom'    => 16,
			'description' => 0,
			'limit'       => 1,
			'venue'       => 0,
			'address'     => 0,
			'stats'       => 0,
			'list'        => 1,
			'autoscroll'  => 0,
			'id'          => 1
		), $atts );
		return display_foursquare_badges( $atts );
	}

}

class FourSquareAPIVenuesWidget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'description' => __( 'This widget displays your foursquare&reg; venue data.', 'FourSquareAPI' ) );
		parent::WP_Widget( 'FourSquareAPIVenuesWidget', __( 'FourSquareAPI Venues', 'FourSquareAPI' ), $widget_ops );
		/* This function checks if this widget is currently added to any sidebars. If your widget requires external JavaScript or CSS, you should only include it if the widget is actually active. Otherwise, you'll be slowing down page loads by including these external files, when they aren't even being used! */
		if( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'template_redirect', array( $this, 'widget_external' ) );
		}
	}

	function widget_external() {
	  wp_deregister_script( 'googlemaps' );
		wp_register_script( 'googlemaps', 'http://maps.googleapis.com/maps/api/js?sensor=false' );
		wp_enqueue_script( 'googlemaps' );
	  wp_enqueue_script( 'jquery' );
	  wp_deregister_script( 'mobilyslider' );
		wp_register_script( 'mobilyslider', WP_PLUGIN_URL . '/foursquareapi/js/mobilyslider.js', 'jquery' );
	  wp_enqueue_script( 'mobilyslider' );
		wp_register_style( 'FourSquareAPI_CSS',  WP_PLUGIN_URL . '/foursquareapi/css/FourSquareAPI.css'  );
		wp_enqueue_style( 'FourSquareAPI_CSS' );
	}
	
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'type'       => 'checkins',
			'title'      => 'foursquare Venues',
			'byline'     => 'where I have been',
			'width'      => 200,
			'map_height' => 200,
			'map_zoom'   => 16,
			'address'    => 1,
			'stats'      => 1,
			'limit'      => 4,
			'list'       => 0,
			'private'    => 0,
			'autoscroll' => 5000,
			'id'         => 1,
			'link'       => 1
		) );
		echo '
			<p>
			<label for="' . $this->get_field_id( 'type' ) . '">' . __( 'Data Type', 'FourSquareAPI' ) . '</label>
			<select id="' . $this->get_field_id( 'type' ) . '" name="' . $this->get_field_name( 'type' ) . '">
				<option value="venuehistory"';
		echo ( 'venuehistory' == $instance['type'] ) ? 'selected="selected"' : '';
		echo '>' . __( 'Venue History', 'FourSquareAPI' ) . '</option>
				<option value="checkins"';
		echo ( 'checkins' == $instance['type'] ) ? 'selected="selected"' : '';
		echo '>' . __( 'Recent Checkins', 'FourSquareAPI' ) . '</option>
				<option value="mayorships"';
		echo ( 'mayorships' == $instance['type'] ) ? 'selected="selected"' : '';
		echo '>' . __( 'Mayorships', 'FourSquareAPI' ) . '</option>
			</select>
			</p>
			<p>
			<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Widget Title', 'FourSquareAPI' ) . '</label>
			<input type="text" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . attribute_escape( $instance['title'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'byline' ) . '">' . __( 'Widget Byline', 'FourSquareAPI' ) . '</label>
			<input type="text" id="' . $this->get_field_id( 'byline' ) . '" name="' . $this->get_field_name( 'byline' ) . '" value="' . attribute_escape( $instance['byline'] ).'" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'width' ) . '">' . __( 'Widget Width', 'FourSquareAPI' ) . ' <code>' . __( '(in px)', 'FourSquareAPI' ) . '</code></label>
			<input type="text" id="' . $this->get_field_id( 'width' ) . '" name="' . $this->get_field_name( 'width' ) . '" value="' . attribute_escape( $instance['width'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'map_height' ) . '">' . __( 'Map Height', 'FourSquareAPI' ) . ' <code>' . __( '(in px, 0 to disable map)', 'FourSquareAPI' ) . '</code></label>
			<input type="text" id="' . $this->get_field_id( 'map_height' ) . '" name="' . $this->get_field_name( 'map_height' ) . '" value="' . attribute_escape( $instance['map_height'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'map_zoom' ) . '">' . __( 'Initial Map Zoom Level', 'FourSquareAPI' ) . '</label>
			<input type="text" id="' . $this->get_field_id( 'map_zoom' ) . '" name="' . $this->get_field_name( 'map_zoom' ) . '" value="' . attribute_escape( $instance['map_zoom'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'limit' ) . '">' . __( 'Venues Limit', 'FourSquareAPI' ) . ' <code>' . __( '(0 to show all available)', 'FourSquareAPI' ) . '</code></label>
			<input type="text" id="' . $this->get_field_id( 'limit' ) . '" name="' . $this->get_field_name( 'limit' ) . '" value="' . attribute_escape( $instance['limit'] ).'" class="widefat" />
			</p>
			<p>
				<input type="checkbox" id="' . $this->get_field_id( 'address' ) . '" name="' . $this->get_field_name( 'address' ) . '" value="1" ';
		echo ( true == $instance['address'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'address' ) . '">' . __( 'Show Address', 'FourSquareAPI' ) . '</label>
				<br/>
				<input type="checkbox" id="' . $this->get_field_id( 'stats' ) . '" name="' . $this->get_field_name( 'stats' ) . '" value="1" ';
		echo ( true == $instance['stats'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'stats' ) . '">' . __( 'Show Stats', 'FourSquareAPI' ) . '</label>
				<br/>
				<input type="checkbox" id="' . $this->get_field_id( 'list' ) . '" name="' . $this->get_field_name( 'list' ) . '" value="1" ';
		echo ( true == $instance['list'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'list' ) . '">' . __( 'List instead of scrolling box', 'FourSquareAPI' ) . '</label>
				<br/>
				<input type="checkbox" id="' . $this->get_field_id( 'private' ) . '" name="' . $this->get_field_name( 'private' ) . '" value="1" ';
		echo ( true == $instance['private'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'private' ) . '">' . __( 'Show Private checkins', 'FourSquareAPI' ) . '</label>
			</p>
			<p>
			<label for="' . $this->get_field_id( 'autoscroll' ) . '">' . __( 'Autoscroll Rate', 'FourSquareAPI' ) . ' <code>' . __( '(in milliseconds, 0 to disable, ignored if list)', 'FourSquareAPI' ) . '</code></label>
			<input type="text" id="' . $this->get_field_id( 'autoscroll' ) . '" name="' . $this->get_field_name( 'autoscroll' ) . '" value="' . attribute_escape( $instance['autoscroll'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'id' ) . '">' . __( 'Unique ID', 'FourSquareAPI' ) . '</label>
			<input type="text" id="' . $this->get_field_id( 'id' ) . '" name="' . $this->get_field_name( 'id' ) . '" value="' . attribute_escape( $instance['id'] ) . '" class="widefat" />
			</p>
			<p>
				<input type="checkbox" id="' . $this->get_field_id( 'link' ) . '" name="' . $this->get_field_name( 'link' ) . '" value="1" ';
		echo ( true == $instance['link'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'link' ) . '">' . __( 'Link back to NZGuru (I appreciate it)', 'FourSquareAPI' ) . '</label>
			</p>
			';
	}
	
	function update( $new_instance, $old_instance ) {
		$instance['type']       = $new_instance['type'];
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['byline']     = strip_tags( $new_instance['byline'] );
		$instance['width']      = intval( $new_instance['width'] );
		$instance['map_height'] = intval( $new_instance['map_height'] );
		$instance['map_zoom']   = intval( $new_instance['map_zoom'] );
		$instance['limit']      = intval( $new_instance['limit'] );
		$instance['private']    = intval( $new_instance['private'] );
		$instance['address']    = intval( $new_instance['address'] );
		$instance['stats']      = intval( $new_instance['stats'] );
		$instance['list']       = intval( $new_instance['list'] );
		$instance['autoscroll'] = intval( $new_instance['autoscroll'] );
		$instance['id']         = intval( $new_instance['id'] );
		$instance['link']       = intval( $new_instance['link'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		global $FourSquareAPI;
		echo $args['before_widget'];
		if( $instance['title'] )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		if( $instance['byline'] )
			echo '<div class="entry-meta">' . $instance['byline'] . '</div>';
		echo display_foursquare_venues( $instance );
		if( $instance['link'] )
			echo '<div style="font-style:italic;font-size:0.6em;text-align:right;">' . __( 'powered by', 'FourSquareAPI' ) . ' <a href="http://nzguru.net/cool-stuff/foursquareapi-plugin-for-wordpress" target="_blank">FourSquareAPI</a></span>';
		echo $args['after_widget'];
	}

}

class FourSquareAPIBadgesWidget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'description' => __( 'This widget displays your foursquare&reg; badge data.', 'FourSquareAPI' ) );
		parent::WP_Widget( 'FourSquareAPIBadgesWidget', __( 'FourSquareAPI Badges', 'FourSquareAPI' ), $widget_ops );
		/* This function checks if this widget is currently added to any sidebars. If your widget requires external JavaScript or CSS, you should only include it if the widget is actually active. Otherwise, you'll be slowing down page loads by including these external files, when they aren't even being used! */
		if( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'template_redirect', array( $this, 'widget_external' ) );
		}
	}

	function widget_external() {
	  wp_deregister_script( 'googlemaps' );
		wp_register_script( 'googlemaps', 'http://maps.googleapis.com/maps/api/js?sensor=false' );
		wp_enqueue_script( 'googlemaps' );
	  wp_enqueue_script( 'jquery' );
	  wp_deregister_script( 'mobilyslider' );
		wp_register_script( 'mobilyslider', WP_PLUGIN_URL . '/foursquareapi/js/mobilyslider.js', 'jquery' );
	  wp_enqueue_script( 'mobilyslider' );
		wp_register_style( 'FourSquareAPI_CSS',  WP_PLUGIN_URL . '/foursquareapi/css/FourSquareAPI.css'  );
		wp_enqueue_style( 'FourSquareAPI_CSS' );
	}
	
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'type'        => 'badges',
			'title'       => 'foursquare Badges',
			'byline'      => 'what I have earned',
			'width'       => 200,
			'map_height'  => 0,
			'map_zoom'    => 16,
			'description' => 0,
			'limit'       => 1,
			'venue'       => 0,
			'address'     => 0,
			'stats'       => 0,
			'list'        => 1,
			'autoscroll'  => 0,
			'id'          => 1,
			'link'        => 1
		) );
		echo '
			<p>
			<label for="' . $this->get_field_id( 'type' ) . '">' . __( 'Data Type', 'FourSquareAPI' ) . '</label>
			<select id="' . $this->get_field_id( 'type' ) . '" name="' . $this->get_field_name( 'type' ) . '">
				<option value="badges"';
		echo ( 'badges' == $instance['type'] ) ? 'selected="selected"' : '';
		echo '>' . __( 'Badges', 'FourSquareAPI' ) . '</option>
			</select>
			</p>
			<p>
			<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Widget Title', 'FourSquareAPI' ) . '</label>
			<input type="text" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . attribute_escape( $instance['title'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'byline' ) . '">' . __( 'Widget Byline', 'FourSquareAPI' ) . '</label>
			<input type="text" id="' . $this->get_field_id( 'byline' ) . '" name="' . $this->get_field_name( 'byline' ) . '" value="' . attribute_escape( $instance['byline'] ).'" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'width' ) . '">' . __( 'Widget Width', 'FourSquareAPI' ) . ' <code>' . __( '(in px)', 'FourSquareAPI' ) . '</code></label>
			<input type="text" id="' . $this->get_field_id( 'width' ) . '" name="' . $this->get_field_name( 'width' ) . '" value="' . attribute_escape( $instance['width'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'map_height' ) . '">' . __( 'Map Height', 'FourSquareAPI' ) . ' <code>' . __( '(in px, 0 to disable map)', 'FourSquareAPI' ) . '</code></label>
			<input type="text" id="' . $this->get_field_id( 'map_height' ) . '" name="' . $this->get_field_name( 'map_height' ) . '" value="' . attribute_escape( $instance['map_height'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'map_zoom' ) . '">' . __( 'Initial Map Zoom Level', 'FourSquareAPI' ) . '</label>
			<input type="text" id="' . $this->get_field_id( 'map_zoom' ) . '" name="' . $this->get_field_name( 'map_zoom' ) . '" value="' . attribute_escape( $instance['map_zoom'] ) . '" class="widefat" />
			</p>
			<p>
				<input type="checkbox" id="' . $this->get_field_id( 'description' ) . '" name="' . $this->get_field_name( 'description' ) . '" value="1" ';
		echo ( true == $instance['description'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'description' ) . '">' . __( 'Show Description', 'FourSquareAPI' ) . '</label>
				<br/>
				<input type="checkbox" id="' . $this->get_field_id( 'limit' ) . '" name="' . $this->get_field_name( 'limit' ) . '" value="1" ';
		echo ( true == $instance['limit'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'limit' ) . '">' . __( 'Show Only Earned', 'FourSquareAPI' ) . '</label>
				<br/>
				<input type="checkbox" id="' . $this->get_field_id( 'venue' ) . '" name="' . $this->get_field_name( 'venue' ) . '" value="1" ';
		echo ( true == $instance['venue'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'venue' ) . '">' . __( 'Show Venue', 'FourSquareAPI' ) . '</label>
				<br/>
				<input type="checkbox" id="' . $this->get_field_id( 'address' ) . '" name="' . $this->get_field_name( 'address' ) . '" value="1" ';
		echo ( true == $instance['address'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'address' ) . '">' . __( 'Show Address', 'FourSquareAPI' ) . '</label>
				<br/>
				<input type="checkbox" id="' . $this->get_field_id( 'stats' ) . '" name="' . $this->get_field_name( 'stats' ) . '" value="1" ';
		echo ( true == $instance['stats'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'stats' ) . '">' . __( 'Show Stats', 'FourSquareAPI' ) . '</label>
				<br/>
				<input type="checkbox" id="' . $this->get_field_id( 'list' ) . '" name="' . $this->get_field_name( 'list' ) . '" value="1" ';
		echo ( true == $instance['list'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'list' ) . '">' . __( 'List instead of scrolling box', 'FourSquareAPI' ) . '</label>
			</p>
			<p>
			<label for="' . $this->get_field_id( 'autoscroll' ) . '">' . __( 'Autoscroll Rate', 'FourSquareAPI' ) . ' <code>' . __( '(in milliseconds, 0 to disable, ignored if list)', 'FourSquareAPI' ) . '</code></label>
			<input type="text" id="' . $this->get_field_id( 'autoscroll' ) . '" name="' . $this->get_field_name( 'autoscroll' ) . '" value="' . attribute_escape( $instance['autoscroll'] ) . '" class="widefat" />
			</p>
			<p>
			<label for="' . $this->get_field_id( 'id' ) . '">' . __( 'Unique ID', 'FourSquareAPI' ) . '</label>
			<input type="text" id="' . $this->get_field_id( 'id' ) . '" name="' . $this->get_field_name( 'id' ) . '" value="' . attribute_escape( $instance['id'] ) . '" class="widefat" />
			</p>
			<p>
				<input type="checkbox" id="' . $this->get_field_id( 'link' ) . '" name="' . $this->get_field_name( 'link' ) . '" value="1" ';
		echo ( true == $instance['link'] ) ? 'checked="checked"' : '';
		echo ' />
				<label for="' . $this->get_field_id( 'link' ) . '">' . __( 'Link back to NZGuru (I appreciate it)', 'FourSquareAPI' ) . '</label>
			</p>
			';
	}
	
	function update( $new_instance, $old_instance ) {
		$instance['type']        = $new_instance['type'];
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['byline']      = strip_tags( $new_instance['byline'] );
		$instance['width']       = intval( $new_instance['width'] );
		$instance['map_height']  = intval( $new_instance['map_height'] );
		$instance['map_zoom']    = intval( $new_instance['map_zoom'] );
		$instance['description'] = intval( $new_instance['description'] );
		$instance['limit']       = intval( $new_instance['limit'] );
		$instance['venue']       = intval( $new_instance['venue'] );
		$instance['address']     = intval( $new_instance['address'] );
		$instance['stats']       = intval( $new_instance['stats'] );
		$instance['list']        = intval( $new_instance['list'] );
		$instance['autoscroll']  = intval( $new_instance['autoscroll'] );
		$instance['id']          = intval( $new_instance['id'] );
		$instance['link']        = intval( $new_instance['link'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		global $FourSquareAPI;
		echo $args['before_widget'];
		if( $instance['title'] )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		if( $instance['byline'] )
			echo '<div class="entry-meta">' . $instance['byline'] . '</div>';
		echo display_foursquare_badges( $instance );
		if( $instance['link'] )
			echo '<div style="font-style:italic;font-size:0.6em;text-align:right;">' . __( 'powered by', 'FourSquareAPI' ) . ' <a href="http://nzguru.net/foursquareapi-plugin-for-wordpress" target="_blank">FourSquareAPI</a></span>';
		echo $args['after_widget'];
	}

}

class FourSquareAPI_API {
	/** @var String $BaseUrl The base url for the foursquare API */
	private $BaseUrl = "https://api.foursquare.com/";
	/** @var String $AuthUrl The url for obtaining the auth access code */
	private $AuthUrl = "https://foursquare.com/oauth2/authenticate";
	/** @var String $TokenUrl The url for obtaining an auth token */
	private $TokenUrl = "https://foursquare.com/oauth2/access_token";
	/** @var String $ClientID */
	private $ClientID;
	/** @var String $ClientSecret */
	private $ClientSecret;
  /** @var String $RedirectURL */
  protected $RedirectURL;
	/** @var String $AuthToken */
	private $AuthToken;
	
	/**
	 * Constructor for the API
	 * Prepares the request URL and client api params
	 * @param String $client_id
	 * @param String $client_secret
	 * @param String $version Defaults to v2, appends into the API url
	 */
	public function  __construct( $client_id = false, $client_secret = false, $redirect_url = '', $version = 'v2' ){
		$this->BaseUrl      = $this->BaseUrl . $version . '/';
		$this->ClientID     = $client_id;
		$this->ClientSecret = $client_secret;
		$this->RedirectURL  = $redirect_url;
	}
    
  public function set_redirect_url( $url ) {
		$this->RedirectURL = $url;
  }
	
	// Request functions
	
	/** 
	 * GetPublic
	 * Performs a request for a public resource
	 * @param String $endpoint A particular endpoint of the Foursquare API
	 * @param Array $params A set of parameters to be appended to the request, defaults to false (none)
	 */
	public function get_public( $endpoint, $params = false ){
		// Build the endpoint URL
		$url = $this->BaseUrl . trim( $endpoint, '/' );
		// Append the client details
		$params['client_id']     = $this->ClientID;
		$params['client_secret'] = $this->ClientSecret;
		// Return the result;
		return $this->GET( $url, $params );
	}
	
	/** 
	 * GetPrivate
	 * Performs a request for a private resource
	 * @param String $endpoint A particular endpoint of the Foursquare API
	 * @param Array $params A set of parameters to be appended to the request, defaults to false (none)
	 * @param bool $POST whether or not to use a POST request
	 */
	public function get_private( $endpoint, $params = false, $POST = false ){
		$url = $this->BaseUrl . trim( $endpoint, '/' );
		$params['oauth_token'] = $this->AuthToken;
		if( !$POST ) return $this->GET( $url, $params );	
		else return $this->POST( $url, $params );
	}
    
  public function get_response_from_json_string( $json ) {
    $json = json_decode( $json );
    if( !isset( $json->response ) ) {
			throw new FourSquareAPIException( 'Invalid response' );
    }
    
    // Better to check status code and fail gracefully, but not worried about it
    // ... REALLY, we should be checking the HTTP status code as well, not 
    // just what the API gives us in it's microformat
    /*
    if( !isset( $json->meta->code ) || 200 !== $json->meta->code ) {
        throw new FoursquareApiException( 'Invalid response' );
    }
    */
    return $json->response;
  }
	
	/**
	 * Request
	 * Performs a cUrl request with a url generated by MakeUrl. The useragent of the request is hardcoded
	 * as the Google Chrome Browser agent
	 * @param String $url The base url to query
	 * @param Array $params The parameters to pass to the request
	 */
	private function request( $url, $params = false, $type = 'GET' ){
		
		// Populate data for the GET request
		if( 'GET' == $type) $url = $this->make_url( $url, $params );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		if( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );
		}
		else {
			// Handle the useragent like we are Google Chrome
			curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.X.Y.Z Safari/525.13.' );
		}
		curl_setopt( $ch , CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		// Populate the data for POST
		if( 'POST' == $type ) {
			curl_setopt( $ch, CURLOPT_POST, 1 ); 
			if( $params ) curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
		}

		$result = curl_exec( $ch );
		$info = curl_getinfo( $ch );
		curl_close( $ch );
		
		return $result;
	}

	/**
	 * GET
	 * Abstraction of the GET request
	 */
	private function GET( $url, $params = false ){
		return $this->request( $url, $params, 'GET' );
	}

	/**
	 * POST
	 * Abstraction of a POST request
	 */
	private function POST( $url, $params = false ){
		return $this->request( $url, $params, 'POST' );
	}

	
	// Helper Functions
	
	/**
	 * GeoLocate
	 * Leverages the google maps api to generate a lat/lng pair for a given address
	 * packaged with FoursquareApi to facilitate locality searches.
	 * @param String $addr An address string accepted by the google maps api
	 * @return array(lat, lng) || NULL
	 */
	public function geo_locate( $addr ) {
		$geoapi = 'http://maps.googleapis.com/maps/api/geocode/json';
		$params = array( 'address' => $addr, 'sensor' => 'false' );
		$response = $this->GET( $geoapi, $params );
		$json = json_decode( $response );
		if( 'ZERO_RESULTS' === $json->status ) {			
			return NULL;
		}
		else {
			return array( $json->results[0]->geometry->location->lat, $json->results[0]->geometry->location->lng );
		}
	}
	
	/**
	 * MakeUrl
	 * Takes a base url and an array of parameters and sanitizes the data, then creates a complete
	 * url with each parameter as a GET parameter in the URL
	 * @param String $url The base URL to append the query string to (without any query data)
	 * @param Array $params The parameters to pass to the URL
	 */	
	private function make_url( $url, $params ) {
		if( !empty( $params ) && $params ){
			foreach( $params as $key => $value ) $kv[] = $key . '=' . $value;
			$url_params = str_replace( ' ', '+', implode( '&', $kv ) );
			$url = trim( $url ) . '?' . $url_params;
		}
		return $url;
	}
	
	// Access token functions
	
	/**
	 * SetAccessToken
	 * Basic setter function, provides an authentication token to GetPrivate requests
	 * @param String $token A Foursquare user auth_token
	 */
	public function set_access_token( $token ) {
		$this->AuthToken = $token;
	}
	
	/**
	 * AuthenticationLink
	 * Returns a link to the Foursquare web authentication page.
	 * @param String $redirect The configured redirect_uri for the provided client credentials
	 */
	public function authentication_link( $redirect = '' ) {
	  if( 0 === strlen( $redirect ) ) {
	    $redirect = $this->RedirectURL;
	  }
		$params = array( 'client_id' => $this->ClientID, 'response_type' => 'code', 'redirect_uri' => $redirect );
		return $this->make_url( $this->AuthUrl, $params );
	}
	
	/**
	 * GetToken
	 * Performs a request to Foursquare for a user token, and returns the token, while also storing it
	 * locally for use in private requests
	 * @param $code The 'code' parameter provided by the Foursquare webauth callback redirect
	 * @param $redirect The configured redirect_uri for the provided client credentials
	 */
	public function get_token( $code, $redirect = '' ) {
    if( 0 === strlen( $redirect ) ) {
      $redirect = $this->RedirectURL;
    }
		$params = array(
			'client_id'     => $this->ClientID,
			'client_secret' => $this->ClientSecret,
			'grant_type'    => 'authorization_code',
			'redirect_uri'  => $redirect,
			'code'          => $code
		);
		$result = $this->GET( $this->TokenUrl, $params );
		$json = json_decode( $result );
		$this->set_access_token( $json->access_token );
		return $json->access_token;
	}
}

function display_foursquare_badges( $options ) {
	global $wp_plugin_dir, $wp_plugin_url;
	$image_path = plugin_dir_path( __FILE__ ) . '/images/';
	$image_url = plugin_dir_url( __FILE__ ) . '/images/';
	$cache = get_option( 'FourSquareAPI_' . $options['type'] . '_cache' );
	$cache_life = get_option( 'FourSquareAPI_' . $options['type'] . '_cache_life' );
	$cache_time = get_option( 'FourSquareAPI_' . $options['type'] . '_cache_time' );
	if( '' == $cache || 0 == $cache_life || time() > $cache_time + ( 60 * $cache_life ) ) {
		// Load the Foursquare API library
		$foursquare = new FourSquareAPI_API( get_option( 'FourSquareAPI_client_id' ), get_option( 'FourSquareAPI_client_secret' ) );
		$foursquare->set_access_token( get_option( 'FourSquareAPI_oauth_token' ) );
		// Prepare parameters
		$params = array( 'limit' => 250 );
		// Perform a request to a public resource
		$response = $foursquare->get_private( 'users/self/' . $options['type'], $params );
		$badges = json_decode( $response );
		if( 200 == $badges->meta->code ) {
			update_option( 'FourSquareAPI_' . $options['type'] . '_cache', $badges );
			update_option( 'FourSquareAPI_' . $options['type'] . '_cache_time', time() );
			update_option( 'FourSquareAPI_' . $options['type'] . '_api_calls', get_option( 'FourSquareAPI_' . $options['type'] . '_api_calls' ) + 1 );
		}
		else
			$badges = $cache;
	}
	else
		$badges = $cache;
	$html = ''; $i = 0; $last_badge = '';
	$html .= '<div id="FourSquareAPI_badges' . $options['id'] . '" class="FourSquareAPI_badges" style="width: ' . $options['width'] . 'px">';
	if( 0 != $options['map_height'] )
		$html .= '<div id="FourSquareAPI_badges' . $options['id'] . '_map_canvas" style="width:' . $options['width'] . 'px; height:' . $options['map_height'] . 'px; margin-bottom: 5px;"></div>';
	$height = max( 64, ( 55 * $options['description'] ) + ( 34 * $options['venue'] ) + ( 145 * $options['address'] ) + ( 95 * $options['stats'] ) );
	if( !$options['list'] ) {
		$html .= '
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#FourSquareAPI_badges' . $options['id'] . '_slider").mobilyslider({
		content: "#FourSquareAPI_sliderContent' . $options['id'] . '", // class for slides container
		children: ".FourSquareAPI_item", // selector for children elements
		transition: "fade", // transition: horizontal, vertical, fade
		animationSpeed: 300, // slide transition speed (miliseconds)
		autoplay: ' . ( $options['autoscroll'] > 0 ? 'true' : 'false' ) . ',
		autoplaySpeed: ' . $options['autoscroll'] . ', // time between transitions (miliseconds)
		pauseOnHover: true, // stop animation while hovering
		bullets: false, // generate pagination (true/false, class: sliderBullets)
		arrows: true, // generate next and previous arrow (true/false, class: sliderArrows)
		arrowsHide: true, // show arrows only on hover
		arrowsClass: "FourSquareAPI_sliderArrows", // class name for previous button
		prev: "FourSquareAPI_sliderPrev", // class name for previous button
		next: "FourSquareAPI_sliderNext", // class name for next button
		animationStart: function(){}, // call the function on start transition
		animationComplete: function(){}, // call the function when transition completed
		id: ' . $options['id'] . '
	});
});
</script>
		';
		$html .= '
		<div id="FourSquareAPI_badges' . $options['id'] . '_slider" class="FourSquareAPI_slider" style="height: ' . ( 12 + $height ) . 'px; width: ' . $options['width'] . 'px">
		<div id="FourSquareAPI_sliderContent' . $options['id'] . '" class="FourSquareAPI_sliderContent" style="height: ' . ( 12 + $height ) . 'px; width: ' . $options['width'] . 'px">
		';
	}
	else {
		$html .= '
		<div id="FourSquareAPI_badges' . $options['id'] . '_list" class="FourSquareAPI_list" style="width: ' . $options['width'] . 'px">
		<div id="FourSquareAPI_listContent' . $options['id'] . '" class="FourSquareAPI_listContent" style="width: ' . $options['width'] . 'px">
		';
	}
	$icon_js = '';
	if( 'badges' == $options['type'] ) {
		$badges = $badges->response->badges;
	}
	foreach( $badges as $badge ) {
		if( ( 1 == $options['limit'] && isset( $badge->unlocks[0]->checkins[0] ) ) || 0 == $options['limit'] ) {
			$i++;
			if( 0 != $options['map_height'] ) {
				if( 1 == $i )
					$js = '
				<script type="text/javascript">
				jQuery(document).ready(function() {
					var page_badges' . $options['id'] . '_latlng = new google.maps.LatLng(' . $badge->unlocks[0]->checkins[0]->venue->location->lat . ', ' . $badge->unlocks[0]->checkins[0]->venue->location->lng . ');
					var page_badges' . $options['id'] . '_Options = {
						zoom: ' . $options['map_zoom'] . ',
						zoomControlOptions: {
					    style: google.maps.ZoomControlStyle.SMALL
					  },
						panControl: false,
						scaleControl: false,
						rotateControl: false,
						overviewMapControl: false,
						scrollwheel: false,
						center: page_badges' . $options['id'] . '_latlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					var page_badges' . $options['id'] . ' = [';
				$mapLatLng = $badge->unlocks[0]->checkins[0]->venue->location->lat . ', ' . $badge->unlocks[0]->checkins[0]->venue->location->lng;
				if( !file_exists( $image_path . 'mapbadge_' . $badge->badgeId . '.png' ) ) {
					if( $badge->image ) {
						if( copy( $badge->image->prefix . $badge->image->sizes[0] . $badge->image->name, $image_path . 'badge_' . $badge->badgeId . '.png' ) ) {
							require_once( $image_path . 'Zebra_Image.php' );
							$image = new Zebra_Image();
							$image->source_path = $image_path . 'badge_' . $badge->badgeId . '.png';
							$image->target_path = $image_path . 'mapbadge_' . $badge->badgeId . '.png';
					    $image->resize(25, 25, ZEBRA_IMAGE_CROP_CENTER, -1);
							$js .= '
							["'.$badge->name.'",' . $mapLatLng . ', ' . $i . ', "' . $image_path . 'mapbadge_' . $badge->badgeId . '.png' . '"],';
					  }
					  else {
							$js .= '
							["'.$badge->name.'",' . $mapLatLng . ', ' . $i . ', "' . $badge->image->prefix . $badge->image->sizes[0] . $badge->image->name . '"],';
					  }
				  }
				}
				else {
					$js .= '
					["'.$badge->name.'",' . $mapLatLng . ', ' . $i . ', "' . $image_url . 'mapbadge_' . $badge->badgeId . '.png' . '"],';
				}
				$icon_js .= '
				jQuery("#icon' . $options['id'] . $badge->badgeId . '").click(function() { page_badges' . $options['id'] . '_map.panTo( new google.maps.LatLng(' . $badge->unlocks[0]->checkins[0]->venue->location->lat . ', ' . $badge->unlocks[0]->checkins[0]->venue->location->lng . ') ) });';
			}
			if( $options['list'] ) {
				if( !$options['description'] && !$options['venue'] && !$options['address'] && !$options['stats'] )
					$html .= '<div class="FourSquareAPI_badge">';
				else
					$html .= '<div class="FourSquareAPI_item" style="position: inherit; width: ' . ( $options['width'] - 12 ) . 'px">';
			}
			else
				$html .= '<div class="FourSquareAPI_item" style="position: absolute; height: ' . $height . 'px; width: ' . ( $options['width'] - 12 ) . 'px">';
			$html .= '<img id="icon' . $options['id'] . $badge->badgeId . '" class="FourSquareAPI_badgeImage" src="' . $badge->image->prefix . $badge->image->sizes[0] . $badge->image->name . '" alt="' . $badge->name . '" title="' . $badge->name . '">';
			if( $options['description'] ) {	
				$html .= '<div class="FourSquareAPI_title" title="' . $badge->name . '">' . $badge->name . '</div>';
				if( 0 != $options['description'] ) {
					if( $badge->description ) {
						$html .= '<div class="FourSquareAPI_description" title="' . $badge->description . '">' . $badge->description . '</div>';
					}
					else {
						$html .= '<div class="FourSquareAPI_description">' . __( 'Not earned yet!', 'FourSquareAPI' ) . '</div>';
					}
				}
			}
			if( $options['venue'] || $options['address'] || $options['stats'] )
				$html .= display_foursquare_venue( $options, $badge->unlocks[0]->checkins[0]);
			$html .= '</div>';
		}
	}
	$html .= '</div></div>';
	if( 0 != $options['map_height'] ) {
		$js = substr( $js, 0, -1 );
		$js .= '
				];
				var page_badges' . $options['id'] . '_map = new google.maps.Map(document.getElementById("FourSquareAPI_badges' . $options['id'] . '_map_canvas"), page_badges' . $options['id'] . '_Options);
				page_badges' . $options['id'] . '_Markers(page_badges' . $options['id'] . '_map, page_badges' . $options['id'] . ');
				function page_badges' . $options['id'] . '_Markers(map, locations) {
					for (var i = 0; i < locations.length; i++) {
						var location = locations[i];
						var myLatLng = new google.maps.LatLng(location[1], location[2]);
						var image = new google.maps.MarkerImage(location[4], new google.maps.Size(32, 32), new google.maps.Point(0,0), new google.maps.Point(16, 16));
						var marker = new google.maps.Marker({
							position: myLatLng,
							map: map,
							icon: image,
							title: location[0],
							zIndex: location[3]
						});
					}
				}
		' . $icon_js . '
			});
			</script>';
	}
	return $html . $js . '</div>';
}

function display_foursquare_venues( $options ) {
	global $wp_plugin_dir, $wp_plugin_url;
	$image_path = plugin_dir_path( __FILE__ ) . '/images/';
	$image_url = plugin_dir_url( __FILE__ ) . '/images/';
	$cache = get_option( 'FourSquareAPI_' . $options['type'] . '_cache' );
	$cache_life = get_option( 'FourSquareAPI_' . $options['type'] . '_cache_life' );
	$cache_time = get_option( 'FourSquareAPI_' . $options['type'] . '_cache_time' );
	if( '' == $cache || 0 == $cache_life || time() > $cache_time + ( 60 * $cache_life ) ) {
		// Load the Foursquare API library
		$foursquare = new FourSquareAPI_API( get_option( 'FourSquareAPI_client_id' ), get_option( 'FourSquareAPI_client_secret' ) );
		$foursquare->set_access_token( get_option( 'FourSquareAPI_oauth_token' ) );
		// Prepare parameters
		$params = array( 'limit' => 250 );
		// Perform a request to a public resource
		$response = $foursquare->get_private( 'users/self/' . $options['type'], $params );
		$venues = json_decode( $response );
		if( 200 == $venues->meta->code ) {
			update_option( 'FourSquareAPI_' . $options['type'] . '_cache', $venues );
			update_option( 'FourSquareAPI_' . $options['type'] . '_cache_time', time() );
			update_option( 'FourSquareAPI_' . $options['type'] . '_api_calls', get_option( 'FourSquareAPI_' . $options['type'] . '_api_calls' ) + 1 );
		}
		else
			$venues = $cache;
	}
	else
		$venues = $cache;
	$html = ''; $i = 0; $last_venue = '';
	$html .= '<div id="FourSquareAPI_venues' . $options['id'] . '" class="FourSquareAPI_venues" style="width: ' . $options['width'] . 'px">';
	if( 0 != $options['map_height'] )
		$html .= '<div id="FourSquareAPI_venues' . $options['id'] . '_map_canvas" style="width:' . $options['width'] . 'px; height:' . $options['map_height'] . 'px; margin-bottom: 5px;"></div>';
	$height = 47 + ( 102 * $options['address'] ) + ( 60 * $options['stats'] );
	if( !$options['list'] ) {
		$html .= '
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#FourSquareAPI_venues' . $options['id'] . '_slider").mobilyslider({
		content: "#FourSquareAPI_sliderContent' . $options['id'] . '", // class for slides container
		children: ".FourSquareAPI_item", // selector for children elements
		transition: "fade", // transition: horizontal, vertical, fade
		animationSpeed: 300, // slide transition speed (miliseconds)
		autoplay: ' . ( $options['autoscroll'] > 0 ? 'true' : 'false' ) . ',
		autoplaySpeed: ' . $options['autoscroll'] . ', // time between transitions (miliseconds)
		pauseOnHover: true, // stop animation while hovering
		bullets: false, // generate pagination (true/false, class: sliderBullets)
		arrows: true, // generate next and previous arrow (true/false, class: sliderArrows)
		arrowsHide: true, // show arrows only on hover
		arrowsClass: "FourSquareAPI_sliderArrows", // class name for previous button
		prev: "FourSquareAPI_sliderPrev", // class name for previous button
		next: "FourSquareAPI_sliderNext", // class name for next button
		animationStart: function(){}, // call the function on start transition
		animationComplete: function(){}, // call the function when transition completed
		id: ' . $options['id'] . '
	});
});
</script>
		';
		$html .= '<div id="FourSquareAPI_venues' . $options['id'] . '_slider" class="FourSquareAPI_slider" style="height: ' . $height . 'px; width: ' . $options['width'] . 'px"><div id="FourSquareAPI_sliderContent' . $options['id'] . '" class="FourSquareAPI_sliderContent" style="height: ' . $height . 'px; width: ' . $options['width'] . 'px">';
	}
	else {
		$html .= '<div id="FourSquareAPI_venues' . $options['id'] . '_list" class="FourSquareAPI_list" style="width: ' . $options['width'] . 'px"><div id="FourSquareAPI_listContent' . $options['id'] . '" class="FourSquareAPI_listContent" style="width: ' . $options['width'] . 'px">';
	}
	$icon_js = '';
	if( 'venuehistory' == $options['type'] ) {
		$venues_count = $venues->response->venues->count;
		$venues = $venues->response->venues->items;
	}
	if( 'checkins' == $options['type'] ) {
		$venues_count = $venues->response->checkins->count;
		$venues = $venues->response->checkins->items;
	}
	if( 'mayorships' == $options['type'] ) {
		$venues_count = $venues->response->mayorships->count;
		$venues = $venues->response->mayorships->items;
	}
	foreach( $venues as $venue ) {
		if( $venue->venue->id != $last_venue && ( !$venue->private || $options['private'] ) ) {
			$last_venue = $venue->venue->id;
			$i++;
			if( 0 != $options['map_height'] ) {
				if( 1 == $i ) $js = '
				<script type="text/javascript">
				jQuery(document).ready(function() {
					var page_venues' . $options['id'] . '_latlng = new google.maps.LatLng(' . $venue->venue->location->lat . ', ' . $venue->venue->location->lng . ');
					var page_venues' . $options['id'] . '_Options = {
						zoom: ' . $options['map_zoom'] . ',
						zoomControlOptions: {
					    style: google.maps.ZoomControlStyle.SMALL
					  },
						panControl: false,
						scaleControl: false,
						rotateControl: false,
						overviewMapControl: false,
						scrollwheel: false,
						center: page_venues' . $options['id'] . '_latlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					var page_venues' . $options['id'] . ' = [';
				$mapLatLng = $venue->venue->location->lat . ', ' . $venue->venue->location->lng;
				if( !file_exists( $image_path . 'mapcat_' . $venue->venue->categories[0]->id . '.png' ) ) {
					if( '' != $venue->venue->categories[0]->icon ) {
#						if( copy( $venue->venue->categories[0]->icon, $image_path . 'cat_' . $venue->venue->categories[0]->id . '.png' ) ) {
						if( foursquareapi_copy( $venue->venue->categories[0]->icon, $image_path . 'cat_' . $venue->venue->categories[0]->id . '.png' ) ) {
							require_once( $image_path . 'Zebra_Image.php' );
							$image = new Zebra_Image();
							$image->source_path = $image_path . 'cat_' . $venue->venue->categories[0]->id . '.png';
							$image->target_path = $image_path . 'mapcat_' . $venue->venue->categories[0]->id . '.png';
					    $image->resize(25, 25, ZEBRA_IMAGE_CROP_CENTER, -1);
							$js .= '
							["'.$venue->venue->name.'",' . $mapLatLng . ', ' . $i . ', "' . $image_path . 'mapcat_' . $venue->venue->categories[0]->id . '.png' . '"],';
					  }
					  else {
							$js .= '
							["'.$venue->venue->name.'",' . $mapLatLng . ', ' . $i . ', "' . $venue->venue->categories[0]->icon . '"],';
					  }
				  }
				}
				else {
					$js .= '
					["'.$venue->venue->name.'",' . $mapLatLng . ', ' . $i . ', "' . $image_url . 'mapcat_' . $venue->venue->categories[0]->id . '.png' . '"],';
				}
				$icon_js .= '
				jQuery("#icon' . $options['id'] . $venue->venue->id . '").click(function() { page_venues' . $options['id'] . '_map.panTo( new google.maps.LatLng(' . $venue->venue->location->lat . ', ' . $venue->venue->location->lng . ') ) });';
			}
			if( $options['list'] )
				$html .= '<div class="FourSquareAPI_item" style="position: inherit; width: ' . ( $options['width'] - 12 ) . 'px">';
			else
				$html .= '<div class="FourSquareAPI_item" style="position: absolute; height: ' . ( $height - 15 ) . 'px; width: ' . ( $options['width'] - 12 ) . 'px">';
			$html .= display_foursquare_venue( $options, $venue);
			$html .= '</div>';
			if( $i == $options['limit'] )
				break;
		}
	}
	$html .= '</div></div>';
	if( 0 != $options['map_height'] ) {
		$js = substr( $js, 0, -1 );
		$js .= '
				];
				var page_venues' . $options['id'] . '_map = new google.maps.Map(document.getElementById("FourSquareAPI_venues' . $options['id'] . '_map_canvas"), page_venues' . $options['id'] . '_Options);
				page_venues' . $options['id'] . '_Markers(page_venues' . $options['id'] . '_map, page_venues' . $options['id'] . ');
				function page_venues' . $options['id'] . '_Markers(map, locations) {
					for (var i = 0; i < locations.length; i++) {
						var location = locations[i];
						var myLatLng = new google.maps.LatLng(location[1], location[2]);
						var image = new google.maps.MarkerImage(location[4], new google.maps.Size(32, 32), new google.maps.Point(0,0), new google.maps.Point(16, 16));
						var marker = new google.maps.Marker({
							position: myLatLng,
							map: map,
							icon: image,
							title: location[0],
							zIndex: location[3]
						});
					}
				}
		' . $icon_js . '
			});
			</script>';
	}
	return $html . $js . '</div>';
}

function foursquareapi_copy( $file1, $file2 ){
	$contentx = @file_get_contents( $file1 );
	if( $contentx === FALSE ) return false;
	else{
		$openedfile = fopen( $file2, "w" );
		fwrite( $openedfile, $contentx );
		fclose( $openedfile );
		return true;
	}
}

function display_foursquare_venue( $options, $data ) {
	$venue = '';
	if( $data->venue->categories[0]->icon ) {
		$venue .= '<img id="icon' . $options['id'] . $data->venue->id . '"' . ( $options['map_height'] == 0 ? ' class="noclick"' : '' ) . ' src="' . $data->venue->categories[0]->icon . '" alt="' . $data->venue->categories[0]->name . '" title="' . $data->venue->categories[0]->name . '">';
	}
	else {
		$venue .= '<img id="icon' . $options['id'] . $data->venue->id . '"' . ( $options['map_height'] == 0 ? ' class="noclick"' : '' ) . ' src="http://foursquare.com/img/categories/none.png" alt="No Category" title="No Category">';
	}
	$venue .= '<div class="FourSquareAPI_title"><a href="http://foursquare.com/venue/' . $data->venue->id . '" target="_blank" title="' . $data->venue->name . '">' . $data->venue->name . '</a></div>';
	if( $data->createdAt ) {
			$time = $data->createdAt;
			if( ( abs( time() - $time) ) < 86400 )
			$h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
			else
			$h_time = date( __('Y/m/d'), $time);
			$venue .= sprintf( __('%s', 'FourSquareAPI'), ' <div class="FourSquareAPI_timestamp">' . ( 'badges' == $options['type'] ? __( 'Unlocked at', 'FourSquareAPI' ) : __( 'Last visited', 'FourSquareAPI' ) ) . ' <abbr title="' . date(__('Y/m/d H:i:s'), $time) . '">' . $h_time . '</abbr></div>' );
	}
	if( $options['address'] ) {
		if( $data->venue->location->address || $data->venue->location->city || $data->venue->location->state || $data->venue->location->postalCode || $data->venue->contact->formattedPhone || $data->venue->contact->twitter || $data->venue->url ) {
			$venue .= '<div class="FourSquareAPI_details"' . ( 212 > $options['width'] ? ' style="margin-left:0;"' : '' ) . '>';
			if( $data->venue->location->address || $data->venue->location->city || $data->venue->location->state || $data->venue->location->postalCode || $data->venue->contact->formattedPhone ) {
				$venue .= '<div class="FourSquareAPI_details_adr">';
				if( $data->venue->location->address )
					$venue .= '<span class="street-address">' . $data->venue->location->address . '</span><br>';
				if( $data->venue->location->city || $data->venue->location->state || $data->venue->location->postalCode )
					$venue .= '<span class="locality">' . $data->venue->location->city . '</span>, <span class="region">' . $data->venue->location->state . '</span> <span class="postal-code">' . $data->venue->location->postalCode . '</span><br>';
				if( $data->venue->contact->formattedPhone )
					$venue .= '<span class="tel">' . $data->venue->contact->formattedPhone . '</span><br>';
				$venue .= '</div>';//adr
			}
			if( $data->venue->contact->twitter )
				$venue .= '<div class="FourSquareAPI_details_twitter"><a itemprop="url" href="http://twitter.com/' . $data->venue->contact->twitter . '" target="_blank">@' . $data->venue->contact->twitter . '</a></div>';
			if( $data->venue->url )
				$venue .= '<div class="FourSquareAPI_details_website url"><a itemprop="url" href="' . $data->venue->url . '" target="_blank">' . $data->venue->url . '</a></div>';
			$venue .= '</div>';//details
		}
	}
	if( $options['stats'] ) {
		$venue .= '<div class="FourSquareAPI_stats"' . ( 212 > $options['width'] ? ' style="margin-left:0;"' : '' ) . '>';
		$statclass = 'statsdigits';
		if( max( $data->venue->stats->tipCount, $data->venue->stats->usersCount, $data->venue->stats->checkinsCount ) > 999 )
			$statclass = 'stats4digits';
		if( max( $data->venue->stats->tipCount, $data->venue->stats->usersCount, $data->venue->stats->checkinsCount ) > 9999 )
			$statclass = 'stats5digits';
		if( max( $data->venue->stats->tipCount, $data->venue->stats->usersCount, $data->venue->stats->checkinsCount ) > 99999 )
			$statclass = 'stats6digits';
		if( max( $data->venue->stats->tipCount, $data->venue->stats->usersCount, $data->venue->stats->checkinsCount ) > 999999 )
			$statclass = 'stats7digits';
		$venue .= '<div class="FourSquareAPI_stat">' . __( 'VENUE TIPS', 'FourSquareAPI' ) . '<strong><span class="FourSquareAPI_' . $statclass . '">' . number_format( $data->venue->stats->tipCount, 0, '', ',' ) . '</span></strong></div>';
		$venue .= '<div class="FourSquareAPI_stat">' . __( 'TOTAL PEOPLE', 'FourSquareAPI' ) . '<strong><span class="FourSquareAPI_' . $statclass . '">' . number_format( $data->venue->stats->usersCount, 0, '', ',' ) . '</span></strong></div>';
		$venue .= '<div class="FourSquareAPI_stat" style="border-right:none;margin-left:4px;">' . __( 'TOTAL CHECKINS', 'FourSquareAPI' ) . '<strong><span class="FourSquareAPI_' . $statclass . '">' . number_format( $data->venue->stats->checkinsCount, 0, '', ',' ) . '</span></strong></div>';
		$venue .= '</div>';//stats
	}
	return $venue;
}

$FourSquareAPI = new FourSquareAPI(); 
?>