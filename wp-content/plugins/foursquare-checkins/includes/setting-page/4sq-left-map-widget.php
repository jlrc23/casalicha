<?php
/**
 * @author Crunchify.com
 * Plugin: Foursquare Checkins
 */
?>
<div class="postbox">
	<h3>
		Map details for Widgets
		<?=$new_icon?>
	</h3>
	<div>
		<table class="form-table">
			<tr valign="top" class="alternate">
				<th scope="row" style="width: 35%;"><label>Enable Map on <code>Widget
							Area?</code>
				</label></th>
				<td><input id="styled" name="wp_4sq_checkins_widget_map_enable"
					type="checkbox"
					<?php if(get_option('wp_4sq_checkins_widget_map_enable')!='-1') echo 'checked="checked"'; ?>
					value="1" /> <code>Check</code> to Enable Map <br> <code>NOTE:</code>
					List view always enabled</td>
			</tr>

			<tr valign="top" class="alternate">
				<th scope="row" style="width: 35%;"><label>Widget Title</label></th>
				<td><input id="styled" name="wp_4sq_checkins_widget_title"
					type="text" size="25"
					value="<?php echo get_option('wp_4sq_checkins_widget_title'); ?>" />
				</td>
			</tr>

			<tr valign="top">
				<th scope="row" style="width: 35%;"><label>Widget Width</label></th>
				<td><input id="styled" name="wp_4sq_checkins_widget_width"
					type="text" size="15"
					value="<?php echo get_option('wp_4sq_checkins_widget_width'); ?>" />
				</td>
			</tr>

			<tr valign="top" class="alternate">
				<th scope="row" style="width: 35%;"><label>Widget Height</label></th>
				<td><input id="styled" name="wp_4sq_checkins_widget_height"
					type="text" size="15"
					value="<?php echo get_option('wp_4sq_checkins_widget_height'); ?>" />
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="submit">

	<input name="my_squarez_update_setting" type="hidden"
		value="<?php echo wp_create_nonce('square-update-setting'); ?>" /> <input
		type="submit" name="info_update" class="button-primary"
		value="<?php _e('Update options'); ?> &raquo;" />

</div>

</form>
</div>
