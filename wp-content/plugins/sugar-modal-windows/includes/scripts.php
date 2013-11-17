<?php
// load the sugar modal windows scripts
function smw_load_scripts() {
	global $smw_base_dir;
	if(!is_admin()) {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script('smw-modalWindow', $smw_base_dir . 'includes/js/jquery.modalWindow.js');
		wp_enqueue_script('smw-cookies', $smw_base_dir . 'includes/js/jquery.cookie.js');
	}
}

function smw_load_styles() {
	global $smw_base_dir;
	wp_enqueue_style('smw-modalWindow', $smw_base_dir . 'includes/css/modalWindow.css');
}
add_action('wp_print_scripts', 'smw_load_scripts');
add_action('wp_print_styles', 'smw_load_styles');

function smw_admin_css() {
	global $smw_base_dir;
	wp_enqueue_style('smw-admin', $smw_base_dir . 'includes/css/admin-styles.css');
}

if(strstr($_SERVER['REQUEST_URI'], 'wp-admin/edit.php?post_type=modals&page=sugar-modal-windows/sugar-modal-windows.php')) {
	add_action('admin_print_styles', 'smw_admin_css');
}

function smw_remove_preview() {
	global $post;
	if(get_post_type($post) == 'modals') {
	?>
		<script type="text/javascript">
			//<![CDATA[
				jQuery(function($){
					$('#preview-action, #edit-slug-box').remove();
				}); // end jquery(function($))
			//]]>
		</script>
	<?php
	}
}
if (strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php') || strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php')) {
	add_action('admin_head', 'smw_remove_preview');
}