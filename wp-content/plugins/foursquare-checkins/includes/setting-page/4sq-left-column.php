<?php
/**
 * @author Crunchify.com
 * Plugin: Foursquare Checkins
 */
?>

<?php
require_once '4sq-left-feed.php';
?>    
<br>

<div id="4sqtabs">
    <ul>
        <li><a href="#4sqtabs-1">Map Details for Post/Page</a><?=$new_icon?></li>
        <li><a href="#4sqtabs-2">Map Details for Widgets</a></li>
     </ul>

    <div id="4sqtabs-1">
        <?php
        require_once '4sq-left-map-post-page.php';
        ?>
    </div>

    <div id="4sqtabs-2">
        <?php
        require_once '4sq-left-map-widget.php';
        ?>
    </div>

</div>
<br>
