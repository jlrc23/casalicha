<?php

$oldURL = dirname(__FILE__);
$newURL = str_replace(DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'sugar-modal-windows' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'tinymce', '', $oldURL);
include($newURL . DIRECTORY_SEPARATOR . 'wp-load.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php _e('Insert Modal', 'sugar_modal'); ?></title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo('wpurl');?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php bloginfo('wpurl');?>/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css"></style>
<link rel="stylesheet" href="includes/css/tinymce.css" />

<script type="text/javascript">
 
jQuery(function($){
	$('#style').change(function() {
		var style = $('option:selected', this).val();
		if(style == 'button') {
			$('.hidden-options').fadeIn();
		} else {
			$('.hidden-options').fadeOut();
		}
	});
}); 
 
var ButtonDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ButtonDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var text = jQuery('#button-dialog input#link-text').val();
		var modal = jQuery('#button-dialog select#modal-name').val();
		var style = jQuery('#button-dialog select#style').val();
		var color = jQuery('#button-dialog select#button-color').val();		 
		var size = jQuery('#button-dialog select#size').val();		 
		 
		var output = '';
		
		// setup the output of our shortcode
		output = '[modal ';
			output += 'id="' + modal + '" ';
			output += 'style=' + style + ' ';
			output += 'color=' + color + ' ';
			output += 'size=' + size;
			
		// check to see if the TEXT field is blank
		if(text) {	
			output += ']'+ text + '[/modal]';
		}
		// if it is blank, use the selected text, if present
		else {
			output += ']'+ButtonDialog.local_ed.selection.getContent() + '[/modal]';
		}
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);
 
</script>

</head>
<body>
	<div id="button-dialog">
		<form action="/" method="get" accept-charset="utf-8">
			<div>
				<label for="link-text">Link Text</label>
				<input type="text" name="link-text" value="" id="link-text" />
			</div>
			<div>
				<label for="modal-name">Choose Modal</label>
				<select name="modal-name" id="modal-name" size="1">
					<?php
						$modals = get_posts('post_type=modals&numberposts=-1');
						foreach($modals as $modal) {
							echo '<option value="' . $modal->ID . '">' . $modal->post_title . '</option>';
						}
					?>
				</select>
			</div>
			<div>
				<label for="style">Style</label>
				<select name="style" id="style" size="1">
					<option value="button" selected="selected">Button</option>
					<option value="plain"=>Plain Text</option>
				</select>
			</div>
			<div class="hidden-options">
				<label for="size">Button Size</label>
				<select name="size" id="size" size="1">
					<option value="large">Large</option>
					<option value="default" selected="selected">Default</option>
					<option value="small">Small</option>
				</select>
			</div>
			<div class="hidden-options">
				<label for="button-color">Button Color</label>
				<select name="button-color" id="button-color" size="1">
					<option value="default" selected="selected">Default</option>
					<option value="blue">Blue</option>
					<option value="orange">Orange</option>
					<option value="red">Red</option>
					<option value="green">Green</option>
					<option value="purple">Purple</option>
					<option value="black">Black</option>
				</select>
			</div>
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>