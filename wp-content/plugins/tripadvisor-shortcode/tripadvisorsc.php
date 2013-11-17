<?php
/*
Plugin Name: TripAdvisor shortcode
Plugin URI: http://ypraise.com/2013/wordpress/plugins/wordpress-2/tripadvidorsc-plugin/
Description: Trip Advisor shortcode allows for easy insertion of Tripadvisor review feed if your accommodation or travel website is using Wordpress.
Version: 2.1
Author: Kevin Heath
Author URI: http://ypraise.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// set up menu and options page.

add_action( 'admin_menu', 'tripadvisorsc_menu' );


function tripadvisorsc_menu() {
	add_options_page( 'tripadvisorsc', 'TripAdvisor SC', 'manage_options', 'tripadvisorsc', 'tripadvisorsc_options' );
}

add_action ('admin_init', 'tripadvisorsc_register');

function tripadvisorsc_register(){
register_setting('tripadvisorsc_options', 'tripadvisor_url');
register_setting('tripadvisorsc_options', 'tripadvisor_name');
register_setting('tripadvisorsc_options', 'tripadvisor_id');
register_setting('tripadvisorsc_options', 'tripadvisor_buff');
}

function tripadvisorsc_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>
	<div class="wrap">

	<h2>TripAdvisor Shortcode</h2>
	<div id="donate_container">
      Help keep this plugin in development and improved by using my Amazon links to make your purchases. Your commission can help support all my free Wordpress plugins. <a href="http://ypraise.com/2013/wordpress/plugins/wordpress-2/suport-my-free-wordpress-plugins/">My Amazon page</a>
    </div>
	
	<p><form method="post" action="options.php">	</p>
	<p>Add the url of the hotel or accommodation from Tripadvisor:</p>
	
	<?php
	
	settings_fields( 'tripadvisorsc_options' );
	
?>
<p>Add business url from TripAdvisor (exclude the http://tripadvisor.co.uk/): <input type="text" size="80" name="tripadvisor_url" value="<?php echo get_option('tripadvisor_url'); ?>" /></p>
<p>Add business name to display at top of feed (ie Reviews of BUSINESS NAME ): <input type="text" size="80" name="tripadvisor_name" value="<?php echo get_option('tripadvisor_name'); ?>" /></p>
<p>Add Tripadvisor ID (the dxxxxxx number in your url - do not include d: <input type="text" size="80" name="tripadvisor_id" value="<?php echo get_option('tripadvisor_id'); ?>" /></p>


					
					<p>Use buffering (if shortcode displays at top of content and not where you place it - only use if needed):  <select name='tripadvisor_buff'>
							<option value='No' <?php selected('No',get_option('tripadvisor_buff')); ?>>No</option>
							<option value='Yes' <?php selected('Yes', get_option('tripadvisor_buff')); ?>>Yes</option>
						
						</select></p>
					
				
 <?php


	
 submit_button();
echo '</form>';

	
	echo '</div>';
}



// lets build the shortcode



function tripadvisorscode($atts) {

$name = get_option('tripadvisor_name');
$url = get_option('tripadvisor_url');
$id = get_option('tripadvisor_id');

extract( shortcode_atts( array( 
    'name' => $name,
    'url' => $url,  
	'id' => $id, 
), $atts ) ); 

$buffering = get_option('tripadvisor_buff');
if ($buffering == "Yes") {
	ob_start();
	}
?>

<script>window.realAlert = window.alert;
window.alert = function() {};</script>
<script  src="http://www.tripadvisor.com/FeedsJS?f=restaurants&defaultStyles=n&d=<?php echo isset($atts['id']) ? $atts['id'] : get_option('tripadvisor_id') ?>&plang=es"></script>
<div id="TA_Container">
	<p><img src="/wp-content/uploads/2013/07/cargando.gif" align="left" style="margin-right:10px;"> <br>Cargando...</p>
</div>

<?php
$buffering = get_option('tripadvisor_buff');
if ($buffering == "Yes") {
  return ob_get_clean();
  }
  
}

add_shortcode('tripadvisorsc', 'tripadvisorscode');  
?>