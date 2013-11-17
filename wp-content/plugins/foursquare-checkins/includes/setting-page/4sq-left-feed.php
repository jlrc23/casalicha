<?php
/**
 * @author Crunchify.com
 * Plugin: Foursquare Checkins
 */
?>

			<div class="postbox">
				<h3>FourSquare Feed Information</h3>
					<div>
					<table class="form-table">

					<tr valign="top">
						<th scope="row" style="width:35%;"><label>FourSquare Feed Value?</label></th>
						<td>
						 <input id="styled" name="wp_4sq_checkins_feed_url" type="text" size="50" value="<?php echo get_option('wp_4sq_checkins_feed_url'); ?>" /> 
						 &nbsp;<?=$foursq_feed_tip?>
 
						<br>Get <a href="http://foursquare.com/feeds" target="_blank">Feed Value</a>
						</td>
					</tr>

						<tr valign="top" class="alternate">
							<th scope="row" style="width:35%;"><label>Number of feed entries?</label></th>
							<td>
							 <input id="styled" name="wp_4sq_checkins_feed_count" type="text" size="15" value="<?php echo get_option('wp_4sq_checkins_feed_count'); ?>" />
							 <br>
							 <code>NOTE:</code> Only applicable to List view.
							</td>
						</tr>
						</table>
					</div>
			</div>
		<div class="submit">
			<input name="my_squarez_update_setting" type="hidden" value="<?php echo wp_create_nonce('square-update-setting'); ?>" />
	        <input type="submit" name="info_update" class="button-primary" value="<?php _e('Update options'); ?> &raquo;" />

	    </div>