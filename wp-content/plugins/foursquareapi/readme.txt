=== FourSquareAPI ===
Contributors: nzguru
Author URI: http://nzguru.net
Plugin URI: http://nzguru.net/cool-stuff/foursquareapi-plugin-for-wordpress
Donate link: http://nzguru.net/cool-stuff/foursquareapi-plugin-for-wordpress
Tags: foursquare,checkin,badges,widget,sidebar,api,social,google map,four square,social media,venue,location,4SQ,mayors,mayorships,recent,checkins,latest
Requires at least: 2.7
Tested up to: 3.2.1
Stable tag: 2.0.6

The 1st plugin to integrate the foursquare&reg; API into WordPress to show your checkins and badges

== Description ==

This plugin uses the foursquare<sup>&reg;</sup> API to retrieve various information and display it in a widget or directly in posts and pages via a shortcode. Information currently available includes ...

* your recent checkins
* your mayorships
* your badges
* your checkin history

To display your selected data in a widget, simply drag the widget to your sidebar and select the optins you want to display. Similarly, you can add the widget styled data to a page or post by using the shortcode features (see FAQ)

Your foursquare data may be displayed with options to include a map showing the location(s), address details, and statistics relating to the venue. Some data also allows you display a timestamp relating to when the event occured (such as when you checked in or when you received a badge)

== Installation ==

For an automatic installation through WordPress:

1. Go to the 'Add New' plugins screen in your WordPress admin area
2. Search for 'foursquareapi'
3. Click 'Install Now' and activate the plugin
4. Go to the Settings -> FourSquareAPI admin panel and follow the instructions to connect with foursquare<sup>&reg;</sup>.

For a manual upload installation through WordPress:

