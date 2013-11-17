<?php

// builds the shortcode that displays the modal window link
function smw_shortcodes( $atts, $content = null ) {

	global $wpdb, $post;

	extract( shortcode_atts( array(
	  'id' => '',
      'name' => '',
	  'size' => '',
	  'style' => 'plain',
	  'color' => ''
	  
      ), $atts ) );
	  
	  
	// retrieves the post object of the desired modal
	if( strlen(trim($id)) > 0 ) {
		$modal_object 	= get_post($id);
	} elseif( strlen(trim($name)) > 0 ) {
		$modal_object 	= smw_get_modal_by_title($name);
	} else {
		// no modal ID or name was set, so get out of here
		return;
	}
	$width 			= get_post_meta($modal_object->ID, 'smw_width', true);
	if(!$width) 	{ $width = '600'; }
	
	$auto_height 		= get_post_meta($modal_object->ID, 'smw_auto_height', true);
	if($auto_height != true) {
		$height 		= get_post_meta($modal_object->ID, 'smw_height', true);
		if(!$height) 	{ $height = '300'; }
		$height_option = 'height: ' . $height . 'px; overflow-y: scroll;';
	}
	$trans 			= get_post_meta($modal_object->ID, 'smw_trans', true);
	if(!$trans) 	{ $trans = '90'; } 
	
	$opacity 		= get_post_meta($modal_object->ID, 'smw_opacity', true);
	if(!$opacity) 	{ $opacity = '50'; } 
	
	$speed 			= get_post_meta($modal_object->ID, 'smw_speed', true);
	if(!$speed) 	{ $speed = '600'; } 
	
	$bg_color 		= get_post_meta($modal_object->ID, 'smw_color', true); 
	$title_color	= get_post_meta($modal_object->ID, 'smw_title_color', true); 
	$title_text_color	= get_post_meta($modal_object->ID, 'smw_title_text_color', true); 
	
	$border_width	= get_post_meta($modal_object->ID, 'smw_border_width', true); 
	if(!$border_width) { $border_width = 8; }
	
	$border_radius	= get_post_meta($modal_object->ID, 'smw_border_radius', true); 
		
	$content_color	= get_post_meta($modal_object->ID, 'smw_content_color', true); 
	$content_text_color	= get_post_meta($modal_object->ID, 'smw_content_text_color', true); 
	
	if(get_post_meta($modal_object->ID, 'smw_close', true) == true) {
		$close = 'false';
	} else {
		$close = 'true';
	}
	
	// start with an empty var
	$modal = '';	
	$styles = '
	<style type="text/css">
		.modalWindow-' . esc_html( $modal_object->post_name ) .' { background: ' . $bg_color . '; padding: ' . $border_width . 'px; width: ' . $width . 'px; }
		.modalWindow-' . esc_html( $modal_object->post_name ) .' .modalWindow-title { background: ' . $title_color . '; color: ' . $title_text_color . '; }
		.modalWindow-' . esc_html( $modal_object->post_name ) .' .modalWindow-content { background: ' . $content_color . '; color: ' . $content_text_color . '; }
		.modalWindow-' . esc_html( $modal_object->post_name ) .',
		.modalWindow-' . esc_html( $modal_object->post_name ) .' .modalWindow-boxInner {
			 
			-webkit-border-radius: ' . $border_radius . 'px;
			-moz-border-radius: ' . $border_radius . 'px;
			border-radius: ' . $border_radius . 'px;
		}
		.modalWindow-' . esc_html( $modal_object->post_name ) .' .modalWindow-title {
			-webkit-border-radius: ' . $border_radius . 'px ' . $border_radius . 'px 0 0;
			-moz-border-radius: ' . $border_radius . 'px ' . $border_radius . 'px 0 0;
			border-radius: ' . $border_radius . 'px ' . $border_radius . 'px 0 0;
		}
		.modalWindow-' . esc_html( $modal_object->post_name ) .' .modalWindow-content {
			' . $height_option . '
			-webkit-border-radius: 0 0 ' . $border_radius . 'px ' . $border_radius . 'px;
			-moz-border-radius: 0 0 ' . $border_radius . 'px ' . $border_radius . 'px;
			border-radius: 0 0 ' . $border_radius . 'px ' . $border_radius . 'px;
		}
	</style>';
	$modal .= $styles;	

	$scripts = '
	<script type="text/javascript">
		//<![CDATA[
			jQuery(function($){

				$("#' . esc_html( $modal_object->post_name ) . '-modal").modalWindow({
					position:	"fixed",
					width:		' . $width . ',
					trans:		' . $trans / 100 . ',
					opacity:	' . $opacity / 100 . ',
					close:		' . $close .',
					speed:		' . $speed .',
					className:		"modalWindow-' . esc_html( $modal_object->post_name ) . '",
					borderWidth: ' . $border_width . '
					
				});
			}); // end jquery(function($))
		//]]> 
	</script>';
	$modal .= $scripts;

	$cookie_name = esc_html( $modal_object->post_name );

	if( get_post_meta($modal_object->ID, 'smw_auto_open', true ) == true && get_post_meta( $modal_object->ID, 'smw_delay', true ) == true) {
		$delay_time_option = get_post_meta($modal_object->ID, 'smw_delay_time', true);
		if(strlen(trim($delay_time_option)) > 0 ) {
			$delay_time = $delay_time_option;
		} else {
			$delay_time = 3000;
		}

		if( get_post_meta($modal_object->ID, 'smw_first_load', true ) == true) {
			$scripts = '
			<script type="text/javascript">
				//<![CDATA[
					jQuery(document).ready(function($) {
						if(!$.cookie("smw-' . esc_html( $cookie_name ) . '")) {
							setTimeout( function() {
								var href = "#' . esc_html( $modal_object->post_name ) . '-modal";
								$(href).trigger("click");
								$.cookie("smw-' . esc_html( $cookie_name ) . '", "1", { expires: 1 });
							}, ' . $delay_time . ' );
						}
					});
				//]]> 
			</script>';
		} else {
			$scripts = '
			<script type="text/javascript">
				//<![CDATA[
					jQuery(document).ready(function($) {
						setTimeout( function(){
							var href = "#' . esc_html( $modal_object->post_name ) . '-modal";
							$(href).trigger("click");
						}, ' . $delay_time . ' );
					});
				//]]> 
			</script>';
		}
		$modal .= $scripts;
	} elseif(get_post_meta($modal_object->ID, 'smw_auto_open', true) == true) {
		if(get_post_meta($modal_object->ID, 'smw_first_load', true) == true) {
			$scripts = '
			<script type="text/javascript">
				//<![CDATA[
					jQuery(document).ready(function($) {
						if(!$.cookie("smw-' . esc_html( $cookie_name ) . '")) {
							var href = "#' . esc_html( $modal_object->post_name ) . '-modal";
							$(href).trigger("click");
							$.cookie("smw-' . esc_html( $cookie_name ) . '", "1", { expires: 1 });
						}
					});
				//]]> 
			</script>';
		} else {
			$scripts = '
			<script type="text/javascript">
				//<![CDATA[
					jQuery(document).ready(function($) {
						var href = "#' . esc_html( $modal_object->post_name ) . '-modal";
						$(href).trigger("click");
						$.cookie("smw-' . esc_html( $post->post_name ) . '", "1", { expires: 1 });
					});
				//]]> 
			</script>';
		}	
		$modal .= $scripts;
	}
	
	$modal .= '<div id="' . esc_html( $modal_object->post_name ) . '" class="modalWindow-container">';
		if( get_post_meta($modal_object->ID, 'smw_title', true ) != true) {
			$modal .= '<h3 class="modalWindow-title">' . esc_html( $modal_object->post_title ) . '</h3>';
		}
		$modal .= '<div class="modalWindow-content"><div class="modal-inner">' . apply_filters( 'the_content', $modal_object->post_content ) . '</div></div>';
	$modal .= '</div>';
	
	// open modal link
	if($style == 'button') {
		$modal .= '<a id="' . esc_html( $modal_object->post_name ) . '-modal" href="#' . esc_html( $modal_object->post_name ) . '">';
			$modal .= '<div class="modal-button button-size-' . $size . ' button-color-' . $color . '"><span>' . $content . '</span></div>';
		$modal .= '</a>';
	} else {
		$modal .= '<a id="' . esc_html( $modal_object->post_name ) . '-modal" href="#' . esc_html( $modal_object->post_name ) . '">' . $content . '</a>';
	}
	return $modal;
}
add_shortcode('modal', 'smw_shortcodes');

function smw_close_shortcode($atts, $content = null) {
	if($content == '')
		return '<a href="#" id="modalWindow-close">' . __('Close', 'sugar_modal') . '</a>';
	else 
		return '<a href="#" id="modalWindow-close">' . $content . '</a>';
}
add_shortcode('close', 'smw_close_shortcode');