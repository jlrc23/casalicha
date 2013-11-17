<?php

// registers the buttons for use
function register_modal_buttons($buttons) {
	// inserts a separator between existing buttons and our new one
	// "modal_button" is the ID of our button
	array_push($buttons, "|", "modal_button");
	return $buttons;
}

// filters the tinyMCE buttons and adds our custom buttons
function modal_shortcode_buttons() {
	
	global $post;

	// Don't bother doing this stuff if the current user lacks permissions
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
	 
	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
		// filter the tinyMCE buttons and add our own
		add_filter("mce_external_plugins", "add_modal_tinymce_plugin");
		add_filter('mce_buttons', 'register_modal_buttons');
	}
}
// init process for button control
add_action('init', 'modal_shortcode_buttons');

// add the button to the tinyMCE bar
function add_modal_tinymce_plugin($plugin_array) {
	global $smw_base_dir;
	global $post;
	
	// enable the button on all but the modals post type
	if(get_post_type($post) != 'modals') {
		$plugin_array['modal_button'] = $smw_base_dir . 'includes/tinymce/tinymce-buttons.js';
	}
	return $plugin_array;
}