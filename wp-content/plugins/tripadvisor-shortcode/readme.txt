=== Tripadvisor Shortcode ===
Author: Kevin Heath (ypraise.com)
Plugin URI: http://ypraise.com/2013/wordpress/plugins/wordpress-2/tripadvidorsc-plugin/
Donate link: http://ypraise.com/2013/wordpress/plugins/wordpress-2/suport-my-free-wordpress-plugins/
Tags: tripadvisor, hotels, holidays, vacations, restaurants
Requires at least: 3.0
Tested up to: 3.5.2
Stable tag: 2.1
Version: 2.1
License: GPLv2 or later


== Description ==

This plugin allows you to easily insert the Tripadvisor review feed for a hotel or accommodation through the use of a shortcode. The shortcode is best placed in a page or post. You could try using it in a text widget if your theme allows shortcodes in text wdigets but you will need to do a lot of css changes to get it to fit and look reasonable. 




== Installation ==

Manual install: Unzip the file into your WordPress plugin-directory. Activate the plugin in wp-admin.

Install through WordPress admin: Go to Plugins > Add New. Search for "TripAdvisor Shortcode". Locate the plugin in the search results. Click "Install now". Click "Activate".

== Frequently Asked Questions ==

= How do I use this plugin? =

Go to the settings page and fill in the required information: 
1. TripAdvisor url excluding the main domain part ie exclude http://tripadvisor.co.uk/
2. Add you business name.
3. Add your TripAdvisor business id number - displayed in the url and starting with the letter d.

Add the shortcode [tripadvisorsc] where you want the 10 reviews to be displayed. 

You can make your theme shortcode friendly in widget text boxes by adding the following to your theme functions file:
 add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');

=  Using shortcode attributes =

Use the shortcode attribute name, url and id to add a feed. Any attribute not filled in will be taken from the main settings page. An example shortcode for the Half Moon Inn in Abergavenny would be:

[tripadvisorsc name="Half Moon Inn" url="Hotel_Review-g186433-d297243-Reviews-Half_Moon_Inn-Abergavenny_Monmouthshire_Southern_Wales_Wales.html" id="297243"]

The name is what you want to be places at Reviews for: , the url is the tripadvosr page url excluding the relevent triadvisor domain such as tripadvisor.com/ , the id is the property id number less the d (you can find it in the url as dxxxx).


== Screenshots ==

1. TripAdvisor feeds displayed by the shortcode.


== Changelog ==

= 2.1 =

* added a buffering option. If you have a complez theme and the shortcode keeps appearing at the top of the page rather than where you place it then this could help. Only switch this on in the settings of it is needed. 


= 2.0 =

* You can now use shortcode attributes to add more than one OwnerFeed to your web site, which is ideal for multi-nit operators. Please be aware that TripAdvisor terms and conditions for ownerfeeds means no moe than 50 feeds per web site. Contact them if you need more.

Use the shortcode attribute name, url and id to add a feed. Any attribute not filled in will be taken from the main settings page. An example shortcode for the Half Moon Inn in Abergavenny would be:

[tripadvisorsc name="Half Moon Inn" url="Hotel_Review-g186433-d297243-Reviews-Half_Moon_Inn-Abergavenny_Monmouthshire_Southern_Wales_Wales.html" id="297243"]

The name is what you want to be places at Reviews for: , the url is the tripadvosr page url excluding the relevent triadvisor domain such as tripadvisor.com/ , the id is the property id number less the d (you can find it in the url as dxxxx).


= 1.0 =

* Say hello to the TripAdvisor plugin if your travel based web site is running on Wordpress and features in Tripadvisor.

== Upgrade Notice ==

= 2.0 =
You can now add more than 1 Ownerfeed to your web site but be aware of tripadvisors terms and conditions that restricts you to no more than 50 feeds per web site.

= 1.0 =
Initial release.