1. Download the FourSquareAPI zip file from [wordpress.org](http://wordpress.org/extend/plugins/foursquareapi/)
2. Go to the 'Add New' plugins screen in your Wordpress admin area and select the 'Upload' tab
3. Browse to where you download the zip file
4. Click 'Install Now' and activate the plugin
5. Go to the Settings -> FourSquareAPI admin panel and follow the instructions to connect with foursquare<sup>&reg;</sup>.

For a manual installation via FTP:

1. Download the FourSquareAPI zip file from [wordpress.org](http://wordpress.org/extend/plugins/foursquareapi/)
2. Unzip to your local drive
3. Upload the foursquareapi folder to the /wp-content/plugins/ directory on your server
4. Activate the plugin through the 'Plugins' screen in your WordPress admin area
5. Go to the Settings -> FourSquareAPI admin panel and follow the instructions to connect with foursquare<sup>&reg;</sup>.

== Frequently Asked Questions ==

= What is foursquare<sup>&reg;</sup>? =

foursquare<sup>&reg;</sup> is a mobile application that is a cross between a friend-finder, a social city-guide, and a game that encourages users to explore their neighborhoods and rewards them for doing so.

= What is the foursquare<sup>&reg;</sup> API? =

API stands for "application programming interface." APIs facilitate interaction between different software programs by making it easy for them to share data and resources.

= What about the foursquare<sup>&reg;</sup> API limits? =

foursquare<sup>&reg;</sup> has a very generous 500 requests/hour limit but that doesn't mean we should just plow through it all. This plugin allows you to specify a cache time which will limit your requests to, for example, 1 per minute regardless of the number of visitors to your site.

= Can I get this plugin in a different language? =

Language translations are being added as I am able to do them. If you would like to help by completing a translation, please send [gettext PO and MO files](http://codex.wordpress.org/Translating_WordPress) to me via [NZGuru.net](http://nzguru.net/contact-me) and I will include them in the next update. You can download the latest [POT file from here](http://plugins.svn.wordpress.org/foursquareapi/trunk/lang/foursquareapi.pot).

= How do I use the [foursquare_venues] shortcode? =

Simply place [<code>foursquare_venues</code>] in your page or post. You may optionally add any of the following to customize the appearance -

* <code>type=x</code> where x is either <code>checkins</code>, <code>mayorships</code>, or <code>venuehistory</code> (default is venuehistory)
* <code>width=x</code> where x is the pixel width of the resulting data (default is 400)
* <code>map_height=x</code> where x is the pixel height of the map (default is 0 meaning do not show map)
* <code>map_zoom=x</code> where x is the initial zoom level for the map (default is 16)
* <code>timestamp=1</code> to show when you visited (default is 0 meaning do not show timestamp, data not available for all types)
* <code>address=1</code> to show address data (default is 0 meaning do not show address data)
* <code>stats=1</code> to show venue stats (default is 0 meaning do not show venue stats)
* <code>limit=x</code> where x is the maximum number of venues to show (default is 0 meaning show all available venues)
* <code>list=1</code> to show venues in a list (default is 0 showing scrollable venues)
* <code>autoscroll=1600</code> speed in milliseconds for scrolling box (default is 0 which disables scrolling, ignored if displaying as a list)
* <code>id=x</code> where x is a unique number allowing you to have multiple shortcodes on the same page (default is 1)

= How do I use the [foursquare_badges] shortcode? =

Simply place [<code>foursquare_badges</code>] in your page or post. You may optionally add any of the following to customize the appearance -

* <code>type=x</code> where x is currently only <code>badges</code> (default is badges)
* <code>width=x</code> where x is the pixel width of the resulting data (default is 400)
* <code>map_height=x</code> where x is the pixel height of the map (default is 0 meaning do not show map)
* <code>map_zoom=x</code> where x is the initial zoom level for the map (default is 16)
* <code>timestamp=1</code> to show when you visited (default is 0 meaning do not show timestamp, data not available for all types)
* <code>description=1</code> to show the badge description (default is 0 meaning do not show description, data not available for all types)
* <code>limit=0</code> to show all badges (default is 0 meaning show only earned badges)
* <code>venue=1</code> to show venue data (default is 0 meaning do not show venue data, must be enabled to show address and/or stats)
* <code>address=1</code> to show address data (default is 0 meaning do not show address data)
* <code>stats=1</code> to show venue stats (default is 0 meaning do not show venue stats)
* <code>list=1</code> to show badges in a list (default is 0 showing scrollable badges)
* <code>autoscroll=1600</code> speed in milliseconds for scrolling box (default is 0 which disables scrolling, ignored if displaying as a list)
* <code>id=x</code> where x is a unique number allowing you to have multiple shortcodes on the same page (default is 1)

== Screenshots ==

1. Install process step 1
2. Install process step 2
3. Install process step 3
4. Install process step 4
5. Install process step 5
6. API Stats
7. Venues widget options
8. Badges widget options
9. Venues widget example showing recent checkins
10. Venues widget example showing history
11. Badges widget example
12. Venues shortcode example
13. Badges shortcode example

== Changelog ==

= 2.0.6 =
* Added ability to showcase your site on NZGuru

= 2.0.5 =
* Better caching and resizing of images for map

= 2.0.4 =
* Corrected some typos

= 2.0.3 =
* Corrected missing image

= 2.0.2 =
* Added ability include/exclude private checkins (excluded by default)

= 2.0.1 =
* Changed some class names to avoid template clashes
* Changed slider javascript to better use native jQuery

= 2.0.0 =
* Completely rewritten code for better performance
* Cleaner layouts matching foursquare
* Multi widget capability
* Language translations for Swedish, French, and Spanish

= 1.4.3 =
* Fix for checkins not obaying limit

= 1.4.2 =
* Fix for map not displaying when only using shortcodes (previous update failed)

= 1.4.1 =
* Fix for map not displaying when only using shortcodes 

= 1.4.0 =
* Added mayorships widget and shortcode

= 1.3.9 =
* Improved cache handling to reduce calls and data storage

= 1.3.8 =
* Fixed Badges shortcode map not working
* Added check for an unnamed foursquare venue

= 1.3.7 =
* Fix for Warning: copy() [function.copy]: Filename cannot be empty error

= 1.3.6 =
* Added byline option for widgets
* Added shortcode options
* Added CSS customization options

= 1.3.5 =
* Fix for require_once error on connecting to foursquare<sup>&reg;</sup>

= 1.3.4 =
* Corrected conflict with JetPack

= 1.3.3 =
* Added error checking for FourSquare not being contactable

= 1.3.2 =
* Added additional screenshoots

= 1.3.1 =
* Bug fix for missing Zebra_Image.php file

= 1.3 =
* Added a Badges widget

= 1.2 =
* Learning about SVN :(

= 1.1 =
* Corrected issue with folder name

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.0.5 =
Improved the way images are cached locally and resized for the map

= 2.0.4 =
Found a couple of typos

= 2.0.3 =
Corrected missing image

= 2.0.2 =
Keeps private checkins private (unless you decide to show them

= 2.0.1 =
Fixes compatability issues with some templates

= 2.0.0 =
Major rewite

= 1.4.3 =
Fixed the issue with all checkins showing when a limit is set

= 1.4.1 =
Fixed the issue with maps not displaying when only shortcodes

= 1.4.0 =
Added the ability to show Mayorships both as a widget and a shortcode

= 1.3.9 =
Improved the cache handling so both widget and page use the same cache, therefor reducing the number of calls and data stored

= 1.3.8 =
Update to fix the Badges shortcode not working correctly and handle unnamed foursquare venues

= 1.3.7 =
Fixed for Warning: copy() [function.copy]: Filename cannot be empty error

= 1.3.6 =
Added shortcode feature and further customization options

= 1.3.5 =
Corrected an issue with not finding a required file

= 1.3.4 =
Discovered a conflict with JetPack authorization

= 1.3.3 =
Will now use last cached results if there is an error contacting FourSquare

= 1.3 =
A second widget is now available to show off your badges

= 1.2 =
Made a mistake in updating the SVN

= 1.1 =
Fixes the error caused by an incorrectly named folder

= 1.0 =
Initial release
