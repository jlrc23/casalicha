<div class="wrap">
	<div id="poststuff" style="padding-top:30px;">
		<div style="width:25%; float:right;">
		<div class="postbox" style="padding-bottom:40px;">
			<h3><?php _e( 'Like this plugin?', 'FourSquareAPI' ); ?></h3>
			<div class="inside">
				<p><?php _e( 'Please consider one of the following ...', 'FourSquareAPI' ); ?>
					<ul style="list-style: disc inside none;">
						<li><?php _e( 'Enable the credit link in the widget', 'FourSquareAPI' ); ?></li>
						<li><?php _e( 'Give it a rating on', 'FourSquareAPI' ); ?> <a href="http://wordpress.org/extend/plugins/foursquareapi/" target="_blank">WordPress.org</a></li>
						<li><?php _e( 'Donate for development', 'FourSquareAPI' ); ?>
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">
								<input type="hidden" name="cmd" value="_s-xclick">
								<input type="hidden" name="hosted_button_id" value="GYR6PYQPTNM8E">
								<input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
								<img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
							</form>
						</li>
					</ul>
				</p>
			</div>
		</div>
		<div class="postbox">
			<h3><?php _e( 'Showcase your site @NZGuru', 'GetGlueAPI' ); ?></h3>
			<div class="inside">
				<p><?php _e( 'Tell me about your site and I will feature it on my users page...', 'GetGlueAPI' ); ?>
					<form target="_blank" method="post" action="http://nzguru.net/cool-stuff/foursquareapi-plugin-for-wordpress/who-is-using-foursquareapi">
						<fieldset class="options">
							<input type="hidden" value="11" id="link_category" name="link_category">
							<input type="hidden" value="hot" id="ll_customcaptchaanswer" name="ll_customcaptchaanswer">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="link_name"><?php _e('Your Sites Name', 'GetGlueAPI') ?></label>
											<input type="text" id="link_name" name="link_name" style="width:100%" />
										</th>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="link_name"><?php _e('Your Sites URL', 'GetGlueAPI') ?></label>
											<input type="text" id="link_url" name="link_url" style="width:100%" />
										</th>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="link_notes"><?php _e('Site Description', 'GetGlueAPI') ?></label>
											<textarea id="link_notes" name="link_notes" style="width:100%"></textarea>
										</th>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="ll_reciprocal"><?php _e('Link to page showing plugin', 'GetGlueAPI') ?></label>
											<input type="text" id="ll_reciprocal" name="ll_reciprocal" style="width:100%" />
											<span class="description"><?php _e('(Please ensure that you are linking back to NZGuru in at least 1 plugin)', 'GetGlueAPI') ?></span>
										</td>
									</tr>
								</tbody>
							</table>
						</fieldset>
						<p class="submit">
							<input type="submit" name="submit" class="button-primary" value="<?php _e('Add Link', 'GetGlueAPI'); ?>" />
						</p>
					</form>
				</p>
			</div>
		</div>
		</div>
		<div id="FourSquareAPI_Feedback">
			<?php
			if( $error = $this->errors->get_error_message() ) {
				echo '<div class="error"><p>' . $error . '</p></div>';
			}
			if( $success = $this->success ) {
				echo '<div class="updated"><p>' . $success . '</p></div>';
			}
			?>
		</div>
		<?php
		if( '' == get_option( 'FourSquareAPI_oauth_token' ) ) {
			?>
			<div class="postbox" style="width:74%;">
				<h3><?php _e('Not connected to foursquare&reg;', 'FourSquareAPI' ); ?></h3>
				<div class="inside">
					<form method="post" action="options.php">
						<fieldset class="options">
							<?php
							settings_fields( 'FourSquareAPISettings' );
							?>
							<input type="hidden" id="FourSquareAPI_venuehistory_api_calls" name="FourSquareAPI_venuehistory_api_calls" value="0" />
							<input type="hidden" id="FourSquareAPI_venuehistory_cache_time" name="FourSquareAPI_venuehistory_cache_time" value="0" />
							<input type="hidden" id="FourSquareAPI_checkins_api_calls" name="FourSquareAPI_checkins_api_calls" value="0" />
							<input type="hidden" id="FourSquareAPI_checkins_cache_time" name="FourSquareAPI_checkins_cache_time" value="0" />
							<input type="hidden" id="FourSquareAPI_mayorships_api_calls" name="FourSquareAPI_mayorships_api_calls" value="0" />
							<input type="hidden" id="FourSquareAPI_mayorships_cache_time" name="FourSquareAPI_mayorships_cache_time" value="0" />
							<input type="hidden" id="FourSquareAPI_badges_api_calls" name="FourSquareAPI_badges_api_calls" value="0" />
							<input type="hidden" id="FourSquareAPI_badges_cache_time" name="FourSquareAPI_badges_cache_time" value="0" />
							<p><?php _e( 'The process to set up OAuth authentication for your web site is a simple 3-steps.', 'FourSquareAPI'); ?></p>
							<h4><?php _e( '1. Register this site as an application on ', 'FourSquareAPI' ); ?><a href="https://foursquare.com/oauth/register" target="_blank"><?php _e( 'the foursquare&reg; application registration page', 'FourSquareAPI' ); ?></a></h4>
							<ul>
								<li><?php _e( 'If you are not currently logged in, log-in with the foursquare&reg; account which you want associated with this site' , 'FourSquareAPI' ); ?></li>
								<li><?php _e( 'Your Application Name is for your own reference only.' , 'FourSquareAPI' ); ?></li>
								<li><?php _e( 'Your Application Web Site should be', 'FourSquareAPI' ); ?> <strong><?php echo get_bloginfo( 'url' ); ?></strong></li>
								<li><?php _e( 'The WebSite and Callback URL should be ', 'FourSquareAPI'); ?><strong><?php echo plugins_url(); ?>/foursquareapi/FourSquareAPI.php</strong></li>
							</ul>
							<p><em><?php _e('Once you have registered your site as an application, you will be provided with two keys.', 'FourSquareAPI'); ?></em></p>
							<h4><?php _e('2. Copy and paste your Client ID and Client Secret into the fields below' , 'FourSquareAPI'); ?></h4>
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_client_id"><?php _e('Client ID', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<input type="text" id="FourSquareAPI_client_id" name="FourSquareAPI_client_id" value="<?php echo get_option('FourSquareAPI_client_id'); ?>" />
											<span class="description"><?php _e('Client ID from foursquare&reg;', 'FourSquareAPI') ?></span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_client_secret"><?php _e('Client Secret', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<input type="text" id="FourSquareAPI_client_secret" name="FourSquareAPI_client_secret" value="<?php echo get_option('FourSquareAPI_client_secret'); ?>" />
											<span class="description"><?php _e('Client Secret from foursquare&reg;', 'FourSquareAPI') ?></span>
										</td>
									</tr>
								</tbody>
							</table>
							<?php
							if( get_option('FourSquareAPI_client_id') != '' && get_option('FourSquareAPI_client_secret') != '' ) {
								?>
								<h4><?php _e('3. Now that your have your application details, you may connect to foursquare&reg;' , 'FourSquareAPI'); ?></h4>
								<?php
							}
							?>
						</fieldset>
						<p class="submit">
							<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update API Keys', 'FourSquareAPI'); ?>" />
							<?php
							if( get_option('FourSquareAPI_client_id') != '' && get_option('FourSquareAPI_client_secret') != '' ) {
								$foursquare = new FourSquareAPI_API( get_option( 'FourSquareAPI_client_id' ), get_option( 'FourSquareAPI_client_secret' ), plugins_url() . '/foursquareapi/FourSquareAPI.php' );
								?>
								<a href="<?php echo $foursquare->authentication_link(); ?>" class="button-primary"><?php _e('Connect to foursquare&reg;', 'FourSquareAPI'); ?></a>
								<?php
							}
							?>
						</p>
					</form>
				</div>
			</div>
			<?php
		}
		else {
			?>
			<div class="postbox" style="width:74%;">
				<h3><?php _e('Connected to foursquare&reg;', 'FourSquareAPI' ); ?></h3>
				<div class="inside">
					<form method="post" action="options.php">
						<fieldset class="options">
							<?php
							settings_fields( 'FourSquareAPISettings' );
							?>
							<input type="hidden" id="FourSquareAPI_venuehistory_api_calls" name="FourSquareAPI_venuehistory_api_calls" value="0" />
							<input type="hidden" id="FourSquareAPI_venuehistory_cache_time" name="FourSquareAPI_venuehistory_cache_time" value="<?php echo time(); ?>" />
							<input type="hidden" id="FourSquareAPI_checkins_api_calls" name="FourSquareAPI_checkins_api_calls" value="0" />
							<input type="hidden" id="FourSquareAPI_checkins_cache_time" name="FourSquareAPI_checkins_cache_time" value="<?php echo time(); ?>" />
							<input type="hidden" id="FourSquareAPI_mayorships_api_calls" name="FourSquareAPI_mayorships_api_calls" value="0" />
							<input type="hidden" id="FourSquareAPI_mayorships_cache_time" name="FourSquareAPI_mayorships_cache_time" value="<?php echo time(); ?>" />
							<input type="hidden" id="FourSquareAPI_badges_api_calls" name="FourSquareAPI_badges_api_calls" value="0" />
							<input type="hidden" id="FourSquareAPI_badges_cache_time" name="FourSquareAPI_badges_cache_time" value="<?php echo time(); ?>" />
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_client_id"><?php _e('Client ID', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<code><?php echo get_option('FourSquareAPI_client_id'); ?></code>
											<span class="description"><?php _e('Client ID from foursquare&reg;', 'FourSquareAPI') ?></span>
											<input type="hidden" id="FourSquareAPI_client_id" name="FourSquareAPI_client_id" value="<?php echo get_option('FourSquareAPI_client_id'); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_client_secret"><?php _e('Client Secret', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<code><?php echo get_option('FourSquareAPI_client_secret'); ?></code>
											<span class="description"><?php _e('Client Secret from foursquare&reg;', 'FourSquareAPI') ?></span>
											<input type="hidden" id="FourSquareAPI_client_secret" name="FourSquareAPI_client_secret" value="<?php echo get_option('FourSquareAPI_client_secret'); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_oauth_token"><?php _e( 'OAuth Token', 'FourSquareAPI' ) ?></label>
										</th>
										<td>
											<code><?php echo get_option( 'FourSquareAPI_oauth_token' ); ?></code>
											<span class="description"><?php _e('OAuth Token from foursquare&reg;', 'FourSquareAPI') ?></span>
											<input type="hidden" id="FourSquareAPI_oauth_token" name="FourSquareAPI_oauth_token" value="" />
										</td>
									</tr>
								</tbody>
							</table>
						</fieldset>
						<p class="submit">
							<input type="submit" name="Submit" class="button-primary" value="<?php _e('Disconnect from foursquare&reg;', 'FourSquareAPI'); ?>" />
						</p>
					</form>
				</div>
			</div>
			<div class="postbox" style="width:74%;">
				<h3><?php _e('FourSquareAPI Stats', 'FourSquareAPI' ); ?></h3>
				<div class="inside">
					<form method="post" action="options.php">
						<fieldset class="options">
							<?php
							settings_fields( 'FourSquareAPISettings' );
							?>
							<input type="hidden" id="FourSquareAPI_client_id" name="FourSquareAPI_client_id" value="<?php echo get_option('FourSquareAPI_client_id'); ?>" />
							<input type="hidden" id="FourSquareAPI_client_secret" name="FourSquareAPI_client_secret" value="<?php echo get_option('FourSquareAPI_client_secret'); ?>" />
							<input type="hidden" id="FourSquareAPI_oauth_token" name="FourSquareAPI_oauth_token" value="<?php echo get_option('FourSquareAPI_oauth_token'); ?>" />
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_venuehistory_cache_time"><?php _e('Venue History', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<input type="text" id="FourSquareAPI_venuehistory_api_calls" name="FourSquareAPI_venuehistory_api_calls" value="<?php echo get_option('FourSquareAPI_venuehistory_api_calls'); ?>" />
											<span class="description"><?php _e('last cached', 'FourSquareAPI') ?> <?php echo date( 'D, d M Y H:i:s', get_option( 'FourSquareAPI_venuehistory_cache_time' ) ); ?></span>
											<input type="hidden" id="FourSquareAPI_venuehistory_cache_time" name="FourSquareAPI_venuehistory_cache_time" value="<?php echo time(); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_venuehistory_cache_life"><?php _e('Venue History Cache Life', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<select id="FourSquareAPI_venuehistory_cache_life" name="FourSquareAPI_venuehistory_cache_life">
												<option value="0"<?php echo ( get_option( 'FourSquareAPI_venuehistory_cache_life' ) == 0 ) ? 'selected="selected"' : ''; ?>><?php _e( 'Never', 'FourSquareAPI' ); ?></option>
												<option value="1"<?php echo ( get_option( 'FourSquareAPI_venuehistory_cache_life' ) == 1 ) ? 'selected="selected"' : ''; ?>><?php _e( '1 minute', 'FourSquareAPI' ); ?></option>
												<option value="2"<?php echo ( get_option( 'FourSquareAPI_venuehistory_cache_life' ) == 2 ) ? 'selected="selected"' : ''; ?>><?php _e( '2 minutes', 'FourSquareAPI' ); ?></option>
												<option value="3"<?php echo ( get_option( 'FourSquareAPI_venuehistory_cache_life' ) == 3 ) ? 'selected="selected"' : ''; ?>><?php _e( '3 minutes', 'FourSquareAPI' ); ?></option>
												<option value="4"<?php echo ( get_option( 'FourSquareAPI_venuehistory_cache_life' ) == 4 ) ? 'selected="selected"' : ''; ?>><?php _e( '4 minutes', 'FourSquareAPI' ); ?></option>
												<option value="5"<?php echo ( get_option( 'FourSquareAPI_venuehistory_cache_life' ) == 5 ) ? 'selected="selected"' : ''; ?>><?php _e( '5 minutes', 'FourSquareAPI' ); ?></option>
											</select>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_checkins_cache_time"><?php _e('Checkins', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<input type="text" id="FourSquareAPI_checkins_api_calls" name="FourSquareAPI_checkins_api_calls" value="<?php echo get_option('FourSquareAPI_checkins_api_calls'); ?>" />
											<span class="description"><?php _e('last cached', 'FourSquareAPI') ?> <?php echo date( 'D, d M Y H:i:s', get_option( 'FourSquareAPI_checkins_cache_time' ) ); ?></span>
											<input type="hidden" id="FourSquareAPI_checkins_cache_time" name="FourSquareAPI_checkins_cache_time" value="<?php echo time(); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_checkins_cache_life"><?php _e('Checkins Cache Life', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<select id="FourSquareAPI_checkins_cache_life" name="FourSquareAPI_checkins_cache_life">
												<option value="0"<?php echo ( get_option( 'FourSquareAPI_checkins_cache_life' ) == 0 ) ? 'selected="selected"' : ''; ?>><?php _e( 'Never', 'FourSquareAPI' ); ?></option>
												<option value="1"<?php echo ( get_option( 'FourSquareAPI_checkins_cache_life' ) == 1 ) ? 'selected="selected"' : ''; ?>><?php _e( '1 minute', 'FourSquareAPI' ); ?></option>
												<option value="2"<?php echo ( get_option( 'FourSquareAPI_checkins_cache_life' ) == 2 ) ? 'selected="selected"' : ''; ?>><?php _e( '2 minutes', 'FourSquareAPI' ); ?></option>
												<option value="3"<?php echo ( get_option( 'FourSquareAPI_checkins_cache_life' ) == 3 ) ? 'selected="selected"' : ''; ?>><?php _e( '3 minutes', 'FourSquareAPI' ); ?></option>
												<option value="4"<?php echo ( get_option( 'FourSquareAPI_checkins_cache_life' ) == 4 ) ? 'selected="selected"' : ''; ?>><?php _e( '4 minutes', 'FourSquareAPI' ); ?></option>
												<option value="5"<?php echo ( get_option( 'FourSquareAPI_checkins_cache_life' ) == 5 ) ? 'selected="selected"' : ''; ?>><?php _e( '5 minutes', 'FourSquareAPI' ); ?></option>
											</select>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_mayorships_cache_time"><?php _e('Mayorships', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<input type="text" id="FourSquareAPI_mayorships_api_calls" name="FourSquareAPI_mayorships_api_calls" value="<?php echo get_option('FourSquareAPI_mayorships_api_calls'); ?>" />
											<span class="description"><?php _e('last cached', 'FourSquareAPI') ?> <?php echo date( 'D, d M Y H:i:s', get_option( 'FourSquareAPI_mayorships_cache_time' ) ); ?></span>
											<input type="hidden" id="FourSquareAPI_mayorships_cache_time" name="FourSquareAPI_mayorships_cache_time" value="<?php echo time(); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_mayorships_cache_life"><?php _e('Mayorships Cache Life', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<select id="FourSquareAPI_mayorships_cache_life" name="FourSquareAPI_mayorships_cache_life">
												<option value="0"<?php echo ( get_option( 'FourSquareAPI_mayorships_cache_life' ) == 0 ) ? 'selected="selected"' : ''; ?>><?php _e( 'Never', 'FourSquareAPI' ); ?></option>
												<option value="1"<?php echo ( get_option( 'FourSquareAPI_mayorships_cache_life' ) == 1 ) ? 'selected="selected"' : ''; ?>><?php _e( '1 minute', 'FourSquareAPI' ); ?></option>
												<option value="2"<?php echo ( get_option( 'FourSquareAPI_mayorships_cache_life' ) == 2 ) ? 'selected="selected"' : ''; ?>><?php _e( '2 minutes', 'FourSquareAPI' ); ?></option>
												<option value="3"<?php echo ( get_option( 'FourSquareAPI_mayorships_cache_life' ) == 3 ) ? 'selected="selected"' : ''; ?>><?php _e( '3 minutes', 'FourSquareAPI' ); ?></option>
												<option value="4"<?php echo ( get_option( 'FourSquareAPI_mayorships_cache_life' ) == 4 ) ? 'selected="selected"' : ''; ?>><?php _e( '4 minutes', 'FourSquareAPI' ); ?></option>
												<option value="5"<?php echo ( get_option( 'FourSquareAPI_mayorships_cache_life' ) == 5 ) ? 'selected="selected"' : ''; ?>><?php _e( '5 minutes', 'FourSquareAPI' ); ?></option>
											</select>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_badges_cache_time"><?php _e('Badges', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<input type="text" id="FourSquareAPI_badges_api_calls" name="FourSquareAPI_badges_api_calls" value="<?php echo get_option('FourSquareAPI_badges_api_calls'); ?>" />
											<span class="description"><?php _e('last cached', 'FourSquareAPI') ?> <?php echo date( 'D, d M Y H:i:s', get_option( 'FourSquareAPI_badges_cache_time' ) ); ?></span>
											<input type="hidden" id="FourSquareAPI_badges_cache_time" name="FourSquareAPI_badges_cache_time" value="<?php echo time(); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="FourSquareAPI_badges_cache_life"><?php _e('Badges Cache Life', 'FourSquareAPI') ?></label>
										</th>
										<td>
											<select id="FourSquareAPI_badges_cache_life" name="FourSquareAPI_badges_cache_life">
												<option value="0"<?php echo ( get_option( 'FourSquareAPI_badges_cache_life' ) == 0 ) ? 'selected="selected"' : ''; ?>><?php _e( 'Never', 'FourSquareAPI' ); ?></option>
												<option value="1"<?php echo ( get_option( 'FourSquareAPI_badges_cache_life' ) == 1 ) ? 'selected="selected"' : ''; ?>><?php _e( '1 minute', 'FourSquareAPI' ); ?></option>
												<option value="2"<?php echo ( get_option( 'FourSquareAPI_badges_cache_life' ) == 2 ) ? 'selected="selected"' : ''; ?>><?php _e( '2 minutes', 'FourSquareAPI' ); ?></option>
												<option value="3"<?php echo ( get_option( 'FourSquareAPI_badges_cache_life' ) == 3 ) ? 'selected="selected"' : ''; ?>><?php _e( '3 minutes', 'FourSquareAPI' ); ?></option>
												<option value="4"<?php echo ( get_option( 'FourSquareAPI_badges_cache_life' ) == 4 ) ? 'selected="selected"' : ''; ?>><?php _e( '4 minutes', 'FourSquareAPI' ); ?></option>
												<option value="5"<?php echo ( get_option( 'FourSquareAPI_badges_cache_life' ) == 5 ) ? 'selected="selected"' : ''; ?>><?php _e( '5 minutes', 'FourSquareAPI' ); ?></option>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</fieldset>
						<p class="submit">
							<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update Cache Settings', 'FourSquareAPI'); ?>" />
						</p>
					</form>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
