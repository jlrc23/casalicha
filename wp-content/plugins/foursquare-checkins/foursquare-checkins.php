<?php
/*
Plugin Name: FourSquare Checkins
Plugin URI: http://Crunchify.com/foursquare-checkins/
Description: FourSquare and Wordpress Integration Plugin. Include/Show your FourSquare Checkins along with your Post/Page or in Blog's Sidebar.
Version: 1.4
Author: Crunchify
Author URI: http://Crunchify.com
*/
 
/*
    Copyright (C) 2012-13 Crunchify.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Some default options

add_option('wp_4sq_checkins_feed_url', '');
add_option('wp_4sq_checkins_feed_count', '');

add_option('wp_4sq_checkins_map_enable', '-1');
add_option('wp_4sq_checkins_height', '300');
add_option('wp_4sq_checkins_width', '400');

add_option('wp_4sq_checkins_widget_map_enable', '-1');
add_option('wp_4sq_checkins_widget_title', '4sq Checkins');
add_option('wp_4sq_checkins_widget_width', '200');
add_option('wp_4sq_checkins_widget_height', '200');

function filter_wp_4sq_checkins_profile($content)
{
    if (strpos($content, "<!--wp_foursquare_checkins-->") !== FALSE)
    {
        $content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content);
        $content = str_replace('<!--wp_foursquare_checkins-->', wp_4sq_checkins_profile(), $content);
    }
    return $content;
}

function wp_4sq_checkins_profile()
{
	$map_enable = get_option('wp_4sq_checkins_map_enable');
	$foursq_height = get_option('wp_4sq_checkins_height');
	$foursq_width = get_option('wp_4sq_checkins_width');
	$foursq_feed_URL = get_option('wp_4sq_checkins_feed_url');
	$foursq_counts = get_option('wp_4sq_checkins_feed_count');
	//$foursq_final_feed_URL = 'http://feeds.foursquare.com/history/'.$foursq_feed_URL.'.rss';
	
	$foursq_final_feed_URL="https://api.foursquare.com/v2/venues/4bf988f55317a5930473017f/tips?oauth_token=WFNLZUQILDD2XU3Z31OVIUJ5N3GAFTR4QO32SOFANUZUYFNW&v=20130705";

    //$json = file_get_contents($url);
    //echo $json;
    //$data = json_decode($json, TRUE);

	$foursq_object = simplexml_load_file($foursq_final_feed_URL . '?count=' . $foursq_counts);
	$items = $foursq_object->channel;
	$foursq_checkin = $items->item;

	$postheader = "FourSquare Check-ins:";

	$foursq_credit = "FourSquare Checkins";

	$final_output = '<b>' . $postheader . '</b><br><ul>';
	$count = 0;
	foreach ($foursq_checkin as $item) {
		if ($item->link != '') {
			$final_output = $final_output . '<li><a href="'. $item->link .'">' . $item->title . '</a></li>';
		$count++;
		if ($count == $foursq_counts) {break;}
		}
	}
	$final_output = $final_output . '</ul>';

	if ($map_enable == 1)
	{

		$final_map = '<iframe width="' . $foursq_width . '" height="' . $foursq_height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=http://feeds.foursquare.com/history/'.$foursq_feed_URL.'.kml&amp;ie=UTF8&amp;output=embed"></iframe><br>';

		$final_output = $final_output . $final_map;
	}

	$final_output = $final_output;

	return $final_output;

}

function wp_4sq_checkins_widget()
{

	$foursq_widget_map_enable = get_option('wp_4sq_checkins_widget_map_enable');
	$foursq_widget_height = get_option('wp_4sq_checkins_widget_height');
	$foursq_widget_width = get_option('wp_4sq_checkins_widget_width');
	$foursq_feed_URL = get_option('wp_4sq_checkins_feed_url');
	$foursq_counts = get_option('wp_4sq_checkins_feed_count');
	$foursq_final_feed_URL = 'http://feeds.foursquare.com/history/'.$foursq_feed_URL.'.rss';
	$foursq_object = simplexml_load_file($foursq_final_feed_URL . '?count=' . $foursq_counts);
	$items = $foursq_object->channel;
	$foursq_checkin = $items->item;

	$foursq_credit = "FourSquare Integraton";

	$final_output = '<ul>';
	$count = 0;
	foreach ($foursq_checkin as $item) {
		if ($item->link != '') {
			$final_output = $final_output . '<li><a href="'. $item->link .'">' . $item->title . '</a></li>';
		$count++;
		if ($count == $foursq_counts) {break;}
		}
	}
	$final_output = $final_output . '</ul>';

	if ($foursq_widget_map_enable == 1)
	{

		$final_map = '<iframe width="' . $foursq_widget_width . '" height="' . $foursq_widget_height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=http://feeds.foursquare.com/history/'.$foursq_feed_URL.'.kml&amp;ie=UTF8&amp;output=embed"></iframe><br>';

		$final_output = $final_output . $final_map;
	}

	$final_output = $final_output;

	return $final_output;
}




function wp_4sq_checkins_add_option_page() {
    if (function_exists('add_options_page')) {
        add_options_page('FourSquare Checkins', '4sq Checkins', 8, __FILE__, 'wp_4sq_checkins_options_page');
    }
}

function wp_4sq_checkins_options_page() {

    if (isset($_POST['info_update']))
    {

    	if (!isset($_POST['my_squarez_update_setting'])) die("<br><br>Hmm .. looks like you didn't send any credentials.. No CSRF for you! ");
    	if (!wp_verify_nonce($_POST['my_squarez_update_setting'],'square-update-setting')) die("<br><br>Hmm .. looks like you didn't send any credentials.. No CSRF for you! ");
    	
		update_option('wp_4sq_checkins_feed_url', stripslashes_deep((string)$_POST["wp_4sq_checkins_feed_url"]));
        update_option('wp_4sq_checkins_feed_count', (string)$_POST["wp_4sq_checkins_feed_count"]);

		update_option('wp_4sq_checkins_map_enable', ($_POST['wp_4sq_checkins_map_enable']=='1') ? '1':'-1' );
		update_option('wp_4sq_checkins_height', (string)$_POST['wp_4sq_checkins_height']);
		update_option('wp_4sq_checkins_width', (string)$_POST['wp_4sq_checkins_width']);

		update_option('wp_4sq_checkins_widget_map_enable', ($_POST['wp_4sq_checkins_widget_map_enable']=='1') ? '1':'-1' );
        update_option('wp_4sq_checkins_widget_title', (string)$_POST["wp_4sq_checkins_widget_title"]);
        update_option('wp_4sq_checkins_widget_width', (string)$_POST["wp_4sq_checkins_widget_width"]);
        update_option('wp_4sq_checkins_widget_height', (string)$_POST["wp_4sq_checkins_widget_height"]);

        echo '<div id="message" class="updated fade"><p><strong>Settings Updated.</strong></p></div>';
        echo '</strong>';
    }

	$icon_url = get_bloginfo( 'wpurl' );
  	$foursq_icon = '<img border="0" src="'.$icon_url.'/wp-content/plugins/foursquare-checkins/images/4sq.jpg" /> ';
   	$new_icon = '<img border="0" src="'.$icon_url.'/wp-content/plugins/foursquare-checkins/images/new.gif" /> ';

	$foursq_feed_tip = '<img border="0" id="4sqeast1" value="Tip" title="Include only value appears in <b><font color=&quot;red&quot;>BOLD-RED</font></b><br>(http://feeds.foursquare.com/history/<b><font color=&quot;red&quot;>5XIU52QUJOV2XPSWML0AVDVYJ52Z3AFEL</font></b>.rss)" src="' . $icon_url . '/wp-content/plugins/all-in-one-webmaster/images/tip.png" /> ';

    ?>

	<?php
    require_once (dirname(__FILE__) . '/includes/settings-page.php');
    ?>

<?php
}

function show_wp_4sq_checkins_profile_widget($args)
{
	extract($args);
	$wp_4sq_checkins_widget_title1 = get_option('wp_4sq_checkins_widget_title');
	echo $before_widget;
	echo $before_title . $wp_4sq_checkins_widget_title1 . $after_title;
    echo wp_4sq_checkins_widget();
    echo $after_widget;
}

function wp_4sq_checkins_profile_widget_control()
{
    ?>
    <p>
    <? _e("Please go to <b>Settings -> 4sq Checkins</b> for options. <br><br> Available options: <br> 1) Widget Title <br> 2) Widget Width  <br> 3) Widget Height <br> 4) Enable Map Also??"); ?>
    </p>
    <?php
}

function widget_wp_4sq_checkins_profile_init()
{
    $widget_options = array('classname' => 'widget_wp_4sq_checkins_profile', 'description' => __( "Display FourSquare Widget") );
    wp_register_sidebar_widget('wp_4sq_checkins_profile_widgets', __('4sq Checkins'), 'show_wp_4sq_checkins_profile_widget', $widget_options);
    wp_register_widget_control('wp_4sq_checkins_profile_widgets', __('4sq Checkins'), 'wp_4sq_checkins_profile_widget_control' );
}

function foursq_plugin_admin_init()
{
	wp_enqueue_script('jquery');                    // Enque Default jQuery
	wp_enqueue_script('jquery-ui-core');            // Enque Default jQuery UI Core
	wp_enqueue_script('jquery-ui-tabs');            // Enque Default jQuery UI Tabs


    wp_register_script('4sq-plugin-script3', plugins_url('/js/myscript.js', __FILE__));
    wp_enqueue_script('4sq-plugin-script3');

    wp_register_script('4sq-plugin-script4', plugins_url('/js/tip.js', __FILE__));
    wp_enqueue_script('4sq-plugin-script4');

    wp_register_style('4sq-plugin-css', plugins_url('/css/jquery-ui.css', __FILE__));
    wp_enqueue_style('4sq-plugin-css');

    wp_register_style('4sq-tip-plugin-css', plugins_url('/css/jquery.powertip.css', __FILE__));
    wp_enqueue_style('4sq-tip-plugin-css');

    wp_register_style('4sq-member-plugin-css', plugins_url('/css/foursquare-checkins.css', __FILE__));
    wp_enqueue_style('4sq-member-plugin-css');
}

add_action('admin_menu', 'foursq_plugin_admin_init');
add_filter('the_content', 'filter_wp_4sq_checkins_profile');
add_action('init', 'widget_wp_4sq_checkins_profile_init');
add_action('admin_menu', 'wp_4sq_checkins_add_option_page');

?>